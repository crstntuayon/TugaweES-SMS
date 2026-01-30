<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    // Load the dashboard view with initial counts
   public function index()
{
    $totalStudents = Student::count();
    $totalTeachers = User::whereHas('role', fn ($q) => $q->where('name', 'teacher'))->count();
    $totalSections = Section::count();

    $students = Student::with('section')->get();
    $sections = Section::all(); // ✅ REQUIRED

    return view('admin.dashboard', compact(
        'students',
        'sections',
        'totalStudents',
        'totalTeachers',
        'totalSections'
    ));
}


   
}

