<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teachers | Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-green-100 to-green-200 p-6">

<div class="max-w-6xl mx-auto">

     
    <!-- Header -->
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center space-x-3">
        <!-- Back Button -->
        <a href="{{ route('admin.dashboard') }}"
           class=" hover:bg-green-300 text-gray-700 px-3 py-1 rounded-lg shadow-sm transition duration-200 flex items-center space-x-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span></span>
        </a>

        <h1 class="text-2xl font-bold text-gray-800">Teachers</h1>
    </div>

    <a href="{{ route('admin.teachers.create') }}"
       class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow-lg transition duration-200 hover:scale-105">
        Add Teacher
    </a>
</div>

    <!-- Teachers Table -->
    <div class="bg-white rounded-3xl shadow-lg overflow-hidden animate-fadeIn">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-green-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach($teachers as $teacher)
                <tr class="hover:bg-green-50 transition duration-200">
                    <td class="px-6 py-4 text-gray-700 font-medium">{{ $teacher->first_name }} {{ $teacher->last_name }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $teacher->email }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $teacher->username }}</td>
                    <td class="px-6 py-4 flex space-x-2">
                        <a href="{{ route('admin.teachers.edit', $teacher) }}"
                           class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg shadow-sm transition duration-200">
                            Edit
                        </a>
                        <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" class="inline">
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

        @if($teachers->isEmpty())
            <p class="p-6 text-center text-gray-500">No teachers found.</p>
        @endif
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
