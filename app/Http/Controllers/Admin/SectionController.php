<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\User;
use App\Models\SchoolYear;
use Illuminate\Http\Request;


class SectionController extends Controller
{
public function index()
{


    $teachers = User::whereHas('role', fn($q) => $q->where('name', 'teacher'))->get();

    $sections = Section::with(['teacher', 'students'])
        ->get()
        ->groupBy(fn($s) => $s->teacher?->full_name ?? 'Unassigned');

        
     $schoolYears = SchoolYear::orderBy('name', 'desc')->get();

    return view('admin.sections.index', compact('sections', 'teachers', 'schoolYears')); // ✅ PASS TO VIEW
}
    public function create()
    {
        $teachers = User::whereHas('role', function ($q) {
            $q->where('name', 'Teacher');
        })->get();

        return view('admin.sections.create', compact('teachers'));
    }
public function store(Request $request)
{
    // Validate input
  $request->validate([
    'name' => 'required|string|max:50',
    'teacher_id' => 'nullable|exists:users,id',
    'year_level' => 'required|string|max:20',
    'school_year_id' => 'required|exists:school_years,id',
    'capacity' => 'nullable|integer|min:1|max:100',
]);


    // Create Section
   Section::create([
    'name' => $request->name,
    'teacher_id' => $request->teacher_id,
    'year_level' => $request->year_level,
    'school_year_id' => $request->school_year_id,
    'capacity' => $request->capacity ?? 40,
]);


    return redirect()->route('admin.sections.index')
                     ->with('success', 'Section added successfully.');
}





    public function edit(Section $section)
    {
        $teachers = User::whereHas('role', function ($q) {
            $q->where('name', 'Teacher');
        })->get();

        return view('admin.sections.edit', compact('section', 'teachers'));
    }

    

    public function update(Request $request, Section $section)
    {
        $request->validate([
           'name' => 'required|string|max:30',
        'teacher_id' => 'nullable|exists:users,id',
        'year_level' => 'required|string|max:20', // form sends string now
        'school_year_id' => 'required|exists:school_years,id',
            'capacity' => 'nullable|integer|min:1|max:100',
       
        ]);

        $section->update($request->all());

        return redirect()->route('admin.sections.index')
            ->with('success', 'Section updated successfully');
    }

    public function destroy(Section $section)
    {
        $section->delete();

        return redirect()->route('admin.sections.index')
            ->with('success', 'Section deleted successfully');
    }


    public function assignTeacher(Request $request, Section $section)
{
    $section->update(['teacher_id' => $request->teacher_id]);
    return back()->with('success', 'Teacher assigned');
}
    public function students(Section $section)
{
    $students = $section->students;
    return view('admin.sections.students', compact('section', 'students'));
}

public function assignTeacherBulk(Request $request, User $teacher)
{
    // Validate input
    $request->validate([
        'section_id.*' => 'nullable|exists:sections,id'
    ]);

    $sectionIds = array_filter($request->input('section_id', []));

    // Sync the teacher's assigned sections
    $teacher->sections()->sync($sectionIds);

    return redirect()->back()->with('success', 'Sections assigned successfully.');
}

}