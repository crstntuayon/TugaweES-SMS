<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Section;
use Illuminate\Http\Request;

class TeacherStudentController extends Controller
{
   // TeacherStudentController.php
public function unenroll(Student $student, Section $section)
{
    // Detach the section
    $student->sections()->detach($section->id);

    return redirect()->back()->with('success', $student->first_name . ' has been unenrolled.');
}

}

