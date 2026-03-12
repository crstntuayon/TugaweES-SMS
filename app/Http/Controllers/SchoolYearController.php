<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolYear;

class SchoolYearController extends Controller
{
    // Show all school years
    public function index()
    {
        $schoolYears = SchoolYear::orderBy('name', 'asc')->get();
        return view('admin.schoolyears.index', compact('schoolYears'));
    }

    // Set a school year as active
   // app/Http/Controllers/SchoolYearController.php
public function activate(Request $request)
{
    $id = $request->input('school_year'); // get from the select input

    // Reset all to inactive
    SchoolYear::query()->update(['is_active' => false]);

    // Set the selected one to active
    $activeYear = SchoolYear::findOrFail($id);
    $activeYear->is_active = true;
    $activeYear->save();

    return redirect()->back()->with('success', 'Active school year updated!');
}

}
