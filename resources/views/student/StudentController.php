<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Attendance;
use Carbon\Carbon;

class StudentController extends Controller
{
    // Student SMS (Student Management System?) page
    public function sms()
    {
        $student = Auth::user()->student;
        $grades = $student->grades()->latest()->get();

        return view('student.sms', compact('student', 'grades'));
    }

    // Curriculum page
    public function curriculum()
    {
        $student = Auth::user()->student;
        $section = $student->section;

        // Optional: list subjects or curriculum items for the student's section
        $subjects = $section->subjects ?? [];

        return view('student.curriculum', compact('student', 'section', 'subjects'));
    }

    // Load Slip page
    public function loadslip()
    {
        $student = Auth::user()->student;
        $section = $student->section;

        // Fetch grades and attendance for the current school year
        $grades = $student->grades()->latest()->get();
        $month = Carbon::now()->month;
        $year  = Carbon::now()->year;
        $attendances = $student->attendances()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;

        return view('student.loadslip', compact('student', 'section', 'grades', 'attendances', 'month', 'year', 'daysInMonth'));
    }
}
