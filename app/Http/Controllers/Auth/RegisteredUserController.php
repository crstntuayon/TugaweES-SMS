<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration form.
     */
    public function create()
    {
        return view('auth.student-register');
    }

    /**
     * Handle student registration.
     */
   public function store(Request $request)
{
    // Validate the request
    $validated = $request->validate([
        'lrn'             => 'required|unique:users,lrn',
        'first_name'      => 'required|string|max:255',
        'middle_name'     => 'nullable|string|max:255',
        'last_name'       => 'required|string|max:255',
        'suffix'          => 'nullable|string|max:10',
        'birthday'        => 'required|date',
        'sex'             => 'required|in:Male,Female',
        'email'           => 'nullable|email|unique:users,email',
        'username'        => 'nullable|string|unique:users,username|max:50',
        'password'        => ['required','confirmed', Password::min(8)],
        'contact_number'  => 'nullable|string|max:50',
        'address'         => 'nullable|string|max:255',
        'photo'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    DB::transaction(function () use ($validated, $request) {

        // Handle photo upload if present
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('students', 'public');
        }

        // Auto-generate email if empty
        $email = $validated['email'] ?? strtolower($validated['lrn']) . '@student.school';

        // Auto-generate username if empty
        $username = $validated['username'] ?? strtolower(substr($validated['first_name'],0,1) . $validated['last_name'] . rand(100,999));

        // Get student role
        $studentRole = Role::where('name', 'student')->firstOrFail();

        // Create User
        $user = User::create([
            'lrn'         => $validated['lrn'],
            'first_name'  => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'last_name'   => $validated['last_name'],
            'suffix'      => $validated['suffix'],
            'birthday'    => $validated['birthday'],
            'username'    => $username,
            'email'       => $email,
            'password'    => Hash::make($validated['password']),
            'role_id'     => $studentRole->id,
        ]);

        // Create linked Student
        Student::create([
            'lrn'            => $validated['lrn'],
            'first_name'     => $validated['first_name'],
            'middle_name'    => $validated['middle_name'],
            'last_name'      => $validated['last_name'],
            'suffix'         => $validated['suffix'],
            'birthday'       => $validated['birthday'],
            'sex'            => $validated['sex'],
            'email'          => $email,
            'contact_number' => $validated['contact_number'] ?? null,
            'address'        => $validated['address'] ?? null,
            'photo'          => $validated['photo'] ?? null,
            'user_id'        => $user->id,
        ]);

        // Login the user
        Auth::login($user);
    });

  return redirect()->route('login')
    ->with('success', 'Account created successfully! Please log in.');
}
}
