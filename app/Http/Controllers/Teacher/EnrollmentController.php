<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Section;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    // Show teacher dashboard enrollment modal data
    public function create()
    {
        $students = Student::all(); // or filter by unassigned students
        $sections = Section::where('teacher_id', auth()->id())->get();

        return view('teacher.enrollments.create', compact('students', 'sections'));
    }

    // Enroll student in section
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'section_id' => 'required|exists:sections,id',
        ]);

        $student = Student::findOrFail($request->student_id);

        // Prevent duplicate enrollment
        if ($student->sections()->where('section_id', $request->section_id)->exists()) {
            return back()->with('error', 'Student is already enrolled in this section.');
        }

        // Attach student to section
        $student->sections()->attach($request->section_id);

        return back()->with('success', 'Student enrolled successfully!');
    }

    // Optionally, unenroll
    public function unenroll(Request $request, $studentId, $sectionId)
    {
        $student = Student::findOrFail($studentId);
        $student->sections()->detach($sectionId);

        return back()->with('success', 'Student unenrolled successfully!');
    }
}
