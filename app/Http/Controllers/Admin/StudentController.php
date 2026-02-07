<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Section;
use Illuminate\Support\Facades\Storage;
<<<<<<< HEAD

=======
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
>>>>>>> 363cc25 (when adding student it also create stud. account)
use App\Models\User;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;


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
<<<<<<< HEAD
        
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
         'section_id' => 'required|exists:sections,id',
       
    ]);

     // ✅ Handle photo upload
    if ($request->hasFile('photo')) {
        $validated['photo'] = $request->file('photo')
            ->store('photos', 'public');
    }

    Student::create($validated);
=======
        'first_name'      => 'required|string',
        'middle_name'     => 'nullable|string|max:255',
        'last_name'       => 'required|string',
        'lrn'             => 'required|unique:students,lrn',
        'birthday'        => 'required|date',
        'email'           => 'nullable|email|unique:users,email',
        'contact_number'  => 'nullable|string',
        'address'         => 'nullable|string',
        'sex'             => 'required|in:Male,Female',
        'photo'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    DB::transaction(function () use ($request, &$validated) {

        // ✅ Photo upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')
                ->store('photos', 'public');
        }

        // ✅ Use provided email or auto-generate
        $email = $validated['email'] ?? strtolower($validated['lrn']) . '@student.school';

        // ✅ CREATE USER (role_id = 4 → Student)
      $username = $validated['username']
    ?? strtolower($validated['first_name'][0] . $validated['last_name'] . rand(100, 999));

$user = User::create([
    'first_name' => $validated['first_name'],
    'last_name'  => $validated['last_name'],
    'username'   => $username,
    'name'       => $validated['first_name'] . ' ' . $validated['last_name'],
    'email'      => $email,
    'password'   => Hash::make($validated['lrn']),
    'role_id'    => 4,
]);


        // ✅ CREATE STUDENT (linked)
        Student::create(array_merge($validated, [
            'user_id' => $user->id,
            'email'   => $email,
        ]));
    });
>>>>>>> 363cc25 (when adding student it also create stud. account)

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

  

public function issueIds(Request $request)
{
    $sectionId = $request->section_id;

    $students = Student::where('section_id', $sectionId)->get();

    foreach ($students as $student) {
        if (!$student->school_id) {
            // Generate a professional S-ID (Year + Section + 4-digit number)
            $count = Student::where('section_id', $sectionId)->count();
            $student->school_id = 'S-' . date('Y') . '-' . str_pad($student->id, 4, '0', STR_PAD_LEFT);
            $student->save();
        }
    }

    // Optional: Return a view to print IDs
    return view('admin.students.print-ids', [
        'students' => $students,
        'section' => $students->first()->section ?? null,
        'schoolYear' => date('Y')
    ]);
}

public function exportIdsPdf(Request $request)
{
    $sectionId = $request->section_id;
    $students = Student::where('section_id', $sectionId)->get();
    $section = $students->first()->section ?? null;
    $schoolYear = date('Y');

    $pdf = Pdf::loadView('admin.students.print-ids', compact('students', 'section', 'schoolYear'))
              ->setPaper('a4', 'portrait'); // Adjust orientation if needed

    return $pdf->download('school_ids_' . ($section->name ?? 'section') . '.pdf');
}
}
