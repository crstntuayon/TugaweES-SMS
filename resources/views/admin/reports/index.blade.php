<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reports Dashboard | Student Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <style>
        @media print {
            body { background: white !important; }
            button, select, form { display: none !important; }
            .shadow-md, .shadow-lg, .shadow-xl { box-shadow: none !important; }
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-indigo-100 via-blue-100 to-sky-200">
 

<div class="flex h-screen bg-gray-100 overflow-hidden" x-data="{ sidebarOpen: true }">


<!-- SIDEBAR -->
<aside
x-data="{ sidebarOpen: true }"
class="bg-white/80 backdrop-blur-xl shadow-2xl border-r border-gray-200 
flex flex-col transition-all duration-300 ease-in-out
h-screen sticky top-0"
:class="sidebarOpen ? 'w-64' : 'w-20'"
>

<!-- HEADER -->
<div class="flex items-center justify-between p-4 border-b">

<span
class="font-bold text-gray-800 text-lg tracking-wide"
x-show="sidebarOpen"
x-transition>
Admin Panel
</span>

<button
@click="sidebarOpen = !sidebarOpen"
class="p-2 rounded-lg hover:bg-indigo-50 hover:scale-110 transition">

<svg xmlns="http://www.w3.org/2000/svg"
class="w-6 h-6 text-gray-700"
fill="none"
stroke="currentColor"
stroke-width="2"
viewBox="0 0 24 24">

<path stroke-linecap="round"
stroke-linejoin="round"
d="M4 6h16M4 12h16M4 18h16"/>

</svg>
</button>

</div>


<!-- USER PROFILE -->
<div class="p-4 border-b">

@php
$first = auth()->user()->first_name;
$last = auth()->user()->last_name;
$initials = strtoupper(substr($first,0,1) . substr($last,0,1));
@endphp

<div class="flex items-center gap-3">

<div class="relative">

<!-- Avatar -->
<div class="w-11 h-11 flex items-center justify-center rounded-full bg-gradient-to-r from-indigo-500 to-indigo-700 text-white font-bold shadow-md">
{{ $initials }}
</div>

<!-- Online indicator -->
<span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>

</div>

<div x-show="sidebarOpen" x-transition>

<p class="text-sm font-semibold text-gray-800 leading-tight">

{{ auth()->user()->first_name }}
{{ auth()->user()->middle_name }}
{{ auth()->user()->last_name }}
{{ auth()->user()->suffix }}

</p>

<p class="text-xs text-gray-500 truncate">
{{ auth()->user()->email }}
</p>

</div>

</div>

</div>


<!-- NAVIGATION -->
<div class="flex flex-col gap-2 p-3 flex-1 text-gray-600">


<!-- Dashboard -->
<a href="{{ route('admin.dashboard') }}"
class="group relative flex items-center gap-3 px-3 py-2 rounded-xl transition-all duration-200
{{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-indigo-500 to-indigo-600 text-white shadow-md scale-[1.02]' : 'hover:bg-indigo-50 hover:text-indigo-600 hover:scale-[1.02]' }}">

<svg xmlns="http://www.w3.org/2000/svg"
class="w-5 h-5 group-hover:scale-110 transition"
fill="none"
stroke="currentColor"
stroke-width="2"
viewBox="0 0 24 24">

<path d="M3 13h8V3H3zM13 21h8V11h-8zM13 3h8v6h-8zM3 21h8v-6H3z"/>

</svg>

<span x-show="sidebarOpen">Dashboard</span>

</a>


<!-- Profile -->
<a href="{{ route('profile.edit') }}"
class="group flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 hover:scale-[1.02] transition">

<svg xmlns="http://www.w3.org/2000/svg"
class="w-5 h-5 group-hover:scale-110 transition"
fill="none"
stroke="currentColor"
stroke-width="2"
viewBox="0 0 24 24">

<circle cx="12" cy="7" r="4"/>
<path d="M5.5 21a7.5 7.5 0 0 1 13 0"/>

</svg>

<span x-show="sidebarOpen">Profile</span>

</a>


<!-- Manage Users -->
<button onclick="openManageUsersModal()"
class="group flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 hover:scale-[1.02] transition w-full text-left">

<svg xmlns="http://www.w3.org/2000/svg"
class="w-5 h-5 group-hover:scale-110 transition"
fill="none"
stroke="currentColor"
stroke-width="2"
viewBox="0 0 24 24">

<path d="M17 21v-2a4 4 0 0 0-3-3.87"/>
<path d="M7 21v-2a4 4 0 0 1 3-3.87"/>
<circle cx="12" cy="7" r="4"/>

</svg>

<span x-show="sidebarOpen">Manage Users</span>

</button>


<!-- Create Admin -->
<button onclick="openAddAdminModal()"
class="group flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-green-50 hover:text-green-600 hover:scale-[1.02] transition">

<svg xmlns="http://www.w3.org/2000/svg"
class="w-5 h-5 group-hover:scale-110 transition"
fill="none"
stroke="currentColor"
stroke-width="2"
viewBox="0 0 24 24">

<path d="M12 5v14M5 12h14"/>

</svg>

<span x-show="sidebarOpen">Create Admin</span>

</button>


<!-- Reports -->
<a href="{{ route('admin.reports') }}"
class="group flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-purple-50 hover:text-purple-600 hover:scale-[1.02] transition">

<svg xmlns="http://www.w3.org/2000/svg"
class="w-5 h-5 group-hover:scale-110 transition"
fill="none"
stroke="currentColor"
stroke-width="2"
viewBox="0 0 24 24">

<path d="M3 3v18h18"/>
<path d="M7 15l4-4 4 4 5-5"/>

</svg>

<span x-show="sidebarOpen">Reports</span>

</a>


<!-- Graduation -->
<a href="{{ route('admin.students.graduation') }}"
class="group flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-yellow-50 hover:text-yellow-600 hover:scale-[1.02] transition">

<svg xmlns="http://www.w3.org/2000/svg"
class="w-5 h-5 group-hover:scale-110 transition"
fill="none"
stroke="currentColor"
stroke-width="2"
viewBox="0 0 24 24">

<path d="M22 10L12 5 2 10l10 5 10-5z"/>
<path d="M6 12v5a6 3 0 0 0 12 0v-5"/>

</svg>

<span x-show="sidebarOpen">Graduation</span>

</a>


<!-- Issue School IDs -->
<button onclick="openSectionModal()"
class="group flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 hover:scale-[1.02] transition">

<svg xmlns="http://www.w3.org/2000/svg"
class="w-5 h-5 group-hover:scale-110 transition"
fill="none"
stroke="currentColor"
stroke-width="2"
viewBox="0 0 24 24">

<rect x="3" y="6" width="18" height="12" rx="2"/>
<path d="M7 10h6M7 14h4"/>

</svg>

<span x-show="sidebarOpen">Issue School IDs</span>

</button>


<!-- SCHOOL YEAR -->
<div class="bg-gray-50 p-3 rounded-xl mt-3 shadow-inner" x-show="sidebarOpen">

<span class="text-xs font-semibold text-gray-500">
ACTIVE SCHOOL YEAR
</span>

<form action="{{ route('admin.schoolyears.activate') }}" method="POST">
@csrf

<select
name="school_year"
onchange="this.form.submit()"
class="w-full border mt-2 px-2 py-1 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">

@foreach($schoolYears as $year)

<option value="{{ $year->id }}"
{{ $year->is_active ? 'selected' : '' }}>
{{ $year->name }}
</option>

@endforeach

</select>

</form>

</div>

</div>


<!-- LOGOUT -->
<div class="p-3 border-t">

<a href="{{ route('logout') }}"
onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
class="flex items-center gap-3 px-3 py-2 rounded-xl text-red-600 hover:bg-red-50 hover:scale-[1.02] transition">

<svg xmlns="http://www.w3.org/2000/svg"
class="w-5 h-5"
fill="none"
stroke="currentColor"
stroke-width="2"
viewBox="0 0 24 24">

<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
<path d="M16 17l5-5-5-5"/>
<path d="M21 12H9"/>

</svg>

<span x-show="sidebarOpen">Logout</span>

</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
@csrf
</form>

</div>

</aside>


 <main class="flex-1 p-6 space-y-6 overflow-y-auto h-screen">

    <!-- HEADER -->
    <div class="bg-white/70 backdrop-blur-xl border border-white/40 
                shadow-xl rounded-3xl p-6 flex flex-col md:flex-row 
                justify-between items-center gap-6">

        <div class="flex items-center gap-5">
             <a href="{{ route('admin.dashboard') }}"
           class="p-2 rounded-lg hover:bg-gray-100 transition">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5 text-gray-700"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 19l-7-7 7-7"/>
            </svg>
        </a>

            <img src="{{ asset('images/logo.jpg') }}"
                 class="h-16 w-16 rounded-2xl shadow-md ring-4 ring-indigo-100"
                 alt="School Logo">

            <div>
                <h1 class="text-3xl font-bold text-slate-800 tracking-tight">
                    Reports Dashboard
                </h1>
                <p class="text-slate-500 text-sm">
                    Academic Performance & Enrollment Overview
                </p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <form id="schoolYearForm" action="{{ route('admin.reports') }}" method="GET">
                <select name="school_year"
                        onchange="document.getElementById('schoolYearForm').submit()"
                        class="rounded-2xl border-slate-300 shadow-sm 
                               focus:ring-indigo-500 focus:border-indigo-500 text-sm px-4 py-2">
                    @foreach($schoolYears as $year)
                        <option value="{{ $year->id }}"
                            {{ request('school_year') == $year->id ? 'selected' : '' }}>
                            {{ $year->name }}
                        </option>
                    @endforeach
                </select>
            </form>

            <button onclick="window.print()"
                class="bg-indigo-600 hover:bg-indigo-700 
                       text-white text-sm px-5 py-2.5 rounded-2xl shadow-md transition">
                Print
            </button>

            <button onclick="exportPDF()"
                class="bg-emerald-600 hover:bg-emerald-700 
                       text-white text-sm px-5 py-2.5 rounded-2xl shadow-md transition">
                Export PDF
            </button>
        </div>
    </div>

    <!-- SUMMARY CARDS -->
    <div class="grid md:grid-cols-3 gap-8">
        @foreach($cards as $card)
            <div class="bg-white rounded-3xl p-7 
                        shadow-md hover:shadow-2xl 
                        hover:-translate-y-1 transition duration-300">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-slate-500 text-sm uppercase tracking-wide">
                            {{ $card['title'] }}
                        </p>
                        <h2 class="text-4xl font-bold mt-2 text-slate-800">
                            {{ $card['value'] }}
                        </h2>
                    </div>
                    <div class="text-4xl">
                        {{ $card['icon'] }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>


  <!-- SECTIONS & TEACHERS -->
<div>
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6 gap-2 md:gap-0">
        <h2 class="text-2xl font-bold text-slate-800">
            Sections & Advisers
        </h2>
        <p class="text-sm text-slate-500">
            Teachers handling each section
        </p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($studentsPerSection as $section)

            @php
                $teacher = $section->teacher ?? null;
                // Fix teacher photo URL
                $photoUrl = $teacher && $teacher->photo
                    ? asset('storage/teachers/' . $teacher->photo)
                    : asset('images/photo-placeholder.png');

                // Progress bar percentage
                $progress = min(($section->students_count / 50) * 100, 100);
            @endphp

            <div class="bg-white rounded-3xl shadow-md hover:shadow-2xl transition-transform duration-300 overflow-hidden hover:-translate-y-1">
                
                <!-- Top Gradient Accent -->
                <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500"></div>

                <div class="p-6 space-y-4">

                    <!-- Teacher Info -->
                    <div class="flex items-center gap-4">
                        <img src="{{ $photoUrl }}" 
                             class="h-16 w-16 rounded-2xl object-cover shadow-md" 
                             alt='Teacher'>

                        <div>
                            <p class="font-semibold text-slate-800 text-sm">
                                {{ $teacher 
                                    ? trim("{$teacher->first_name} {$teacher->middle_name} {$teacher->last_name} {$teacher->suffix}") 
                                    : 'No Teacher Assigned!' 
                                }}
                            </p>
                            <p class="text-sm text-slate-500">Section Adviser</p>
                        </div>
                    </div>

                    <!-- Section Info -->
                    <div class="border-t pt-4 space-y-2">
                        <p class="text-sm text-slate-500 uppercase tracking-wide">Section</p>
                        <h4 class="text-lg font-bold text-slate-700">{{ $section->year_level }} - {{ $section->name }}</h4>

                        <div class="flex items-center justify-between mt-4">
                            <span class="text-sm text-slate-500">Students</span>
                            <span class="text-xl font-bold text-emerald-600">{{ $section->students_count }}</span>
                        </div>

                        <!-- Progress bar -->
                        <div class="relative w-full h-3 bg-slate-200 rounded-full mt-2 overflow-hidden">
                            <div class="absolute h-3 rounded-full bg-gradient-to-r from-emerald-400 to-emerald-600 transition-all duration-700 ease-out"
                                 style="width: {{ $progress }}%">
                            </div>

                            <!-- Circle tip -->
                            <div class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-5 h-5 bg-white border-2 border-emerald-500 rounded-full shadow-md"
                                 style="left: {{ $progress }}%">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        @endforeach
    </div>
</div>


    <!-- CHARTS -->
    <div class="grid lg:grid-cols-2 gap-10">
        <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-xl transition">
            <h2 class="text-lg font-semibold text-slate-700 mb-6">
                Total Enrollees Distribution
            </h2>
            <canvas id="enrolleesPieChart"></canvas>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-xl transition">
            <h2 class="text-lg font-semibold text-slate-700 mb-6">
                Total Enrollees by Gender
            </h2>
            <canvas id="enrolleesGenderChart"></canvas>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-xl transition">
            <h2 class="text-lg font-semibold text-slate-700 mb-6">
                Students Per Section
            </h2>
            <canvas id="sectionChart"></canvas>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-xl transition">
            <h2 class="text-lg font-semibold text-slate-700 mb-6">
                Top 10 Students (Average Grade)
            </h2>
            <canvas id="topStudentsChart"></canvas>
        </div>
    </div>

    <!-- TABLES -->
    <div class="space-y-10">

      <!-- Enrollees Table -->
<div class="bg-white rounded-3xl shadow-md p-8 overflow-x-auto">
    <h2 class="text-xl font-semibold mb-6 text-slate-800">
        Total Enrollees
    </h2>

    <table class="w-full text-sm">
        <thead class="text-slate-500 text-xs uppercase tracking-wider border-b">
            <tr>
                <th class="text-left py-3">School Year</th>
                <th class="text-left py-3">Male</th>
                <th class="text-left py-3">Female</th>
                <th class="text-left py-3">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($enrolleesPerYear as $year)
                @php
                    // Determine if this is the active year
                    $isActive = $schoolYears->find($activeYearId)->name === $year['school_year'];
                @endphp

                <tr class="hover:bg-slate-50 transition {{ $isActive ? 'bg-indigo-50 font-semibold' : '' }}">
                    <td class="py-3">{{ $year['school_year'] }}</td>
                    <td class="py-3 text-blue-600 font-semibold">{{ $year['male'] }}</td>
                    <td class="py-3 text-pink-600 font-semibold">{{ $year['female'] }}</td>
                    <td class="py-3 text-indigo-600 font-bold">{{ $year['total'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

        <!-- Top Students Table -->
        <div class="bg-white rounded-3xl shadow-md p-8 overflow-x-auto">
            <h2 class="text-xl font-semibold mb-6 text-slate-800">
                Top 10 Students
            </h2>

            <table class="w-full text-sm">
                <thead class="text-slate-500 text-xs uppercase tracking-wider border-b">
                    <tr>
                        <th class="text-left py-3">Rank</th>
                        <th class="text-left py-3">Student Name</th>
                        <th class="text-left py-3">Average Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topStudents as $index => $student)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3 font-semibold">#{{ $index + 1 }}</td>
                            <td class="py-3">{{ $student->full_name }}</td>
                            <td class="py-3 font-bold text-purple-600">
                                {{ $student->average_grade }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</div>

<!-- EXPORT PDF -->
<script>
function exportPDF() {
    const element = document.querySelector('.max-w-7xl');
    html2pdf().from(element).save('reports-dashboard.pdf');
}
</script>

<!-- CHARTS -->
<script>
const chartOptions = {
    responsive: true,
    plugins: { legend: { position: 'top' } },
    scales: {
        y: {
            beginAtZero: true,
            grid: { color: "rgba(0,0,0,0.05)" }
        }
    }
};

new Chart(document.getElementById('enrolleesGenderChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($enrolleesPerYear->pluck('school_year')) !!},
        datasets: [
            { label: 'Male', data: {!! json_encode($enrolleesPerYear->pluck('male')) !!}, backgroundColor: 'rgba(59,130,246,0.7)' },
            { label: 'Female', data: {!! json_encode($enrolleesPerYear->pluck('female')) !!}, backgroundColor: 'rgba(236,72,153,0.7)' }
        ]
    },
    options: chartOptions
});

new Chart(document.getElementById('sectionChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($studentsPerSection->pluck('section_name')) !!},
        datasets: [
            { label: 'Students', data: {!! json_encode($studentsPerSection->pluck('students_count')) !!}, backgroundColor: 'rgba(16,185,129,0.7)' }
        ]
    },
    options: chartOptions
});

new Chart(document.getElementById('topStudentsChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($topStudents->pluck('full_name')) !!},
        datasets: [
            { label: 'Average Grade', data: {!! json_encode($topStudents->pluck('average_grade')) !!}, backgroundColor: 'rgba(139,92,246,0.7)' }
        ]
    },
    options: { ...chartOptions, indexAxis: 'y' }
});

new Chart(document.getElementById('enrolleesPieChart'), {
    type: 'pie',
    data: {
        labels: ['Male', 'Female'],
        datasets: [{
            data: [{{ $totalMale }}, {{ $totalFemale }}],
            backgroundColor: ['rgba(59,130,246,0.8)','rgba(236,72,153,0.8)']
        }]
    },
    options: { responsive: true }
});
</script>



<!-- ================= MANAGE USERS MODAL ================= -->
<div id="manageUsersModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl p-6 relative overflow-y-auto max-h-[90vh]">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Manage Users</h2>
            <button type="button" onclick="closeManageUsersModal()" class="text-gray-500 hover:text-red-500 text-2xl font-bold">&times;</button>
        </div>

        <!-- Search -->
        <div class="relative w-full max-w-md mb-4">
            <input type="text"
                   id="liveUserSearch"
                   placeholder="Search name..."
                   autocomplete="off"
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">

            <div id="searchResults"
                 class="absolute w-full bg-white border rounded-lg shadow-lg mt-1 hidden max-h-60 overflow-y-auto z-50">
            </div>
        </div>

        <!-- Table container with spinner -->
        <div class="relative">

            <!-- Spinner -->
            <div id="usersLoadingSpinner"
                 class="hidden absolute inset-0 bg-white/70 flex items-center justify-center z-10">
                <svg class="animate-spin h-8 w-8 text-indigo-600"
                     xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24">
                    <circle class="opacity-25"
                            cx="12" cy="12" r="10"
                            stroke="currentColor"
                            stroke-width="4"></circle>
                    <path class="opacity-75"
                          fill="currentColor"
                          d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
            </div>

            <div id="usersTableContainer">
                <table class="w-full border rounded-lg overflow-hidden text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">Name</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Created</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($users ?? [] as $user)
                        <tr class="border-t hover:bg-gray-50 transition"
                            data-id="{{ $user->id }}"
                            data-first-name="{{ $user->first_name }}"
                            data-last-name="{{ $user->last_name }}"
                            data-email="{{ $user->email }}"
                            data-username="{{ $user->username }}"
                            data-role-id="{{ $user->role_id }}"
                            data-name="{{ strtolower($user->first_name . ' ' . $user->last_name) }}">

                            <td class="p-3">
                            <div class="flex items-center gap-4">
        <img src="{{ $user->photo ? asset('storage/'.$user->photo) : asset('images/photo-placeholder.png') }}"
             class="w-12 h-12 rounded-full object-cover shadow" alt="Photo">
        <div>
        
        <p>{{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }} {{ $user->suffix }}</p>
    </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->role->name ?? 'N/A' }}</td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>

                            <td class="p-3 text-center flex justify-center gap-2">
                                <button onclick="openEditUserModal({{ $user->id }})"
                                         class="text-yellow-500 hover:text-yellow-700 transition transform hover:scale-110">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M11 5h2m2 2l6 6-6 6-6-6 6-6zM4 21h16"/>
    </svg>
                                </button>

                                <button onclick="openDeleteUserModal({{ $user->id }})"
                                        class="text-red-500 hover:text-red-700 transition transform hover:scale-110">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                 a2 2 0 01-1.995-1.858L5 7m5-4h4"/>
    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-4">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-3 flex justify-center">
                    {{ $users->links() }}
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: "{{ session('success') }}",
    confirmButtonColor: '#4f46e5',
    background: '#eef2ff',
    color: '#1e1b4b'
});
</script>
@endif

        <!-- Footer -->
        <div class="mt-4 flex justify-between items-center text-gray-700 text-sm">
            <p>Total Users: {{ $users->total() ?? 0 }}</p>
            <p>Showing {{ $users->count() }} of {{ $users->total() ?? 0 }}</p>
        </div>

    </div>
</div>
<script>

// ================= MANAGE MODAL =================
function openManageUsersModal() {
    document.getElementById('manageUsersModal').classList.remove('hidden');
    document.getElementById('manageUsersModal').classList.add('flex');
}

function closeManageUsersModal() {
    document.getElementById('manageUsersModal').classList.add('hidden');
    document.getElementById('manageUsersModal').classList.remove('flex');
}

</script>


<!-- ================= ADD ADMIN MODAL ================= -->
<div id="addAdminModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 relative overflow-y-auto max-h-[90vh]">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Create New Admin</h2>
            <button type="button" onclick="closeAddAdminModal()" class="text-gray-400 hover:text-red-500 text-3xl font-bold transition">&times;</button>
        </div>

        <!-- FORM -->
        <form method="POST" action="{{ route('admin.create') }}" class="space-y-5">
            @csrf
            <input type="hidden" name="role_id" value="1">

            <!-- NAME FIELDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="first_name" placeholder="First Name" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">
                <input type="text" name="middle_name" placeholder="Middle Name"
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="last_name" placeholder="Last Name" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">
                <input type="text" name="suffix" placeholder="Suffix (Jr., Sr.)"
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">
            </div>

            <!-- BIRTHDAY -->
           <div>
    <label class="block text-sm text-gray-600 mb-1">Birthday</label>
    <input type="date" name="birthday" required
           value="{{ old('birthday') }}"
           min="1900-01-01"
           max="{{ date('Y') }}-12-31"
           class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-pink-400 focus:border-pink-400">
</div>


            <!-- EMAIL & USERNAME -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="email" name="email" placeholder="Email" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">
                <input type="text" name="username" placeholder="Username" required
                       class="w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">
            </div>

            <!-- PASSWORD -->
            <input type="password" name="password" placeholder="Password" required
                   class="w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required
                   class="w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">

            <!-- ACTION BUTTONS -->
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeAddAdminModal()"
                        class="px-5 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 font-medium transition">
                    Cancel
                </button>
                <button type="submit"
                        class="px-5 py-3 rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold shadow-lg transition transform hover:scale-105">
                    Create Admin
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    
function openAddAdminModal() {
    const modal = document.getElementById('addAdminModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeAddAdminModal() {
    const modal = document.getElementById('addAdminModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>

<!-- Section Selection Modal -->
<div id="sectionModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-96 shadow-lg">
        <h3 class="text-lg font-semibold mb-4">Select Section</h3>

        <form action="{{ route('admin.students.issue-ids') }}" method="POST">
            @csrf
            <select name="section_id" required
                    class="w-full border rounded-lg px-3 py-2 mb-4 focus:ring-2 focus:ring-indigo-400">
                <option value="">-- Choose Section --</option>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}">
                        {{ $section->year_level }} - {{ $section->name }}
                    </option>
                @endforeach
            </select>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeSectionModal()" class="px-4 py-2 rounded-lg border">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">Generate IDs</button>
            </div>
        </form>
    </div>
</div>

<script>
function openSectionModal() {
    document.getElementById('sectionModal').classList.remove('hidden');
}

function closeSectionModal() {
    document.getElementById('sectionModal').classList.add('hidden');
}
</script>



</body>
</html>