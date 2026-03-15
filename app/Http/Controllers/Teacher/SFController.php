<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Enrollment;
use App\Models\SchoolYear;
use App\Models\Section;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Attendance;
use Carbon\Carbon;
use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\DB;



class SFController extends Controller
{
 public function sf1SectionSelect()
    {
        $teacher = Auth::user();
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        
        $sections = Section::where('teacher_id', $teacher->id)
            ->where('school_year_id', $activeSchoolYear?->id)
            ->withCount('students')
            ->get();
        
        return view('teacher.school-forms.sf1-section-select', compact('sections', 'activeSchoolYear'));
    }

    /**
     * Display SF1 for a specific section
     */
    public function sf1($section)
    {
        $section = Section::with(['students', 'schoolYear'])->findOrFail($section);
        
        if ($section->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this section.');
        }
        
        $school = (object) [
            'school_id' => '123456',
            'name' => 'Tugawe Elementary School',
            'region' => 'NIR - Negros Island Region',
            'division' => 'Division of Negros Oriental',
            'district' => 'Dauin District',
            'principal' => ''
        ];
        
        $activeSchoolYear = $section->schoolYear;
        $adviser = $section->teacher?->full_name ?? Auth::user()->full_name;
        
        $students = $section->students()
            ->orderBy('sex', 'desc')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();
        
        $maleStudents = $students->where('sex', 'Male');
        $femaleStudents = $students->where('sex', 'Female');
        
        return view('teacher.school-forms.sf1', compact(
            'section',
            'school',
            'activeSchoolYear',
            'adviser',
            'students',
            'maleStudents',
            'femaleStudents'
        ));
    }

     /**
     * SF2 - Daily Attendance Report (View)
     */
  /**
 * SF2 - Daily Attendance Report (View)
 */
public function sf2(Request $request, Section $section)
{
    $activeSchoolYear = SchoolYear::where('is_active', true)->first();
    
    // Get current year and month from request or default to current date
    $year = $request->input('year', date('Y'));
    $month = $request->input('month', date('m'));
    
    // If month is provided as "2024-01" format (from input type="month")
    if ($request->has('month')) {
        $monthValue = $request->input('month');
        if (strlen($monthValue) == 7 && strpos($monthValue, '-') !== false) {
            list($year, $month) = explode('-', $monthValue);
        }
    }
    
    // Get students
    $studentIds = \App\Models\Enrollment::where('section_id', $section->id)
        ->where('school_year_id', $activeSchoolYear->id)
        ->pluck('student_id');
    
    $students = Student::whereIn('id', $studentIds)
        ->orderBy('last_name')
        ->orderBy('first_name')
        ->get();
    
    // Get attendance data for the selected month/year
    $attendances = \App\Models\Attendance::whereIn('student_id', $studentIds)
        ->whereYear('date', $year)
        ->whereMonth('date', $month)
        ->get()
        ->groupBy('student_id');
            
    return view('teacher.school-forms.sf2', compact(
        'section', 
        'students', 
        'activeSchoolYear',
        'year',
        'month',
        'attendances'
    ));
}

public function selectSectionSF2()
{
     $teacher = Auth::user();
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        
        $sections = Section::where('teacher_id', $teacher->id)
            ->where('school_year_id', $activeSchoolYear?->id)
            ->withCount('students')
            ->get();

   return view('teacher.school-forms.sf2-section-select', compact('sections', 'activeSchoolYear'));
}
    /**
     * SF2 - Daily Attendance Report (PDF Export)
     */
  /**
 * SF2 - Daily Attendance Report (PDF Export)
 */
public function sf2Export(Request $request, Section $section)
{
    $activeSchoolYear = SchoolYear::where('is_active', true)->first();
    
    $month = $request->input('month', date('m'));
    $year = $request->input('year', date('Y'));
    
    $studentIds = \App\Models\Enrollment::where('section_id', $section->id)
        ->where('school_year_id', $activeSchoolYear->id)
        ->pluck('student_id');
    
    $students = Student::whereIn('id', $studentIds)
        ->with(['attendances' => function($query) use ($year, $month) {
            $query->whereYear('date', $year)
                  ->whereMonth('date', $month);
        }])
        ->orderBy('last_name')
        ->orderBy('first_name')
        ->get();
    
    // FIX: Use 'teacher.school-forms.sf2' instead of 'sf2-pdf'
    $pdf = PDF::loadView('teacher.school-forms.sf2', compact('section', 'students', 'activeSchoolYear', 'month', 'year'))
        ->setPaper('legal', 'landscape')
        ->setOption('margin-top', 0.5)
        ->setOption('margin-bottom', 0.5)
        ->setOption('margin-left', 0.5)
        ->setOption('margin-right', 0.5);
    
    $filename = 'SF2_Daily_Attendance_' . $section->name . '_' . $activeSchoolYear->name . '.pdf';
    
    return $pdf->download($filename);
}
    
/**
 * SF3 - Books Issued and Returned Report
 * Fixed to properly display section and grade level
 */
public function sf3(Student $student)
{
    $reportType = request('report_type', 'bosy');
    
    // Get student's books
    $student->load('books');
    
    // Get the active school year
    $activeSchoolYear = SchoolYear::where('is_active', 1)->first();
    
    // Get student's enrollment for the active school year - SAME AS SF10
    $enrollment = Enrollment::where('student_id', $student->id)
        ->where('school_year_id', $activeSchoolYear->id ?? 0)
        ->first();

    // Get section through enrollment - THIS IS THE KEY!
    $section = $enrollment ? $enrollment->section : null;
    
    // Get school info
    $school = School::first();
    
    return view('teacher.school-forms.sf3', compact(
        'student',
        'section',        // Now properly passed!
        'enrollment',     // Optional, if you need it in the view
        'activeSchoolYear',
        'school',
        'reportType'
    ));
}


    /**
     * SF3 - Books Issued/Returned (PDF Export)
     */
    public function sf3Export(Student $student)
    {
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        
        $pdf = PDF::loadView('teacher.school-forms.sf3-pdf', compact('student', 'activeSchoolYear'))
            ->setPaper('legal', 'portrait')
            ->setOption('margin-top', 0.5)
            ->setOption('margin-bottom', 0.5);
        
        $filename = 'SF3_Books_' . $student->last_name . '_' . $student->first_name . '.pdf';
        
        return $pdf->download($filename);
    }
    
    /**
     * SF4 - Monthly Attendance (View)
     */
     public function sf4(Request $request)
    {
        $selectedMonth = $request->get('month', now()->format('m'));
        $selectedYear = $request->get('year', now()->format('Y'));
        
        // Get school info
        $school = School::first();
        $activeSchoolYear = SchoolYear::where('is_active', 1)->first();
        
        // Get teacher's sections
        $teacher = auth()->user();
        $sections = Section::where('teacher_id', $teacher->id)
            ->where('school_year_id', $activeSchoolYear?->id)
            ->with('students')
            ->get();
        
        // Calculate monthly data for each grade level
        $monthlyData = [];
        foreach ($sections as $section) {
            $gradeLevel = 'Grade ' . $section->year_level;
            
            // Get students in this section
            $students = $section->students;
            $maleCount = $students->where('sex', 'Male')->count();
            $femaleCount = $students->where('sex', 'Female')->count();
            
            // Get attendance data for the month
            $attendanceStats = $this->calculateSectionAttendance(
                $section, 
                $selectedMonth, 
                $selectedYear
            );
            
            // Get dropout/transfer data (you'll need to adjust based on your actual data structure)
            $dropoutStats = $this->calculateMovementStats(
                $section,
                $selectedMonth,
                $selectedYear,
                'dropout'
            );
            
            $transferOutStats = $this->calculateMovementStats(
                $section,
                $selectedMonth,
                $selectedYear,
                'transfer_out'
            );
            
            $transferInStats = $this->calculateMovementStats(
                $section,
                $selectedMonth,
                $selectedYear,
                'transfer_in'
            );
            
            $monthlyData[] = [
                'level' => $gradeLevel,
                'section_name' => $section->name,
                'adviser' => $teacher->full_name ?? $teacher->name,
                'registered' => [
                    'male' => $maleCount,
                    'female' => $femaleCount,
                    'total' => $maleCount + $femaleCount,
                ],
                'attendance' => $attendanceStats,
                'dropout' => $dropoutStats,
                'transfer_out' => $transferOutStats,
                'transfer_in' => $transferInStats,
            ];
        }
        
        // Calculate totals
        $totals = $this->calculateTotals($monthlyData);
        
        return view('teacher.school-forms.sf4', compact(
            'school',
            'activeSchoolYear',
            'selectedMonth',
            'selectedYear',
            'monthlyData',
            'totals'
        ));
    }

    /**
     * Calculate attendance statistics for a section
     */
   /**
 * Calculate attendance statistics for a section
 */
private function calculateSectionAttendance($section, $month, $year)
{
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $studentIds = $section->students->pluck('id');
    
    // Get all attendance records for this section's students in the month
    $attendances = Attendance::whereIn('student_id', $studentIds)
        ->whereMonth('date', $month)
        ->whereYear('date', $year)
        ->get();
    
    $totalPresent = $attendances->where('status', 'P')->count();
    $totalAbsent = $attendances->where('status', 'A')->count();
    $totalTardy = $attendances->where('status', 'T')->count();
    $totalRecords = $attendances->count();
    
    // Get school days array and count
    $schoolDaysArray = $this->getSchoolDays($month, $year);
    $schoolDaysCount = count($schoolDaysArray); // FIX: Get the count, not the array
    
    // Calculate average daily attendance
    $averageDaily = $schoolDaysCount > 0 ? round($totalPresent / $schoolDaysCount, 1) : 0;
    
    // Calculate percentage
    $studentCount = count($studentIds);
    $totalPossible = $studentCount * $schoolDaysCount; // FIX: Use count here too
    $percentage = $totalPossible > 0 ? round(($totalPresent / $totalPossible) * 100, 1) : 0;
    
    return [
        'daily_average' => $averageDaily,
        'percentage' => $percentage,
    ];
}

    /**
     * Calculate movement statistics (dropouts/transfers)
     */
    private function calculateMovementStats($section, $month, $year, $type)
    {
        // This is placeholder logic - adjust based on your actual database structure
        // You might have a separate table for tracking dropouts/transfers
        
        $currentMonthCount = 0; // Query your database for current month
        $previousCumulative = 0; // Query for cumulative before this month
        
        return [
            'previous_male' => 0,
            'previous_female' => 0,
            'previous_total' => $previousCumulative,
            'current_male' => 0,
            'current_female' => 0,
            'current_total' => $currentMonthCount,
            'cumulative_male' => 0,
            'cumulative_female' => 0,
            'cumulative_total' => $previousCumulative + $currentMonthCount,
        ];
    }

    /**
     * Get school days (excluding weekends)
     */
    private function getSchoolDays($month, $year)
    {
        $schoolDays = [];
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($year, $month, $day);
            // Exclude weekends (0 = Sunday, 6 = Saturday)
            if (!in_array($date->dayOfWeek, [0, 6])) {
                $schoolDays[] = $day;
            }
        }
        
        return $schoolDays;
    }

    /**
     * Calculate totals across all grade levels
     */
    private function calculateTotals($monthlyData)
    {
        $totals = [
            'registered_male' => 0,
            'registered_female' => 0,
            'registered_total' => 0,
            'attendance_daily' => 0,
            'attendance_percentage' => 0,
            'dropout_previous' => 0,
            'dropout_current' => 0,
            'dropout_cumulative' => 0,
            'transfer_out_previous' => 0,
            'transfer_out_current' => 0,
            'transfer_out_cumulative' => 0,
            'transfer_in_previous' => 0,
            'transfer_in_current' => 0,
            'transfer_in_cumulative' => 0,
        ];
        
        foreach ($monthlyData as $data) {
            $totals['registered_male'] += $data['registered']['male'];
            $totals['registered_female'] += $data['registered']['female'];
            $totals['registered_total'] += $data['registered']['total'];
            
            $totals['attendance_daily'] += $data['attendance']['daily_average'];
            $totals['dropout_previous'] += $data['dropout']['previous_total'];
            $totals['dropout_current'] += $data['dropout']['current_total'];
            $totals['dropout_cumulative'] += $data['dropout']['cumulative_total'];
            
            $totals['transfer_out_previous'] += $data['transfer_out']['previous_total'];
            $totals['transfer_out_current'] += $data['transfer_out']['current_total'];
            $totals['transfer_out_cumulative'] += $data['transfer_out']['cumulative_total'];
            
            $totals['transfer_in_previous'] += $data['transfer_in']['previous_total'];
            $totals['transfer_in_current'] += $data['transfer_in']['current_total'];
            $totals['transfer_in_cumulative'] += $data['transfer_in']['cumulative_total'];
        }
        
        // Average the attendance percentage
        $count = count($monthlyData);
        $totals['attendance_percentage'] = $count > 0 ? 
            round(array_sum(array_column(array_column($monthlyData, 'attendance'), 'percentage')) / $count, 1) : 0;
        
        return $totals;
    }



  public function sf5(Request $request)
    {
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();

        if (!$activeSchoolYear) {
            return back()->with('error', 'No active school year found.');
        }

        // Get teacher sections
        $sections = Section::where('school_year_id', $activeSchoolYear->id)
            ->where('teacher_id', auth()->id())
            ->orderBy('year_level')
            ->orderBy('name')
            ->get();

        if ($sections->isEmpty()) {
            return back()->with('error', 'No sections assigned to this teacher.');
        }

        $sectionId = $request->section_id ?? $sections->first()->id;
        $currentSection = Section::with('teacher')->findOrFail($sectionId);
        $currentYearLevel = $currentSection->year_level;
        $school = auth()->user()->school ?? School::first();

        // ============================================================
        // CRITICAL: Get subjects that actually have grades in the database
        // for this section/school year, not just default subjects
        // ============================================================
        
        // First, get student IDs in this section
        $studentIdsInSection = DB::table('enrollments')
            ->where('section_id', $currentSection->id)
            ->where('school_year_id', $activeSchoolYear->id)
            ->pluck('student_id');

        // Get actual subjects that have grades for these students
        $subjectIdsWithGrades = Grade::whereIn('student_id', $studentIdsInSection)
            ->where('school_year_id', $activeSchoolYear->id)
            ->whereNotNull('subject_id')
            ->distinct()
            ->pluck('subject_id');

        // Get subjects from database that match the year level AND have grades
        $subjects = Subject::whereIn('id', $subjectIdsWithGrades)
            ->orWhere(function($query) use ($currentYearLevel, $subjectIdsWithGrades) {
                $query->where('grade_level', $currentYearLevel)
                      ->whereNotIn('id', $subjectIdsWithGrades);
            })
            ->orderBy('name', 'asc')
            ->get();

        // If no subjects found with grades, fall back to defaults
        if ($subjects->isEmpty()) {
            $subjects = $this->getDefaultSubjectsForYearLevel($currentYearLevel);
        }

        // Build subject lookup by ID
        $subjectById = $subjects->keyBy('id');
        $subjectKeysById = [];
        foreach ($subjects as $subject) {
            $key = strtolower(str_replace(' ', '_', trim($subject->name)));
            $subjectKeysById[$subject->id] = $key;
        }

        // ============================================================
        // LOAD STUDENTS WITH GRADES - FILTER BY school_year_id
        // ============================================================
        
        $students = Student::whereIn('id', $studentIdsInSection)
            ->with(['grades' => function($query) use ($activeSchoolYear) {
                $query->where('school_year_id', $activeSchoolYear->id)
                      ->whereNotNull('subject_id')
                      ->whereNotNull('quarter')
                      ->whereIn('quarter', [1, 2, 3, 4])
                      // CRITICAL: Only get FINAL quarterly grades, not components
                      ->whereNull('component')
                      ->with(['subject']);
            }])
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        // Process students
        $students = $students->map(function ($student) use ($subjects, $currentYearLevel, $subjectById, $subjectKeysById) {
            
            $student->current_year_level = $currentYearLevel;
            
            // Initialize grades array with null for ALL subjects
            $gradesArray = [];
            foreach ($subjects as $subject) {
                $key = strtolower(str_replace(' ', '_', trim($subject->name)));
                $gradesArray[$key] = null;
            }

            $totalGenAve = 0;
            $subjectCount = 0;
            $failingSubjects = [];

            // Group grades by subject_id
            $gradesBySubject = $student->grades->groupBy('subject_id');

            foreach ($gradesBySubject as $subjectId => $subjectGrades) {
                
                // Skip if subject not in our list
                if (!isset($subjectById[$subjectId])) {
                    continue;
                }

                $subject = $subjectById[$subjectId];
                $subjectKey = $subjectKeysById[$subjectId] ?? strtolower(str_replace(' ', '_', trim($subject->name)));

                // Calculate final grade from quarters (average of Q1-Q4)
                $finalGrade = $this->calculateFinalGrade($subjectGrades);

                if ($finalGrade !== null) {
                    $gradesArray[$subjectKey] = round($finalGrade, 0);
                    $totalGenAve += $finalGrade;
                    $subjectCount++;
                    
                    if ($finalGrade < 75) {
                        $failingSubjects[] = $subject->name;
                    }
                }
            }

            // Calculate General Average
            $student->grades_array = $gradesArray;
            $student->general_average = $subjectCount > 0 ? round($totalGenAve / $subjectCount, 2) : 0;

            // Determine action taken
            $failingCount = count($failingSubjects);
            if ($student->general_average >= 75 && $failingCount === 0) {
                $student->action_taken = 'Promoted';
            } elseif ($student->general_average >= 75 && $failingCount > 0) {
                $student->action_taken = 'Irregular';
            } elseif ($student->general_average < 75 || $failingCount >= 3) {
                $student->action_taken = 'Retained';
            } else {
                $student->action_taken = 'Deferred';
            }

            $student->incomplete_subjects = !empty($failingSubjects) ? implode(', ', $failingSubjects) : null;

            return $student;
        });

        // Calculate totals
        $totals = [
            'promoted' => $students->where('action_taken', 'Promoted')->count(),
            'irregular' => $students->where('action_taken', 'Irregular')->count(),
            'retained' => $students->where('action_taken', 'Retained')->count(),
            'deferred' => $students->where('action_taken', 'Deferred')->count(),
            'average_gen_ave' => $students->avg('general_average') ?? 0,
        ];

        $teacherFullName = $this->getTeacherFullName($currentSection);

        return view('teacher.school-forms.sf5', compact(
            'currentSection', 
            'sections',
            'students', 
            'activeSchoolYear', 
            'school',
            'totals',
            'subjects',
            'currentYearLevel',
            'teacherFullName'
        ));
    }

    /**
     * Calculate final grade from quarterly grades
     * Your table has: quarter (1-4), grade (value), component (NULL for final)
     */
    private function calculateFinalGrade($subjectGrades)
    {
        $quarters = [];
        
        foreach ($subjectGrades as $grade) {
            // Only process quarterly grades (component is NULL)
            if ($grade->quarter >= 1 && $grade->quarter <= 4 && 
                is_numeric($grade->grade) && 
                empty($grade->component)) { // component is NULL or empty for final grades
                
                $quarters[$grade->quarter] = (float) $grade->grade;
            }
        }

        if (empty($quarters)) {
            return null;
        }

        // Average of available quarters
        return array_sum($quarters) / count($quarters);
    }

    private function getTeacherFullName($section)
    {
        $teacher = User::find($section->teacher_id) ?? auth()->user();
        
        $name = $teacher->last_name . ', ' . $teacher->first_name;
        if (!empty($teacher->middle_name)) {
            $name .= ' ' . substr($teacher->middle_name, 0, 1) . '.';
        }
        if (!empty($teacher->suffix)) {
            $name .= ' ' . $teacher->suffix;
        }
        
        return $name;
    }

    private function getDefaultSubjectsForYearLevel($yearLevel)
    {
        $defaultSubjects = [
            'Kinder' => [
                ['name' => 'Mother Tongue', 'code' => 'MT'],
                ['name' => 'Filipino', 'code' => 'Fil'],
                ['name' => 'English', 'code' => 'Eng'],
                ['name' => 'Mathematics', 'code' => 'Math'],
                ['name' => 'Araling Panlipunan', 'code' => 'AP'],
                ['name' => 'Edukasyon sa Pagpapakatao', 'code' => 'ESP'],
                ['name' => 'Music', 'code' => 'Music'],
                ['name' => 'Arts', 'code' => 'Arts'],
                ['name' => 'Physical Education', 'code' => 'PE'],
                ['name' => 'Health', 'code' => 'Health'],
            ],
            'Grade 1' => [
                ['name' => 'Mother Tongue', 'code' => 'MT'],
                ['name' => 'Filipino', 'code' => 'Fil'],
                ['name' => 'English', 'code' => 'Eng'],
                ['name' => 'Mathematics', 'code' => 'Math'],
                ['name' => 'Araling Panlipunan', 'code' => 'AP'],
                ['name' => 'Edukasyon sa Pagpapakatao', 'code' => 'ESP'],
                ['name' => 'Music', 'code' => 'Music'],
                ['name' => 'Arts', 'code' => 'Arts'],
                ['name' => 'Physical Education', 'code' => 'PE'],
                ['name' => 'Health', 'code' => 'Health'],
            ],
            'Grade 2' => [
                ['name' => 'Mother Tongue', 'code' => 'MT'],
                ['name' => 'Filipino', 'code' => 'Fil'],
                ['name' => 'English', 'code' => 'Eng'],
                ['name' => 'Mathematics', 'code' => 'Math'],
                ['name' => 'Araling Panlipunan', 'code' => 'AP'],
                ['name' => 'Edukasyon sa Pagpapakatao', 'code' => 'ESP'],
                ['name' => 'Music', 'code' => 'Music'],
                ['name' => 'Arts', 'code' => 'Arts'],
                ['name' => 'Physical Education', 'code' => 'PE'],
                ['name' => 'Health', 'code' => 'Health'],
            ],
            'Grade 3' => [
                ['name' => 'Mother Tongue', 'code' => 'MT'],
                ['name' => 'Filipino', 'code' => 'Fil'],
                ['name' => 'English', 'code' => 'Eng'],
                ['name' => 'Mathematics', 'code' => 'Math'],
                ['name' => 'Araling Panlipunan', 'code' => 'AP'],
                ['name' => 'Edukasyon sa Pagpapakatao', 'code' => 'ESP'],
                ['name' => 'Music', 'code' => 'Music'],
                ['name' => 'Arts', 'code' => 'Arts'],
                ['name' => 'Physical Education', 'code' => 'PE'],
                ['name' => 'Health', 'code' => 'Health'],
            ],
            'Grade 4' => [
                ['name' => 'Filipino', 'code' => 'Fil'],
                ['name' => 'English', 'code' => 'Eng'],
                ['name' => 'Mathematics', 'code' => 'Math'],
                ['name' => 'Science', 'code' => 'Sci'],
                ['name' => 'Araling Panlipunan', 'code' => 'AP'],
                ['name' => 'Edukasyon sa Pagpapakatao', 'code' => 'ESP'],
                ['name' => 'Music', 'code' => 'Music'],
                ['name' => 'Arts', 'code' => 'Arts'],
                ['name' => 'Physical Education', 'code' => 'PE'],
                ['name' => 'Health', 'code' => 'Health'],
                ['name' => 'Edukasyong Pantahanan at Pangkabuhayan', 'code' => 'EPP'],
            ],
            'Grade 5' => [
                ['name' => 'Filipino', 'code' => 'Fil'],
                ['name' => 'English', 'code' => 'Eng'],
                ['name' => 'Mathematics', 'code' => 'Math'],
                ['name' => 'Science', 'code' => 'Sci'],
                ['name' => 'Araling Panlipunan', 'code' => 'AP'],
                ['name' => 'Edukasyon sa Pagpapakatao', 'code' => 'ESP'],
                ['name' => 'Music', 'code' => 'Music'],
                ['name' => 'Arts', 'code' => 'Arts'],
                ['name' => 'Physical Education', 'code' => 'PE'],
                ['name' => 'Health', 'code' => 'Health'],
                ['name' => 'Edukasyong Pantahanan at Pangkabuhayan', 'code' => 'EPP'],
            ],
            'Grade 6' => [
                ['name' => 'Filipino', 'code' => 'Fil'],
                ['name' => 'English', 'code' => 'Eng'],
                ['name' => 'Mathematics', 'code' => 'Math'],
                ['name' => 'Science', 'code' => 'Sci'],
                ['name' => 'Araling Panlipunan', 'code' => 'AP'],
                ['name' => 'Edukasyon sa Pagpapakatao', 'code' => 'ESP'],
                ['name' => 'Music', 'code' => 'Music'],
                ['name' => 'Arts', 'code' => 'Arts'],
                ['name' => 'Physical Education', 'code' => 'PE'],
                ['name' => 'Health', 'code' => 'Health'],
                ['name' => 'Edukasyong Pantahanan at Pangkabuhayan', 'code' => 'EPP'],
            ],
        ];

        $subjects = $defaultSubjects[$yearLevel] ?? $defaultSubjects['Grade 1'];
        
        return collect($subjects)->map(function($subject, $index) use ($yearLevel) {
            return (object)[
                'id' => $index + 1000, // Offset to avoid collision with real IDs
                'name' => $subject['name'],
                'code' => $subject['code'],
                'grade_level' => $yearLevel
            ];
        });
    }


    /**
     * SF5 - Report on Promotion (PDF Export)
     */
    public function sf5Export(Section $section)
    {
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        
        $students = $section->students()
            ->wherePivot('school_year_id', $activeSchoolYear->id)
            ->with(['grades' => function($query) use ($activeSchoolYear) {
                $query->where('school_year_id', $activeSchoolYear->id);
            }])
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();
        
        $pdf = PDF::loadView('teacher.school-forms.sf5-pdf', compact('section', 'students', 'activeSchoolYear'))
            ->setPaper('legal', 'landscape')
            ->setOption('margin-top', 0.5)
            ->setOption('margin-bottom', 0.5);
        
        $filename = 'SF5_Report_on_Promotion_' . $section->name . '_' . $activeSchoolYear->name . '.pdf';
        
        return $pdf->download($filename);
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