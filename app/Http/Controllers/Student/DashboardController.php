<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Announcement;

class DashboardController extends Controller
{
   public function index()
{
    $student = Student::where('user_id', auth()->id())->first();

    if (!$student) {
        abort(404, 'Student record not found.');
    }

    $activeSchoolYear = \App\Models\SchoolYear::where('is_active', true)->first();

    $enrollment = \App\Models\Enrollment::with([
        'section' => function($query) {
            $query->with(['teacher', 'schoolYear']);
        }
    ])
    ->where('student_id', $student->id)
    ->where('school_year_id', $activeSchoolYear?->id)
    ->first();

    $section = $enrollment?->section;

    $announcements = Announcement::visibleToStudent($student)
    ->with('author')
    ->orderBy('is_pinned', 'desc')
    ->orderBy('created_at', 'desc')
    ->get();

$unreadCount = $announcements->where('is_read', false)->count();

// Pass to JavaScript
$announcementsJson = $announcements->toJson();

    return view('student.dashboard', compact(
        'student',
        'announcements',
        'unreadCount',
        'announcementsJson',
        'section',
        'activeSchoolYear'
    ));
}
    public function grades()
    {
        $student = Student::with('grades.subject')->where('user_id', auth()->id())->first();

        if (!$student) {
            abort(404, 'Student record not found.');
        }

        $grades = $student->grades;

        return view('student.grades', compact('student', 'grades'));
    }

    
}
