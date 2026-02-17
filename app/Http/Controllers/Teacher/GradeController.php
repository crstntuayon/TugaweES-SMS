<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Grade; // Assume you have a Grade model

class GradeController extends Controller
{
    // Show grades form for a section
    public function index($sectionId)
    {
        $section = Section::with(['students.grades'])->findOrFail($sectionId);
        $subjects = Subject::all(); // Or filter subjects for the section if needed

        // Group subjects by grade level for the view
        $allSubjectsByGrade = $subjects->groupBy('grade_level');

        return view('teacher.grades', compact('section', 'subjects', 'allSubjectsByGrade'));
    }

    // Store grades
    public function store(Request $request, $sectionId)
    {
        $section = Section::with('students')->findOrFail($sectionId);

        $gradesInput = $request->input('grades', []);

        foreach ($gradesInput as $studentId => $subjectsGrades) {
            $student = $section->students->where('id', $studentId)->first();
            if (!$student) continue;

            $total = 0;
            $count = 0;

            foreach ($subjectsGrades as $subjectId => $gradeValue) {
                // Validate each grade
                $gradeValue = floatval($gradeValue);
                if ($gradeValue < 0 || $gradeValue > 100) continue;

                $total += $gradeValue;
                $count++;

                // Update or create grade
                Grade::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'subject_id' => $subjectId,
                        
                    ],
                    [
                        'grade' => $gradeValue,
                    ]
                );
            }

            // Calculate average if any valid grades exist
            if ($count > 0) {
                $average = round($total / $count, 2);
                $student->average_grade = $average;
                $student->save();
            }
        }

        return redirect()->back()->with('success', 'Grades saved successfully.');
    }

    public function storeModal(Request $request)
{
    $request->validate([
        'student_id' => 'required|exists:students,id',
        'grades' => 'required|array'
    ]);

    foreach ($request->grades as $subjectId => $quarters) {
        foreach ($quarters as $quarter => $grade) {

            if ($grade === null || $grade === '') {
                continue;
            }

            Grade::updateOrCreate(
                [
                    'student_id' => $request->student_id,
                    'subject_id' => $subjectId,
                    'quarter'    => $quarter,
                ],
                [
                    'grade' => $grade
                ]
            );
        }
    }

    return response()->json([
        'message' => 'Grades saved successfully'
    ]);
}

}
