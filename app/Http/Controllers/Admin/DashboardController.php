<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Section;
use App\Models\Student;
use App\Models\Role;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    // Load the dashboard view with initial counts
   public function index()
{

$users = User::with('role')->latest()->paginate(10); // 10 per page

<<<<<<< HEAD

=======
    // TOTAL STUDENTS
>>>>>>> 363cc25 (when adding student it also create stud. account)
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

       $roles = Role::all(); // <-- add this line
$currentSchoolYear = \App\Models\Section::latest('school_year')->first()->school_year ?? null;

    return view('admin.dashboard', compact(
        'students',
        'sections',
        'totalStudents',
        'totalTeachers',
        'totalSections',
        'users',
<<<<<<< HEAD
        'roles' // <-- and this line
=======
        'roles', 
        'maleCount', 
        'femaleCount', 
        'studentsPerSection'
       
    ));
}

   
}

