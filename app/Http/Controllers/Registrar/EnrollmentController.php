<?php

namespace App\Http\Controllers\Registrar;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Section;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    // Show enrollment form
    public function create()
    {
        $students = Student::all();
        $sections = Section::all();

        return view('registrar.enrollments.create', compact('students', 'sections'));
    }

    // Store enrollment
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'section_id' => 'required|exists:sections,id',
        ]);

        // Get the student
        $student = Student::find($request->student_id);

        // Safety check: make sure sections() relationship exists
        if (!method_exists($student, 'sections')) {
            return back()->with('error', 'Enrollment relationship is not set up for this student.');
        }

        // Check if student is already enrolled in this section
        $alreadyEnrolled = $student->sections()->where('section_id', $request->section_id)->exists();
        if ($alreadyEnrolled) {
            return back()->with('error', 'Student is already enrolled in this section.');
        }

        // Attach student to section
        try {
            $student->sections()->attach($request->section_id);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to enroll student: ' . $e->getMessage());
        }

        return back()->with('success', 'Student enrolled successfully!');
    }

    
}
