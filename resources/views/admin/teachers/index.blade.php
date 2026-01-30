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


    <!-- TEACHER CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($teachers->sortBy('last_name') as $teacher)
            @php
                $teacherSections = $teacher->sections ?? collect();
                $initials = strtoupper(substr($teacher->first_name,0,1) . substr($teacher->last_name,0,1));
            @endphp

            <div class="bg-white rounded-3xl shadow-2xl p-6 transform transition duration-300 hover:scale-105 hover:shadow-3xl teacher-card">

                <!-- Header -->
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-green-200 to-green-400 text-green-900 font-bold flex items-center justify-center text-xl shadow-inner">
                            {{ $initials }}
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-green-700">{{ $teacher->first_name }} {{ $teacher->last_name }}</h2>
                            <p class="text-gray-500 text-sm mt-1">Teacher ID: {{ $teacher->id }}</p>
                        </div>
                    </div>

                    <div class="flex gap-3">
                     <button
    onclick="openEditTeacherModal(this)"
    data-id="{{ $teacher->id }}"
    data-first="{{ $teacher->first_name }}"
    data-middle="{{ $teacher->middle_name ?? '' }}"
    data-last="{{ $teacher->last_name }}"
    data-suffix="{{ $teacher->suffix ?? '' }}"
    data-birthday="{{ $teacher->birthday }}"
    data-email="{{ $teacher->email }}"
    data-username="{{ $teacher->username }}"
    class="text-yellow-500 hover:text-yellow-700 transition transform hover:scale-110">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M11 5h2m2 2l6 6-6 6-6-6 6-6zM4 21h16"/>
    </svg>
</button>

                        <button type="button" onclick="showDeleteModal({{ $teacher->id }})"
                                title="Delete"
                                class="text-red-500 hover:text-red-700 transition transform hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Info Badges -->
                <div class="flex flex-col gap-2 mb-4">
                    <span class="bg-gradient-to-r from-green-100 to-green-200 text-green-800 px-3 py-1 rounded-full text-sm font-medium shadow-inner flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m0 0h8m-8 0v8m0-8V4m0 8h8"/>
                        </svg>
                        {{ $teacher->email }}
                    </span>
                    <span class="bg-gradient-to-r from-green-100 to-green-200 text-green-800 px-3 py-1 rounded-full text-sm font-medium shadow-inner flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3-2 6-5 6s-5-3-5-6 2-6 5-6 5 3 5 6zm6 0c0 3-2 6-5 6s-5-3-5-6 2-6 5-6 5 3 5 6z"/>
                        </svg>
                        {{ $teacher->username }}
                    </span>
                </div>

                <!-- Sections -->
                <div>
                    <h3 class="text-gray-700 font-semibold mb-1">Assigned Sections:</h3>
                    @if($teacherSections->isNotEmpty())
                        <div class="flex flex-wrap gap-2">
                            @foreach($teacherSections as $section)
                                @php
    $colors = ['green','blue','indigo','purple','pink','yellow','red','teal'];
    $index = crc32($section->year_level) % count($colors); // string → number
    $color = $colors[$index];
@endphp

                                <span class="px-3 py-1 rounded-full text-sm font-semibold shadow-sm
                                    bg-{{ $color }}-100 text-{{ $color }}-800">
                                    {{ $section->year_level }} - {{ $section->name }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm font-medium shadow-inner">
                            No assigned sections
                        </span>
                    @endif
                </div>

            </div>
        @endforeach
    </div>

    @if($teachers->isEmpty())
        <p class="p-6 text-center text-gray-500">No teachers found.</p>
    @endif

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


<!-- ADD TEACHER MODAL -->
<div id="addTeacherModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl p-6 relative">

        <h2 class="text-xl font-bold text-gray-800 mb-4">Add New Teacher</h2>

        <form method="POST" action="{{ route('admin.teachers.store') }}" class="space-y-4">
            @csrf

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
            <div>
                <label class="text-sm text-gray-600 mb-1 block">Birthday</label>
                <input type="date" name="birthday" required
                       class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">
            </div>

            <!-- EMAIL -->
            <input type="email" name="email" placeholder="Email Address" required
                   class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">

            <!-- USERNAME -->
            <input type="text" name="username" placeholder="Username" required
                   class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">

            <!-- PASSWORDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="password" name="password" placeholder="Password" required
                       class="px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">

                <input type="password" name="password_confirmation"
                       placeholder="Confirm Password" required
                       class="px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">
            </div>

            <!-- ACTION BUTTONS -->
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

        <!-- CLOSE ICON -->
        <button onclick="closeAddTeacherModal()"
                class="absolute top-3 right-3 text-gray-500 hover:text-red-500 text-xl">
            ✕
        </button>
    </div>
</div>

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
