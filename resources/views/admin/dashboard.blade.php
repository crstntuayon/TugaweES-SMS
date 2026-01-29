<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Student Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes flash {
            0%   { background-color: #fff8c4; }
            50%  { background-color: #fef3c7; }
            100% { background-color: transparent; }
        }
        .flash {
            animation: flash 0.8s ease-in-out;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-100 via-blue-100 to-sky-200">

<header class="sticky top-0 z-50 backdrop-blur bg-white/80 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/logo.jpg') }}" class="h-12 w-12 rounded-full shadow" alt="School Logo">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Admin Dashboard</h1>
                <p class="text-sm text-gray-500">Tugawe Elementary School</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-sm text-gray-600 hidden md:block">{{ auth()->user()->email }}</span>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium shadow">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </div>
</header>

<main class="max-w-7xl mx-auto px-6 py-10">

    <!-- NAVIGATION TABS -->
    <div class="flex flex-wrap gap-3 mb-10">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm shadow">Dashboard</a>
        <a href="{{ route('admin.students.index') }}" class="px-4 py-2 rounded-lg bg-white hover:bg-indigo-50 text-gray-700 text-sm shadow">Students</a>
        <a href="{{ route('admin.teachers.index') }}" class="px-4 py-2 rounded-lg bg-white hover:bg-green-50 text-gray-700 text-sm shadow">Teachers</a>
        <a href="{{ route('admin.sections.index') }}" class="px-4 py-2 rounded-lg bg-white hover:bg-yellow-50 text-gray-700 text-sm shadow">Sections</a>
    </div>

    <!-- STATS CARDS -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">

        <!-- Students -->
        <div id="students-card" class="bg-white/90 backdrop-blur rounded-2xl shadow-lg p-6 hover:scale-105 transition">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-semibold text-gray-600">Total Students</h2>
                <span class="bg-indigo-100 text-indigo-600 p-2 rounded-lg">🎓</span>
            </div>
            <p id="students-count" class="text-4xl font-bold text-indigo-600 mt-4">{{ $totalStudents ?? 0 }}</p>
            <a href="{{ route('admin.students.index') }}" class="mt-4 inline-block text-sm text-indigo-600 hover:underline">Manage Students →</a>
        </div>

        <!-- Teachers -->
        <div id="teachers-card" class="bg-white/90 backdrop-blur rounded-2xl shadow-lg p-6 hover:scale-105 transition">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-semibold text-gray-600">Total Teachers</h2>
                <span class="bg-green-100 text-green-600 p-2 rounded-lg">👩‍🏫</span>
            </div>
            <p id="teachers-count" class="text-4xl font-bold text-green-600 mt-4">{{ $totalTeachers ?? 0 }}</p>
            <a href="{{ route('admin.teachers.index') }}" class="mt-4 inline-block text-sm text-green-600 hover:underline">Manage Teachers →</a>
        </div>

        <!-- Sections -->
        <div id="sections-card" class="bg-white/90 backdrop-blur rounded-2xl shadow-lg p-6 hover:scale-105 transition">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-semibold text-gray-600">Total Sections</h2>
                <span class="bg-yellow-100 text-yellow-600 p-2 rounded-lg">🏫</span>
            </div>
            <p id="sections-count" class="text-4xl font-bold text-yellow-600 mt-4">{{ $totalSections ?? 0 }}</p>
            <a href="{{ route('admin.sections.index') }}" class="mt-4 inline-block text-sm text-yellow-600 hover:underline">Manage Sections →</a>
        </div>
    </section>

    <!-- QUICK ACTIONS -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('admin.students.create') }}" class="group bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl p-6 shadow-lg transition hover:scale-105">
            <h3 class="font-semibold text-lg">Add Student</h3>
            <p class="mt-2 text-sm text-indigo-200">Enroll a new student</p>
        </a>

        <a href="{{ route('admin.teachers.create') }}" class="group bg-green-600 hover:bg-green-700 text-white rounded-2xl p-6 shadow-lg transition hover:scale-105">
            <h3 class="font-semibold text-lg">Add Teacher</h3>
            <p class="mt-2 text-sm text-green-200">Create teacher account</p>
        </a>

        <a href="{{ route('admin.sections.create') }}" class="group bg-yellow-500 hover:bg-yellow-600 text-white rounded-2xl p-6 shadow-lg transition hover:scale-105">
            <h3 class="font-semibold text-lg">Create Section</h3>
            <p class="mt-2 text-sm text-yellow-100">Organize classes</p>
        </a>
    </section>

</main>

<!-- ===== LIVE COUNTER + FLASH ===== -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const animateCount = (el, target, cardEl) => {
        let current = parseInt(el.textContent) || 0;
        if(current === target) return;

        let diff = Math.abs(target - current);
        let increment = Math.max(Math.ceil(diff / 50), 1);

        cardEl.classList.add('flash');

        let interval = setInterval(() => {
            if(current < target) current += increment;
            else current -= increment;

            if(current > target && current < target + increment) current = target;
            if(current < target && current > target - increment) current = target;

            el.textContent = current;

            if(current === target){
                clearInterval(interval);
                setTimeout(()=> cardEl.classList.remove('flash'),300);
            }
        }, 15);
    };

    const updateCounts = async () => {
        try{
            const res = await fetch("{{ route('admin.dashboard.stats') }}");
            const data = await res.json();

            animateCount(document.getElementById('students-count'), data.students, document.getElementById('students-card'));
            animateCount(document.getElementById('teachers-count'), data.teachers, document.getElementById('teachers-card'));
            animateCount(document.getElementById('sections-count'), data.sections, document.getElementById('sections-card'));
        } catch(e){
            console.error('Error fetching dashboard stats:', e);
        }
    }

    updateCounts();
    setInterval(updateCounts, 10000); // refresh every 10 seconds
});
</script>

</body>
</html>
