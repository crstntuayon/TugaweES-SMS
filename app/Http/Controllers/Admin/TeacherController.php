<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\Section;
use App\Models\YearLevel;

class TeacherController extends Controller
{
    /**
     * Display a listing of teachers.
     */
    public function index()
    {
        $teachers = User::whereHas('role', fn($q) => $q->where('name', 'Teacher'))->get();
        $sections = Section::all();
        $yearLevels = YearLevel::all();

        return view('admin.teachers.index', compact('teachers', 'sections', 'yearLevels'));
    }

    /**
     * Show the form for creating a new teacher.
     */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created teacher in storage.
     */
    public function store(Request $request)
    {
           $request->validate([
    'first_name' => 'required|string',
    'middle_name' => 'nullable|string',
    'last_name' => 'required|string',
    'suffix' => 'nullable|string',
    'birthday' => 'required|date',
    'email' => 'required|email|unique:users,email',
    'username' => 'required|unique:users,username',
    'password' => 'required|confirmed|min:6',
]);


        $teacherRole = Role::where('name', 'Teacher')->first(); // role name must match DB

        User::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'suffix' => $request->suffix,
            'birthday' => $request->birthday,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $teacherRole->id,
        ]);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher created successfully.');
    }

    /**
     * Show the form for editing the teacher.
     */
    public function edit(User $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified teacher in storage.
     */
    public function update(Request $request, User $teacher)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:255',
            'birthday' => 'required|date',
            'username' => "required|string|unique:users,username,{$teacher->id}",
            'email' => "required|email|unique:users,email,{$teacher->id}",
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $teacher->first_name = $request->first_name;
        $teacher->middle_name = $request->middle_name;
        $teacher->last_name = $request->last_name;
        $teacher->username = $request->username;
        $teacher->email = $request->email;

        if ($request->filled('password')) {
            $teacher->password = Hash::make($request->password);
        }

        $teacher->save();

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified teacher from storage.
     */
    public function destroy(User $teacher)
    {
        $teacher->delete();

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher deleted successfully.');
    }

    /**
     * Bulk assign sections to a teacher (per year-level).
     */
    public function assignSections(Request $request, User $teacher)
    {
        $request->validate([
            'section_id.*' => 'nullable|exists:sections,id',
        ]);

        $sectionIds = array_filter($request->input('section_id', []));

        // Make sure your User model has a many-to-many relation: sections()
        $teacher->sections()->sync($sectionIds);

        return redirect()->back()->with('success', 'Sections assigned successfully.');
    }
}
    