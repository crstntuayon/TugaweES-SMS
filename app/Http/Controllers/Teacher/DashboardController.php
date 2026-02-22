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

    $activeSchoolYear = SchoolYear::active()->first();
    $section = Section::findOrFail($request->section_id);

    // Security: teacher ownership
    if ($section->teacher_id !== auth()->id()) {
        return back()->with('error', 'You are not allowed to enroll in this section.');
    }

     // ✅ SECTION CAPACITY CHECK (PUT IT HERE)
   if ($section->isFull($activeSchoolYear->id)) {
    return back()->with('error', 'Section is already full.');
}

    // Prevent duplicate enrollment
    $alreadyEnrolled = Enrollment::where('student_id', $request->student_id)
        ->where('school_year_id', $activeSchoolYear->id)
        ->exists();

    if ($alreadyEnrolled) {
        return back()->with('error', 'Student is already enrolled this school year.');
    }

    Enrollment::create([
        'student_id' => $request->student_id,
        'section_id' => $request->section_id,
        'school_year_id' => $activeSchoolYear->id,
        'status' => 'enrolled'
    ]);

    return back()->with('success', 'Student enrolled successfully.');
}

    // Unenroll (already covered)
    public function unenroll($studentId)
{
    $activeSchoolYear = SchoolYear::active()->first();

    $enrollment = Enrollment::where('student_id', $studentId)
        ->where('school_year_id', $activeSchoolYear->id)
        ->first();

    if (!$enrollment) {
        return back()->with('error', 'Student not enrolled this school year.');
    }

    // Security check
    if ($enrollment->section->teacher_id !== auth()->id()) {
        return back()->with('error', 'You cannot unenroll a student from another teacher’s section.');
    }

    $enrollment->delete();

    return back()->with('success', 'Student unenrolled successfully.');
}

public function unenrollAll($sectionId)
{
    $section = \App\Models\Section::findOrFail($sectionId);

    // Ensure the logged-in teacher owns the section
    if ($section->teacher_id !== auth()->id()) {
        return back()->with('error', 'You cannot unenroll students from this section.');
    }

    $activeYear = \App\Models\SchoolYear::active()->first();

    // Delete all enrollments for this section in the active school year
    \App\Models\Enrollment::where('section_id', $section->id)
        ->where('school_year_id', $activeYear->id)
        ->delete();

    return back()->with('success', 'All students have been unenrolled successfully.');
}
 
// wala pa ni gamit 
public function updateStatus(Request $request, $studentId)
{
    $request->validate([
        'action' => 'required|string|in:unenroll,promote,retain,transfer,completed',
        'section_id' => 'nullable|exists:sections,id', // only required for transfer
    ]);

    $action = $request->action;
    $activeYear = \App\Models\SchoolYear::active()->first();

    $enrollment = \App\Models\Enrollment::where('student_id', $studentId)
        ->where('school_year_id', $activeYear->id)
        ->firstOrFail();

    switch ($action) {
        case 'unenroll':
            $enrollment->delete();
            return back()->with('success', 'Student unenrolled successfully.');

        case 'promote':
            // Example promote logic: create new enrollment in next grade
            $this->promoteStudent($enrollment);
            return back()->with('success', 'Student promoted successfully.');

        case 'retain':
            $this->retainStudent($enrollment);
            return back()->with('success', 'Student retained successfully.');

        case 'transfer':
            $newSectionId = $request->section_id;
            if (!$newSectionId) {
                return back()->with('error', 'Please select a section to transfer.');
            }
            $this->transferStudent($enrollment, $newSectionId);
            return back()->with('success', 'Student transferred successfully.');

        case 'completed':
            $enrollment->update(['status' => 'completed']);
            return back()->with('success', 'Student marked as completed.');
    }
}

protected function promoteStudent($enrollment)
{
    $currentYear = \App\Models\SchoolYear::find($enrollment->school_year_id);

    // Get next school year
    $nextYear = \App\Models\SchoolYear::where('id', '>', $currentYear->id)
        ->orderBy('id', 'asc')
        ->first();

    if (!$nextYear) return; // no next school year

    // Make sure year_level is integer
    $currentYearLevel = (int) $enrollment->section->year_level;

    $nextSection = \App\Models\Section::where('year_level', $currentYearLevel + 1)
        ->where('school_year_id', $nextYear->id)
        ->first();

    if (!$nextSection) return; // no section for next grade

    // Create new enrollment
    \App\Models\Enrollment::create([
        'student_id' => $enrollment->student_id,
        'section_id' => $nextSection->id,
        'school_year_id' => $nextYear->id,
        'status' => 'promoted'
    ]);
}
protected function retainStudent($enrollment)
{
    $nextYear = \App\Models\SchoolYear::find($enrollment->school_year_id + 1); // example
    \App\Models\Enrollment::create([
        'student_id' => $enrollment->student_id,
        'section_id' => $enrollment->section_id,
        'school_year_id' => $nextYear->id,
        'status' => 'retained'
    ]);
}

protected function transferStudent($enrollment, $newSectionId)
{
    $enrollment->update([
        'section_id' => $newSectionId,
        'status' => 'transferred'
    ]);
}
//hangtud diri 





}