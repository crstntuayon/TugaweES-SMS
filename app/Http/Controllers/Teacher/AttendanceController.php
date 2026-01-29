<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceRecord;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $sections = Section::where('teacher_id', Auth::id())->get();
        return view('teacher.attendance.index', compact('sections'));
    }

    public function create(Section $section)
    {
        $students = $section->students;
        return view('teacher.attendance.create', compact('section', 'students'));
    }

    public function store(Request $request, Section $section)
    {
        $attendance = Attendance::create([
            'section_id' => $section->id,
            'date' => now()->toDateString(),
            'teacher_id' => Auth::id()
        ]);

        foreach ($request->status as $studentId => $status) {
            AttendanceRecord::create([
                'attendance_id' => $attendance->id,
                'student_id' => $studentId,
                'status' => $status
            ]);
        }

        return redirect()->route('teacher.attendance.index')
            ->with('success', 'Attendance saved successfully');
    }
}
