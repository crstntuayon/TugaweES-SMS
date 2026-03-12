<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Grade; // Assume you have a Grade model
use App\Models\Announcement;

class GradeController extends Controller
{
    // Show grades form for a section
    public function index($sectionId)
    {
       // Controller method

$section = Section::with(['students' => function($q) {
    $q->orderBy('last_name')->orderBy('first_name');
}])->find($sectionId);

// Get all subjects
$subjects = Subject::all();

// Optional: prepare subjects grouped by grade for each student
$allSubjectsByGrade = [];
foreach ($section->students as $student) {
    $grades = Grade::where('student_id', $student->id)->get();
    $allSubjectsByGrade[$student->id] = $grades;
}

$announcements = Announcement::with('user') // eager load poster
    ->orderBy('created_at', 'desc')
    ->get();

return view('teacher.grades', [
    'section' => $section,
    'sections' => Section::all(), // for dropdowns
    'subjects' => $subjects,
    'allSubjectsByGrade' => $allSubjectsByGrade,
     'announcements' => $announcements,
]);
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
