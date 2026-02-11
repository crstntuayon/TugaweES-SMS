<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\SchoolYear;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id();

        $sections = Section::where('teacher_id', $teacherId)
            ->with('students')
            ->get();

             // Sections assigned to this teacher
       
 // Students **not yet enrolled in any section**
        $students = Student::whereNull('section_id')->get();

 $activeSchoolYear = \App\Models\SchoolYear::where('is_active', true)->first();
   
        return view('teacher.dashboard', compact('students', 'sections', 'activeSchoolYear'));
    }
    // Enroll student into a section
 public function enroll(Request $request)
{
    $request->validate([
        'student_id' => 'required|exists:students,id',
        'section_id' => 'required|exists:sections,id',
    ]);

    $student = Student::findOrFail($request->student_id);
    $section = Section::findOrFail($request->section_id);

    // Security: teacher ownership
    if ($section->teacher_id !== auth()->id()) {
        return back()->with('error', 'You are not allowed to enroll in this section.');
    }

    // Already in same section
    if ($student->section_id == $section->id) {
        return back()->with('error', 'Student is already enrolled in this section.');
    }

    // Enroll / transfer
    $student->section_id = $section->id;
    $student->save();

    return back()->with('success', 'Student enrolled successfully.');
}


    // Unenroll (already covered)
    public function unenroll($studentId)
    {
        $student = Student::findOrFail($studentId);

        if ($student->section_id) {
            $section = $student->section;
            if ($section->teacher_id != auth()->id()) {
                return back()->with('error', 'You cannot unenroll a student from another teacher’s section.');
            }
        }

        $student->section_id = null;
        $student->save();

        return back()->with('success', 'Student has been unenrolled successfully!');
    }
    

}