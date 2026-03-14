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
//$teachers = Teacher::all();

    // Load teachers with sections and teaching load
    $teachers = Teacher::with(['sections','teachingLoad'])->get();

    // Get the active school year
    $activeSchoolYear = SchoolYear::where('is_active', 1)->first();

     $schoolYears = SchoolYear::orderByDesc('name')->get();
  
     $users = User::with('role')->latest()->paginate(10);

        return view('admin.teachers.index', compact('users', 'schoolYears', 'activeSchoolYear','teachers', 'sections', 'yearLevels'));
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
          'sex' => 'required|in:male,female',  // or 'Male,Female' - must match form values!
        'email' => 'required|email|unique:users,email',
        'username' => 'required|unique:users,username',
        'password' => 'required|confirmed|min:6',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
       'street_address' => 'required|string',
    'city' => 'required|string',
    'state_province' => 'required|string',
    'postal_code' => 'required|string',
    'country' => 'required|string',
        'contact_number' => 'required|string|max:20', 
    ]);

    DB::transaction(function () use ($request, $validated) {

        // PHOTO UPLOAD
        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')
                ->store('teachers', 'public');
        }

          // Combine address fields
        $fullAddress = implode(', ', [
            $validated['street_address'],
            $validated['city'],
            $validated['state_province'],
            $validated['postal_code'],
            $validated['country']
        ]);

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
              'sex' => $validated['sex'], 
                'contact_number' => $validated['contact_number'], // ADD THIS
            'email' => $validated['email'],
            'photo' => $photoPath,
             'address' => $fullAddress,  
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
            'middle_name' => $validated['middle_name'],
            'last_name'  => $validated['last_name'],
            'suffix'     => $validated['suffix'],
            'username'   => $validated['username'],
            'email'      => $validated['email'],
            //'name'       => $validated['first_name'].' '.$validated['last_name'],
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



public function updateProgram(Request $request, Teacher $teacher)
{
    $data = $request->validate([
        // Personal Info - ADD THESE NEW FIELDS
        'first_name' => 'nullable|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'suffix' => 'nullable|string|max:50',
        'employee_id' => 'nullable|string|max:255',
        'birthdate' => 'nullable|date',           // NEW
        'sex' => 'nullable|string|in:Male,Female', // NEW
        'contact_number' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:500',    // NEW
        
        // Assignment - ADD THESE
        'school' => 'nullable|string|max:255',
        'district' => 'nullable|string|max:255',
        'division' => 'nullable|string|max:255',
        'region' => 'nullable|string|max:255',     // NEW
        'grade_levels' => 'nullable|string|max:255',
        'section_names' => 'nullable|string|max:255',
        'years_experience' => 'nullable|numeric',
        'grade_experience' => 'nullable|string|max:255',
        'male_enrollment' => 'nullable|numeric',
        'female_enrollment' => 'nullable|numeric',
        
        // Signatures
        'position' => 'nullable|string|max:255',
        'prepared_by' => 'nullable|string|max:255',
        'conforme' => 'nullable|string|max:255',
        'approved_by' => 'nullable|string|max:255',

        // Teaching Load - ADD THESE FIELDS
        'teaching_load' => 'nullable|string',
        'teaching_load.*.time' => 'nullable|string',
        'teaching_load.*.minutes' => 'nullable|numeric',
        'teaching_load.*.subject' => 'nullable|string',
        'teaching_load.*.grade_section' => 'nullable|string',  // NEW
        'teaching_load.*.remarks' => 'nullable|string',         // NEW
        
        // Photo
        'photo' => 'nullable|image|max:2048',
    ]);

    // Handle photo upload
    if ($request->hasFile('photo')) {
        if ($teacher->photo) {
            Storage::disk('public')->delete($teacher->photo);
        }
        $path = $request->file('photo')->store('teachers', 'public');
        $teacher->photo = $path;
    }

    // Parse teaching load from JSON
    $teachingLoad = [];
    if (!empty($data['teaching_load'])) {
        $teachingLoad = json_decode($data['teaching_load'], true) ?? [];
    }

    // UPDATE ALL FIELDS - Make sure your database has these columns!
    $teacher->update([
        // Personal Info
        'first_name' => $data['first_name'] ?? $teacher->first_name,
        'middle_name' => $data['middle_name'] ?? $teacher->middle_name,
        'last_name' => $data['last_name'] ?? $teacher->last_name,
        'suffix' => $data['suffix'] ?? $teacher->suffix,
        'employee_id' => $data['employee_id'] ?? $teacher->employee_id,
        'birthday' => $data['birthday'] ?? $teacher->birthday,           // NEW
        'sex' => $data['sex'] ?? $teacher->sex,                             // NEW
        'contact_number' => $data['contact_number'] ?? $teacher->contact_number,
        'address' => $data['address'] ?? $teacher->address,                 // NEW
        
        // Assignment
        'school' => $data['school'] ?? $teacher->school,
        'district' => $data['district'] ?? $teacher->district,
        'division' => $data['division'] ?? $teacher->division,
        'region' => $data['region'] ?? $teacher->region,                    // NEW
        'years_experience' => $data['years_experience'] ?? $teacher->years_experience,
        'grade_experience' => $data['grade_experience'] ?? $teacher->grade_experience,
        'male_enrollment' => $data['male_enrollment'] ?? $teacher->male_enrollment,
        'female_enrollment' => $data['female_enrollment'] ?? $teacher->female_enrollment,
        
        // Position & Signatures
        'position' => $data['position'] ?? $teacher->position,
        'prepared_by' => $data['prepared_by'] ?? $teacher->prepared_by,
        'conforme' => $data['conforme'] ?? $teacher->conforme,
        'approved_by' => $data['approved_by'] ?? $teacher->approved_by,
    ]);

    // Handle teaching load with ALL fields
    if (!empty($teachingLoad)) {
        // Clear existing and recreate (simpler approach)
        $teacher->teachingLoad()->delete();
        
        foreach ($teachingLoad as $load) {
            if (empty($load['time']) && empty($load['subject'])) continue;
            
            $teacher->teachingLoad()->create([
                'time' => $load['time'] ?? '',
                'minutes' => $load['minutes'] ?? 0,
                'subject' => $load['subject'] ?? '',
                'grade_section' => $load['grade_section'] ?? '',  // NEW
                'remarks' => $load['remarks'] ?? '',              // NEW
            ]);
        }
    }

    // Handle sections
    if (!empty($data['section_names'])) {
        $sectionNames = array_map('trim', explode(',', $data['section_names']));
        $sectionIds = [];
        
        foreach ($sectionNames as $sectionName) {
            if (empty($sectionName)) continue;
            
            $section = \App\Models\Section::firstOrCreate(
                ['name' => $sectionName, 'school_year_id' => $activeSchoolYear->id ?? 1],
                ['year_level' => $data['grade_levels'] ?? 'Grade 1']
            );
            $sectionIds[] = $section->id;
        }
        
        $teacher->sections()->sync($sectionIds);
    }

    $teacher->load(['sections', 'teachingLoad']);

    return response()->json([
        'success' => true,
        'teacher' => $teacher
    ]);
}


}
    