<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Announcement;
use App\Models\SchoolYear;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
  public function index(Request $request)
{
    $teacherId = Auth::id();
    $search = $request->search;

    $activeSchoolYear = SchoolYear::active()->first();

    $sections = Section::where('teacher_id', $teacherId)
        ->with(['enrollments' => function ($query) use ($search, $activeSchoolYear) {

            $query->where('school_year_id', $activeSchoolYear->id)
                  ->with(['student' => function ($q) use ($search) {

                      if ($search) {
                          $q->where(function ($sub) use ($search) {
                              $sub->where('first_name', 'like', "%$search%")
                                  ->orWhere('last_name', 'like', "%$search%")
                                  ->orWhere('school_id', 'like', "%$search%");
                          });
                      }

                      $q->orderBy('last_name')->orderBy('first_name');
                  }]);
        }])
        ->get();

    $announcements = Announcement::where(function ($query) use ($teacherId) {
            $query->where('type', 'teacher')
                  ->where('user_id', $teacherId);
        })
        ->orWhere('type', 'admin')
        ->latest()
        ->get();

    // ✅ Students NOT enrolled this school year, alphabetical
    $students = Student::whereDoesntHave('enrollments', function ($query) use ($activeSchoolYear) {
        $query->where('school_year_id', $activeSchoolYear->id);
    })
    ->orderBy('last_name')
    ->orderBy('first_name')
    ->get();

    return view('teacher.dashboard', compact(
        'students',
        'sections',
        'activeSchoolYear',
        'announcements'
    ));
}

  // Enroll student into a section
public function enroll(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'section_id' => 'required|exists:sections,id',
        ]);

        $activeSchoolYear = SchoolYear::active()->firstOrFail();
        $section = Section::findOrFail($request->section_id);

        // Security: ensure teacher owns section
        if ($section->teacher_id !== Auth::id()) {
            return back()->with('error', 'You are not allowed to enroll in this section.');
        }

        // Section capacity check
        if ($section->isFull($activeSchoolYear->id)) {
            return back()->with('error', 'Section is already full.');
        }

        // Check existing enrollment for this school year
        $existingEnrollment = Enrollment::where('student_id', $request->student_id)
            ->where('school_year_id', $activeSchoolYear->id)
            ->first();

        if ($existingEnrollment) {
            if ($existingEnrollment->status === 'unenrolled') {
                // Re-enroll student
                $existingEnrollment->status = 'enrolled';
                $existingEnrollment->section_id = $request->section_id;
                $existingEnrollment->save();

                return back()->with('success', 'Student re-enrolled successfully.');
            }

            return back()->with('error', 'Student is already enrolled this school year.');
        }

        // Create new enrollment
        Enrollment::create([
            'student_id' => $request->student_id,
            'section_id' => $request->section_id,
            'school_year_id' => $activeSchoolYear->id,
            'status' => 'enrolled',
        ]);

        return back()->with('success', 'Student enrolled successfully.');
    }

    /**
     * Unenroll a single student (mark as unenrolled)
     */
    public function unenroll($studentId)
    {
        $activeSchoolYear = SchoolYear::active()->firstOrFail();

        $enrollment = Enrollment::where('student_id', $studentId)
            ->where('school_year_id', $activeSchoolYear->id)
            ->first();

        if (!$enrollment) {
            return back()->with('error', 'Student not enrolled this school year.');
        }

        // Security: only teacher of section can unenroll
        if ($enrollment->section && $enrollment->section->teacher_id !== Auth::id()) {
            return back()->with('error', 'You cannot unenroll a student from another teacher’s section.');
        }

        // Mark as unenrolled instead of deleting
        $enrollment->status = 'unenrolled';
        $enrollment->section_id = null;
        $enrollment->save();

        return back()->with('success', 'Student unenrolled successfully.');
    }

    /**
     * Unenroll all students in a section (mark as unenrolled)
     */
    public function unenrollAll($sectionId)
    {
        $section = Section::findOrFail($sectionId);

        if ($section->teacher_id !== Auth::id()) {
            return back()->with('error', 'You cannot unenroll students from this section.');
        }

        $activeYear = SchoolYear::active()->firstOrFail();

        Enrollment::where('section_id', $section->id)
            ->where('school_year_id', $activeYear->id)
            ->update([
                'status' => 'unenrolled',
                'section_id' => null
            ]);

        return back()->with('success', 'All students have been unenrolled successfully.');
    }

    /**
     * Display student enrollment status for admin dashboard
     */
    public function studentStatus(Student $student, $schoolYearId = null)
    {
        $schoolYear = $schoolYearId
            ? SchoolYear::findOrFail($schoolYearId)
            : SchoolYear::active()->first();

        $enrollment = $student->enrollments()
            ->where('school_year_id', $schoolYear->id)
            ->first();

        return $enrollment ? $enrollment->status : 'N/A';
    }


    


}