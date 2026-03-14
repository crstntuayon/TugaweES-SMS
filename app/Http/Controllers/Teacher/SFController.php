<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Enrollment;
use App\Models\SchoolYear;
use Barryvdh\DomPDF\Facade\Pdf;

class SFController extends Controller
{
    public function sf1($student)
    {
        $student = Student::findOrFail($student);
        return view('teacher.school-forms.sf1', compact('student'));
    }

    public function sf2($student)
    {
        $student = Student::findOrFail($student);
        return view('teacher.school-forms.sf2', compact('student'));
    }

    public function sf3($student)
    {
        $student = Student::findOrFail($student);
        return view('teacher.school-forms.sf3', compact('student'));
    }

     public function sf4($student)
    {
        $student = Student::findOrFail($student);
        return view('teacher.school-forms.sf4', compact('student'));
    }

     public function sf5($student)
    {
        $student = Student::findOrFail($student);
        return view('teacher.school-forms.sf5', compact('student'));
    }

     public function sf6($student)
    {
        $student = Student::findOrFail($student);
        return view('teacher.school-forms.sf6', compact('student'));
    }

     public function sf7($student)
    {
        $student = Student::findOrFail($student);
        return view('teacher.school-forms.sf7', compact('student'));
    }

     public function sf8($student)
    {
        $student = Student::findOrFail($student);
        return view('teacher.school-forms.sf8', compact('student'));
    }

     public function sf9($student)
    {
         $student = Student::findOrFail($student);

        // Get active school year
        $activeSchoolYear = SchoolYear::where('is_active', 1)->first();

        // Get student's enrollment for the active school year
        $enrollment = Enrollment::where('student_id', $student->id)
            ->where('school_year_id', $activeSchoolYear->id)
            ->first();


if (!$enrollment || !$enrollment->section) {
    return back()->with('error', 'Student has no section assigned.');
}

$section = $enrollment->section;



        // Fetch all subjects for this student (from section or grade level)
       $subjects = \App\Models\Subject::where('grade_level', $section->year_level)
    ->orderBy('name')
    ->get();

        // Fetch all grades for this student, grouped by subject & quarter
        $gradesRaw = Grade::with('subject')
            ->where('student_id', $student->id)
            ->get()
            ->groupBy('subject_id');

        // Transform grades into a structure: $grades[subject_id][quarter] = grade
        $grades = [];
        foreach ($gradesRaw as $subjectId => $subjectGrades) {
            $grades[$subjectId] = [];
            foreach ($subjectGrades as $g) {
                $grades[$subjectId][$g->quarter] = $g->grade;
            }
        }

        return view('teacher.school-forms.sf9', compact(
            'student',
            'activeSchoolYear',
            'enrollment',
            'section',
            'subjects',
            'grades'
        ));
    }

     public function sf10(Student $student)
{
    // Get all grades for the student with subject relation
    $grades = Grade::where('student_id', $student->id)
        ->with('subject')
        ->get()
        ->map(function ($g) {
            // Ensure final_grade exists, if not calculate as average of quarters
            if (is_null($g->final_grade)) {
                $quarters = [$g->q1, $g->q2, $g->q3, $g->q4];
                $validGrades = array_filter($quarters, fn($q) => !is_null($q));
                $g->final_grade = count($validGrades) > 0 ? round(array_sum($validGrades)/count($validGrades), 2) : null;
            }
            return $g;
        });

    // Group subjects by grade_level
    $subjectsByYear = Subject::all()->groupBy('grade_level');

    // Get student sections per year level
    $studentSections = $student->sections()->get()->keyBy('grade_level');

     // Get the active school year
    $activeSchoolYear = SchoolYear::where('is_active', 1)->first();

 // Get student's enrollment for the active school year
    $enrollment = Enrollment::where('student_id', $student->id)
        ->where('school_year_id', $activeSchoolYear->id) // optional, remove if your enrollments table has no school_year_id
        ->first();

    $section = $enrollment ? $enrollment->section : null;

    return view('teacher.school-forms.sf10', compact(
        'enrollment', 
        'section', 
        'activeSchoolYear', 
        'student', 
        'grades', 
        'subjectsByYear', 
        'studentSections'
        
        ));
}



}