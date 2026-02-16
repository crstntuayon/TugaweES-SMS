<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{

protected function authenticated(Request $request, $user)
{
    $role = $user->role->name;

    switch ($role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'teacher':
            return redirect()->route('teacher.dashboard');
        case 'registrar':
            return redirect()->route('registrar.dashboard');
        case 'student':
            return redirect()->route('student.dashboard'); // <- add this
        default:
            return redirect('/'); // fallback
    }
}



    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
  public function store(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();

    // Check if locked
    if ($user && $user->lock_until && now()->lessThan($user->lock_until)) {
        return back()->withErrors([
            'email' => 'Account locked. Try again later.',
        ]);
    }

    if (Auth::attempt($request->only('email', 'password'))) {

        $request->session()->regenerate();

        // Reset attempts
        $user->update([
            'login_attempts' => 0,
            'lock_until' => null,
        ]);

        switch ($user->role->name) {

            case 'System Admin':
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Welcome Admin! Logged in successfully.');

            case 'Registrar':
                return redirect()->route('registrar.dashboard')
                    ->with('success', 'Welcome Registrar! Logged in successfully.');

            case 'Teacher':
                return redirect()->route('teacher.dashboard')
                    ->with('success', 'Welcome Teacher! Logged in successfully.');

            case 'Student':
                return redirect()->route('student.dashboard')
                    ->with('success', 'Welcome Student! Logged in successfully.');

            default:
                Auth::logout();
                return redirect('/login')->withErrors([
                    'email' => 'Role not assigned.',
                ]);
        }
    }

    // Failed login
    if ($user) {
        $user->increment('login_attempts');

        if ($user->login_attempts >= 3) {
            $user->update([
                'lock_until' => now()->addMinutes(5)
            ]);

            return back()->withErrors([
                'email' => 'Too many attempts. Account locked for 5 minutes.',
            ]);
        }
    }

    return back()->withErrors([
        'email' => 'Invalid credentials.',
    ]);
}


    /**
     * Destroy an authenticated session.
     */
  public function destroy(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')
        ->with('success', 'You have been logged out successfully.');
}

}
