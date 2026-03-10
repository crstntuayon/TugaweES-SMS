<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password | Student Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-100 via-blue-100 to-sky-200 flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white/90 backdrop-blur-lg rounded-2xl shadow-2xl p-8">
        
        <!-- HEADER -->
        <div class="text-center mb-6">
            <img src="{{ asset('images/logo.jpg') }}" class="mx-auto h-20 w-20 rounded-full shadow-lg mb-4 ring-4 ring-indigo-200" alt="School Logo">
            <h1 class="text-2xl font-bold text-gray-800">Reset Password</h1>
            <p class="text-gray-600 mt-2 text-sm">Enter your email to receive a password reset link.</p>
        </div>

        <!-- Session Status -->
        @if(session('status'))
            <div class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded-lg shadow-sm text-sm">
                {{ session('status') }}
            </div>
        @endif

        <!-- FORM -->
        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 text-gray-700" />
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-2xl shadow-md font-medium transition">
                    Send Reset Link
                </button>
            </div>
        </form>

        <!-- Back to Login -->
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                ← Back to Login
            </a>
        </div>
    </div>

</body>
</html>
