<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Section;
use App\Models\Student;
use App\Models\Role;
use App\Models\SchoolYear;
use App\Models\Announcement;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    // Load the dashboard view with initial counts
   public function index()
{

$users = User::with('role')->latest()->paginate(10); // 10 per page

    // TOTAL STUDENTS
    $totalStudents = Student::count();

    // Total Male / Female
    $maleCount = Student::where('sex', 'Male')->count();
    $femaleCount = Student::where('sex', 'Female')->count();

     // Students per Section
    $studentsPerSection = Student::with('section')
        ->get()
        ->groupBy(function($student) {
            return ($student->section->year_level ?? 'N/A') . ' - ' . ($student->section->name ?? 'Not Assigned');
        })->map(fn($group) => $group->count());

    $totalTeachers = User::whereHas('role', fn ($q) => $q->where('name', 'teacher'))->count();
    $totalSections = Section::count();

    $students = Student::with('section')->get();
    $sections = Section::all(); // ✅ REQUIRED

     $schoolYears = SchoolYear::orderBy('name', 'desc')->get();
    $activeSchoolYear = SchoolYear::where('is_active', true)->first();

     // Fetch admin announcements
    $announcements = Announcement::where('type', 'admin')
                                 ->latest()
                                 ->get();

       $roles = Role::all(); // <-- add this line


    return view('admin.dashboard', compact(
        'students',
        'sections',
        'totalStudents',
        'totalTeachers',
        'totalSections',
        'users',
        'roles', 
        'maleCount', 
        'femaleCount', 
        'studentsPerSection',
        
        'schoolYears',
        'activeSchoolYear',
       'announcements'
    ));
}

   
}

