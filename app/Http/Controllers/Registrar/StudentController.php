<?php

namespace App\Http\Controllers\Registrar;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Section;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Display all students
  public function index()
    {
         $sections = Section::orderBy('year_level')->get();
        $students = Student::all();
        $sections = Section::all(); // make sure you have sections
        return view('registrar.students.index', compact('students', 'sections'));
    }

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
        'photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
       'section_id' => 'required|integer|exists:sections,id',
       
    ]);
     // ✅ Handle photo upload
    if ($request->hasFile('photo')) {
        $validated['photo'] = $request->file('photo')
            ->store('photos', 'public');
    }

    Student::create($validated);

    return redirect()->back()->with('success', 'Student added successfully!');
}


    // UPDATE method
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


    public function assignTeacher(Request $request, Student $student)
{
    $request->validate([
        'teacher_id' => 'required|exists:teachers,id',
    ]);

    $student->teacher_id = $request->teacher_id;
    $student->save();

    return back()->with('success', 'Teacher assigned successfully.');
}



public function issueSchoolId(Request $request)
{
    $request->validate([
        'student_id' => 'required|exists:students,id',
    ]);

    $student = Student::findOrFail($request->student_id);

    // Prevent duplicate ID
    if ($student->school_id) {
        return back()->with('error', 'This student already has a School ID.');
    }

    $student->school_id = 'TES-' . date('Y') . '-' . str_pad($student->id, 6, '0', STR_PAD_LEFT);
    $student->save();

    return back()->with('success', 'School ID issued successfully!');
}


public function destroy($id)
{
    $student = Student::findOrFail($id);

    // ✅ Delete photo if exists
    if ($student->photo && Storage::disk('public')->exists($student->photo)) {
        Storage::disk('public')->delete($student->photo);
    }

    $student->delete();

    return redirect()->back()->with('success', 'Student deleted successfully.');


}
}