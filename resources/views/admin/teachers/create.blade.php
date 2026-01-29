<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Teacher | Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center p-6">

<div class="w-full max-w-xl">

    <!-- Header Card -->
    <div class="bg-white rounded-3xl shadow-2xl p-6 mb-6 animate-slideDown">
        <h1 class="text-3xl font-bold text-gray-800 text-center">Add Teacher</h1>
        <p class="text-gray-500 text-center mt-1">Create a new teacher account for the system</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl shadow-2xl p-8 space-y-6 animate-fadeIn">
        <form method="POST" action="{{ route('admin.teachers.store') }}" class="space-y-5">
            @csrf

            <!-- First Name -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name') }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 shadow-sm focus:ring-2 focus:ring-green-400 focus:border-green-500 transition"
                       placeholder="John" required>
                <x-input-error :messages="$errors->get('first_name')" class="mt-1" />
            </div>

            <!-- Middle Name -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Middle Name</label>
                <input type="text" name="middle_name" value="{{ old('middle_name') }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 shadow-sm focus:ring-2 focus:ring-green-400 focus:border-green-500 transition"
                       placeholder="A." />
                <x-input-error :messages="$errors->get('middle_name')" class="mt-1" />
            </div>

            <!-- Last Name -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name') }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 shadow-sm focus:ring-2 focus:ring-green-400 focus:border-green-500 transition"
                       placeholder="Doe" required>
                <x-input-error :messages="$errors->get('last_name')" class="mt-1" />
            </div>

            <!-- Email -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 shadow-sm focus:ring-2 focus:ring-green-400 focus:border-green-500 transition"
                       placeholder="teacher@example.com" required>
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- Username -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username') }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 shadow-sm focus:ring-2 focus:ring-green-400 focus:border-green-500 transition"
                       placeholder="teacher123" required>
                <x-input-error :messages="$errors->get('username')" class="mt-1" />
            </div>

            <!-- Password -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Password</label>
                <input type="password" name="password"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 shadow-sm focus:ring-2 focus:ring-green-400 focus:border-green-500 transition"
                       placeholder="Enter a strong password" required>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2 shadow-sm focus:ring-2 focus:ring-green-400 focus:border-green-500 transition"
                       placeholder="Repeat your password" required>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl shadow-lg transition transform hover:scale-105">
                Create Teacher
            </button>
        </form>

        <!-- Back Button -->
        <a href="{{ route('admin.teachers.index') }}"
           class="mt-4 inline-block text-green-600 hover:text-green-700 font-medium transition hover:underline">
            &larr; Back to Teachers List
        </a>
    </div>
</div>

<style>
    /* Animations */
    .animate-fadeIn {
        animation: fadeIn 0.8s ease-out;
    }
    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(-15px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .animate-slideDown {
        animation: slideDown 0.8s ease-out;
    }
    @keyframes slideDown {
        0% { opacity: 0; transform: translateY(-20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
</style>

</body>
</html>
