<!DOCTYPE html>
<html lang="en" x-data="dashboard()">
<head>
    <meta charset="UTF-8">
    <title>Registrar Dashboard | Student Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
    [x-cloak] {
        display: none !important;
    }
</style>

</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-100 to-blue-200 p-6 font-sans">

<!-- ================= HEADER ================= -->
<header class="sticky top-0 z-50 backdrop-blur-lg bg-white/80 shadow-md rounded-b-2xl transition-all duration-500">
    <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col md:flex-row items-center md:justify-between gap-4">

        <!-- Logo & Title -->
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/logo.jpg') }}" class="h-20 w-20 rounded-full shadow-lg ring-4 ring-indigo-300 transition-transform duration-500 hover:scale-110" alt="School Logo">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Registrar Dashboard</h1>
                <p class="text-sm md:text-base text-gray-500">Tugawe Elementary School | Dauin District</p>
            </div>
        </div>

      <!-- Account Dropdown -->
<div class="relative" x-data="{ open: false }">
    <!-- Toggle Button -->
    <button @click="open = !open" 
            class="flex items-center gap-2 bg-white hover:bg-gray-100 px-4 py-2 rounded-lg shadow-md text-sm font-medium text-gray-700 transition duration-300">
        <span class="hidden md:block">Account</span>
        <svg class="w-4 h-4 text-gray-500 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open" 
         @click.away="open = false" 
         x-transition 
         class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50">
        
        <!-- User Info -->
        <div class="px-4 py-3 border-b">
            <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name ?? 'User' }}</p>
            <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
        </div>

        <!-- Links -->
        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
            👤 Profile
        </a>

        <div class="border-t"></div>

        <!-- Logout -->
        <a href="{{ route('logout') }}" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
           class="flex items-center gap-2 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
            </svg>
            Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
    </div>
</div>

</header>

<!-- ================= DASHBOARD CARDS ================= -->
<main class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">

    <!-- Total Students -->
    <div class="bg-white rounded-3xl shadow-lg p-6 flex flex-col items-start transition transform hover:scale-105 hover:shadow-2xl cursor-pointer group">
        <div class="flex items-center gap-3 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-600 group-hover:scale-110 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.211 0 4.307.51 6.121 1.404M15 11a3 3 0 11-6 0 3 3 0 016 0z M12 15v6m-6 0h12" />
            </svg>
            <h2 class="text-lg font-semibold text-gray-700">Total Students</h2>
        </div>
        <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $totalStudents ?? 0 }}</p>
        <a href="{{ route('registrar.students.index') }}" class="mt-4 text-indigo-600 hover:underline font-medium transition">Manage Students</a>
    </div>

    <!-- Total Teachers -->
    <div class="bg-white rounded-3xl shadow-lg p-6 flex flex-col items-start transition transform hover:scale-105 hover:shadow-2xl cursor-pointer group">
        <div class="flex items-center gap-3 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600 group-hover:scale-110 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7a4 4 0 118 0 4 4 0 01-8 0z M12 14c-4 0-6 2-6 4v1h12v-1c0-2-2-4-6-4z" />
            </svg>
            <h2 class="text-lg font-semibold text-gray-700">Total Teachers</h2>
        </div>
        <p class="text-3xl font-bold text-green-600 mt-2">{{ $totalTeachers ?? 0 }}</p>
       
    </div>

    <!-- Enroll New Student Button -->
    <button @click="openEnrollModal()" 
        class="bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-700 hover:to-indigo-600 text-white rounded-3xl p-6 shadow-lg transition transform hover:scale-105 flex flex-col items-start cursor-pointer group">
        <div class="flex items-center gap-3 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white group-hover:scale-110 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            <h3 class="font-semibold text-lg">Enroll New Student</h3>
        </div>
        <p class="mt-1 text-sm text-white/80">Add a student to a section quickly</p>
    </button>

    <!-- Issue School ID -->
<div @click="openIdModal()"
     class="bg-gradient-to-r from-green-600 to-emerald-500 hover:from-green-700 hover:to-emerald-600 
            text-white rounded-3xl p-6 shadow-lg transition transform hover:scale-105 
            flex flex-col items-start cursor-pointer group">
    <div class="flex items-center gap-3 mb-2">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-8 w-8 group-hover:scale-110 transition-transform"
             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M16 12H8m8 4H8m6-10H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V8l-4-4z" />
        </svg>
        <h3 class="font-semibold text-lg">Issue School ID</h3>
    </div>
    <p class="text-sm text-white/90">
        Generate and assign official school ID
    </p>
</div>

</main>



<!-- ================= ENROLL MODAL ================= -->
<div x-show="enrollModal" x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div x-show="enrollModal" x-transition.scale
         class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-6 transform transition-all duration-300 relative">

        <!-- Close Button -->
        <button @click="closeEnrollModal()"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition text-xl font-bold">&times;</button>

        <h2 class="text-xl font-bold text-gray-800 mb-6">Enroll New Student</h2>

        <!-- Form -->
        <form action="{{ route('registrar.enrollments.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Student Select -->
            <div class="relative">
                <label class="block text-gray-700 font-medium mb-2">Select Student</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.211 0 4.307.51 6.121 1.404M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </span>
                    <select name="student_id" required class="w-full border border-gray-300 rounded-xl p-3 pl-10 focus:ring-2 focus:ring-indigo-300 focus:outline-none hover:border-indigo-300 transition">
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                        </svg>
                    </span>
                    <select name="section_id" required class="w-full border border-gray-300 rounded-xl p-3 pl-10 focus:ring-2 focus:ring-indigo-300 focus:outline-none hover:border-indigo-300 transition">
                        <option value="" disabled selected>-- Choose a section --</option>
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}">{{ $section->name }} ({{ $section->year_level }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-3 mt-4">
                <button type="button" @click="closeEnrollModal()" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 transition">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition transform hover:scale-105">Enroll Student</button>
            </div>
        </form>
    </div>
</div>


<!-- ================= ISSUE SCHOOL ID MODAL ================= -->
<div x-show="idModal" x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">

    <div x-show="idModal" x-transition.scale
         class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 relative">

        <!-- Close Button -->
        <button @click="closeIdModal()"
                class="absolute top-4 right-4 text-gray-400 hover:text-red-500 text-2xl font-bold">
            &times;
        </button>

        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Issue School ID
            </h2>
            <p class="text-sm text-gray-500">
                Select a role and user to generate an official school ID.
            </p>
        </div>

        <!-- Form -->
        <form action="{{ route('registrar.id.generate') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Select Type -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Role
                </label>
                <select name="type" required
                        class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="" disabled selected>Choose role</option>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                </select>
            </div>

            <!-- Select Person -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Select Person
                </label>
                <select name="id" required
                        class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                    <optgroup label="Students">
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">
                                {{ $student->first_name }} {{ $student->last_name }}
                            </option>
                        @endforeach
                    </optgroup>

                    <optgroup label="Teachers">
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">
                                {{ $teacher->first_name }} {{ $teacher->last_name }}
                            </option>
                        @endforeach
                    </optgroup>

                </select>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 pt-4">
                <button type="button"
                        @click="closeIdModal()"
                        class="px-4 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100">
                    Cancel
                </button>

                <button type="submit"
                        class="px-5 py-2 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 shadow">
                    Generate ID
                </button>
            </div>
        </form>

    </div>
</div>

<!-- ================= DASHBOARD SCRIPT ================= -->
<script>
function dashboard() {
    return {
        // Modals
        enrollModal: false,
        idModal: false,

        // Enroll modal controls
        openEnrollModal() {
            this.enrollModal = true
        },
        closeEnrollModal() {
            this.enrollModal = false
        },

        // School ID modal controls
        openIdModal() {
            this.idModal = true
        },
        closeIdModal() {
            this.idModal = false
        },
    }
}
</script>

</body>
</html>
