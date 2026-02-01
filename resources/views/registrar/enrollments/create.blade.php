<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enroll Student | Registrar Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js for interactivity -->
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-100 to-blue-200 p-6">

   <!-- ================= HEADER ================= -->
<header class="sticky top-0 z-50 backdrop-blur-lg bg-white/80 shadow-md rounded-xl">
    <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-6">

        <div class="flex items-center gap-4">
            <a href="{{ route('registrar.dashboard') }}" 
               class="hover:bg-orange-300 text-gray-700 px-3 py-2 rounded-lg shadow-sm transition flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                          d="M15 19l-7-7 7-7"/>
                </svg>
            </a>

            <img src="{{ asset('images/logo.jpg') }}" class="h-16 w-16 rounded-full shadow-lg ring-4 ring-indigo-200">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">Teaching Assignment Management</h1>
                <p class="text-sm text-gray-500">Tugawe Elementary School | Dauin District</p>
            </div>
        </div>

    </div>
</header>

<!-- ================= ENROLLMENT CARD ================= -->
<div class="max-w-4xl mx-auto mt-8 bg-white rounded-2xl shadow-2xl p-8 transform transition duration-500 hover:scale-105 hover:shadow-3xl">
    <h2 class="text-2xl font-bold text-gray-700 mb-6">Enroll Student</h2>

    <!-- Success / Error Messages -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.500ms
             class="bg-green-100 border border-green-300 text-green-800 p-4 rounded-lg mb-6 flex justify-between items-center">
            {{ session('success') }}
            <button @click="show=false" class="text-green-800 font-bold">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.500ms
             class="bg-red-100 border border-red-300 text-red-800 p-4 rounded-lg mb-6 flex justify-between items-center">
            {{ session('error') }}
            <button @click="show=false" class="text-red-800 font-bold">&times;</button>
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('registrar.enrollments.store') }}" method="POST" class="space-y-6" x-data>
        @csrf

        <!-- Student Select -->
        <div class="relative">
            <label class="block text-gray-700 font-medium mb-2">Select Student</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5.121 17.804A13.937 13.937 0 0112 15c2.211 0 4.307.51 6.121 1.404M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </span>
                <select name="student_id"
                        class="w-full border border-gray-300 rounded-xl p-3 pl-10 focus:ring-2 focus:ring-indigo-300 focus:outline-none hover:border-indigo-300 transition">
                    <option value="" disabled selected>-- Choose a student --</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Section Select -->
        <div class="relative">
            <label class="block text-gray-700 font-medium mb-2">Select Section</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 7h18M3 12h18M3 17h18" />
                    </svg>
                </span>
                <select name="section_id"
                        class="w-full border border-gray-300 rounded-xl p-3 pl-10 focus:ring-2 focus:ring-indigo-300 focus:outline-none hover:border-indigo-300 transition">
                    <option value="" disabled selected>-- Choose a section --</option>
                    @foreach($sections as $section)
                        <option value="{{ $section->id }}">{{ $section->name }} ({{ $section->year_level }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl shadow-lg transition transform hover:scale-105 w-full md:w-auto font-semibold">
            Enroll Student
        </button>
    </form>
</div>


</body>
</html>
