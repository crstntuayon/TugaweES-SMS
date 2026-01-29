<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Section;
use App\Models\User;

class StudentController extends Controller
{
     // Show all students
    public function index(Request $request)
    {
        $query = Student::with('section');

        // Search by first_name, last_name, or linked user
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $students = $query->orderBy('last_name')->paginate(10)->withQueryString();
        return view('admin.students.index', compact('students'));
    }

    // Show form to create new student
    public function create()
    {
        $sections = Section::all();
        $users = User::whereHas('role', fn($q) => $q->where('name', 'Student'))->get();
        return view('admin.students.create', compact('sections', 'users'));
    }

    // Store new student
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'section_id' => 'required|exists:sections,id',
            'user_id' => 'nullable|exists:users,id'
        ]);

        Student::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'section_id' => $request->section_id,
            'user_id' => $request->user_id ?? null,
        ]);

        return redirect()->route('admin.students.index')
                         ->with('success', 'Student added successfully');
    }

    // Edit student
    public function edit(Student $student)
    {
        $sections = Section::all();
        $users = User::whereHas('role', fn($q) => $q->where('name', 'Student'))->get();
        return view('admin.students.edit', compact('student', 'sections', 'users'));
    }

    // Update student
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'section_id' => 'required|exists:sections,id',
            'user_id' => 'nullable|exists:users,id'
        ]);

        $student->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'section_id' => $request->section_id,
            'user_id' => $request->user_id ?? null,
        ]);

        return redirect()->route('admin.students.index')
                         ->with('success', 'Student updated successfully');
    }

    // Delete student
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')
                         ->with('success', 'Student deleted successfully');
    }
}
