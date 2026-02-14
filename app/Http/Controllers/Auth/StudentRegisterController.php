<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class StudentRegisterController extends Controller
{
    public function show()
    {
        return view('auth.student-register');
    }

 



public function store(Request $request)
{
    $validated = $request->validate([
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
        'password'        => 'required|confirmed|min:6',
    ]);

    DB::transaction(function () use ($request, $validated) {

        // ✅ Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        // ✅ Use provided email or auto-generate
        $email = $validated['email'] ?? strtolower($validated['lrn']) . '@student.school';

        // ✅ Generate username if not provided
        $username = $validated['username'] ?? strtolower($validated['first_name'][0] . $validated['last_name'] . rand(100, 999));

        // ✅ Create user
        $user = User::create([
            'username'  => $username,
            'name'      => $validated['first_name'] . ' ' . $validated['last_name'],
            'email'     => $email,
            'password'  => Hash::make($validated['password']),
            'role_id'   => 4, // Student role
        ]);

        // ✅ Attempt to send verification email (catch errors)
        try {
            event(new Registered($user));
        } catch (\Exception $e) {
            // Log the error, but don't break registration
            Log::error('Email verification failed: ' . $e->getMessage());
        }

        // ✅ Create student record
        Student::create([
            'user_id'        => $user->id,
            'lrn'            => $validated['lrn'],
            'first_name'     => $validated['first_name'],
            'middle_name'    => $validated['middle_name'] ?? null,
            'last_name'      => $validated['last_name'],
            'suffix'         => $validated['suffix'] ?? null,
            'birthday'       => $validated['birthday'],
            'sex'            => $validated['sex'],
            'email'          => $email,
            'contact_number' => $validated['contact_number'] ?? null,
            'address'        => $validated['address'] ?? null,
            'photo'          => $validated['photo'] ?? null,
            'average_grade'  => 0,
            'section_id'     => null,
            'teacher_id'     => null,
            'school_id'      => 1, // default school
        ]);

        // ✅ Auto login
        Auth::login($user);
    });

    // Redirect to verification notice page
    return redirect()->route('verification.notice')
        ->with('success', 'Student added successfully! Please verify your email.');
}
}