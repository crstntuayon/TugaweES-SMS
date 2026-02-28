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

        return view('admin.forms.sf9', compact(
            'student',
            'activeSchoolYear',
            'enrollment',
            'section',
            'subjects',
            'grades'
        ));
    }


public function downloadSf9($studentId)
{
    $student = Student::findOrFail($studentId);

    $activeSchoolYear = SchoolYear::where('is_active', 1)->first();

    $enrollment = Enrollment::with('section.teacher')
        ->where('student_id', $student->id)
        ->where('school_year_id', $activeSchoolYear->id)
        ->first();

    $section = $enrollment?->section;

    $grades = Grade::with('subject')
        ->where('student_id', $student->id)
        ->where('school_year_id', $activeSchoolYear->id)
        ->orderBy('subject_id')
        ->get();

    $pdf = Pdf::loadView('admin.forms.sf9-pdf', compact(
        'student',
        'activeSchoolYear',
        'enrollment',
        'section',
        'grades'
    ))->setPaper('A4', 'portrait');

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

