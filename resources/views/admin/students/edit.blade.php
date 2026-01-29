<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student | Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-100 to-blue-200 p-6">

<div class="w-full max-w-xl mx-auto">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Student</h1>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-2xl shadow-lg p-6 animate-fadeIn">
        <form method="POST" action="{{ route('admin.students.update', $student) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- First Name -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">First Name</label>
                <input type="text" name="first_name" value="{{ $student->first_name }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2">
            </div>

            <!-- Last Name -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Last Name</label>
                <input type="text" name="last_name" value="{{ $student->last_name }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2">
            </div>

            <!-- Section -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Section</label>
                <select name="section_id"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2">
                    @foreach($sections as $section)
                        <option value="{{ $section->id }}"
                            {{ $student->section_id == $section->id ? 'selected' : '' }}>
                            {{ $section->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg shadow transition duration-200 hover:scale-105">
                Update Student
            </button>
        </form>

        <!-- Back Button -->
        <a href="{{ route('admin.students.index') }}"
           class="mt-4 inline-block text-indigo-600 hover:underline font-medium">
            &larr; Back to Students List
        </a>
    </div>
</div>

<style>
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
