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
use App\Models\Role;
use App\Models\StudentHealthRecord;

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


 /**
     * SF7 - School Personnel Assignment List and Basic Profile
     * Inventory of School Personnel - Beginning of School Year Report
     */
    public function sf7(Request $request)
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

        // Get all personnel data for the SELECTED school year
        $personnelData = $this->getPersonnelData($selectedSchoolYear, $school);

        // Calculate totals for summary cards
        $totals = $this->calculatePersonnelTotals($personnelData);

        // Pass the selected school year ID to highlight in dropdown
        $selectedSchoolYearId = $selectedSchoolYear->id;

        return view('teacher.school-forms.sf7', compact(
            'personnelData',
            'totals',
            'selectedSchoolYear',
            'schoolYears',
            'selectedSchoolYearId',
            'school'
        ));
    }

    /**
     * Get all personnel data categorized by type
     */
 private function getPersonnelData($school, $schoolYear)
{
    $personnelData = [];

    // Get role IDs
    $teacherRoleId = Role::where('name', 'teacher')->value('id');
    $adminRoleId = Role::where('name', 'admin')->value('id');

    // 1️⃣ Teaching Personnel (Teachers)
    $teachers = User::where('role_id', $teacherRoleId)
        ->whereHas('sections', function($q) use ($school) {
            $q->where('school_id', $school->id);
        })
        ->orderBy('last_name', 'asc')
        ->orderBy('first_name', 'asc')
        ->get();

    foreach ($teachers as $teacher) {
        $personnelData[] = [
            'category' => 'teaching',
            'name' => $teacher->full_name ?? $teacher->name,
            'sex' => $this->getGenderCode($teacher->gender),
            'position' => $teacher->position ?? 'Teacher',
            'appointment' => $teacher->appointment_type ?? 'Permanent',
            'degree' => $teacher->degree ?? 'Bachelor of Education',
            'major' => $teacher->major ?? 'General Education',
            'assignment' => $this->getTeacherAssignment($teacher, $schoolYear),
        ];
    }

    // 2️⃣ Non-Teaching Personnel (Admins / Staff)
    $admins = User::where('role_id', $adminRoleId)
        ->orderBy('last_name', 'asc')
        ->orderBy('first_name', 'asc')
        ->get();

    foreach ($admins as $admin) {
        $personnelData[] = [
            'category' => 'non-teaching',
            'name' => $admin->full_name ?? $admin->name,
            'sex' => $this->getGenderCode($admin->gender),
            'position' => $admin->position ?? 'Administrative Staff',
            'appointment' => $admin->appointment_type ?? 'Permanent',
            'degree' => $admin->degree ?? null,
            'major' => $admin->major ?? null,
            'assignment' => $admin->assignment ?? null,
        ];
    }

    return $personnelData;
}

    /**
     * Get gender code (M/F)
     */
    private function getGenderCode($gender)
    {
        $gender = strtolower($gender ?? 'male');
        return in_array($gender, ['male', 'm']) ? 'M' : 'F';
    }

    /**
     * Get teacher assignment details
     */
    private function getTeacherAssignment($teacher, $schoolYear)
    {
        // Get sections/subjects assigned to teacher for this school year
        $assignments = DB::table('teacher_assignments')
            ->where('teacher_id', $teacher->id)
            ->where('school_year_id', $schoolYear->id)
            ->get();

        if ($assignments->isEmpty()) {
            return 'As assigned';
        }

        $assignmentStrings = [];
        
        foreach ($assignments as $assignment) {
            $section = DB::table('sections')->find($assignment->section_id);
            $subject = DB::table('subjects')->find($assignment->subject_id);
            
            if ($section && $subject) {
                $assignmentStrings[] = $subject->name . ' - ' . $section->name;
            } elseif ($section) {
                $assignmentStrings[] = 'Adviser - ' . $section->name;
            }
        }

        return implode('; ', $assignmentStrings) ?: 'As assigned';
    }

    /**
     * Get daily program schedule
     */
    private function getDailyProgram($teacher, $schoolYear)
    {
        // Get schedule entries for this teacher
        $schedules = DB::table('teacher_schedules')
            ->where('teacher_id', $teacher->id)
            ->where('school_year_id', $schoolYear->id)
            ->distinct('day')
            ->pluck('day');

        if ($schedules->isEmpty()) {
            return 'MTWThF';
        }

        // Map full day names to abbreviated format
        $dayMap = [
            'Monday' => 'M',
            'Tuesday' => 'T',
            'Wednesday' => 'W',
            'Thursday' => 'Th',
            'Friday' => 'F',
            'Saturday' => 'Sat',
            'Sunday' => 'Sun'
        ];

        $abbreviated = $schedules->map(function($day) use ($dayMap) {
            return $dayMap[$day] ?? substr($day, 0, 1);
        });

        return implode('', $abbreviated->toArray());
    }

    /**
     * Calculate average minutes per day
     */
    private function calculateAverageMinutes($teacher, $schoolYear)
    {
        // Get total teaching minutes from schedule
        $totalMinutes = DB::table('teacher_schedules')
            ->where('teacher_id', $teacher->id)
            ->where('school_year_id', $schoolYear->id)
            ->sum(DB::raw('TIMESTAMPDIFF(MINUTE, start_time, end_time)'));

        // Get count of teaching days
        $teachingDays = DB::table('teacher_schedules')
            ->where('teacher_id', $teacher->id)
            ->where('school_year_id', $schoolYear->id)
            ->distinct('day')
            ->count();

        if ($teachingDays == 0) {
            return 300; // Default 5 hours per day
        }

        return round($totalMinutes / $teachingDays);
    }

    /**
     * Calculate personnel totals for summary cards
     */
    private function calculatePersonnelTotals($personnelData)
    {
        $totals = [
            'teaching_total' => 0,
            'nonteaching_total' => 0,
            'other_total' => 0,
            'total_personnel' => 0,
            'male_total' => 0,
            'female_total' => 0,
        ];

        foreach ($personnelData as $person) {
            // Count by category
            if ($person['category'] === 'teaching') {
                $totals['teaching_total']++;
            } elseif ($person['category'] === 'non-teaching') {
                $totals['nonteaching_total']++;
            } elseif ($person['category'] === 'other') {
                $totals['other_total']++;
            }

            // Count by gender
            if ($person['sex'] === 'M') {
                $totals['male_total']++;
            } else {
                $totals['female_total']++;
            }

            $totals['total_personnel']++;
        }

        return $totals;
    }


   /**
     * SF8 - Learner's Basic Health and Nutrition Report
     * Records learner health data including BMI and nutritional status
     */
    public function sf8(Request $request)
    {
        // Get ALL school years from database for the dropdown
        $schoolYears = SchoolYear::orderBy('name', 'desc')->get();
        
        // Get the active school year (for default display)
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        
        // Get selected school year from request, or use active one, or first available
        $selectedSchoolYearId = $request->input('school_year_id');
        
        if ($selectedSchoolYearId) {
            $selectedSchoolYear = SchoolYear::find($selectedSchoolYearId);
        } elseif ($activeSchoolYear) {
            $selectedSchoolYear = $activeSchoolYear;
        } else {
            $selectedSchoolYear = SchoolYear::orderBy('id', 'desc')->first();
        }
        
        if (!$selectedSchoolYear) {
            return back()->with('error', 'No school year found in database.');
        }

        // Get school info
        $school = auth()->user()->school ?? School::first();
        
        if (!$school) {
            return back()->with('error', 'No school information found.');
        }

        // Get all sections for the dropdown filter
        $sections = Section::where('school_year_id', $selectedSchoolYear->id)
            ->orderBy('year_level')
            ->orderBy('name')
            ->get();

        // Get selected section from request (optional filter)
        $selectedSectionId = $request->input('section_id');
        $selectedSection = null;

        if ($selectedSectionId) {
            $selectedSection = Section::find($selectedSectionId);
        }

        // Get health data for students
        $healthData = $this->getHealthData($selectedSchoolYear, $school, $selectedSection);

        // Calculate summaries for summary tables
        $summaries = $this->calculateHealthSummaries($healthData);

        // Pass variables to view
        $selectedSchoolYearId = $selectedSchoolYear->id;

        return view('teacher.school-forms.sf8', compact(
            'healthData',
            'summaries',
            'selectedSchoolYear',
            'schoolYears',
            'selectedSchoolYearId',
            'sections',
            'selectedSection',
            'selectedSectionId',
            'school'
        ));
    }

      /**
     * Get health data for students
     */
    private function getHealthData($schoolYear, $school, $section = null)
    {
        $healthData = [];
        $counter = 1;

        // Build query for enrolled students
        $query = Enrollment::where('school_year_id', $schoolYear->id)
            ->where('status', 'enrolled')
            ->with(['student', 'section']);

        // Filter by section if provided
        if ($section) {
            $query->where('section_id', $section->id);
        } else {
            // Get all sections for this school year
            $sectionIds = Section::where('school_year_id', $schoolYear->id)
                ->pluck('id');
            $query->whereIn('section_id', $sectionIds);
        }

        $enrollments = $query->get();

        foreach ($enrollments as $enrollment) {
            $student = $enrollment->student;
            
            if (!$student) {
                continue;
            }

            // Get health record for this student and school year
            $healthRecord = StudentHealthRecord::where('student_id', $student->id)
                ->where('school_year_id', $schoolYear->id)
                ->first();

            // If no health record exists, create default empty record
            if (!$healthRecord) {
                $healthRecord = new StudentHealthRecord([
                    'weight' => null,
                    'height' => null,
                    'bmi' => null,
                    'nutritional_status' => 'Not Assessed',
                    'hfa_status' => 'Not Assessed',
                    'remarks' => ''
                ]);
            }

            // ✅ FIXED: Calculate age as WHOLE NUMBER using floor()
            $assessmentDate = Carbon::now();
            $age = $student->birthday
                ? (int) floor(Carbon::parse($student->birthday)->diffInYears($assessmentDate))
                : null;

            // ✅ FIXED: Calculate BMI, Height² with proper precision
            $bmi = null;
            $heightSquared = null;
            $heightInMeters = null;
            
            if ($healthRecord->weight && $healthRecord->height) {
                // Height is stored in cm, convert to meters
                $heightInMeters = $healthRecord->height / 100;
                
                // ✅ FIXED: Calculate height squared (M²) - proper formula
                $heightSquared = pow($heightInMeters, 2); // or: $heightInMeters ** 2
                
                // ✅ FIXED: Calculate BMI = weight(kg) / height(m)²
                if ($heightSquared > 0) {
                    $bmi = $healthRecord->weight / $heightSquared;
                }
                
                // Determine nutritional status if not set or needs recalculation
                if (!$healthRecord->nutritional_status || $healthRecord->nutritional_status === 'Not Assessed') {
                    $healthRecord->nutritional_status = $this->determineNutritionalStatus($bmi, $age, $student->gender);
                }
            }

            $healthData[] = [
                'no' => $counter++,
                'lrn' => $student->lrn ?? 'N/A',
                'name' => $this->formatStudentName($student),
                'gender' => strtolower($student->gender ?? 'male'),
                'birthday' => $student->birthday ? Carbon::parse($student->birthday)->format('m/d/Y') : 'N/A',
                'age' => $age ?? 'N/A', // ✅ Now displays as whole number
                'weight' => $healthRecord->weight ? number_format($healthRecord->weight, 2) : 'N/A',
                'height' => $heightInMeters ? number_format($heightInMeters, 2) : 'N/A', // ✅ Height in meters (2 decimal)
                'height_squared' => $heightSquared ? number_format($heightSquared, 4) : 'N/A', // ✅ M² with 4 decimals
                'bmi' => $bmi ? number_format($bmi, 2) : 'N/A', // ✅ BMI with 2 decimals
                'nutritional_status' => $healthRecord->nutritional_status ?? 'Not Assessed',
                'hfa_status' => $healthRecord->hfa_status ?? 'Not Assessed',
                'remarks' => $healthRecord->remarks ?? ''
            ];
        }

        // Sort by gender (male first) then by name
        usort($healthData, function($a, $b) {
            if ($a['gender'] !== $b['gender']) {
                return $a['gender'] === 'male' ? -1 : 1;
            }
            return strcmp($a['name'], $b['name']);
        });

        // Re-number after sorting
        foreach ($healthData as $index => &$data) {
            $data['no'] = $index + 1;
        }

        return $healthData;
    }

  /**
 * Calculate age in years from birthdate to a given date
 * Returns whole number (integer) age
 */
private function calculateAge($birthdate, $toDate = null)
{
    if (!$birthdate) {
        return null;
    }

    $birth = Carbon::parse($birthdate);
    $toDate = $toDate ?? Carbon::now();
    
    // ✅ Cast to int to truncate decimals (e.g., 12.75 becomes 12)
    return (int) $birth->diffInYears($toDate);
}

    /**
     * Format student name (Last Name, First Name, Middle Name)
     */
    private function formatStudentName($student)
    {
        $parts = [];
        
        if ($student->last_name) {
            $parts[] = strtoupper($student->last_name);
        }
        if ($student->first_name) {
            $parts[] = $student->first_name;
        }
        if ($student->middle_name) {
            $parts[] = substr($student->middle_name, 0, 1) . '.';
        }
        
        return implode(', ', $parts) ?: ($student->full_name ?? 'Unknown');
    }

    /**
     * Determine nutritional status based on BMI-for-Age using WHO standards
     * Simplified calculation - in production, use WHO reference tables with z-scores
     */
    private function determineNutritionalStatus($bmi, $age, $gender)
    {
        if (!$bmi || !$age) {
            return 'Not Assessed';
        }

        // Simplified BMI categories based on WHO Child Growth Standards
        // These are approximate thresholds - actual WHO tables use age and gender-specific z-scores
        
        // Age-adjusted BMI thresholds (simplified)
        if ($age < 5) {
            // Preschoolers (2-5 years)
            if ($bmi < 14) {
                return 'Severely Wasted';
            } elseif ($bmi < 15) {
                return 'Wasted';
            } elseif ($bmi < 18) {
                return 'Normal';
            } elseif ($bmi < 20) {
                return 'Overweight';
            } else {
                return 'Obese';
            }
        } elseif ($age < 10) {
            // School age (5-9 years)
            if ($bmi < 13.5) {
                return 'Severely Wasted';
            } elseif ($bmi < 14.5) {
                return 'Wasted';
            } elseif ($bmi < 19) {
                return 'Normal';
            } elseif ($bmi < 22) {
                return 'Overweight';
            } else {
                return 'Obese';
            }
        } elseif ($age < 15) {
            // Adolescents (10-14 years)
            if ($bmi < 14) {
                return 'Severely Wasted';
            } elseif ($bmi < 15.5) {
                return 'Wasted';
            } elseif ($bmi < 21) {
                return 'Normal';
            } elseif ($bmi < 25) {
                return 'Overweight';
            } else {
                return 'Obese';
            }
        } else {
            // Teenagers (15+ years) - approaching adult thresholds
            if ($bmi < 15) {
                return 'Severely Wasted';
            } elseif ($bmi < 17) {
                return 'Wasted';
            } elseif ($bmi < 23) {
                return 'Normal';
            } elseif ($bmi < 27) {
                return 'Overweight';
            } else {
                return 'Obese';
            }
        }
    }

    /**
     * Calculate health summaries for summary tables
     */
    private function calculateHealthSummaries($healthData)
    {
        $summaries = [
            'nutritional' => [
                'severely_wasted' => ['male' => 0, 'female' => 0, 'total' => 0],
                'wasted' => ['male' => 0, 'female' => 0, 'total' => 0],
                'normal' => ['male' => 0, 'female' => 0, 'total' => 0],
                'overweight' => ['male' => 0, 'female' => 0, 'total' => 0],
                'obese' => ['male' => 0, 'female' => 0, 'total' => 0],
            ],
            'hfa' => [
                'severely_stunted' => ['male' => 0, 'female' => 0, 'total' => 0],
                'stunted' => ['male' => 0, 'female' => 0, 'total' => 0],
                'normal' => ['male' => 0, 'female' => 0, 'total' => 0],
                'tall' => ['male' => 0, 'female' => 0, 'total' => 0],
            ],
            'totals' => [
                'total_students' => 0,
                'total_male' => 0,
                'total_female' => 0,
                'normal_nutrition' => 0,
                'malnourished' => 0,
                'obese_count' => 0,
            ]
        ];

        foreach ($healthData as $student) {
            $gender = $student['gender'];
            $nutritionalStatus = strtolower(str_replace(' ', '_', $student['nutritional_status']));
            $hfaStatus = strtolower(str_replace(' ', '_', $student['hfa_status']));

            // Count totals by gender
            $summaries['totals']['total_students']++;
            if ($gender === 'male') {
                $summaries['totals']['total_male']++;
            } else {
                $summaries['totals']['total_female']++;
            }

            // Count nutritional status
            if (isset($summaries['nutritional'][$nutritionalStatus])) {
                $summaries['nutritional'][$nutritionalStatus][$gender]++;
                $summaries['nutritional'][$nutritionalStatus]['total']++;
            }

            // Count HFA status
            if (isset($summaries['hfa'][$hfaStatus])) {
                $summaries['hfa'][$hfaStatus][$gender]++;
                $summaries['hfa'][$hfaStatus]['total']++;
            }

            // Summary counts for cards
            if ($nutritionalStatus === 'normal') {
                $summaries['totals']['normal_nutrition']++;
            }
            if (in_array($nutritionalStatus, ['severely_wasted', 'wasted'])) {
                $summaries['totals']['malnourished']++;
            }
            if (in_array($nutritionalStatus, ['overweight', 'obese'])) {
                $summaries['totals']['obese_count']++;
            }
        }

        return $summaries;
    }

}

