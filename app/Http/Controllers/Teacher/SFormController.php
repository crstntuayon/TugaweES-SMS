<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\School;
use App\Models\SchoolYear;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Subject;
use App\Models\User;
use Carbon\Carbon;

class SFormController extends Controller
{
    /**
     * SF6 - Summarized Report on Promotion and Level of Proficiency
     * End of School Year Report - Aggregates data from all sections/grades
     */
    public function sf6(Request $request)
    {
        // Get ALL school years from database for the dropdown
        $schoolYears = SchoolYear::orderBy('name', 'desc')->get();
        
        // Get the active school year (for default display)
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        
        // Get selected school year from request, or use active one, or first available
        $selectedSchoolYearId = $request->input('school_year_id');
        
        if ($selectedSchoolYearId) {
            // User selected a specific school year from dropdown
            $selectedSchoolYear = SchoolYear::find($selectedSchoolYearId);
        } elseif ($activeSchoolYear) {
            // Use active school year as default
            $selectedSchoolYear = $activeSchoolYear;
        } else {
            // Fallback to most recent school year
            $selectedSchoolYear = SchoolYear::orderBy('id', 'desc')->first();
        }
        
        if (!$selectedSchoolYear) {
            return back()->with('error', 'No school year found in database.');
        }

        // Get school info - from authenticated user or first school in database
        $school = auth()->user()->school ?? School::first();
        
        if (!$school) {
            return back()->with('error', 'No school information found.');
        }

        // Get all sections for the SELECTED school year
        $sections = Section::where('school_year_id', $selectedSchoolYear->id)
            ->orderBy('year_level')
            ->orderBy('name')
            ->get();

        // Get all unique year levels from sections
        $yearLevels = $sections->pluck('year_level')->unique()->sort()->values();

        // Process data by year level
        $promotionData = [];
        
        foreach ($yearLevels as $yearLevel) {
            $gradeData = $this->getGradeLevelData($yearLevel, $selectedSchoolYear, $school);
            
            if ($gradeData['has_data']) {
                $promotionData[] = [
                    'level' => $yearLevel,
                    'promoted' => $gradeData['promoted'],
                    'retained' => $gradeData['retained'],
                    'proficiency' => $gradeData['proficiency']
                ];
            }
        }

        // Calculate totals across all grade levels
        $totals = $this->calculateTotals($promotionData);

        // Pass the selected school year ID to highlight in dropdown
        $selectedSchoolYearId = $selectedSchoolYear->id;

        return view('teacher.school-forms.sf6', compact(
            'promotionData',
            'totals',
            'selectedSchoolYear',
            'schoolYears',
            'selectedSchoolYearId',
            'school'
        ));
    }

    /**
     * Get promotion and proficiency data for a specific grade level
     */
    private function getGradeLevelData($yearLevel, $schoolYear, $school)
    {
        // Get all sections for this year level and SELECTED school year
        $sectionIds = Section::where('school_year_id', $schoolYear->id)
            ->where('year_level', $yearLevel)
            ->pluck('id');

        if ($sectionIds->isEmpty()) {
            return $this->getEmptyGradeData();
        }

        // Get all students enrolled in these sections for SELECTED school year
        $studentIds = Enrollment::whereIn('section_id', $sectionIds)
            ->where('school_year_id', $schoolYear->id)
            ->where('status', 'enrolled')
            ->pluck('student_id');

        if ($studentIds->isEmpty()) {
            return $this->getEmptyGradeData();
        }

        // Load students with their grades for SELECTED school year
        $students = Student::whereIn('id', $studentIds)
            ->with(['grades' => function($query) use ($schoolYear) {
                $query->where('school_year_id', $schoolYear->id)
                      ->whereNotNull('subject_id')
                      ->whereNotNull('quarter')
                      ->whereIn('quarter', [1, 2, 3, 4])
                      ->whereNull('component')
                      ->with(['subject']);
            }])
            ->get();

        if ($students->isEmpty()) {
            return $this->getEmptyGradeData();
        }

        // Initialize counters
        $promoted = ['male' => 0, 'female' => 0, 'total' => 0];
        $retained = ['male' => 0, 'female' => 0, 'total' => 0];
        $proficiency = [
            'beginning' => ['male' => 0, 'female' => 0, 'total' => 0],
            'developing' => ['male' => 0, 'female' => 0, 'total' => 0],
            'proficient' => ['male' => 0, 'female' => 0, 'total' => 0],
            'advanced' => ['male' => 0, 'female' => 0, 'total' => 0]
        ];

        foreach ($students as $student) {
            $gender = strtolower($student->gender ?? 'male');
            if (!in_array($gender, ['male', 'female'])) {
                $gender = 'male';
            }

            // Calculate general average
            $generalAverage = $this->calculateStudentGeneralAverage($student);
            
            // Determine promotion status (75+ is passing)
            $isPromoted = $generalAverage >= 75;
            
            if ($isPromoted) {
                $promoted[$gender]++;
                $promoted['total']++;
            } else {
                $retained[$gender]++;
                $retained['total']++;
            }

            // Determine proficiency level
            $proficiencyLevel = $this->getProficiencyLevel($generalAverage);
            $proficiency[$proficiencyLevel][$gender]++;
            $proficiency[$proficiencyLevel]['total']++;
        }

        return [
            'has_data' => true,
            'promoted' => $promoted,
            'retained' => $retained,
            'proficiency' => $proficiency
        ];
    }

    /**
     * Calculate student's general average
     */
    private function calculateStudentGeneralAverage($student)
    {
        $gradesBySubject = $student->grades->groupBy('subject_id');
        
        $totalGenAve = 0;
        $subjectCount = 0;

        foreach ($gradesBySubject as $subjectId => $subjectGrades) {
            $finalGrade = $this->calculateFinalGrade($subjectGrades);
            
            if ($finalGrade !== null) {
                $totalGenAve += $finalGrade;
                $subjectCount++;
            }
        }

        return $subjectCount > 0 ? round($totalGenAve / $subjectCount, 2) : 0;
    }

    /**
     * Calculate final grade from quarterly grades
     */
    private function calculateFinalGrade($subjectGrades)
    {
        $quarters = [];
        
        foreach ($subjectGrades as $grade) {
            if ($grade->quarter >= 1 && $grade->quarter <= 4 && 
                is_numeric($grade->grade) && 
                empty($grade->component)) {
                
                $quarters[$grade->quarter] = (float) $grade->grade;
            }
        }

        if (empty($quarters)) {
            return null;
        }

        return array_sum($quarters) / count($quarters);
    }

    /**
     * Determine proficiency level based on general average
     */
    private function getProficiencyLevel($generalAverage)
    {
        if ($generalAverage >= 90) {
            return 'advanced';
        } elseif ($generalAverage >= 80) {
            return 'proficient';
        } elseif ($generalAverage >= 75) {
            return 'developing';
        } else {
            return 'beginning';
        }
    }

    /**
     * Get empty grade data structure
     */
    private function getEmptyGradeData()
    {
        return [
            'has_data' => false,
            'promoted' => ['male' => 0, 'female' => 0, 'total' => 0],
            'retained' => ['male' => 0, 'female' => 0, 'total' => 0],
            'proficiency' => [
                'beginning' => ['male' => 0, 'female' => 0, 'total' => 0],
                'developing' => ['male' => 0, 'female' => 0, 'total' => 0],
                'proficient' => ['male' => 0, 'female' => 0, 'total' => 0],
                'advanced' => ['male' => 0, 'female' => 0, 'total' => 0]
            ]
        ];
    }

    /**
     * Calculate totals across all grade levels
     */
    private function calculateTotals($promotionData)
    {
        $totals = [
            'promoted_male' => 0,
            'promoted_female' => 0,
            'promoted_total' => 0,
            'retained_male' => 0,
            'retained_female' => 0,
            'retained_total' => 0,
            'beginning_male' => 0,
            'beginning_female' => 0,
            'beginning_total' => 0,
            'developing_male' => 0,
            'developing_female' => 0,
            'developing_total' => 0,
            'proficient_male' => 0,
            'proficient_female' => 0,
            'proficient_total' => 0,
            'advanced_male' => 0,
            'advanced_female' => 0,
            'advanced_total' => 0,
        ];

        foreach ($promotionData as $data) {
            $totals['promoted_male'] += $data['promoted']['male'] ?? 0;
            $totals['promoted_female'] += $data['promoted']['female'] ?? 0;
            $totals['promoted_total'] += $data['promoted']['total'] ?? 0;

            $totals['retained_male'] += $data['retained']['male'] ?? 0;
            $totals['retained_female'] += $data['retained']['female'] ?? 0;
            $totals['retained_total'] += $data['retained']['total'] ?? 0;

            $totals['beginning_male'] += $data['proficiency']['beginning']['male'] ?? 0;
            $totals['beginning_female'] += $data['proficiency']['beginning']['female'] ?? 0;
            $totals['beginning_total'] += $data['proficiency']['beginning']['total'] ?? 0;

            $totals['developing_male'] += $data['proficiency']['developing']['male'] ?? 0;
            $totals['developing_female'] += $data['proficiency']['developing']['female'] ?? 0;
            $totals['developing_total'] += $data['proficiency']['developing']['total'] ?? 0;

            $totals['proficient_male'] += $data['proficiency']['proficient']['male'] ?? 0;
            $totals['proficient_female'] += $data['proficiency']['proficient']['female'] ?? 0;
            $totals['proficient_total'] += $data['proficiency']['proficient']['total'] ?? 0;

            $totals['advanced_male'] += $data['proficiency']['advanced']['male'] ?? 0;
            $totals['advanced_female'] += $data['proficiency']['advanced']['female'] ?? 0;
            $totals['advanced_total'] += $data['proficiency']['advanced']['total'] ?? 0;
        }

        // Calculate proficiency rate (75% and above)
        $totalStudents = $totals['promoted_total'] + $totals['retained_total'];
        $proficientAndAbove = $totals['developing_total'] + $totals['proficient_total'] + $totals['advanced_total'];

        $totals['proficiency_75_above'] = $totalStudents > 0 
            ? round(($proficientAndAbove / $totalStudents) * 100, 1) 
            : 0;

        return $totals;
    }



    
}

