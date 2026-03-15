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
use App\Models\SchoolYear;


class AttendanceController extends Controller
{
    // Show attendance modal / month view
  public function index(Request $request, $sectionId)
{


    
    // FIX: Pass active school year
    $activeSchoolYear = SchoolYear::where('is_active', true)->first() 
        ?? SchoolYear::latest()->first();
    

    // Current section with students and attendances
    $section = Section::with('students.attendances')->findOrFail($sectionId);

    // All sections for the dropdown
    $sections = Section::orderBy('year_level')->orderBy('name')->get();

    // Parse month from query parameter
    $month = $request->query('month', date('m'));
    $year = $request->query('year', date('Y'));

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
        'section', 'announcements', 'sections', 'activeSchoolYear', 'students', 'month', 'year', 'daysInMonth'
    ));
}

    // Save attendance
    public function store(Section $section, Request $request)
    {
        $request->validate([
            'attendance' => 'required|array'
        ]);

        $savedCount = 0;
        $deletedCount = 0;

        foreach ($request->attendance as $studentId => $days) {
            foreach ($days as $date => $status) {
                // Skip empty/null status - delete existing if present
                if (empty($status)) {
                    $deleted = Attendance::where('student_id', $studentId)
                        ->where('date', $date)
                        ->delete();
                    if ($deleted) {
                        $deletedCount++;
                    }
                    continue;
                }

                // Validate status is one of allowed values
                $allowedStatuses = ['present', 'late', 'absent', 'excused'];
                if (!in_array($status, $allowedStatuses)) {
                    continue;
                }

                Attendance::updateOrCreate(
                    [
                        'student_id' => $studentId, 
                        'date' => $date
                    ],
                    [
                        'section_id' => $section->id, 
                        'status' => $status
                    ]
                );
                $savedCount++;
            }
        }

        $message = 'Attendance saved successfully!';
        if ($savedCount > 0 && $deletedCount > 0) {
            $message = "Saved {$savedCount} records, removed {$deletedCount} blank records.";
        } elseif ($deletedCount > 0) {
            $message = "Removed {$deletedCount} blank records.";
        }

        return back()->with('success', $message);
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
