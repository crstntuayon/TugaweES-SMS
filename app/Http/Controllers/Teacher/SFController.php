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
use App\Models\School;

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
    public function sf4(Student $student)
    {
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        
        return view('teacher.school-forms.sf4', compact('student', 'activeSchoolYear'));
    }

    /**
     * SF4 - Monthly Attendance (PDF Export)
     */
    public function sf4Export(Student $student)
    {
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        
        $pdf = PDF::loadView('teacher.school-forms.sf4-pdf', compact('student', 'activeSchoolYear'))
            ->setPaper('legal', 'landscape')
            ->setOption('margin-top', 0.5)
            ->setOption('margin-bottom', 0.5);
        
        $filename = 'SF4_Monthly_Attendance_' . $student->last_name . '_' . $student->first_name . '.pdf';
        
        return $pdf->download($filename);
    }
    
    /**
     * SF5 - Report on Promotion (View)
     */
    public function sf5(Section $section)
    {
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        
        $students = $section->students()
            ->wherePivot('school_year_id', $activeSchoolYear->id)
            ->with(['grades' => function($query) use ($activeSchoolYear) {
                $query->where('school_year_id', $activeSchoolYear->id);
            }])
            ->get();
            
        return view('teacher.school-forms.sf5', compact('section', 'students', 'activeSchoolYear'));
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