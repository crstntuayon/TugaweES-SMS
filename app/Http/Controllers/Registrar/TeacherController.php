<?php

namespace App\Http\Controllers\Registrar;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
{
    $teachers = Teacher::all();

    return view('registrar.teachers.index', compact('teachers'));
}
    
}
