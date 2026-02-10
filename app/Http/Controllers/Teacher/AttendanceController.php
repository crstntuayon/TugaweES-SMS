<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Section;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf; // for PDF export

class AttendanceController extends Controller
{
    // Show attendance modal / month view
   public function index(Request $request, $sectionId)
{
    $section = Section::with('students.attendances')->findOrFail($sectionId);

    // Parse month from query parameter
    $monthParam = $request->query('month'); // expects "YYYY-MM"
    if ($monthParam) {
        [$year, $month] = explode('-', $monthParam);
    } else {
        $year = date('Y');
        $month = date('m');
    }

    $students = $section->students()->with([
        'attendances' => fn($q) => $q->whereYear('date', $year)
                                     ->whereMonth('date', $month)
    ])->get();

    $daysInMonth = Carbon::parse("$year-$month-01")->daysInMonth;

    return view('teacher.attendance', compact(
        'section','students','month','year','daysInMonth'
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
