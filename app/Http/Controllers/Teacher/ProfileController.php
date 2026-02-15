<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Teacher;

class ProfileController extends Controller
{
    // Return teacher profile as JSON
    public function json(Request $request)
    {
        $teacher = $request->user()->teacher; // assumes teacher relation exists on User

        return response()->json([
            'id' => $teacher->id,
            'first_name' => $teacher->first_name,
            'last_name' => $teacher->last_name,
            'full_name' => $teacher->full_name ?? ($teacher->first_name . ' ' . $teacher->last_name),
            'email' => $teacher->user->email ?? $teacher->email,
            'contact_number' => $teacher->contact_number,
            'address' => $teacher->address,
            'photo_url' => $teacher->photo ? asset('storage/' . $teacher->photo) : null,
        ]);
    }

    // Update teacher profile
  public function update(Request $request)
{
    $user = auth()->user();

    // Get teacher record linked to this user
    $teacher = Teacher::where('user_id', $user->id)->first();

    $data = $request->validate([
        'first_name' => 'required|string',
        'middle_name' => 'nullable|string',
        'last_name' => 'required|string',
        'suffix' => 'nullable|string',
        'birthday' => 'nullable|date',
        'contact_number' => 'nullable|string',
        'photo' => 'nullable|image|max:2048',
        'password' => 'nullable|min:6'
    ]);

    // OPTIONAL: update username (users table)
    if ($request->username) {
        auth()->user()->update([
            'username' => $request->username
        ]);
    }

    // Handle photo
    if ($request->hasFile('photo')) {
        $data['photo'] = $request->file('photo')->store('teachers', 'public');
    }

    // Update teacher table
    $teacher->update($data);

    // If password changed → update users table
    if ($request->filled('password')) {
        $user->update([
            'password' => bcrypt($request->password)
        ]);
    }

    return back()->with('success', 'Profile updated successfully!');
}
}
