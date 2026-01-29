<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function index(Section $section)
    {
        $subjects = Subject::all();
        $students = $section->students;

        return view('teacher.grades.index', compact(
            'section',
            'subjects',
            'students'
        ));
    }

    public function store(Request $request, Section $section)
    {
        foreach ($request->grades as $studentId => $subjects) {
            foreach ($subjects as $subjectId => $gradeValue) {
                Grade::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'subject_id' => $subjectId,
                        'quarter' => $request->quarter
                    ],
                    [
                        'grade' => $gradeValue,
                        'teacher_id' => Auth::id()
                    ]
                );
            }
        }

        return back()->with('success', 'Grades saved successfully');
    }
}
