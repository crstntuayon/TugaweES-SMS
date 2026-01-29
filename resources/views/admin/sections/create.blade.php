<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Section | Student Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-100 to-blue-200 flex items-center justify-center px-4 py-8">

    <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl p-8 animate-fadeIn">
        <!-- Header -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Create Section</h1>
            <p class="text-sm text-gray-500 mt-1">Assign a teacher to the new section</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('admin.sections.store') }}" class="space-y-5">
            @csrf

            <!-- Section Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Section Name</label>
                <input type="text" name="name" id="name" placeholder="e.g., Grade 5 - A"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 shadow-sm"
                       required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

           <!-- Teacher Select -->
<div>
    <label for="teacher_id" class="block text-sm font-medium text-gray-700 mb-1">Teacher</label>
    <select name="teacher_id" id="teacher_id"
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 shadow-sm">
        <option value="">-- None --</option>
        @foreach($teachers as $teacher)
            <option value="{{ $teacher->id }}">
                {{ $teacher->first_name }} {{ $teacher->middle_name }} {{ $teacher->last_name }}
            </option>
        @endforeach
    </select>
    @error('teacher_id')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>


            <!-- Submit Button -->
            <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg transition duration-200 shadow-lg hover:scale-105">
                Save Section
            </button>
        </form>

        <!-- Back Link -->
        <p class="mt-6 text-center text-sm text-gray-500">
            <a href="{{ route('admin.sections.index') }}" class="text-indigo-600 hover:underline font-medium">Back to Sections</a>
        </p>
    </div>

    <style>
        /* Simple fade-in animation */
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
