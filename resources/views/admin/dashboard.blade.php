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
 

<div class="flex min-h-screen bg-gray-100" x-data="{ sidebarOpen: true }">
<!-- SIDEBAR -->
<aside
x-data="{ sidebarOpen: true }"
class="bg-white/80 backdrop-blur-xl shadow-2xl border-r border-gray-200 flex flex-col transition-all duration-300 ease-in-out"
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

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col">

        <!-- HEADER -->
        <header class="sticky top-0 bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center gap-4">

                <img src="{{ asset('images/logo.jpg') }}"
                     class="h-14 w-14 rounded-full shadow ring-2 ring-indigo-200">

                <div>
                    <h1 class="text-xl font-bold text-gray-800">
                        Admin Dashboard
                    </h1>
                    <p class="text-sm text-gray-500">
                        Tugawe Elementary School | Dauin District
                    </p>
                </div>

            </div>
        </header>


        <!-- PAGE CONTENT -->
        <main class="max-w-7xl mx-auto px-6 py-10 w-full">

            <!-- NAVIGATION TABS -->
            <div class="flex flex-wrap gap-3 mb-10">
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm shadow">Dashboard</a>
                <a href="{{ route('admin.students.index') }}" class="px-4 py-2 rounded-lg bg-white hover:bg-indigo-50 text-gray-700 text-sm shadow">Students</a>
                <a href="{{ route('admin.teachers.index') }}" class="px-4 py-2 rounded-lg bg-white hover:bg-green-50 text-gray-700 text-sm shadow">Teachers</a>
                <a href="{{ route('admin.sections.index') }}" class="px-4 py-2 rounded-lg bg-white hover:bg-yellow-50 text-gray-700 text-sm shadow">Sections</a>
            </div>


            <!-- DASHBOARD CARDS -->
            <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                <!-- STUDENTS -->
                <div class="bg-white rounded-3xl shadow-lg p-6 hover:scale-105 transition">
                    <div class="flex items-center justify-between">
                        <h2 class="text-sm font-semibold text-gray-500 uppercase">Total Students</h2>
                        <span class="bg-indigo-100 text-indigo-600 p-3 rounded-xl">🎓</span>
                    </div>

                    <p class="text-5xl font-extrabold text-indigo-600 mt-4">
                        {{ $totalStudents ?? 0 }}
                    </p>

                    <a href="{{ route('admin.students.index') }}" 
                   class="mt-4 inline-block text-sm font-medium text-indigo-600 hover:underline">
                   Manage Students →
                </a>

                <button onclick="openAddStudentModal()" 
                    class="mt-6 w-full bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-2xl p-6 shadow-lg flex flex-col hover:scale-105 transition">

                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-lg">Add Student</h3>

                        <span class="bg-white/20 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </span>
                    </div>

                    <p class="mt-2 text-sm text-indigo-100">
                        Add new student with basic information
                    </p>
                </button>

            </div>


                <!-- TEACHERS -->
                <div class="bg-white rounded-3xl shadow-lg p-6 hover:scale-105 transition">
                    <div class="flex items-center justify-between">
                        <h2 class="text-sm font-semibold text-gray-500 uppercase">Total Teachers</h2>
                        <span class="bg-green-100 text-green-600 p-3 rounded-xl">👩‍🏫</span>
                    </div>

                    <p class="text-5xl font-extrabold text-green-600 mt-4">
                        {{ $totalTeachers ?? 0 }}
                    </p>

                      <a href="{{ route('admin.teachers.index') }}" 
                   class="mt-4 inline-block text-sm font-medium text-green-600 hover:underline">
                   Manage Teachers →
                </a>

                <button onclick="openAddTeacherModal()" 
                    class="mt-6 w-full bg-gradient-to-r from-green-500 to-green-600 text-white rounded-2xl p-6 shadow-lg flex flex-col hover:scale-105 transition">

                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-lg">Add Teacher</h3>

                        <span class="bg-white/20 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </span>
                    </div>

                    <p class="mt-2 text-sm text-green-100">
                        Create teacher account
                    </p>
                </button>

            </div>



                <!-- SECTIONS -->
                <div class="bg-white rounded-3xl shadow-lg p-6 hover:scale-105 transition">
                    <div class="flex items-center justify-between">
                        <h2 class="text-sm font-semibold text-gray-500 uppercase">Total Sections</h2>
                        <span class="bg-orange-100 text-orange-600 p-3 rounded-xl">🏫</span>
                    </div>

                    <p class="text-5xl font-extrabold text-orange-600 mt-4">
                        {{ $totalSections ?? 0 }}
                    </p>
  <a href="{{ route('admin.sections.index') }}" 
        class="mt-4 inline-block text-sm font-medium text-orange-600 hover:underline">
        Manage Sections →
        </a>

        <button onclick="openAddSectionModal()" 
        class="mt-6 w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-2xl p-6 shadow-lg flex flex-col hover:scale-105 transition">


        <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-lg">Add Section</h3>

                        <span class="bg-white/20 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </span>
                    </div>

   <p class="mt-2 text-sm text-bg-orange-100">
                        Create section
                    </p>
</div>
  
        </button>
    

            </section>

        </main>

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
       min="1000-01-01"   
       max="9999-12-31"   
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

<!-- ================= ADD STUDENT MODAL ================= -->
<div id="addStudentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl p-6 relative overflow-y-auto max-h-[90vh]">

        <!-- MODAL HEADER -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Add New Student</h2>
            <button type="button" onclick="closeAddStudentModal()" class="text-gray-500 hover:text-red-500 text-2xl font-bold">&times;</button>
        </div>

        <!-- STUDENT FORM -->
        <form method="POST" action="{{ route('admin.students.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- NAMES + LRN -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <input type="text" name="first_name" placeholder="First Name" required value="{{ old('first_name') }}" class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                <input type="text" name="middle_name" placeholder="Middle Name" value="{{ old('middle_name') }}" class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                <input type="text" name="last_name" placeholder="Last Name" required value="{{ old('last_name') }}" class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                <input type="text" name="suffix" placeholder="Suffix (Jr., Sr.)" value="{{ old('suffix') }}" class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">

                <input type="text"
                       name="lrn"
                       id="lrn"
                       placeholder="120231xxxxxx"
                       required
                       maxlength="12"
                       inputmode="numeric"
                       value="120231"
                       class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400"
                       oninput="handleLRNInput(this)"
                       onkeydown="preventPrefixDeletion(event)" />
            </div>

<!-- EMAIL & HOME ADDRESS -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <!-- Email -->
    <input type="email"
           name="email"
           placeholder="Email Address"
           required
           value="{{ old('email') }}"
           class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">

    <!-- Home Address -->
    <div>
        <x-input-label for="address" value="Home Address" />
        <input list="addresses"
               id="address"
               name="address"
               placeholder="Enter your address"
               value="{{ old('address') }}"
               class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400">
        <datalist id="addresses">
            <option value="Bulak, Dauin, Negros Oriental">
            <option value="Libjo, Dauin, Negros Oriental">
            <option value="Lipayo, Dauin, Negros Oriental">
            <option value="Mag-aso, Dauin, Negros Oriental">
            <option value="Tugawe, Dauin, Negros Oriental">
        </datalist>
    </div>
</div>
            

            <!-- SEX, BIRTHDAY, SCHOOL YEAR -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">

    <!-- SEX -->
    <div>
        <label class="block text-sm text-gray-600 mb-1">Sex</label>
        <select name="sex" required class="w-full px-4 py-2 rounded-lg border border-gray-300">
            <option value="">-- Select Sex --</option>
            <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
        </select>
    </div>

    <!-- BIRTHDAY -->
    <div>
        <label class="block text-sm text-gray-600 mb-1">Birthday</label>
        <input type="date"
               name="birthday"
               required
               value="{{ old('birthday') }}"
               min="1900-01-01"
               max="{{ date('Y') }}-12-31"
               class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-pink-400 focus:border-pink-400">
    </div>

    <!-- SCHOOL YEAR -->
    <div>
        <label class="block text-sm text-gray-600 mb-1">School Year</label>
        <select name="school_year_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300">
            <option value="">-- Select School Year --</option>
            @foreach($schoolYears as $year)
                <option value="{{ $year->id }}" {{ old('school_year_id') == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
            @endforeach
        </select>
    </div>

</div>

          
            <!-- CONTACT NUMBER & HOME ADDRESS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- CONTACT NUMBER -->
                 
                <div class="flex items-center gap-2 mt-1">
                    <div class="px-3 py-2 bg-gray-100 rounded-xl border text-gray-700 text-sm flex items-center">+63</div>
                   
                    <input type="text"
                           id="contact_number"
                           name="contact_number"
                           maxlength="12"
                           inputmode="numeric"
                           placeholder="917 123 4567"
                           value="{{ old('contact_number') }}"
                           class="flex-1 rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-center"
                           oninput="formatPhone(this)" />
                </div>

            </div>

           

            <!-- PASSWORDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="password" name="password" placeholder="Password" required class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
            </div>

          <!-- PROFILE PHOTO (Add Student) -->
<div class="mb-3 mt-3">
    <label for="addPhoto" class="block text-sm font-medium text-gray-700">Profile Photo</label>
    <input type="file" name="photo" id="addPhoto" accept="image/*" class="mt-1 block w-full">
    <div class="mt-2">
        <img id="addPhotoPreview" src="{{ asset('images/photo-placeholder.png') }}" class="w-24 h-24 object-cover rounded-full border" alt="Photo Preview">
    </div>
</div>

<script>
document.getElementById('addPhoto').addEventListener('change', function(event) {
    const preview = document.getElementById('addPhotoPreview');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        }
        reader.readAsDataURL(file);
    } else {
        // Reset to placeholder if no file selected
        preview.src = "{{ asset('images/photo-placeholder.png') }}";
    }
});
</script>

            <!-- ACTION BUTTONS -->
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeAddStudentModal()" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-lg font-medium">Cancel</button>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow-md font-medium">Save Student</button>
            </div>
        </form>
    </div>
</div>

<!-- ================= SCRIPTS ================= -->
<script>
const prefix = '120231';

function handleLRNInput(input) {
    let numbers = input.value.replace(/\D/g, '');
    let typed = numbers.slice(prefix.length, prefix.length + 6); // max 6 digits
    input.value = prefix + typed;
}

function preventPrefixDeletion(event) {
    const input = event.target;
    const cursorPos = input.selectionStart;

    if ((event.key === 'Backspace' && cursorPos <= prefix.length) ||
        (event.key === 'Delete' && cursorPos < prefix.length)) {
        event.preventDefault();
        input.setSelectionRange(prefix.length, prefix.length);
    }
}

function formatPhone(input) {
    let numbers = input.value.replace(/\D/g, '').substring(0,10);
    let formatted = numbers;
    if (numbers.length > 3 && numbers.length <= 6) formatted = numbers.slice(0,3) + ' ' + numbers.slice(3);
    else if (numbers.length > 6) formatted = numbers.slice(0,3) + ' ' + numbers.slice(3,6) + ' ' + numbers.slice(6);
    input.value = formatted; // +63 shown only visually, not included in input
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



<!-- ================= EDIT USER MODAL ================= -->
<div id="editUserModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-[70] px-4">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 relative">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Edit User</h2>
            <button type="button" onclick="closeEditUserModal()" class="text-gray-500 hover:text-red-500 text-2xl font-bold">&times;</button>
        </div>

        <form id="editUserForm" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="user_id" id="editUserId">

            <input type="text" name="first_name" id="editFirstName"
                   placeholder="First Name"
                   class="w-full px-4 py-2 rounded-lg border mb-2">

            <input type="text" name="last_name" id="editLastName"
                   placeholder="Last Name"
                   class="w-full px-4 py-2 rounded-lg border mb-2">

            <input type="email" name="email" id="editEmail"
                   placeholder="Email"
                   class="w-full px-4 py-2 rounded-lg border mb-2">

            <input type="text" name="username" id="editUsername"
                   placeholder="Username"
                   class="w-full px-4 py-2 rounded-lg border mb-2">

            <select name="role_id" id="editRole"
                    class="w-full px-4 py-2 rounded-lg border mb-4">
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                @endforeach
            </select>

            <div class="flex justify-end gap-2">
                <button type="button"
                        onclick="closeEditUserModal()"
                        class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200">
                    Cancel
                </button>

                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>









<!-- ================= DELETE USER MODAL ================= -->
<div id="deleteUserModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-[70] px-4">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">

        <h2 class="text-xl font-bold text-gray-800 mb-4">Delete User?</h2>

        <p class="text-gray-600 mb-4">
            This action cannot be undone. Deleting in
            <span id="deleteCountdown">5</span> seconds.
        </p>

        <div class="flex justify-center gap-4">
            <button type="button"
                    onclick="cancelDelete()"
                    class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200">
                Cancel
            </button>

            <form id="deleteUserForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600">
                    Delete
                </button>
            </form>
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


// ================= EDIT USER =================
function openEditUserModal(userId) {

    const row = document.querySelector(`tr[data-id='${userId}']`);
    if (!row) return;

    document.getElementById('editUserId').value = userId;
    document.getElementById('editFirstName').value = row.dataset.firstName;
    document.getElementById('editLastName').value = row.dataset.lastName;
    document.getElementById('editEmail').value = row.dataset.email;
    document.getElementById('editUsername').value = row.dataset.username;
    document.getElementById('editRole').value = row.dataset.roleId;

    document.getElementById('editUserForm').action =
        `/admin/users/${userId}`;

    const modal = document.getElementById('editUserModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeEditUserModal() {
    const modal = document.getElementById('editUserModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}


// ================= DELETE USER =================
let deleteTimer;
let countdown = 5;

function openDeleteUserModal(userId) {

    document.getElementById('deleteUserForm').action =
        `/admin/users/${userId}`;

    const modal = document.getElementById('deleteUserModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    countdown = 5;
    document.getElementById('deleteCountdown').innerText = countdown;

    deleteTimer = setInterval(() => {
        countdown--;
        document.getElementById('deleteCountdown').innerText = countdown;

        if (countdown <= 0) {
            clearInterval(deleteTimer);
        }
    }, 1000);
}

function cancelDelete() {
    clearInterval(deleteTimer);
    const modal = document.getElementById('deleteUserModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}


// ================= LIVE SEARCH (UNCHANGED) =================
const searchInput = document.getElementById('liveUserSearch');
const resultsBox = document.getElementById('searchResults');

searchInput.addEventListener('keyup', function () {

    let query = this.value.toLowerCase();
    const rows = document.querySelectorAll('#usersTableContainer tbody tr');

    resultsBox.innerHTML = '';

    if (query.length < 1) {
        rows.forEach(row => row.style.display = '');
        resultsBox.classList.add('hidden');
        return;
    }

    let matchCount = 0;

    rows.forEach(row => {
        let name = row.dataset.name;

        if (name.includes(query)) {
            row.style.display = '';
            matchCount++;

            if (matchCount <= 5) {
                resultsBox.innerHTML += `
                    <div class="p-2 hover:bg-indigo-50 cursor-pointer"
                         onclick="selectUser(${row.dataset.id})">
                        ${row.children[0].innerText}
                    </div>
                `;
            }

        } else {
            row.style.display = 'none';
        }
    });

    if (matchCount === 0) {
        resultsBox.innerHTML = `<div class="p-2 text-gray-500">No users found</div>`;
    }

    resultsBox.classList.remove('hidden');
});

function selectUser(userId) {
    const rows = document.querySelectorAll('#usersTableContainer tbody tr');

    rows.forEach(row => {
        row.style.display = (row.dataset.id == userId) ? '' : 'none';
    });

    resultsBox.classList.add('hidden');
}

searchInput.addEventListener('input', function () {
    if (this.value === '') {
        const rows = document.querySelectorAll('#usersTableContainer tbody tr');
        rows.forEach(row => row.style.display = '');
    }
});

</script>



  <!-- ================= EDIT USER MODAL ================= -->
<div id="editUserModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-60 px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 relative">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Edit User</h2>
            <button type="button" onclick="closeEditUserModal()" class="text-gray-500 hover:text-red-500 text-2xl font-bold">&times;</button>
        </div>

        <form id="editUserForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="user_id" id="editUserId">

            <input type="text" name="first_name" id="editFirstName" placeholder="First Name" class="w-full px-4 py-2 rounded-lg border mb-2">
            <input type="text" name="last_name" id="editLastName" placeholder="Last Name" class="w-full px-4 py-2 rounded-lg border mb-2">
            <input type="email" name="email" id="editEmail" placeholder="Email" class="w-full px-4 py-2 rounded-lg border mb-2">
            <input type="text" name="username" id="editUsername" placeholder="Username" class="w-full px-4 py-2 rounded-lg border mb-2">
            <select name="role_id" id="editRole" class="w-full px-4 py-2 rounded-lg border mb-4">
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                @endforeach
            </select>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeEditUserModal()" class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">Save Changes</button>
            </div>
        </form>
    </div>
</div>
<!-- ================= DELETE USER MODAL ================= -->
<div id="deleteUserModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-60 px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 relative text-center">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Delete User?</h2>
        <p class="text-gray-600 mb-4">This action cannot be undone. Deleting in <span id="deleteCountdown">5</span> seconds.</p>
        <div class="flex justify-center gap-4">
            <button type="button" onclick="cancelDelete()" class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200">Cancel</button>
            <form id="deleteUserForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600">Delete</button>
            </form>
        </div>
    </div>
</div>



<!-- ================= AJAX PAGINATION SCRIPT ================= -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('manageUsersModal');
    const tableContainer = document.getElementById('usersTableContainer');
    const spinner = document.getElementById('usersLoadingSpinner');

    // Delegate clicks for pagination links
    modal.addEventListener('click', function(e) {
        const link = e.target.closest('.pagination a');
        if (!link) return;

        e.preventDefault();
        spinner.classList.remove('hidden');

        fetch(link.href, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            tableContainer.innerHTML = html;
        })
        .catch(err => console.error('Error fetching users:', err))
        .finally(() => spinner.classList.add('hidden'));
    });
});

// Open/Close modal functions
function openManageUsersModal() {
    document.getElementById('manageUsersModal').classList.remove('hidden');
}
function closeManageUsersModal() {
    document.getElementById('manageUsersModal').classList.add('hidden');
}
</script>

<!-- ================= EDIT & DELETE USER MODAL SCRIPTS ================= -->

<script>
let deleteInterval;

// Edit User Modal
function openEditUserModal(userId) {
    const form = document.getElementById('editUserForm');

    // Set form action dynamically
    form.action = "{{ url('/admin/users') }}/" + userId;

    // Fill modal fields
    const row = document.querySelector(`tr[data-id='${userId}']`);
    if (!row) return;

    document.getElementById('editUserId').value = row.dataset.id;
    document.getElementById('editFirstName').value = row.dataset.firstName;
    document.getElementById('editLastName').value = row.dataset.lastName;
    document.getElementById('editEmail').value = row.dataset.email;
    document.getElementById('editUsername').value = row.dataset.username;
    document.getElementById('editRole').value = row.dataset.roleId;

    // Show modal
    const modal = document.getElementById('editUserModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeEditUserModal() {
    document.getElementById('editUserModal').classList.add('hidden');
}

// Delete User Modal (your existing code)
function openDeleteUserModal(userId) {
    const form = document.getElementById('deleteUserForm');
    form.action = `/admin/users/${userId}`;
    
    const modal = document.getElementById('deleteUserModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    let countdown = 5;
    const counter = document.getElementById('deleteCountdown');
    counter.textContent = countdown;

    window.deleteInterval = setInterval(() => {
        countdown--;
        counter.textContent = countdown;
        if (countdown <= 0) {
            clearInterval(window.deleteInterval);
            form.submit();
        }
    }, 1000);
}

function cancelDelete() {
    clearInterval(window.deleteInterval);
    const modal = document.getElementById('deleteUserModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

</script>





<!-- ============ MODAL JS FUNCTIONS ============ -->
<script>
function openManageUsersModal() {
    const modal = document.getElementById('manageUsersModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeManageUsersModal() {
    const modal = document.getElementById('manageUsersModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

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

// TEACHER MODAL FUNCTIONS

 function openAddTeacherModal() {
        document.getElementById('addTeacherModal').classList.remove('hidden');
        document.getElementById('addTeacherModal').classList.add('flex');
    }

    function closeAddTeacherModal() {
        document.getElementById('addTeacherModal').classList.add('hidden');
    }

    
// SECTION MODAL FUNCTIONS

    function openAddSectionModal() {
        document.getElementById('addSectionModal').classList.remove('hidden');
        document.getElementById('addSectionModal').classList.add('flex');
    }

    function closeAddSectionModal() {
        document.getElementById('addSectionModal').classList.add('hidden');
    }


    // STUDENT MODAL FUNCTIONS
    function openAddStudentModal() {
    const modal = document.getElementById('addStudentModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeAddStudentModal() {
    const modal = document.getElementById('addStudentModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>


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

</body>
</html>
