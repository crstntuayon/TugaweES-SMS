<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; 
use App\Models\Student;
class StudentProfileController extends Controller
{
    public function update(Request $request)
{
    $student = auth()->user()->student;

    $request->validate([
        'first_name' => 'required',
        'last_name' => 'required',
        'photo' => 'nullable|image',
    ]);

    if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('students', 'public');
        $student->photo = $path;
    }

    // UPDATE STUDENTS TABLE
    $student->update([
        'first_name' => $request->first_name,
        'middle_name' => $request->middle_name,
        'last_name' => $request->last_name,
        'suffix' => $request->suffix,
        'birthday' => $request->birthday,
        'contact_number' => $request->contact_number,
    ]);

    // OPTIONAL: update username (users table)
    if ($request->username) {
        auth()->user()->update([
            'username' => $request->username
        ]);
    }

    // OPTIONAL: update password
    if ($request->password) {
        auth()->user()->update([
            'password' => bcrypt($request->password)
        ]);
    }

    return back()->with('success', 'Profile updated successfully.');
}

}