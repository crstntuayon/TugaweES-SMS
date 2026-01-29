<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sections | Student Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-100 to-blue-200 px-4 py-8">

<div class="w-full max-w-6xl mx-auto">

    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center space-x-3">
            <!-- Back Button -->
            <a href="{{ route('admin.dashboard') }}"
               class="hover:bg-indigo-300 text-gray-700 px-3 py-1 rounded-lg shadow-sm transition duration-200 flex items-center space-x-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 19l-7-7 7-7"/>
                </svg>
                <span class="font-medium"></span>
            </a>

            <h1 class="text-2xl font-bold text-gray-800">Sections</h1>
        </div>

        <a href="{{ route('admin.sections.create') }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-xl shadow-lg transition duration-200 hover:scale-105">
            Add Section
        </a>
    </div>

    <!-- Sections Table -->
    <div class="bg-white rounded-3xl shadow-lg overflow-hidden animate-fadeIn">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-indigo-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teacher</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($sections as $section)
                    <tr class="hover:bg-indigo-50 transition duration-200">
                        <td class="px-6 py-4 text-gray-700 font-medium">{{ $section->name }}</td>
                        <td class="px-6 py-4 text-gray-600">
                            @if($section->teacher)
                                {{ $section->teacher->first_name }} {{ $section->teacher->middle_name }} {{ $section->teacher->last_name }}
                            @else
                                Not Assigned
                            @endif
                        </td>
                        <td class="px-6 py-4 space-x-2">
                            <a href="{{ route('admin.sections.edit', $section) }}"
                               class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg shadow-sm transition duration-200">
                                Edit
                            </a>
                            <form action="{{ route('admin.sections.destroy', $section) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg shadow-sm transition duration-200">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if($sections->isEmpty())
            <p class="p-6 text-center text-gray-500">No sections found.</p>
        @endif
    </div>
</div>

<style>
    /* Fade-in animation for table card */
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
