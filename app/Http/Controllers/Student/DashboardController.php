<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        // Logged-in student
        $student = Student::with(['section', 'grades.subject', 'attendances'])->where('user_id', auth()->id())->first();

        if (!$student) {
            abort(404, 'Student record not found.');
        }

        // Just get the section of this student
        $section = $student->section;

          // Get the active school year
    $activeSchoolYear = \App\Models\SchoolYear::where('is_active', true)->first();

        return view('student.dashboard', compact('student', 'section'   , 'activeSchoolYear'));
    }

    public function grades()
    {
        $student = Student::with('grades.subject')->where('user_id', auth()->id())->first();

        if (!$student) {
            abort(404, 'Student record not found.');
        }

        $grades = $student->grades;

        return view('student.grades', compact('student', 'grades'));
    }
}
