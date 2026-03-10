<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\SchoolYear;
use App\Models\User;
use App\Models\Section;

class GraduationController extends Controller
{
   // app/Http/Controllers/Admin/GraduationController.php

public function index(Request $request)
{
    $status = $request->query('status'); // get filter value

    // Fetch students based on status if selected, otherwise all
    $studentsQuery = Student::orderBy('last_name')->orderBy('first_name');

    if ($status) {
        $studentsQuery->where('graduation_status', $status);
    }

    $students = $studentsQuery->get();

    // Group by graduation status
    $studentsByStatus = $students->groupBy('graduation_status');

    

    return view('admin.students.graduation', compact('studentsByStatus'));
}



public function graduation()
{
    $students = \App\Models\Student::orderBy('last_name')
                                   ->orderBy('first_name')
                                   ->get();

    // Group students by graduation_status (since graduation_year doesn't exist)
    $studentsByStatus = $students->groupBy('graduation_status');
  $schoolYears = SchoolYear::orderBy('name','desc')->get();
   $users = User::paginate(10); // or Student::paginate(10)
    $sections = Section::all(); // fetch all sections


    return view('admin.students.graduation', compact('sections', 'users', 'schoolYears', 'students', 'studentsByStatus'));
}

public function search(Request $request)
{
    $q = $request->query('q');

    $students = \App\Models\Student::when($q, function($query, $q) {
                    $query->where('first_name', 'like', "%{$q}%")
                          ->orWhere('last_name', 'like', "%{$q}%");
                })
                ->get(['id', 'first_name', 'middle_name', 'last_name', 'suffix', 'school_id', 'graduation_status', 'photo']);

    return response()->json($students);
}

public function updateStatus(Request $request, Student $student)
{
    $request->validate([
        'graduation_status' => 'required|in:active,candidate,graduated',
    ]);

    $student->graduation_status = $request->graduation_status;
    $student->save();

    return response()->json(['success' => true]);
}


}
