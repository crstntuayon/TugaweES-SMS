<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sections | Student Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-100 via-blue-100 to-sky-200 px-4 py-8">

<div class="max-w-7xl mx-auto space-y-6">


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

                <div class="relative w-full md:w-64">
                    <input type="text" id="searchInput"
                        placeholder="Search teacher or section..."
                        class="w-full px-4 py-2.5 rounded-xl shadow-md border border-gray-200
                               focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">🔍</span>
                </div>

                <button onclick="openAddSectionModal()"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold
                           px-5 py-2.5 rounded-xl shadow-lg hover:scale-105 transition">
                    + Add Section
                </button>
            </div>

        </div>
    </div>
</header>


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
<td class="px-4 py-3">{{ $section->school_year }}</td>

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

<form id="editSectionForm" method="POST" class="space-y-4">
@csrf
@method('PUT')

<input id="edit_name" name="name" required
class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">

<select id="edit_year_level" name="year_level" required
class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">
<option>Kindergarten</option>
<option>Grade 1</option>
<option>Grade 2</option>
<option>Grade 3</option>
<option>Grade 4</option>
<option>Grade 5</option>
<option>Grade 6</option>
</select>

<input id="edit_school_year" name="school_year" required
class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">

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
            <input type="text" name="school_year" placeholder="School Year (e.g. 2025-2026)" required
                   class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">

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
    btn.nextElementSibling.classList.toggle('hidden');
    btn.querySelector('.rotate-icon').classList.toggle('rotate-180');
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

</script>

</body>
</html>
