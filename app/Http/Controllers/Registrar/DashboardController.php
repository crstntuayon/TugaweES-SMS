<?php

namespace App\Http\Controllers\Registrar;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {

     // Fetch sections for the registrar (or all if needed)
    $sections = Section::all(); // for section dropdown
    $students = Student::all(); // for student dropdown
    $teachers = Teacher::all(); // for teacher dropdown

    
        $totalStudents = \App\Models\Student::count();
        $totalTeachers = \App\Models\User::whereHas('role', fn($q) => $q->where('name', 'teacher'))->count();
        $totalSections = \App\Models\Section::count();

        return view('registrar.dashboard', compact('teachers', 'students', 'sections', 'totalStudents', 'totalTeachers', 'totalSections'));
    }


}
