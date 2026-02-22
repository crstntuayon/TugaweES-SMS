<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Enrollment;
use App\Models\SchoolYear;
use Barryvdh\DomPDF\Facade\Pdf;



class SchoolFormController extends Controller
{
  public function sf9($studentId)
{
    $student = Student::findOrFail($studentId);

    // Get the active school year
    $activeSchoolYear = SchoolYear::where('is_active', 1)->first();

    // Get student's enrollment for the active school year
    $enrollment = Enrollment::where('student_id', $student->id)
        ->where('school_year_id', $activeSchoolYear->id) // optional, remove if your enrollments table has no school_year_id
        ->first();

    $section = $enrollment ? $enrollment->section : null;

    // Fetch grades for this student in this section
  $grades = Grade::with(['subject' => function($q) {
        $q->orderBy('name', 'asc');
    }])
    ->where('student_id', $student->id)
    ->get();

    return view('admin.forms.sf9', compact(
        'student',
        'activeSchoolYear',
        'enrollment',
        'section',
        'grades'
    ));
}    public function downloadSf9(Student $student)
    {
        $pdf = Pdf::loadView('admin.forms.sf9-pdf', compact('student'));
        return $pdf->download('SF9_'.$student->last_name.'.pdf');
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

    return view('admin.forms.sf10', compact('enrollment', 'section', 'activeSchoolYear', 'student', 'grades', 'subjectsByYear', 'studentSections'));
}



    
    
    public function downloadSf10(Student $student)
{
    $subjectsByYear = Subject::all()->groupBy('grade_level');
    $grades = $student->grades()->get();

    $student->grades = $grades;

    $pdf = Pdf::loadView('admin.forms.sf10', compact('student', 'grades', 'subjectsByYear'));
    return $pdf->download("SF10_{$student->last_name}.pdf");
}
}

