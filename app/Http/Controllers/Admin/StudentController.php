<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Section;
use Illuminate\Support\Facades\Storage;

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
          'middle_name' => 'nullable|string|max:255',
        'last_name' => 'required|string',
        'lrn' => 'required|unique:students,lrn',
        'birthday' => 'required|date',
        'email' => 'nullable|email',
        'contact_number' => 'nullable|string',
        'address' => 'nullable|string',
        'sex' => 'required|in:Male,Female',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
       
    ]);

     // ✅ Handle photo upload
    if ($request->hasFile('photo')) {
        $validated['photo'] = $request->file('photo')
            ->store('photos', 'public');
    }

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
    // Validate input
    $request->validate([
        'first_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'last_name' => 'required|string|max:255',
        'suffix' => 'nullable|string|max:50',
        'birthday' => 'required|date',
        'email' => 'required|email',
        'contact_number' => 'nullable|string|max:20',
        'sex' => 'required|string',
        'section_id' => 'required|exists:sections,id',
        'lrn' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Update all fields except photo
    $student->update($request->only([
        'first_name', 'middle_name', 'last_name', 'suffix',
        'birthday', 'email', 'contact_number', 'sex',
        'section_id', 'lrn', 'address'
    ]));

    // Handle photo upload if present
    if ($request->hasFile('photo')) {
        $file = $request->file('photo');

        // Delete old photo if exists
        if ($student->photo && Storage::disk('public')->exists($student->photo)) {
            Storage::disk('public')->delete($student->photo);
        }

        // Store new photo with unique name
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('photos', $filename, 'public');

        // Save path in DB
        $student->photo = $path;
        $student->save();
    }

    return redirect()->back()->with('success', 'Student updated successfully!');
}



    // Delete student
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')
                         ->with('success', 'Student deleted successfully');
    }

    public function getStudentsJson()
{
    $students = Student::with('section')->get();

    return response()->json($students);
}

public function unenroll(Student $student)
{
    // Remove section assignment
    $student->section_id = null;
    $student->save();

    return redirect()->back()->with('success', $student->first_name . ' has been unenrolled.');
}

    
}
