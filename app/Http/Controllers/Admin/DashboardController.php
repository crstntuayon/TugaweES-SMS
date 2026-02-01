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


    $totalStudents = Student::count();
    $totalTeachers = User::whereHas('role', fn ($q) => $q->where('name', 'teacher'))->count();
    $totalSections = Section::count();

    $students = Student::with('section')->get();
    $sections = Section::all(); // ✅ REQUIRED

       $roles = Role::all(); // <-- add this line

    return view('admin.dashboard', compact(
        'students',
        'sections',
        'totalStudents',
        'totalTeachers',
        'totalSections',
        'users',
        'roles' // <-- and this line
       
    ));
}


   
}

