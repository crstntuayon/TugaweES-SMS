<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Section;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf; // for PDF export
use App\Models\Announcement;

class AttendanceController extends Controller
{
    // Show attendance modal / month view
  public function index(Request $request, $sectionId)
{
    // Current section with students and attendances
    $section = Section::with('students.attendances')->findOrFail($sectionId);

    // All sections for the dropdown
    $sections = Section::orderBy('year_level')->orderBy('name')->get();

    // Parse month from query parameter
    $monthParam = $request->query('month'); // expects "YYYY-MM"
    if ($monthParam) {
        [$year, $month] = explode('-', $monthParam);
    } else {
        $year = date('Y');
        $month = date('m');
    }

    // Students in this section, with attendances for selected month, alphabetically
    $students = $section->students()
        ->with([
            'attendances' => fn($q) => $q->whereYear('date', $year)
                                         ->whereMonth('date', $month)
        ])
        ->orderBy('last_name')
        ->orderBy('first_name')
        ->get();

    $daysInMonth = Carbon::parse("$year-$month-01")->daysInMonth;

    $announcements = Announcement::with('user') // eager load poster
    ->orderBy('created_at', 'desc')
    ->get();

    return view('teacher.attendance', compact(
        'section', 'announcements', 'sections', 'students', 'month', 'year', 'daysInMonth'
    ));
}

    // Save attendance
    public function store(Request $request, Section $section)
    {
        $request->validate([
            'attendance' => 'required|array'
        ]);

        foreach ($request->attendance as $studentId => $days) {
            foreach ($days as $date => $status) {
                Attendance::updateOrCreate(
                    ['student_id' => $studentId, 'date' => $date],
                    ['section_id' => $section->id, 'status' => $status]
                );
            }
        }

        return back()->with('success','Attendance saved successfully!');
    }

    // Export attendance for the month
    public function export(Section $section, Request $request)
    {
        $month = $request->month ?? now()->format('m');
        $year  = $request->year ?? now()->format('Y');

        $students = $section->students()->with([
            'attendances' => fn($q) => $q->whereYear('date',$year)
                                        ->whereMonth('date',$month)
        ])->get();

        $daysInMonth = Carbon::parse("$year-$month-01")->daysInMonth;

        $pdf = Pdf::loadView('teacher.export', compact(
            'section','students','month','year','daysInMonth'
        ));

        return $pdf->download("Attendance_{$section->name}_{$month}_{$year}.pdf");
    }

    
}
