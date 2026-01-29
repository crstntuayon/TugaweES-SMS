<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student | Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-100 to-blue-200 flex items-center justify-center p-6">

<div class="w-full max-w-lg bg-white rounded-2xl shadow-xl p-8 animate-fadeIn">

    <!-- Header -->
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Add New Student</h1>
        <p class="text-gray-500 mt-1">Enroll a student into a section</p>
    </div>

    <!-- Student Form -->
    <form method="POST" action="{{ route('admin.students.store') }}" class="space-y-4">
        @csrf

        <div>
            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
            <input id="first_name" name="first_name" type="text" required
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 px-4 py-2">
            <x-input-error :messages="$errors->get('first_name')" class="mt-1" />
        </div>

        <div>
            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
            <input id="last_name" name="last_name" type="text" required
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 px-4 py-2">
            <x-input-error :messages="$errors->get('last_name')" class="mt-1" />
        </div>

        <div>
            <label for="section_id" class="block text-sm font-medium text-gray-700">Select Section</label>
            <select id="section_id" name="section_id" required
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 px-4 py-2">
                <option value="">-- Choose Section --</option>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('section_id')" class="mt-1" />
        </div>

        <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg shadow-lg transition duration-200 transform hover:scale-105">
            Save Student
        </button>
    </form>

    <!-- Back to Dashboard -->
    <a href="{{ route('admin.dashboard') }}"
       class="mt-6 inline-block text-indigo-600 hover:underline font-medium">
        &larr; Back to Dashboard
    </a>
</div>

<style>
    /* Fade-in animation */
    .animate-fadeIn {
        animation: fadeIn 0.8s ease-out;
    }
    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
</style>
</body>
</html>
