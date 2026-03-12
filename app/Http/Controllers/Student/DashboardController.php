<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class DashboardController extends Controller
{
   public function index()
{
    $student = Student::where('user_id', auth()->id())->first();

    if (!$student) {
        abort(404, 'Student record not found.');
    }

    $activeSchoolYear = \App\Models\SchoolYear::where('is_active', true)->first();

    $enrollment = \App\Models\Enrollment::with('section')
        ->where('student_id', $student->id)
        ->where('school_year_id', $activeSchoolYear?->id)
        ->first();

    $section = $enrollment?->section;

    return view('student.dashboard', compact(
        'student',
        'section',
        'activeSchoolYear'
    ));
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
