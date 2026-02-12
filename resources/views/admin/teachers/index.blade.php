<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teachers | Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-green-100 to-green-200 p-6">

<div class="max-w-7xl mx-auto space-y-6">

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
            <div class="flex items-center gap-3 w-full md:w-auto">

                <!-- SEARCH -->
                <div class="relative w-full md:w-64">
                    <input 
                        type="text" 
                        id="searchInput"
                        placeholder="Search teacher or section..."
                        class="w-full px-4 py-2.5 rounded-xl shadow-md border border-gray-200
                               focus:outline-none focus:ring-2 focus:ring-indigo-400
                               focus:border-indigo-400 transition"
                    >
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">🔍</span>
                </div>

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
    </div>

</div>


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

                <p><strong>Grade Level Assigned:</strong><br>
                    ${t.sections.length > 0 
                        ? t.sections.map(s => s.year_level).join(', ') 
                        : '-'}
                </p>

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

function saveTeacherChanges() {

    // collect teaching load inputs
    document.querySelectorAll('[data-index]').forEach(input => {
        let index = input.dataset.index;
        let field = input.dataset.field;
        currentTeacher.teaching_load[index][field] = input.value;
    });

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

    // Live search
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const value = this.value.toLowerCase();
        document.querySelectorAll('.teacher-card').forEach(card => {
            card.style.display = card.innerText.toLowerCase().includes(value) ? 'block' : 'none';
        });
    });



      function openAddTeacherModal() {
        document.getElementById('addTeacherModal').classList.remove('hidden');
        document.getElementById('addTeacherModal').classList.add('flex');
    }

    function closeAddTeacherModal() {
        document.getElementById('addTeacherModal').classList.add('hidden');
    }
</script>

</body>
</html>
