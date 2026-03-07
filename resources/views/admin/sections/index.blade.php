<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sections | Student Management System</title>
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

<!-- ================= HEADER ================= -->
<header class="sticky top-0 z-50 backdrop-blur-lg bg-white/80 shadow-md rounded-xl">
    <div class="max-w-7xl mx-auto px-6 py-4">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

            <div class="flex items-center gap-4">
                <a href="{{ route('admin.dashboard') }}"
                   class="hover:bg-orange-300 text-gray-700 px-3 py-2 rounded-lg shadow-sm transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                              d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>

                <img src="{{ asset('images/logo.jpg') }}"
                     class="h-16 w-16 rounded-full shadow-lg ring-4 ring-indigo-200">

                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Teaching Assignment Management</h1>
                    <p class="text-sm text-gray-500">Tugawe Elementary School</p>
                </div>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">

   
                <button onclick="openAddSectionModal()"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold
                           px-5 py-2.5 rounded-xl shadow-lg hover:scale-105 transition">
                    + Add Section
                </button>
            </div>

        </div>
    </div>
</header>


 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        title: 'Success!',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonText: 'OK',
        confirmButtonColor: '#6366f1'
    });
});
</script>
@endif


<!-- ================= SECTIONS ================= -->
@forelse($sections as $teacherName => $teacherSections)
@php
    $totalStudents = $teacherSections->sum(fn($s) => $s->students->count());
    $teacherId = optional($teacherSections->first()->teacher)->id;
@endphp

<div class="bg-white rounded-3xl shadow-2xl overflow-hidden teacher-card hover:shadow-3xl transition">

<button onclick="toggleGroup(this)"
        class="w-full flex justify-between items-center px-6 py-4
               bg-indigo-50 hover:bg-indigo-100 transition font-medium text-indigo-700">

    <div>
        <h2 class="text-lg font-bold">{{ $teacherName }}</h2>
        <p class="text-sm text-gray-600">
            {{ $teacherSections->count() }} section(s) • {{ $totalStudents }} student(s)
        </p>
    </div>

    <div class="flex items-center gap-3">
        @if($teacherId)
        <a href="{{ route('export.teacher', $teacherId) }}"
           class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg
                  text-sm shadow hover:scale-105 transition">
            Export
        </a>
        @endif
        <span class="rotate-icon text-xl transition-transform">⌄</span>
    </div>
</button>

<div class="group-content hidden px-6 py-4 border-t border-gray-200">

<table class="w-full text-sm rounded-lg overflow-hidden shadow-sm">
<thead class="bg-indigo-50">
<tr>
    <th class="px-4 py-2 text-left font-medium text-gray-600">Section</th>
    <th class="px-4 py-2 text-left font-medium text-gray-600">Students</th>
    <th class="px-4 py-2 text-left font-medium text-gray-600">Capacity</th>
    <th class="px-4 py-2 text-left font-medium text-gray-600">Teacher</th>
    <th class="px-4 py-2 text-left font-medium text-gray-600">Year Level</th>
    <th class="px-4 py-2 text-left font-medium text-gray-600">School Year</th>
    <th class="px-4 py-2 text-left font-medium text-gray-600">Actions</th>
</tr>
</thead>

<tbody class="divide-y divide-gray-200 bg-white">
@foreach($teacherSections as $section)
@php $count = $section->students->count(); @endphp

<tr class="hover:bg-indigo-50 transition">
<td class="px-4 py-3 font-semibold">{{ $section->name }}</td>

<td class="px-4 py-3">
    <button onclick="loadStudents({{ $section->id }})"
            class="text-indigo-600 hover:underline font-semibold">
        {{ $count }}
    </button>
</td>

@php
    $count = $section->students->count();
    $full = $count >= $section->capacity;
    $percent = min(100, ($count / max(1, $section->capacity)) * 100);
@endphp

<td class="px-4 py-3">
    <div class="w-32 bg-gray-200 rounded-full h-2 mb-1">
        <div
            class="h-2 rounded-full {{ $full ? 'bg-red-500' : 'bg-indigo-500' }}"
            style="width: {{ $percent }}%">
        </div>
    </div>

    <span class="text-xs {{ $full ? 'text-red-600 font-bold' : 'text-gray-600' }}">
        {{ $count }}/{{ $section->capacity }}
    </span>
</td>


<td class="px-4 py-3">
<form method="POST" action="{{ route('sections.assignTeacher', $section) }}">
@csrf
@method('PUT')
<select name="teacher_id" onchange="this.form.submit()"
        class="border border-gray-300 rounded-lg px-2 py-1
               hover:border-indigo-400 focus:ring focus:ring-indigo-200">
<option value="">Unassigned</option>
@foreach($teachers as $teacher)
<option value="{{ $teacher->id }}" @selected($teacher->id == $section->teacher_id)>
{{ $teacher->first_name }} {{ $teacher->last_name }}
</option>
@endforeach
</select>
</form>
</td>

<td class="px-4 py-3">{{ $section->year_level }}</td>
<td class="px-4 py-3">
    {{ $section->schoolYear?->name ?? 'N/A' }}
</td>


<td class="px-4 py-3 flex gap-3">

<!-- EDIT (UNCHANGED ICON, NOW MODAL) -->
<button
    onclick="openEditSectionModal(
        {{ $section->id }},
        '{{ $section->name }}',
        '{{ $section->year_level }}',
        '{{ $section->school_year }}'
    )"
    class="text-yellow-500 hover:text-yellow-700 transition transform hover:scale-110">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M11 5h2m2 2l6 6-6 6-6-6 6-6zM4 21h16"/>
    </svg>
</button>

<!-- DELETE (UNCHANGED) -->
<button onclick="showDeleteModal({{ $section->id }})"
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
@endforeach
</tbody>
</table>

</div>
</div>
@empty
<p class="text-center text-gray-600">No sections found.</p>
@endforelse
</div>

<!-- ================= EDIT SECTION MODAL ================= -->
<div id="editSectionModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
  <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 relative">

    <h2 class="text-xl font-bold text-gray-800 mb-4">Edit Section</h2>

    <form id="editSectionForm" method="POST" class="space-y-4" action="{{ route('admin.sections.update', $section->id ?? 0) }}">
      @csrf
      @method('PUT')

      <!-- SECTION NAME -->
      <input id="edit_name" name="name" required
             value="{{ old('name', $section->name ?? '') }}"
             class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400"
             placeholder="Section Name">

      <!-- YEAR LEVEL -->
      <select id="edit_year_level" name="year_level" required
              class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">
        @php
          $levels = ['Kindergarten', 'Grade 1','Grade 2','Grade 3','Grade 4','Grade 5','Grade 6'];
        @endphp
        @foreach($levels as $level)
          <option value="{{ $level }}" {{ (old('year_level', $section->year_level ?? '') == $level) ? 'selected' : '' }}>
            {{ $level }}
          </option>
        @endforeach
      </select>

      <!-- SCHOOL YEAR -->
      <select id="edit_school_year" name="school_year_id" required
              class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">
        <option value="">-- Select School Year --</option>
        @foreach($schoolYears as $year)
          <option value="{{ $year->id }}"
                  {{ (old('school_year_id', $section->school_year_id ?? '') == $year->id) ? 'selected' : '' }}>
            {{ $year->name }}
          </option>
        @endforeach
      </select>

      <!-- Buttons -->
      <div class="flex justify-end gap-3 pt-4">
        <button type="button" onclick="closeEditSectionModal()"
                class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-lg">
          Cancel
        </button>

        <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg">
          Update Section
        </button>
      </div>
    </form>

    <!-- Close Modal Button -->
    <button onclick="closeEditSectionModal()"
            class="absolute top-3 right-3 text-gray-500 hover:text-red-500 text-xl">✕</button>
  </div>
</div>


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

<!-- ADD SECTION MODAL -->
<div id="addSectionModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 relative">

        <h2 class="text-xl font-bold text-gray-800 mb-4">Add New Section</h2>

        <form method="POST" action="{{ route('admin.sections.store') }}" class="space-y-4">
            @csrf

            <!-- SECTION NAME -->
            <input type="text" name="name" placeholder="Section Name (e.g. A, B, Einstein)" required
                   class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">

            <!-- YEAR LEVEL -->
             <!-- YEAR LEVEL -->
            <select name="year_level" required
                    class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">
                <option value="">Select Year Level</option>
                <option value="Kindergarten">Kindergarten</option>
                <option value="Grade 1">Grade 1</option>
                <option value="Grade 2">Grade 2</option>
                <option value="Grade 3">Grade 3</option>
                <option value="Grade 4">Grade 4</option>
                <option value="Grade 5">Grade 5</option>
                <option value="Grade 6">Grade 6</option>
            </select>
            
            <!-- SCHOOL YEAR -->   
       <select name="school_year_id" required
        class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">

    <option value="">-- Select School Year --</option>

    @foreach($schoolYears as $year)
        <option value="{{ $year->id }}"
            {{ old('school_year_id', $section->school_year_id ?? '') == $year->id ? 'selected' : '' }}>
            {{ $year->name }}
        </option>
    @endforeach

</select>


            <!-- ACTION BUTTONS -->
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeAddSectionModal()"
                        class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-lg">
                    Cancel
                </button>

                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg">
                    Save Section
                </button>
            </div>
        </form>

        <!-- CLOSE ICON -->
        <button onclick="closeAddSectionModal()"
                class="absolute top-3 right-3 text-gray-500 hover:text-red-500 text-xl">
            ✕
        </button>
    </div>
</div>


<!-- ================= SCRIPTS ================= -->
<script>
function toggleGroup(btn){
    const content = btn.nextElementSibling;
    const teacherName = btn.querySelector('h2').innerText;

    content.classList.toggle('hidden');
    btn.querySelector('.rotate-icon').classList.toggle('rotate-180');

    // Save state in localStorage
    const expanded = JSON.parse(localStorage.getItem('expandedTeachers') || '{}');
    expanded[teacherName] = !content.classList.contains('hidden');
    localStorage.setItem('expandedTeachers', JSON.stringify(expanded));
}

function openEditSectionModal(id, name, year, sy){
    edit_name.value = name;
    edit_year_level.value = year;
    edit_school_year.value = sy;
    editSectionForm.action = `/admin/sections/${id}`;
    editSectionModal.classList.remove('hidden');
    editSectionModal.classList.add('flex');
}

function closeEditSectionModal(){
    editSectionModal.classList.add('hidden');
}


// SECTION MODAL FUNCTIONS

    function openAddSectionModal() {
        document.getElementById('addSectionModal').classList.remove('hidden');
        document.getElementById('addSectionModal').classList.add('flex');
    }

    function closeAddSectionModal() {
        document.getElementById('addSectionModal').classList.add('hidden');
    }

// DELETE MODAL LOGIC
 let deleteTimeout;

    function showDeleteModal(sectionId) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const countdownEl = document.getElementById('deleteCountdown');

        form.action = `/admin/sections/${sectionId}`;

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



// Restore expanded sections on page load
document.addEventListener('DOMContentLoaded', () => {
    const expanded = JSON.parse(localStorage.getItem('expandedTeachers') || '{}');

    document.querySelectorAll('.teacher-card').forEach(card => {
        const btn = card.querySelector('button');
        const content = card.querySelector('.group-content');
        const teacherName = btn.querySelector('h2').innerText;

        if(expanded[teacherName]){
            content.classList.remove('hidden');
            btn.querySelector('.rotate-icon').classList.add('rotate-180');
        }
    });
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

@foreach($allSections as $section)
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
