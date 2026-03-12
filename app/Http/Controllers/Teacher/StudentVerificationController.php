<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class StudentVerificationController extends Controller
{
    public function verify($school_id)
    {
        $student = Student::where('school_id', $school_id)->first();

        if (!$student) {
            abort(404, 'Student not found');
        }

        return view('admin.students.verify', compact('student'));
    }
}
