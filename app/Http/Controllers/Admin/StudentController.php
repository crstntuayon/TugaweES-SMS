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
  public function index()
{
    $students = Student::with('section')->get();
    $sections = Section::all(); // <- fetch all sections

    return view('admin.students.index', compact('students', 'sections'));
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
    $validated = $request->validate([
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'lrn' => 'required|unique:students,lrn',
        'birthday' => 'required|date',
        'email' => 'nullable|email',
        'contact_number' => 'nullable|string',
        'address' => 'nullable|string',
        'sex' => 'required|in:Male,Female',
        'section_id' => 'required|exists:sections,id',
    ]);

    Student::create($validated);

    return redirect()->back()->with('success', 'Student added successfully!');
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
        'middle_name' => 'nullable|string|max:255',
        'last_name' => 'required|string|max:255',
        'suffix' => 'nullable|string|max:50',
        'birthday' => 'required|date',
        'email' => 'required|email',
        'contact_number' => 'nullable|string|max:20',
        'sex' => 'required|string',
        'section_id' => 'nullable|exists:sections,id',
        'lrn' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
    ]);

    $student->update($request->only([
        'first_name', 'middle_name', 'last_name', 'suffix',
        'birthday', 'email', 'contact_number', 'sex', 'section_id', 'lrn', 'address'
    ]));

    return redirect()->back()->with('success', 'Student updated successfully!');
}


    // Delete student
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')
                         ->with('success', 'Student deleted successfully');
    }

    
}
