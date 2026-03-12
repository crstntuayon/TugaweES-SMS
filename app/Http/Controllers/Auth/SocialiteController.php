<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Supported providers
     */
    protected $providers = ['google', 'facebook'];

    /**
     * Redirect to provider
     */
    public function redirectToProvider(string $provider)
    {
        if (!in_array($provider, $this->providers)) {
            abort(404, 'Provider not supported');
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle provider callback
     */
    public function handleProviderCallback(string $provider)
    {
        if (!in_array($provider, $this->providers)) {
            abort(404);
        }

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Authentication failed. Please try again.');
        }

        // Find or create user
        $user = $this->findOrCreateUser($socialUser, $provider);

        // Login user
        Auth::login($user, true);

        // Redirect based on user role or intended URL
        return redirect()->intended('/dashboard')
            ->with('success', 'Welcome back, ' . $user->name . '!');
    }

    /**
     * Find existing user or create new one
     */
    protected function findOrCreateUser($socialUser, string $provider): User
    {
        $providerIdField = $provider . '_id';
        $providerId = $socialUser->getId();

        // 1. Check if user exists with this social ID
        $user = User::where($providerIdField, $providerId)->first();

        if ($user) {
            return $user;
        }

        // 2. Check if user exists with same email
        $user = User::where('email', $socialUser->getEmail())->first();

        if ($user) {
            // Link social account to existing user
            $user->update([
                $providerIdField => $providerId,
                'avatar' => $socialUser->getAvatar() ?? $user->avatar,
            ]);
            return $user;
        }

        // 3. Create new user
        $name = $socialUser->getName() ?? $socialUser->getNickname() ?? 'User';
        
        // Split name into first and last (optional)
        $nameParts = explode(' ', $name, 2);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1] ?? '';

        $user = User::create([
            'name' => $name,
            'email' => $socialUser->getEmail(),
            'password' => Hash::make(Str::random(24)), // Random password
            $providerIdField => $providerId,
            'avatar' => $socialUser->getAvatar(),
            'email_verified_at' => now(), // Social emails are pre-verified
        ]);

        // Optional: Assign default role if using Spatie Permission
        // $user->assignRole('student');

        return $user;
    }
}