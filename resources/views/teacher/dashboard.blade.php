<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Dashboard | Student Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
<div class="min-h-screen flex flex-col">


<!-- HEADER -->
<div x-data="{ sidebarOpen: true }" class="min-h-screen bg-gray-50 flex">

   <aside 
    :class="sidebarOpen ? 'w-72' : 'w-20'" 
    class="fixed left-0 top-0 h-screen bg-white border-r border-gray-200 z-50 flex flex-col shadow-sm overflow-y-auto transition-all duration-300 ease-in-out"
>
    <!-- Sidebar Header -->
    <div class="p-4 flex items-center gap-3 h-24 border-b border-gray-50">

        <!-- Hamburger Button -->
        <button @click="sidebarOpen = !sidebarOpen" 
                class="p-2 rounded-full hover:bg-gray-100 text-gray-600 transition shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- Logo + User Info -->
        <div x-show="sidebarOpen" x-transition class="flex flex-col gap-2 overflow-hidden">

           

            <!-- User Info -->
            @php
                $user = auth()->user();
                $fullName = trim(($user->first_name ?? '') . ' ' . ($user->middle_name ?? '') . ' ' . ($user->last_name ?? '') . ' ' . ($user->suffix ?? ''));
                $initials = collect(explode(' ', $fullName))->map(fn($n) => $n ? strtoupper($n[0]) : '')->join('');
            @endphp

            <div class="flex items-center gap-2">
                <!-- Profile Picture or Initials -->
                @if($user && $user->photo)
                    <img src="{{ asset('storage/'.$user->photo) }}" 
                         alt="Profile" 
                         class="w-10 h-10 rounded-full object-cover shadow-md">
                @else
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-500 text-white font-bold shadow-md text-sm">
                        {{ $initials ?: 'T' }}
                    </div>
                @endif

                <!-- Username / Full Name -->
                <div class="flex flex-col overflow-hidden">
                    <span class="text-sm font-bold text-gray-800 truncate">{{ $user->name ?? 'Teacher' }}</span>
                    <span class="text-xs text-gray-500 truncate">{{ $fullName ?: 'N/A' }}</span>
                </div>
            </div>

        </div>
    </div>

    <!-- Sidebar Nav -->
    <nav class="flex-1 mt-4 px-3 space-y-1">
        <!-- Home -->
        <a href="{{ route('teacher.dashboard') }}"  class="flex items-center gap-4 p-3 rounded-r-full bg-blue-50 text-blue-700 transition group hover:scale-[1.02]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6m2 12H5a2 2 0 01-2-2V7a2 2 0 012-2h2"/>
            </svg>
            <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Home</span>
        </a>

        <!-- My Profile -->
        <button @click="document.getElementById('profileModal').classList.remove('hidden'); document.getElementById('profileModal').classList.add('flex');"
                class="w-full flex items-center gap-4 p-3 rounded-r-full text-gray-600 hover:bg-gray-100 transition group hover:scale-[1.02]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A9 9 0 1118.879 6.196 9 9 0 015.121 17.804zM12 12a3 3 0 100-6 3 3 0 000 6z"/>
            </svg>
            <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">My Profile</span>
        </button>

        <!-- Enroll Student -->
        <button @click="document.getElementById('enrollStudentModal').classList.remove('hidden');"
                class="w-full flex items-center gap-4 p-3 rounded-r-full text-gray-600 hover:bg-gray-100 transition group hover:scale-[1.02]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Enroll Student</span>
        </button>

        <!-- Announcements -->
        <button @click="document.getElementById('announcementModal').classList.remove('hidden');"
                class="w-full flex items-center gap-4 p-3 rounded-r-full text-gray-600 hover:bg-gray-100 transition group hover:scale-[1.02]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Announcements</span>
        </button>
    </nav>

    <!-- Logout -->
    <div class="p-3 border-t border-gray-100">
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="flex items-center gap-4 p-3 rounded-r-full text-red-500 hover:bg-red-50 transition group hover:scale-[1.02]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1"/>
            </svg>
            <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
    </div>
</aside>


    <div class="flex-1 transition-all duration-300" :class="sidebarOpen ? 'ml-72' : 'ml-20'">
        
        <header class="h-50 bg-white border-b border-gray-200 flex items-center px-8 sticky top-0 z-40">
            <div x-show="sidebarOpen" class="px-6 py-6 border-b border-gray-50 bg-gray-50/50">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.jpg') }}" class="h-10 w-10 rounded-full ring-2 ring-emerald-300 shadow-sm">
                <div class="overflow-hidden">
                    <p class="text-sm font-bold text-gray-800 truncate">
    {{ auth()->user()->first_name }}
    @if(auth()->user()->middle_name)
        {{ auth()->user()->middle_name }}
    @endif
    {{ auth()->user()->last_name }}
    @if(auth()->user()->suffix)
        {{ auth()->user()->suffix }}
    @endif
</p>
                    <p class="text-xs text-gray-500 truncate">Tugawe Elementary School</p>
                </div>
            </div>
        </div>
        
            
        </header>

       @if($sections->isEmpty())
        <div class="bg-white rounded-3xl shadow-xl p-10 text-center">
            <div class="text-gray-500 text-lg font-medium">
                You are not assigned to any section yet.
            </div>
        </div>
    @endif

    <div class="space-y-12">
        @foreach($sections as $section)

        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">

            <!-- SECTION HEADER -->
            <div class="bg-gradient-to-r from-emerald-600 via-green-500 to-emerald-600 text-white p-6 flex flex-col md:flex-row md:justify-between md:items-center">

                <div>
                    <h2 class="text-2xl font-bold tracking-wide">
                        {{ $section->year_level }} - {{ $section->name }}
                    </h2>
                    <p class="text-sm opacity-90 mt-1">
                        School Year: {{ $section->schoolYear?->name ?? 'N/A' }}
                    </p>
                </div>

                <div class="flex gap-3 mt-4 md:mt-0">
                    <a href="{{ route('teacher.attendance', $section->id) }}"
                       class="bg-white text-emerald-600 font-semibold px-5 py-2 rounded-xl shadow hover:scale-105 transition">
                        📝 Attendance
                    </a>

                    <a href="{{ route('teacher.grades', $section->id) }}"
                       class="bg-white text-indigo-600 font-semibold px-5 py-2 rounded-xl shadow hover:scale-105 transition">
                        📊 Grades
                    </a>
                </div>
            </div>

            <!-- STATS CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 p-6 bg-gray-50">

               <div class="bg-white rounded-2xl shadow-sm p-5 text-center relative">
    <p class="text-sm text-gray-500">Total Students</p>
    <p class="text-3xl font-bold text-gray-800">
        {{ $section->students->count() }}
    </p>

    <!-- Unenroll All Button -->
    <form action="{{ route('teacher.sections.unenrollAll', $section->id) }}" method="POST"
          onsubmit="return confirm('Are you sure you want to unenroll all students in this section?')"
          class="mt-3">
        @csrf
        @method('PUT')
        <button type="submit"
                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm shadow">
            Unenroll All
        </button>
    </form>
</div>

              
            </div>

       <!-- STUDENTS (SIDE BY SIDE) -->
<div class="p-6">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- ================= MALE STUDENTS ================= --}}
        <div class="bg-white rounded-2xl border border-blue-100 shadow-sm flex flex-col">

            <!-- Card Header -->
            <div class="bg-blue-50 px-6 py-4 border-b border-blue-100 rounded-t-2xl">
                <h3 class="text-lg font-bold text-blue-700 flex justify-between">
                    <span>Male Students</span>
                    <span class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                        {{ $section->students->where('sex','Male')->count() }}
                    </span>
                </h3>
            </div>

            <!-- Table -->
            <div class="overflow-auto flex-1">
                <table class="min-w-full text-sm">
                    <tbody class="divide-y">

                       @php
    $maleStudents = $section->students
        ->where('sex', 'Male')
        ->sortBy(function($student) {
            return $student->last_name . ' ' . $student->first_name;
        });
@endphp

                        @forelse($maleStudents as $index => $student)
                            <tr class="hover:bg-blue-50 transition">

                                <td class="px-4 py-4 text-gray-500 w-10">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">

                                        <img
                                            src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/photo-placeholder.png') }}"
                                            class="w-10 h-10 rounded-full object-cover border shadow-sm">

                                        <div>
                                            <p class="font-semibold text-gray-800 text-sm">
                                                {{ $student->last_name }},
                                                {{ $student->first_name }}
                                                {{ $student->middle_name ? ' '.$student->middle_name[0].'.' : '' }}
                                                {{ $student->suffix ? ' '.$student->suffix : '' }}
                                            </p>
                                            <p class="text-xs text-gray-400">
                                                {{ $student->school_id }}
                                            </p>
                                        </div>

                                    </div>
                                </td>

                                <td class="px-4 py-4 text-right">
                                    <form action="{{ route('teacher.students.unenroll', $student->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Unenroll this student?')">
                                        @csrf
                                        @method('PUT')
                                        <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs shadow">
                                            Unenroll
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-6 text-gray-400">
                                    No male students
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

        </div>



        {{-- ================= FEMALE STUDENTS ================= --}}
        <div class="bg-white rounded-2xl border border-pink-100 shadow-sm flex flex-col">

            <!-- Card Header -->
            <div class="bg-pink-50 px-6 py-4 border-b border-pink-100 rounded-t-2xl">
                <h3 class="text-lg font-bold text-pink-700 flex justify-between">
                    <span>Female Students</span>
                    <span class="text-sm bg-pink-100 text-pink-700 px-3 py-1 rounded-full">
                        {{ $section->students->where('sex','Female')->count() }}
                    </span>
                </h3>
            </div>

            <!-- Table -->
            <div class="overflow-auto flex-1">
                <table class="min-w-full text-sm">
                    <tbody class="divide-y">

                       @php
    $femaleStudents = $section->students
        ->where('sex', 'Female')
        ->sortBy(function($student) {
            return $student->last_name . ' ' . $student->first_name;
        });
@endphp
                        @forelse($femaleStudents as $index => $student)
                            <tr class="hover:bg-pink-50 transition">

                                <td class="px-4 py-4 text-gray-500 w-10">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">

                                        <img
                                            src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/photo-placeholder.png') }}"
                                            class="w-10 h-10 rounded-full object-cover border shadow-sm">

                                        <div>
                                            <p class="font-semibold text-gray-800 text-sm">
                                                {{ $student->last_name }},
                                                {{ $student->first_name }}
                                                {{ $student->middle_name ? ' '.$student->middle_name[0].'.' : '' }}
                                                {{ $student->suffix ? ' '.$student->suffix : '' }}
                                            </p>
                                            <p class="text-xs text-gray-400">
                                                {{ $student->school_id }}
                                            </p>
                                        </div>

                                    </div>
                                </td>

                                <td class="px-4 py-4 text-right">
                                    <form action="{{ route('teacher.students.unenroll', $student->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Unenroll this student?')">
                                        @csrf
                                        @method('PUT')
                                        <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs shadow">
                                            Unenroll
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-6 text-gray-400">
                                    No female students
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

        </div>

    </div>

</div>


        @endforeach
    </div>
    </div>
</div>





<main class="max-w-7xl mx-auto space-y-12 px-4">

    
</main>




<!-- ENROLL STUDENT MODAL -->
<div id="enrollStudentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 relative mx-auto my-auto">
        <h2 class="text-xl font-bold mb-4">Enroll Student</h2>

        <form method="POST" action="{{ route('teacher.students.enroll') }}">
            @csrf
<label class="block text-gray-700 font-medium mb-2">Select Student</label>
<select name="student_id" required class="w-full px-4 py-2 border rounded-lg mb-4">
    <option value="">-- Choose Student --</option>
    @foreach($students as $student)
        <option value="{{ $student->id }}">
            {{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name ? ' '.$student->middle_name[0].'.' : '' }} {{ $student->suffix ? ' '.$student->suffix : '' }} ({{ $student->school_id }})    
        </option>
    @endforeach
</select>

            <label class="block text-gray-700 font-medium mb-2">Select Section</label>
            <select name="section_id" required class="w-full px-4 py-2 border rounded-lg mb-4">
                <option value="">-- Choose Section --</option>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}">{{ $section->year_level }} - {{ $section->name }}</option>
                @endforeach
            </select>

            <div class="flex justify-end gap-3 mt-4">
                <button type="button" onclick="document.getElementById('enrollStudentModal').classList.add('hidden');"
                        class="bg-gray-300 px-4 py-2 rounded-lg">Cancel</button>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg">Enroll</button>
            </div>
        </form>

        <button onclick="document.getElementById('enrollStudentModal').classList.add('hidden');"
                class="absolute top-3 right-3 text-xl">✕</button>
    </div>
</div>


<!-- ANNOUNCEMENT MODAL -->
<div id="announcementModal"
     class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl p-6 relative animate-fadeIn">

        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-indigo-600">📢 Create Announcement</h2>
            <button onclick="closeAnnouncementModal()"
                    class="text-gray-400 hover:text-red-500 text-xl">&times;</button>
        </div>

        <!-- Form to create new announcement -->
        <form action="{{ route('teacher.announcements.store') }}" method="POST" class="mb-4">
            @csrf

            <!-- Title -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" required
                       class="w-full mt-1 px-4 py-2 border rounded-xl focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>

            <!-- Message -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Message</label>
                <textarea name="message" rows="4" required
                          class="w-full mt-1 px-4 py-2 border rounded-xl focus:ring-2 focus:ring-indigo-400 focus:outline-none"></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-3">
                <button type="button"
                        onclick="closeAnnouncementModal()"
                        class="px-4 py-2 bg-gray-200 rounded-xl hover:bg-gray-300">
                    Cancel
                </button>

                <button type="submit"
                        class="px-5 py-2 bg-indigo-600 text-white rounded-xl shadow hover:bg-indigo-700 transition">
                    Post Announcement
                </button>
            </div>
        </form>

        <!-- List of announcements -->
        <ul class="space-y-4 mt-4">
            @foreach($announcements as $announcement)
            <li x-data="{ editing: false, title: '{{ addslashes($announcement->title) }}', content: '{{ addslashes($announcement->content) }}' }"
                class="bg-indigo-50 p-4 rounded-2xl shadow hover:shadow-lg transition">

                <!-- Display Mode -->
                <div x-show="!editing">
                    <h3 class="font-semibold text-indigo-900 text-lg mb-1" x-text="title"></h3>
                    <p class="text-gray-700 text-sm" x-text="content"></p>
                    <div class="flex justify-between items-center mt-2 text-xs text-gray-500">
                        <span>Posted by: {{ $announcement->user->name }}</span>
                        <span>{{ $announcement->created_at->format('M d, Y') }}</span>
                    </div>

                    <div class="flex gap-2 mt-2">
                        <button @click="editing = true"
                                class="text-indigo-600 hover:underline text-sm">Edit</button>

                        <form @submit.prevent="deleteAnnouncement({{ $announcement->id }}, $el)" class="inline">
                            @csrf
                            @method('DELETE')
                          <!--  <button type="submit" class="text-red-600 hover:underline text-sm">Delete</button> -->
                        </form>
                    </div>
                </div>

                <!-- Edit Mode -->
                <div x-show="editing" x-cloak class="space-y-2">
                    <input type="text" x-model="title" class="w-full px-3 py-2 rounded-xl border" />
                    <textarea x-model="content" class="w-full px-3 py-2 rounded-xl border"></textarea>

                    <div class="flex gap-2">
                        <button @click="
                            updateAnnouncement({{ $announcement->id }}, title, content);
                            editing = false;
                        "
                                class="bg-indigo-600 text-white px-3 py-1 rounded-xl hover:bg-indigo-700 text-sm">Save</button>

                        <button @click="editing = false"
                                class="bg-gray-300 px-3 py-1 rounded-xl text-sm">Cancel</button>
                    </div>
                </div>

            </li>
            @endforeach
        </ul>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function closeAnnouncementModal() {
    const modal = document.getElementById('announcementModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Inline Update
function updateAnnouncement(id, title, content) {
    axios.put(`/teacher/announcements/${id}`, {
        title: title,
        message: content
    })
    .then(() => {
        Swal.fire({
            icon: 'success',
            title: 'Updated!',
            text: 'Announcement updated successfully.',
            confirmButtonColor: '#6366f1'
        });
    })
    .catch(() => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to update announcement.',
            confirmButtonColor: '#f87171'
        });
    });
}

// Inline Delete
function deleteAnnouncement(id, formElement) {
    axios.delete(`/teacher/announcements/${id}`)
        .then(() => {
            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: 'Announcement deleted successfully.',
                confirmButtonColor: '#6366f1'
            });
            formElement.closest('li').remove();
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to delete announcement.',
                confirmButtonColor: '#f87171'
            });
        });
}
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
.animate-fadeIn {
    animation: fadeIn 0.2s ease-out;
}
</style>


<!-- PROFILE MODAL -->
<div id="profileModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl p-6 relative overflow-y-auto max-h-[90vh]">

        <h2 class="text-xl font-bold mb-6">My Profile</h2>

        <form method="POST"
              action="{{ route('profile.update') }}"
              enctype="multipart/form-data"
              x-data="{ editMode: false }">

            @csrf
            @method('PATCH')

            @php
                $teacher = auth()->user()->teacher;
            @endphp

            <!-- PHOTO -->
            <div class="flex items-center gap-6 mb-6">
                <img src="{{ $teacher && $teacher->photo 
                                ? asset('storage/'.$teacher->photo) 
                                : asset('images/photo-placeholder.png') }}"
                     class="w-24 h-24 rounded-full object-cover shadow">

                <div x-show="editMode">
                    <input type="file" name="photo" class="block text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- FIRST NAME -->
                <div>
                    <label class="text-sm font-medium">First Name</label>
                    <input type="text" name="first_name"
                           value="{{ $teacher->first_name ?? '' }}"
                           :disabled="!editMode"
                           class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-50 disabled:bg-gray-100">
                </div>

                <!-- MIDDLE NAME -->
                <div>
                    <label class="text-sm font-medium">Middle Name</label>
                    <input type="text" name="middle_name"
                           value="{{ $teacher->middle_name ?? '' }}"
                           :disabled="!editMode"
                           class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-50 disabled:bg-gray-100">
                </div>

                <!-- LAST NAME -->
                <div>
                    <label class="text-sm font-medium">Last Name</label>
                    <input type="text" name="last_name"
                           value="{{ $teacher->last_name ?? '' }}"
                           :disabled="!editMode"
                           class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-50 disabled:bg-gray-100">
                </div>

                <!-- SUFFIX -->
                <div>
                    <label class="text-sm font-medium">Suffix</label>
                    <input type="text" name="suffix"
                           value="{{ $teacher->suffix ?? '' }}"
                           :disabled="!editMode"
                           class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-50 disabled:bg-gray-100">
                </div>

                <!-- BIRTHDAY -->
                <div>
                    <label class="text-sm font-medium">Birthday</label>
                    <input type="date" name="birthday"
                           value="{{ $teacher->birthday ?? '' }}"
                           :disabled="!editMode"
                           class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-50 disabled:bg-gray-100">
                </div>

                <!-- USERNAME (from users table)  -->
                <div>
                    <label class="text-sm font-medium">Username</label>
                    <input type="text" name="username"
                           value="{{ auth()->user()->username }}"
                           :disabled="!editMode"
                           class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-50 disabled:bg-gray-100">
                </div> 

                <!-- CONTACT -->
                <div>
                    <label class="text-sm font-medium">Contact Number</label>
                    <input type="text" name="contact_number"
                           value="{{ $teacher->contact_number ?? '' }}"
                           :disabled="!editMode"
                           class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-50 disabled:bg-gray-100">
                </div>

                <!-- EMAIL (NOT EDITABLE - from users table) -->
                <div>
                    <label class="text-sm font-medium">Email</label>
                    <input type="email"
                           value="{{ auth()->user()->email }}"
                           disabled
                           class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-200 cursor-not-allowed">
                </div>

                <!-- PASSWORD -->
                <div class="md:col-span-2" x-show="editMode">
                    <label class="text-sm font-medium">New Password</label>
                    <input type="password" name="password"
                           placeholder="Leave blank if not changing"
                           class="w-full border rounded-lg px-3 py-2 mt-1">
                </div>

            </div>

            <!-- BUTTONS -->
            <div class="flex justify-end gap-3 mt-8">

                <!-- EDIT BUTTON -->
                <button type="button"
                        x-show="!editMode"
                        @click="editMode = true"
                        class="bg-indigo-600 text-white px-5 py-2 rounded-lg">
                    Edit Profile
                </button>

                <!-- CANCEL BUTTON -->
                <button type="button"
                        x-show="editMode"
                        @click="editMode = false"
                        class="bg-gray-400 text-white px-5 py-2 rounded-lg">
                    Cancel
                </button>

                <!-- SAVE BUTTON -->
                <button type="submit"
                        x-show="editMode"
                        class="bg-green-600 text-white px-5 py-2 rounded-lg">
                    Save Changes
                </button>

            </div>
        </form>

        <!-- CLOSE -->
        <button onclick="closeProfileModal()"
                class="absolute top-3 right-4 text-xl">
            ✕
        </button>
    </div>
</div>

<script>
function closeProfileModal() {
    document.getElementById('profileModal').classList.add('hidden');
    document.getElementById('profileModal').classList.remove('flex');
}
</script>


<!-- RE-ENROLL MODAL -->
<div id="reEnrollModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 relative">

        <h2 class="text-lg font-bold mb-4">Re-Enroll Student</h2>

        <form method="POST" action="{{ route('teacher.students.enroll') }}">
            @csrf

            {{-- Student ID (auto-filled) --}}
            <input type="hidden" name="student_id" id="reEnrollStudentId">

            <label class="block text-gray-700 font-medium mb-2">
                Select Section
            </label>

            <select name="section_id" required class="w-full border rounded-lg px-4 py-2 mb-4">
                @foreach($sections as $section)
                    <option value="{{ $section->id }}">
                        {{ $section->year_level }} - {{ $section->name }}
                    </option>
                @endforeach
            </select>

            <div class="flex justify-end gap-3">
                <button type="button"
                        onclick="closeReEnrollModal()"
                        class="bg-gray-300 px-4 py-2 rounded">
                    Cancel
                </button>
                <button type="submit"
                        class="bg-green-600 text-white px-5 py-2 rounded">
                    Re-Enroll
                </button>
            </div>
        </form>

        <button onclick="closeReEnrollModal()"
                class="absolute top-3 right-4 text-xl">
            ✕
        </button>
    </div>
</div>
<script>
    function openReEnrollModal(studentId) {
        document.getElementById('reEnrollStudentId').value = studentId;
        document.getElementById('reEnrollModal').classList.remove('hidden');
        document.getElementById('reEnrollModal').classList.add('flex');
    }

    function closeReEnrollModal() {
        document.getElementById('reEnrollModal').classList.add('hidden');
        document.getElementById('reEnrollModal').classList.remove('flex');
    }
</script>



<script src="//unpkg.com/alpinejs" defer></script>

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
</div>
</body>


<<<<<<< HEAD

=======
<<<<<<< HEAD

=======
<!--@if(session('success'))
<div x-data="{ 
        show: true, 
        seconds: 3,
        startCountdown() {
            let timer = setInterval(() => {
                if (this.seconds > 0) {
                    this.seconds--;
                } else {
                    this.show = false;
                    clearInterval(timer);
                }
            }, 1000);
        }
    }"
    x-init="startCountdown()"
    x-show="show"
    x-transition
    class="fixed top-6 right-6 bg-green-600 text-white px-6 py-4 rounded-xl shadow-lg z-50 w-80">

    <div class="flex justify-between items-start gap-4">
        <div>
            <p class="font-semibold">✅ Success</p>
            <p class="text-sm mt-1">{{ session('success') }}</p>
            <p class="text-xs mt-2 opacity-80">
                Closing in <span x-text="seconds"></span> seconds...
            </p>
        </div>

        <button @click="show = false" class="text-white font-bold text-lg leading-none">
            ✕
        </button>
    </div>
</div>
@endif-->
>>>>>>> 613e1229c52f180efb9f6039d1dc4243eba34df1
>>>>>>> 7945d1551f9510fadfced8469c757ebd7da4a99a


</html>
