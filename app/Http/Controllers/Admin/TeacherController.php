<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Section;
use App\Models\YearLevel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Teacher;
use App\Models\TeachingLoad;
use App\Models\SchoolYear;


class TeacherController extends Controller
{
    /**
     * Display a listing of teachers.
     */
    public function index()
    {
       
        $sections = Section::all();
        $yearLevels = YearLevel::all();
$teachers = Teacher::all();

    // Load teachers with sections and teaching load
    $teachers = Teacher::with(['sections','teachingLoad'])->get();

    // Get the active school year
    $activeSchoolYear = SchoolYear::where('is_active', 1)->first();

        return view('admin.teachers.index', compact('activeSchoolYear','teachers', 'sections', 'yearLevels'));
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
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'last_name' => 'required|string|max:255',
        'suffix' => 'nullable|string|max:50',
        'birthday' => 'required|date',
        'email' => 'required|email|unique:users,email',
        'username' => 'required|unique:users,username',
        'password' => 'required|confirmed|min:6',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    DB::transaction(function () use ($request, $validated) {

        // PHOTO UPLOAD
        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')
                ->store('teachers', 'public');
        }

        // CREATE USER (role_id = 3 → Teacher)
        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'last_name' => $validated['last_name'],
            'suffix' => $validated['suffix'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => 2,
        ]);

        // CREATE TEACHER
        \App\Models\Teacher::create([
            'user_id' => $user->id,
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'last_name' => $validated['last_name'],
            'suffix' => $validated['suffix'],
            'birthday' => $validated['birthday'],
            'email' => $validated['email'],
            'photo' => $photoPath,
        ]);
    });

    return redirect()->back()->with('success', 'Teacher added successfully!');
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
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'last_name' => 'required|string|max:255',
        'suffix' => 'nullable|string|max:255',
        'birthday' => 'required|date',
        'username' => "required|string|unique:users,username,{$teacher->id}",
        'email' => "required|email|unique:users,email,{$teacher->id}",
        'password' => 'nullable|string|min:8|confirmed',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    DB::transaction(function () use ($request, $teacher, $validated) {

        /*
        |--------------------------------------------------------------------------
        | UPDATE USERS TABLE
        |--------------------------------------------------------------------------
        */

        $teacher->update([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'username'   => $validated['username'],
            'email'      => $validated['email'],
            'name'       => $validated['first_name'].' '.$validated['last_name'],
        ]);

        if ($request->filled('password')) {
            $teacher->update([
                'password' => Hash::make($validated['password'])
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE TEACHERS TABLE
        |--------------------------------------------------------------------------
        */

        $teacherProfile = $teacher->teacher; // relationship

        if ($teacherProfile) {

            // PHOTO UPDATE
            if ($request->hasFile('photo')) {

                // Delete old photo
                if ($teacherProfile->photo &&
                    Storage::disk('public')->exists($teacherProfile->photo)) {

                    Storage::disk('public')->delete($teacherProfile->photo);
                }

                // Store new photo
                $photoPath = $request->file('photo')
                    ->store('teachers', 'public');

                $teacherProfile->photo = $photoPath;
            }

            $teacherProfile->update([
                'first_name'  => $validated['first_name'],
                'middle_name' => $validated['middle_name'],
                'last_name'   => $validated['last_name'],
                'suffix'      => $validated['suffix'],
                'birthday'    => $validated['birthday'],
                'email'       => $validated['email'],
            ]);
        }
    });

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

// TeacherController.php
public function updateProgram(Request $request, Teacher $teacher)
{
    $data = $request->validate([
        'position' => 'nullable|string|max:255',
        'years_experience' => 'nullable|numeric',
        'grade_experience' => 'nullable|string|max:255',
        'male_enrollment' => 'nullable|numeric',
        'female_enrollment' => 'nullable|numeric',
        'prepared_by' => 'nullable|string|max:255',
        'conforme' => 'nullable|string|max:255',
        'approved_by' => 'nullable|string|max:255',
        'teaching_load' => 'nullable|array',
        'teaching_load.*.id' => 'nullable|exists:teaching_loads,id',
        'teaching_load.*.time' => 'required|string',
        'teaching_load.*.minutes' => 'required|numeric',
        'teaching_load.*.subject' => 'required|string',
    ]);

    // Update teacher main info
    $teacher->update([
        'position' => $data['position'] ?? $teacher->position,
        'years_experience' => $data['years_experience'] ?? $teacher->years_experience,
        'grade_experience' => $data['grade_experience'] ?? $teacher->grade_experience,
        'male_enrollment' => $data['male_enrollment'] ?? $teacher->male_enrollment,
        'female_enrollment' => $data['female_enrollment'] ?? $teacher->female_enrollment,
        'prepared_by' => $data['prepared_by'] ?? $teacher->prepared_by,
        'conforme' => $data['conforme'] ?? $teacher->conforme,
        'approved_by' => $data['approved_by'] ?? $teacher->approved_by,
    ]);

    // Update / Create teaching loads
    foreach ($data['teaching_load'] ?? [] as $load) {

        if (!empty($load['id'])) {

            TeachingLoad::where('id', $load['id'])
                ->where('teacher_id', $teacher->id)
                ->update([
                    'time' => $load['time'],
                    'minutes' => $load['minutes'],
                    'subject' => $load['subject'],
                ]);

        } else {

            $teacher->teachingLoad()->create([
                'time' => $load['time'],
                'minutes' => $load['minutes'],
                'subject' => $load['subject'],
            ]);
        }
    }

    // 🔥 RETURN UPDATED TEACHER WITH RELATIONS
    $teacher->load(['sections', 'teachingLoad']);

    return response()->json([
        'success' => true,
        'teacher' => $teacher
    ]);
}


}
    