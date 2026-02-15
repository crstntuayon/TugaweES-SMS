<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\SchoolYear;
use App\Models\Section;
use Illuminate\Support\Facades\DB;



class ReportController extends Controller
{
    public function index(Request $request)
    {
        
        // Get all school years
        $schoolYears = SchoolYear::orderByDesc('name')->get();

        // Determine active school year (from request or default active)
        $activeYearId = $request->query('school_year') 
            ?? SchoolYear::where('is_active', 1)->value('id');

        // -----------------------------
        // Students per Section (filtered by active year)
        // -----------------------------
        $studentsPerSection = Section::withCount(['students' => function ($query) use ($activeYearId) {
            $query->where('school_year_id', $activeYearId);
        }])->get();

        // -----------------------------
        // Total Enrollees for active year
        // -----------------------------
       $enrolleesPerYear = SchoolYear::withCount([
    'students as male' => function ($query) {
        $query->where('sex', 'Male');
    },
    'students as female' => function ($query) {
        $query->where('sex', 'Female');
    }
])->orderByDesc('name')->get()
  ->map(function ($year) {
      return [
          'school_year' => $year->name,
          'male' => $year->male,
          'female' => $year->female,
          'total' => $year->male + $year->female
      ];
  });

        // -----------------------------
        // Top 10 Students (filtered by active year)
        // -----------------------------
        $topStudents = Student::where('school_year_id', $activeYearId)
            ->withAvg('grades', 'grade')
            ->orderByDesc('grades_avg_grade')
            ->take(10)
            ->get()
            ->map(function ($student) {
                $student->average_grade = round($student->grades_avg_grade, 2);
                return $student;
            });

            // -----------------------------
    // Summary cards (for Blade)
    // -----------------------------
    $cards = [
        [
            'title' => 'Selected School Year',
            'value' => $schoolYears->find($activeYearId)->name ?? 'N/A',
            'icon' => '📅',
            'bg' => 'bg-indigo-50',
            'text' => 'text-indigo-600'
        ],
        [
            'title' => 'Total Sections',
            'value' => $studentsPerSection->where('students_count', '>', 0)->count(),
            'icon' => '🏫',
            'bg' => 'bg-green-50',
            'text' => 'text-green-600'
        ],
        [
            'title' => 'Total Students',
            'value' => $studentsPerSection->sum('students_count'),
            'icon' => '👨‍🎓',
            'bg' => 'bg-purple-50',
            'text' => 'text-purple-600'
        ],
    ];

    $totalMale = $enrolleesPerYear->sum('male');
$totalFemale = $enrolleesPerYear->sum('female');


        return view('admin.reports.index', compact(
            'schoolYears',
            'activeYearId',
            'studentsPerSection',
            'enrolleesPerYear',
            'topStudents',
            'cards',
            'totalMale',
            'totalFemale'
        ));
    }
}


