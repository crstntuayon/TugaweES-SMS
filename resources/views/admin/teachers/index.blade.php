<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teachers | Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
<header class="sticky top-0 z-50 backdrop-blur-lg bg-white/80 shadow-md rounded-xl">
    <div class="max-w-7xl mx-auto px-6 py-4">

        <!-- TOP ROW -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

            <!-- LEFT: BACK + LOGO + TITLE -->
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.dashboard') }}"
                   class="hover:bg-green-300 text-gray-700 px-3 py-2 rounded-lg shadow-sm transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                              d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>

                <img src="{{ asset('images/logo.jpg') }}"
                     class="h-16 w-16 rounded-full shadow-lg ring-4 ring-indigo-200"
                     alt="School Logo">

                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Teacher Management</h1>
                    <p class="text-sm text-gray-500">Tugawe Elementary School</p>
                </div>
            </div>

            <!-- RIGHT: SEARCH + ADD BUTTON -->
            <div class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">

                <!-- SEARCH -->
                <input type="text" id="teacherSearch" placeholder="Search Teacher..."
                       class="px-4 py-2 border rounded-lg w-full md:w-64 focus:ring-2 focus:ring-green-400"
                       onkeyup="filterTeachers()">

                <!-- ADD TEACHER BUTTON -->
                <button onclick="openAddTeacherModal()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold
                               px-5 py-2.5 rounded-xl shadow-lg hover:scale-105 transition
                               whitespace-nowrap">
                    + Add Teacher
                </button>

            </div>

        </div>
    </div>
</header>

<!-- FILTER SCRIPT -->
<script>
function filterTeachers() {
    const input = document.getElementById('teacherSearch');
    const filter = input.value.toLowerCase();
    const table = document.querySelector('table tbody');
    const rows = table.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const nameCell = rows[i].querySelector('td:nth-child(2)');
        if (nameCell) {
            const txtValue = nameCell.textContent || nameCell.innerText;
            rows[i].style.display = txtValue.toLowerCase().includes(filter) ? "" : "none";
        }
    }
}
</script>



@if(session('success'))
<div id="successAlert"
     class="flex items-center justify-between gap-4
            bg-green-100 border border-green-300 text-green-800
            px-6 py-4 rounded-xl shadow-lg transition-all duration-500">

    <div class="flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-6 w-6 text-green-600"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 13l4 4L19 7"/>
        </svg>
        <span class="font-semibold">
            {{ session('success') }}
        </span>
    </div>

    <button onclick="closeSuccessAlert()"
            class="text-green-700 hover:text-red-500 text-xl font-bold">
        ✕
    </button>
</div>
@endif
<script>

function closeSuccessAlert(){
    const alert = document.getElementById('successAlert');
    if(alert){
        alert.classList.add('opacity-0');
        setTimeout(() => alert.remove(), 500);
    }
}

// auto-hide after 5 seconds
setTimeout(() => {
    closeSuccessAlert();
}, 5000);


</script>


   <div class="bg-white rounded-2xl shadow-xl p-6">

    <h2 class="text-2xl font-bold text-green-700 mb-6">Teachers List</h2>

<<<<<<< HEAD
    <!-- TEACHERS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

        @forelse($teachers->sortBy('last_name')->values() as $index => $teacher)

        <!-- CARD -->
        <div class="bg-white border rounded-2xl shadow-md hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 p-6 text-center group">

            <!-- NUMBER -->
            <div class="text-xs text-black-400 mb-2">
                {{ $index + 1 }}
            </div>

            <!-- PHOTO -->
            <div class="flex justify-center mb-4">
                <div class="relative group">

                    <img
                        src="{{ $teacher->photo ? asset('storage/'.$teacher->photo) : asset('images/photo-placeholder.png') }}"
                        class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-lg group-hover:scale-105 transition"
                        alt="Photo">

                    <!-- GREEN HOVER OVERLAY -->
                    <div class="absolute inset-0 rounded-full bg-green-600 opacity-0 group-hover:opacity-30 transition"></div>

                </div>
            </div>

            <!-- NAME -->
            <p class="font-semibold text-gray-800 text-lg leading-tight">
                {{ $teacher->first_name }}
                {{ $teacher->middle_name }}
                {{ $teacher->last_name }}
                {{ $teacher->suffix }}
            </p>

            <!-- EMAIL -->
            <p class="text-xs text-gray-500 mt-2">
                {{ $teacher->email }}
            </p>

            <!-- ACTION -->
            <div class="mt-4">
                <button 
                    onclick="openTeacherModal({{ $teacher->id }})"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 transition text-sm">
                    View Profile
                </button>
            </div>

        </div>

        @empty

        <div class="col-span-full text-center text-gray-500 py-10">
            No teachers found.
        </div>

        @endforelse

=======
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-xl overflow-hidden">
            
            <!-- Table Head -->
            <thead class="bg-green-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">No.</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Teacher</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold">Action</th>
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody class="divide-y divide-gray-200 bg-white">

                @forelse($teachers->sortBy('last_name')->values() as $index => $teacher)
                    <tr class="hover:bg-green-50 transition">

                        <!-- Number -->
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $index + 1 }}
                        </td>

                        <!-- Teacher Name -->
                       <td class="px-5 py-4">
                                <div class="flex items-center gap-4">
                                    <img
                                        src="{{ $teacher->photo ? asset('storage/'.$teacher->photo) : asset('images/photo-placeholder.png') }}"
                                        class="w-12 h-12 rounded-full object-cover shadow"
                                        alt="Photo">

                                    <div>
                                        <p class="font-semibold text-gray-800 leading-tight">
                                            {{ $teacher->first_name }}
                                            {{ $teacher->middle_name }}
                                            {{ $teacher->last_name }}
                                            {{ $teacher->suffix }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Email: {{ $teacher->email }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                        <!-- Action -->
                        <td class="px-6 py-4 text-center">
                            <button 
                                onclick="openTeacherModal({{ $teacher->id }})"
                                class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 transition">
                                View Profile
                            </button>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-6 text-center text-gray-500">
                            No teachers found.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
>>>>>>> a2e1da32ac52ddd5b71a7d0ebd78dc817a30e466
    </div>

</div>


<<<<<<< HEAD

=======
>>>>>>> a2e1da32ac52ddd5b71a7d0ebd78dc817a30e466
<!-- Teacher Profile Modal -->
<div id="teacherModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl p-6 relative overflow-auto max-h-[90vh]">

        <!-- Close button -->
        <button onclick="closeTeacherModal()" 
                class="absolute top-3 right-4 text-xl font-bold text-gray-500 hover:text-red-500">
            ✕
        </button>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-2 mb-4">

            <!-- Edit -->
            <button id="editBtn" onclick="enableEditMode()" 
                class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.213 3 21l1.787-4.5 12.075-13.013z" />
                </svg>
            </button>

            <!-- Save -->
            <button id="saveBtn" onclick="saveTeacherChanges()" 
                class="bg-green-500 hover:bg-green-600 text-white p-2 rounded hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5 13l4 4L19 7" />
                </svg>
            </button>

            <!-- Cancel -->
            <button id="cancelBtn" onclick="cancelEditMode()" 
                class="bg-red-500 hover:bg-red-600 text-white p-2 rounded hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

        </div>

        <div id="teacherModalContent">
            <!-- Dynamic content -->
        </div>
    </div>
</div>


<script>
    const activeSchoolYear = @json($activeSchoolYear);

const teachers = @json($teachers->load('sections'));
let currentTeacher = null;
let originalTeacher = null;
let isEditing = false;

function openTeacherModal(id) {
    currentTeacher = JSON.parse(JSON.stringify(teachers.find(t => t.id === id)));
    originalTeacher = JSON.parse(JSON.stringify(currentTeacher));

    if (!currentTeacher) return;

    renderTeacherDocument();

    document.getElementById('teacherModal').classList.remove('hidden');
    document.getElementById('teacherModal').classList.add('flex');
}

function renderTeacherDocument() {
<<<<<<< HEAD


=======
>>>>>>> a2e1da32ac52ddd5b71a7d0ebd78dc817a30e466
    let t = currentTeacher;

    const photoUrl = t.photo 
        ? `/storage/${t.photo}` 
        : `/images/photo-placeholder.png`;

    document.getElementById('teacherModalContent').innerHTML = `
        
        <!-- HEADER -->
        <div class="relative">

            <!-- Logos + Header -->
            <div class="flex items-center justify-center gap-4">
                <img src="{{ asset('images/logo1.png') }}" class="h-14 w-auto">
                
                <div class="text-center leading-tight">
                    <p class="font-bold uppercase text-xs">Republic of the Philippines</p>
                    <p class="font-bold uppercase text-sm">Department of Education</p>
                    <p class="text-xs">Division of Negros Oriental</p>
                </div>

                <img src="{{ asset('images/logo.jpg') }}" class="h-14 w-auto">
            </div>

            <!-- Teacher Photo (Top Right Vertical Rectangle) -->
            <div class="absolute top-0 right-0">
                <div class="w-28 h-40 border-2 border-gray-400 shadow-md bg-white overflow-hidden">
                    <img src="${photoUrl}" 
                        class="w-full h-full object-cover">
                </div>
            </div>
        </div>

        <hr class="my-6 border-gray-400">

        <!-- TEACHER DETAILS -->
        <div class="grid grid-cols-2 gap-8 text-sm">

            <!-- LEFT SIDE -->
            <div class="space-y-2">

                <p><strong>Teacher Name:</strong><br>
                    ${t.first_name} ${t.middle_name ?? ''} ${t.last_name} ${t.suffix ?? ''}
                </p>

                <p><strong>Current Position:</strong><br>
                    ${isEditing 
                        ? `<input id="position" value="${t.position ?? ''}" class="border px-2 py-1 w-full rounded">`
                        : (t.position ?? 'Teacher I')}
                </p>

                <p><strong>Teaching Experience (Years):</strong><br>
                    ${isEditing 
                        ? `<input id="years_experience" type="number" value="${t.years_experience ?? 0}" class="border px-2 py-1 w-full rounded">`
                        : (t.years_experience ?? 0)}
                </p>

                <p><strong>Teaching Experience (Grade Level):</strong><br>
                    ${isEditing 
                        ? `<input id="grade_experience" value="${t.grade_experience ?? ''}" class="border px-2 py-1 w-full rounded">`
                        : (t.grade_experience ?? '')}
                </p>

            </div>

            <!-- RIGHT SIDE -->
            <div class="space-y-2">

<<<<<<< HEAD
               <p><strong>Grade Level Assigned:</strong><br>
    ${t.sections && t.sections.length > 0
        ? t.sections.map(s => s.year_level).join(', ')
        : '-'}
</p>
=======
                <p><strong>Grade Level Assigned:</strong><br>
                    ${t.sections.length > 0 
                        ? t.sections.map(s => s.year_level).join(', ') 
                        : '-'}
                </p>
>>>>>>> a2e1da32ac52ddd5b71a7d0ebd78dc817a30e466

                <p><strong>Enrollment (Male):</strong><br>
                    ${isEditing 
                        ? `<input id="male_enrollment" type="number" value="${t.male_enrollment ?? 0}" class="border px-2 py-1 w-full rounded">`
                        : (t.male_enrollment ?? 0)}
                </p>

                <p><strong>Enrollment (Female):</strong><br>
                    ${isEditing 
                        ? `<input id="female_enrollment" type="number" value="${t.female_enrollment ?? 0}" class="border px-2 py-1 w-full rounded">`
                        : (t.female_enrollment ?? 0)}
                </p>

                <p><strong>Active School Year:</strong><br>
                    ${activeSchoolYear?.name ?? '-'}
                </p>

            </div>
        </div>

        <!-- TEACHING LOAD SECTION -->
        <div class="mt-8">

            <h3 class="text-center font-bold text-sm mb-3">
                TEACHER'S PROGRAM / TEACHING LOAD
            </h3>
           

            <div class="overflow-auto">
                <table class="w-full border text-xs">
<<<<<<< HEAD
                 <thead>
    <tr class="bg-gray-200 text-center">
        <th class="border px-2 py-1">Time</th>
        <th class="border px-2 py-1">Minutes</th>
        <th class="border px-2 py-1">Subject</th>
        ${isEditing ? `<th class="border px-2 py-1 w-10">Action</th>` : ''}
    </tr>
</thead>
                    <tbody>
                        ${t.teaching_load?.length > 0 
                            ? t.teaching_load.map((l, index) => `
                       <tr>
    <td class="border px-2 py-1">
        ${isEditing 
            ? `<input data-index="${index}" data-field="time" value="${l.time}" class="border w-full px-1 rounded">`
            : l.time}
    </td>

    <td class="border px-2 py-1 text-center">
        ${isEditing 
            ? `<input data-index="${index}" data-field="minutes" value="${l.minutes}" class="border w-full px-1 rounded">`
            : l.minutes}
    </td>

    <td class="border px-2 py-1">
        ${isEditing 
            ? `<input data-index="${index}" data-field="subject" value="${l.subject}" class="border w-full px-1 rounded">`
            : l.subject}
    </td>

    ${isEditing ? `
        <td class="border text-center">
            <button onclick="removeTeachingRow(${index})"
    class="p-1 rounded hover:bg-red-100 text-red-500 hover:text-red-700 transition">
    
    <svg xmlns="http://www.w3.org/2000/svg" 
         class="w-4 h-4"
         fill="none" 
         viewBox="0 0 24 24" 
         stroke="currentColor" 
         stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 3h6a1 1 0 011 1v1H8V4a1 1 0 011-1z"/>
    </svg>

</button>
        </td>
    ` : ''}
</tr>
=======
                    <thead>
                        <tr class="bg-gray-200 text-center">
                            <th class="border px-2 py-1">Time</th>
                            <th class="border px-2 py-1">Minutes</th>
                            <th class="border px-2 py-1">Subject</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${t.teaching_load?.length > 0 
                            ? t.teaching_load.map((l, index) => `
                                <tr>
                                    <td class="border px-2 py-1">
                                        ${isEditing 
                                            ? `<input data-index="${index}" data-field="time" value="${l.time}" class="border w-full px-1 rounded">`
                                            : l.time}
                                    </td>
                                    <td class="border px-2 py-1 text-center">
                                        ${isEditing 
                                            ? `<input data-index="${index}" data-field="minutes" value="${l.minutes}" class="border w-full px-1 rounded">`
                                            : l.minutes}
                                    </td>
                                    <td class="border px-2 py-1">
                                        ${isEditing 
                                            ? `<input data-index="${index}" data-field="subject" value="${l.subject}" class="border w-full px-1 rounded">`
                                            : l.subject}
                                    </td>
                                </tr>
>>>>>>> a2e1da32ac52ddd5b71a7d0ebd78dc817a30e466
                            `).join('')
                            : '<tr><td colspan="3" class="border px-2 py-2 text-center">No load assigned</td></tr>'
                        }
                    </tbody>
                </table>

                ${isEditing ? `
                    <div class="mt-2 text-right">
                        <button onclick="addTeachingRow()" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded shadow">
                            +
                        </button>
                    </div>
                ` : ''}
            </div>
        </div>

        <!-- SIGNATURES -->
        <div class="grid grid-cols-3 gap-8 mt-12 text-center text-sm">

            <div>
                ${isEditing 
                    ? `<input id="prepared_by" value="${t.prepared_by ?? 'Principal'}" class="border px-2 py-1 w-full text-center rounded">`
                    : `<p class="border-t pt-2">Prepared by<br><strong>${t.prepared_by ?? 'Principal'}</strong></p>`}
            </div>

            <div>
                ${isEditing 
                    ? `<input id="conforme" value="${t.conforme ?? 'Adviser'}" class="border px-2 py-1 w-full text-center rounded">`
                    : `<p class="border-t pt-2">Conforme<br><strong>${t.conforme ?? 'Adviser'}</strong></p>`}
            </div>

            <div>
                ${isEditing 
                    ? `<input id="approved_by" value="${t.approved_by ?? 'Public School District Supervisor'}" class="border px-2 py-1 w-full text-center rounded">`
                    : `<p class="border-t pt-2">Approved by<br><strong>${t.approved_by ?? 'Public School District Supervisor'}</strong></p>`}
            </div>

        </div>
    `;
}


function enableEditMode() {
    isEditing = true;
    document.getElementById('editBtn').classList.add('hidden');
    document.getElementById('saveBtn').classList.remove('hidden');
    document.getElementById('cancelBtn').classList.remove('hidden');
    renderTeacherDocument();
}

function cancelEditMode() {
    isEditing = false;
    currentTeacher = JSON.parse(JSON.stringify(originalTeacher));
    document.getElementById('editBtn').classList.remove('hidden');
    document.getElementById('saveBtn').classList.add('hidden');
    document.getElementById('cancelBtn').classList.add('hidden');
    renderTeacherDocument();
}

function addTeachingRow() {
    if (!currentTeacher.teaching_load) {
        currentTeacher.teaching_load = [];
    }
    currentTeacher.teaching_load.push({ time: '', minutes: '', subject: '' });
    renderTeacherDocument();
}

<<<<<<< HEAD
function removeTeachingRow(index) {
    if (!currentTeacher.teaching_load) return;

    currentTeacher.teaching_load.splice(index, 1);

    renderTeacherDocument();
}



function saveTeacherChanges() {

    // collect teaching load inputs
    let teachingLoad = [];

document.querySelectorAll('[data-index]').forEach(input => {
    const index = input.dataset.index;
    const field = input.dataset.field;

    if (!teachingLoad[index]) {
        teachingLoad[index] = { time: '', minutes: '', subject: '' };
    }

    teachingLoad[index][field] = input.value;
});

currentTeacher.teaching_load = teachingLoad;
=======
function saveTeacherChanges() {

    // collect teaching load inputs
    document.querySelectorAll('[data-index]').forEach(input => {
        let index = input.dataset.index;
        let field = input.dataset.field;
        currentTeacher.teaching_load[index][field] = input.value;
    });
>>>>>>> a2e1da32ac52ddd5b71a7d0ebd78dc817a30e466

    let data = {
        position: document.getElementById('position')?.value,
        years_experience: document.getElementById('years_experience')?.value,
        grade_experience: document.getElementById('grade_experience')?.value,
        male_enrollment: document.getElementById('male_enrollment')?.value,
        female_enrollment: document.getElementById('female_enrollment')?.value,
        prepared_by: document.getElementById('prepared_by')?.value,
        conforme: document.getElementById('conforme')?.value,
        approved_by: document.getElementById('approved_by')?.value,
        teaching_load: currentTeacher.teaching_load
    };

    fetch(`/admin/teachers/${currentTeacher.id}/program`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(response => {
      if (response.success) {

    // ✅ Replace current teacher with fresh backend data
    currentTeacher = JSON.parse(JSON.stringify(response.teacher));
    originalTeacher = JSON.parse(JSON.stringify(response.teacher));

    // ✅ Update teachers array (so reopening modal stays updated)
    const teacherIndex = teachers.findIndex(t => t.id === currentTeacher.id);
    if (teacherIndex !== -1) {
        teachers[teacherIndex] = response.teacher;
    }

    isEditing = false;

    document.getElementById('editBtn').classList.remove('hidden');
    document.getElementById('saveBtn').classList.add('hidden');
    document.getElementById('cancelBtn').classList.add('hidden');

    renderTeacherDocument();

    alert('Teacher program updated successfully!');
}

    });
}

function closeTeacherModal() {
    isEditing = false;
    document.getElementById('teacherModal').classList.add('hidden');
    document.getElementById('teacherModal').classList.remove('flex');
}
</script>





<!-- DELETE MODAL -->
<div id="deleteModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-2xl text-center">
        <h3 class="text-lg font-bold mb-4">Confirm Deletion</h3>
        <p class="mb-6 text-gray-700">Are you sure you want to delete this teacher? This action will happen in <span id="deleteCountdown">5</span> seconds.</p>

        <div class="flex justify-center gap-4">
            <button onclick="cancelDelete()" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-lg">Cancel</button>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                    Delete Now
                </button>
            </form>
        </div>
    </div>
</div>


<!-- ADD TEACHER MODAL -->
<div id="addTeacherModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl p-6 relative">

        <h2 class="text-xl font-bold text-gray-800 mb-4">Add New Teacher</h2>

        <form method="POST"
              action="{{ route('admin.teachers.store') }}"
              enctype="multipart/form-data"
              class="space-y-4">
            @csrf

            <!-- PHOTO UPLOAD -->
            <div class="flex flex-col items-center">
                <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-200 mb-2">
                    <img id="photoPreview"
                         src="https://ui-avatars.com/api/?name=Teacher"
                         class="w-full h-full object-cover">
                </div>

                <input type="file" name="photo"
                       accept="image/*"
                       onchange="previewTeacherPhoto(event)"
                       class="text-sm">
            </div>

            <!-- NAME FIELDS -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="first_name" placeholder="First Name" required
                       class="px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">

                <input type="text" name="middle_name" placeholder="Middle Name"
                       class="px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">

                <input type="text" name="last_name" placeholder="Last Name" required
                       class="px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">

                <input type="text" name="suffix" placeholder="Suffix (Jr., Sr.)"
                       class="px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">
            </div>

            <!-- BIRTHDAY -->
            <input type="date" name="birthday" required
                   class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">

            <!-- EMAIL -->
            <input type="email" name="email" placeholder="Email Address" required
                   class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">

            <!-- USERNAME -->
            <input type="text" name="username" placeholder="Username" required
                   class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">

            <!-- PASSWORD -->
            <div class="grid grid-cols-2 gap-4">
                <input type="password" name="password" placeholder="Password" required
                       class="px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">

                <input type="password" name="password_confirmation"
                       placeholder="Confirm Password" required
                       class="px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">
            </div>

            <!-- BUTTONS -->
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeAddTeacherModal()"
                        class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-lg">
                    Cancel
                </button>

                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow-md">
                    Save Teacher
                </button>
            </div>

        </form>

        <button onclick="closeAddTeacherModal()"
                class="absolute top-3 right-3 text-gray-500 hover:text-red-500 text-xl">
            ✕
        </button>
    </div>
</div>
<script>
function previewTeacherPhoto(event) {
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('photoPreview').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

<!-- EDIT MODAL -->
<div id="editTeacherModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
<div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl p-6 relative">

<h2 class="text-xl font-bold mb-4">Edit Teacher</h2>

<form id="editTeacherForm" method="POST">
@csrf
@method('PUT')

<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
<input type="text" name="first_name" id="edit_first" placeholder="First Name" class="px-4 py-2 border rounded-lg">
<input type="text" name="middle_name" id="edit_middle" placeholder="Middle Name" class="px-4 py-2 border rounded-lg">
<input type="text" name="last_name" id="edit_last" placeholder="Last Name" class="px-4 py-2 border rounded-lg">
<input type="text" name="suffix" id="edit_suffix" placeholder="Suffix (Jr., Sr.)" class="px-4 py-2 border rounded-lg">
</div>

<input type="date" name="birthday" id="edit_birthday"
       class="w-full mt-3 px-4 py-2 border rounded-lg">

<input type="email" name="email" placeholder="Email Address" id="edit_email"
       class="w-full mt-3 px-4 py-2 border rounded-lg">

<input type="text" name="username" placeholder="Username" id="edit_username"
       class="w-full mt-3 px-4 py-2 border rounded-lg">

<div class="flex justify-end gap-3 mt-4">
<button type="button" onclick="closeEditTeacherModal()"
        class="bg-gray-300 px-4 py-2 rounded-lg">
Cancel
</button>
<button type="submit"
        class="bg-indigo-600 text-white px-6 py-2 rounded-lg">
Update
</button>
</div>
</form>

<button onclick="closeEditTeacherModal()"
        class="absolute top-3 right-3 text-xl">✕</button>

</div>
</div>

<script>
function openEditTeacherModal(el) {
    const modal = document.getElementById('editTeacherModal');
    const form = document.getElementById('editTeacherForm');

    // Set form action to the correct PUT route
    form.action = `/admin/teachers/${el.dataset.id}`;

    // Fill the fields
    document.getElementById('edit_first').value = el.dataset.first;
    document.getElementById('edit_middle').value = el.dataset.middle;
    document.getElementById('edit_last').value = el.dataset.last;
    document.getElementById('edit_suffix').value = el.dataset.suffix;
    document.getElementById('edit_birthday').value = el.dataset.birthday;
    document.getElementById('edit_email').value = el.dataset.email;
    document.getElementById('edit_username').value = el.dataset.username;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeEditTeacherModal() {
    document.getElementById('editTeacherModal').classList.add('hidden');
}

</script>


<script>
    let deleteTimeout;

    function showDeleteModal(teacherId) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const countdownEl = document.getElementById('deleteCountdown');

        form.action = `/admin/teachers/${teacherId}`;

        let counter = 5;
        countdownEl.textContent = counter;
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        deleteTimeout = setInterval(() => {
            counter--;
            countdownEl.textContent = counter;
            if(counter <= 0){
                clearInterval(deleteTimeout);
                form.submit();
            }
        }, 1000);
    }

    function cancelDelete() {
        clearInterval(deleteTimeout);
        document.getElementById('deleteModal').classList.add('hidden');
    }




      function openAddTeacherModal() {
        document.getElementById('addTeacherModal').classList.remove('hidden');
        document.getElementById('addTeacherModal').classList.add('flex');
    }

    function closeAddTeacherModal() {
        document.getElementById('addTeacherModal').classList.add('hidden');
    }
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
