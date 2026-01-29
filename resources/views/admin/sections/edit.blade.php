<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Section | Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-100 to-blue-200 flex items-center justify-center p-6">

<div class="w-full max-w-lg bg-white rounded-2xl shadow-xl p-8 animate-fadeIn">

    <!-- Header -->
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Section</h1>
        <p class="text-gray-500 mt-1">Update section name or assign a teacher</p>
    </div>

    <!-- Edit Section Form -->
    <form method="POST" action="{{ route('admin.sections.update', $section) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Section Name</label>
            <input id="name" type="text" name="name" value="{{ $section->name }}" required
                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 px-4 py-2">
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <div>
            <label for="teacher_id" class="block text-sm font-medium text-gray-700">Assign Teacher</label>
            <select id="teacher_id" name="teacher_id"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 px-4 py-2">
                <option value="">-- None --</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ $section->teacher_id == $teacher->id ? 'selected' : '' }}>
    {{ $teacher->first_name }} {{ $teacher->middle_name }} {{ $teacher->last_name }}
</option>
>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('teacher_id')" class="mt-1" />
        </div>

        <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg shadow-lg transition duration-200 transform hover:scale-105">
            Update Section
        </button>
    </form>

    <!-- Back to Sections -->
    <a href="{{ route('admin.sections.index') }}"
       class="mt-6 inline-block text-indigo-600 hover:underline font-medium">
        &larr; Back to Sections
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
