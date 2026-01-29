<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id();

        $sections = Section::where('teacher_id', $teacherId)
            ->with('students')
            ->get();

        return view('teacher.dashboard', compact('sections'));
    }
}
