<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students | Admin Dashboard</title>
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
   <header class="bg-white shadow-sm border rounded-xl px-6 py-4 flex items-center justify-between">

    <!-- LEFT -->
    <div class="flex items-center gap-4">

        <a href="{{ route('admin.dashboard') }}"
           class="p-2 rounded-lg hover:bg-indigo-100 transition">
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
             class="h-12 w-12 rounded-full shadow ring-2 ring-indigo-200">

        <div>
            <h1 class="text-xl font-bold text-gray-800">
                Student Management
            </h1>
            <p class="text-xs text-gray-500">
                Tugawe Elementary School
            </p>
        </div>

    </div>

    <!-- RIGHT -->
    <div class="flex items-center gap-3">

        <input type="text"
               id="studentSearch"
               placeholder="Search student..."
               class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 w-64">

        <button onclick="openAddStudentModal()"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow">
            + Add Student
        </button>

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

<!-- STUDENTS TABLE -->
<div class="overflow-x-auto bg-white rounded-2xl shadow border">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-100 uppercase text-xs text-gray-600">
            <tr>
                <th class="px-5 py-3 text-left">No.</th>
                <th class="px-5 py-3 text-left">Student</th>
                <th class="px-5 py-3 text-center">Actions</th>
            </tr>
        </thead>

        <tbody class="divide-y">
        @foreach($students->sortBy('last_name') as $student)

        @php
            $enrollment = $student->enrollments()->where('school_year_id', $activeYear->id)->first();

            $status = $enrollment->status ?? 'N/A';

            $statusColor = match($status) {
                'enrolled' => 'bg-green-100 text-green-800',
                'unenrolled' => 'bg-red-100 text-red-800',
                'promoted' => 'bg-blue-100 text-blue-800',
                'retained' => 'bg-yellow-100 text-yellow-800',
                'transferred' => 'bg-purple-100 text-purple-800',
                default => 'bg-gray-100 text-gray-800',
            };
        @endphp

        <tr class="hover:bg-indigo-50 transition student-row"
            data-search="{{ strtolower($student->first_name.' '.$student->middle_name.' '.$student->last_name.' '.$student->school_id) }}">

            <!-- NUMBER -->
            <td class="px-5 py-4">
                {{ $loop->iteration }}
            </td>

            <!-- STUDENT -->
            <td class="px-5 py-4">
                <div class="flex items-center gap-4">
                    <img src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/photo-placeholder.png') }}"
                         class="w-12 h-12 rounded-full object-cover shadow">

                    <div>
                        <p class="font-semibold text-gray-800 leading-tight">
                            {{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name }} {{ $student->suffix }}
                        </p>

                        <p class="text-xs text-gray-500 mt-1">
                            S-ID: {{ $student->school_id }}
                        </p>

                         <p class="text-xs text-gray-500 mt-1">
                            Section: {{ $enrollment->section->name ?? 'N/A' }}
                        </p>

                        <span class="mt-1 inline-block px-2 py-0.5 text-xs font-medium rounded-full {{ $statusColor }}">
                            {{ ucfirst($status) }}
                        </span>
                    </div>
                </div>
            </td>

            <!-- GRADE -->



            <!-- SECTION -->
     

            <!-- ACTIONS -->
            <td class="px-5 py-4 text-center">
                <div class="flex justify-center gap-3 relative">

                    <div class="relative inline-block text-left">

                        <button onclick="toggleFormDropdown({{ $student->id }})"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded-lg text-xs">
                            School Forms
                        </button>

                        <div id="formDropdown{{ $student->id }}"
                             class="hidden absolute right-0 mt-2 w-36 bg-white border rounded-lg shadow-lg z-50">

                            <a href="{{ route('admin.sf9.show', $student->id) }}"
                               class="block px-4 py-2 text-sm hover:bg-indigo-100">SF9</a>

                            <a href="{{ route('admin.sf10.show', $student->id) }}"
                               class="block px-4 py-2 text-sm hover:bg-indigo-100">SF10</a>

                            <button onclick="openEditStudentModal(this)"
                                    data-id="{{ $student->id }}"
                                    data-first="{{ $student->first_name }}"
                                    data-middle="{{ $student->middle_name ?? '' }}"
                                    data-last="{{ $student->last_name }}"
                                    data-suffix="{{ $student->suffix ?? '' }}"
                                    data-birthday="{{ $student->birthday }}"
                                    data-email="{{ $student->email }}"
                                    data-contact="{{ $student->contact_number ?? '' }}"
                                    data-sex="{{ $student->sex ?? '' }}"
                                    data-address="{{ $student->address ?? '' }}"
                                    data-photo="{{ $student->photo ?? '' }}"
                                    class="block px-4 py-2 text-sm hover:bg-indigo-100">
                                Update Student
                            </button>

                        </div>

                    </div>

                </div>
            </td>

        </tr>
        @endforeach
        </tbody>
    </table>
</div>

<!-- ================= ADD STUDENT MODAL ================= -->
<div id="addStudentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl p-6 relative overflow-y-auto max-h-[90vh]">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Add New Student</h2>
            <button type="button" onclick="closeAddStudentModal()" class="text-gray-500 hover:text-red-500 text-2xl font-bold">&times;</button>
        </div>

        <!-- FORM -->
        <form method="POST" action="{{ route('admin.students.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- NAMES + LRN -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <input type="text" name="first_name" placeholder="First Name" required value="{{ old('first_name') }}" class="px-4 py-2 rounded-lg border">
                <input type="text" name="middle_name" placeholder="Middle Name" value="{{ old('middle_name') }}" class="px-4 py-2 rounded-lg border">
                <input type="text" name="last_name" placeholder="Last Name" required value="{{ old('last_name') }}" class="px-4 py-2 rounded-lg border">
                <input type="text" name="suffix" placeholder="Suffix (Jr., Sr.)" value="{{ old('suffix') }}" class="px-4 py-2 rounded-lg border">
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

<script>
function toggleFormDropdown(studentId) {
    let dropdown = document.getElementById('formDropdown' + studentId);

    // Close other dropdowns first
    document.querySelectorAll('[id^="formDropdown"]').forEach(menu => {
        if(menu !== dropdown){
            menu.classList.add('hidden');
        }
    });

    dropdown.classList.toggle('hidden');
}

document.addEventListener('click', function(event) {

    document.querySelectorAll('[id^="formDropdown"]').forEach(dropdown => {

        let button = dropdown.parentElement.querySelector('button');

        if(!dropdown.contains(event.target) && !button.contains(event.target)){
            dropdown.classList.add('hidden');
        }

    });

});
</script>

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


          

            <!-- CONTACT NUMBER & ADDRESS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Contact Number -->
                <div class="mt-1 flex items-center gap-2">
    <!-- Visual +63 only -->
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

<script>
function formatPhone(input) {
    let numbers = input.value.replace(/\D/g, '').substring(0,10); // max 10 digits (without +63)
    
    // Format as XXX XXX XXXX
    let formatted = numbers;
    if (numbers.length > 3 && numbers.length <= 6) formatted = numbers.slice(0,3) + ' ' + numbers.slice(3);
    else if (numbers.length > 6) formatted = numbers.slice(0,3) + ' ' + numbers.slice(3,6) + ' ' + numbers.slice(6);
    
    input.value = formatted; // DO NOT prepend +63 here
}
</script>

               
            </div>

           

            <!-- PASSWORDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="password" name="password" placeholder="Password" required class="px-4 py-2 rounded-lg border">
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required class="px-4 py-2 rounded-lg border">
            </div>

            <!-- PROFILE PHOTO -->
            <div class="mb-3 mt-3">
                <label for="addPhoto" class="block text-sm font-medium text-gray-700">Profile Photo</label>
                <input type="file" name="photo" id="addPhoto" accept="image/*" class="mt-1 block w-full">
                <div class="mt-2">
                    <img id="addPhotoPreview" src="{{ asset('images/photo-placeholder.png') }}" class="w-24 h-24 object-cover rounded-full border" alt="Photo Preview">
                </div>
            </div>

            <!-- BUTTONS -->
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeAddStudentModal()" class="bg-gray-300 px-4 py-2 rounded-lg font-medium">Cancel</button>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg shadow-md font-medium">Save Student</button>
            </div>
        </form>
    </div>
</div>




<!-- ================= EDIT STUDENT MODAL ================= -->
<div id="editStudentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl p-6 relative overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-bold mb-4">Edit Student</h2>
        <form id="editStudentForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- NAME FIELDS -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="first_name" id="edit_student_first" placeholder="First Name" class="px-4 py-2 border rounded-lg" required>
                <input type="text" name="middle_name" id="edit_student_middle" placeholder="Middle Name" class="px-4 py-2 border rounded-lg">
                <input type="text" name="last_name" id="edit_student_last" placeholder="Last Name" class="px-4 py-2 border rounded-lg" required>
                <input type="text" name="suffix" id="edit_student_suffix" placeholder="Suffix" class="px-4 py-2 border rounded-lg">
            </div>

            <!-- BIRTHDAY FIELD -->
            <input type="date" name="birthday" id="edit_student_birthday" class="w-full mt-3 px-4 py-2 border rounded-lg" required>
           
           <!-- EMAIL FIELD (READONLY) -->
           <div class="relative mt-3">
    <label for="edit_student_email" class="block text-gray-700 text-sm font-medium mb-1">
        Email Address
    </label>
    <input type="email"
           name="email"
           id="edit_student_email"
           placeholder="Email Address"
          value="{{ old('email', $student->email ?? '') }}"
           readonly
           class="w-full mt-1 px-4 py-2 border rounded-lg bg-gray-100 cursor-not-allowed"
           onfocus="showEmailTooltip()">

    <!-- Tooltip -->
    <span id="emailTooltip"
          class="absolute left-2 top-full mt-1 text-xs text-white bg-gray-800 px-2 py-1 rounded opacity-0 transition-opacity duration-300 pointer-events-none">
        This field is uneditable
    </span>
</div>

<script>
function showEmailTooltip() {
    const tooltip = document.getElementById('emailTooltip');
    tooltip.classList.add('opacity-100'); // Show tooltip
    setTimeout(() => {
        tooltip.classList.remove('opacity-100'); // Hide after 2 seconds
    }, 2000);
}
</script>

       <!-- CONTACT NUMBER -->
            <input type="text" name="contact_number" id="edit_student_contact" placeholder="Contact Number" class="w-full mt-3 px-4 py-2 border rounded-lg">

       <!--SEX SELECTION-->
            <select name="sex" id="edit_student_sex" class="w-full mt-3 px-4 py-2 border rounded-lg" required>
                <option value="">Select Sex</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

        <!-- ADDRESS FIELD WITH SUGGESTIONS -->
            <div class="mt-3">
                <label for="edit_student_address" class="block text-gray-700 text-sm font-medium mb-1">Home Address</label>
                <input list="addresses_list" id="edit_student_address" name="address" placeholder="Enter your address" class="w-full px-4 py-2 rounded-lg border">
                <datalist id="addresses_list">
                    <option value="Bulak, Dauin, Negros Oriental">
                    <option value="Libjo, Dauin, Negros Oriental">
                    <option value="Lipayo, Dauin, Negros Oriental">
                    <option value="Mag-aso, Dauin, Negros Oriental">
                    <option value="Tugawe, Dauin, Negros Oriental">
                </datalist>
            </div>

            <!--EDIT PHOTO-->
            <div class="mb-3 mt-3">
                <label for="editPhoto" class="block text-sm font-medium text-gray-700">Profile Photo</label>
                <input type="file" name="photo" id="editPhoto" accept="image/*" class="mt-1 block w-full">
                <div class="mt-2">
                    <img id="photoPreview" src="{{ asset('images/photo-placeholder.png') }}" class="w-24 h-24 object-cover rounded-full border" alt="Photo Preview">
                </div>
            </div>


            <div class="flex justify-end gap-3 mt-4">
                <button type="button" onclick="closeEditStudentModal()" class="bg-gray-300 px-4 py-2 rounded-lg">Cancel</button>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg">Update</button>
            </div>
        </form>
        <button onclick="closeEditStudentModal()" class="absolute top-3 right-3 text-xl">✕</button>
    </div>
</div>

<script>
/* ------------------ MODAL FUNCTIONS ------------------ */
function openAddStudentModal() {
    document.getElementById('addStudentModal').classList.remove('hidden');
    document.getElementById('addStudentModal').classList.add('flex');
}
function closeAddStudentModal() {
    document.getElementById('addStudentModal').classList.add('hidden');
    document.getElementById('addStudentModal').classList.remove('flex');
}
function openEditStudentModal(button) {
    const modal = document.getElementById('editStudentModal');
    const form = document.getElementById('editStudentForm');
    form.action = `{{ url('admin/students') }}/${button.dataset.id}`;
    document.getElementById('edit_student_first').value = button.dataset.first;
    document.getElementById('edit_student_middle').value = button.dataset.middle || '';
    document.getElementById('edit_student_last').value = button.dataset.last;
    document.getElementById('edit_student_suffix').value = button.dataset.suffix || '';
    document.getElementById('edit_student_birthday').value = button.dataset.birthday || '';
    document.getElementById('edit_student_email').value = button.dataset.email || '';
    document.getElementById('edit_student_contact').value = button.dataset.contact || '';
    document.getElementById('edit_student_sex').value = button.dataset.sex || '';
    document.getElementById('edit_student_address').value = button.dataset.address || '';
    document.getElementById('photoPreview').src = button.dataset.photo ? `{{ asset('storage') }}/${button.dataset.photo}` : '{{ asset("images/photo-placeholder.png") }}';
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeEditStudentModal() {
    const modal = document.getElementById('editStudentModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

/* ------------------ PHOTO PREVIEW ------------------ */
document.getElementById('editPhoto').addEventListener('change', function(){
    const file = this.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = e => document.getElementById('photoPreview').src = e.target.result;
        reader.readAsDataURL(file);
    } else {
        document.getElementById('photoPreview').src = '{{ asset("images/photo-placeholder.png") }}';
    }
});
document.getElementById('addPhoto').addEventListener('change', function(){
    const file = this.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = e => document.getElementById('addPhotoPreview').src = e.target.result;
        reader.readAsDataURL(file);
    } else {
        document.getElementById('addPhotoPreview').src = '{{ asset("images/photo-placeholder.png") }}';
    }
});

/* ------------------ SEARCH FILTER ------------------ */
document.getElementById('studentSearch').addEventListener('input', function(){
    const query = this.value.toLowerCase();
    document.querySelectorAll('.student-row').forEach(row => {
        const text = row.dataset.search;
        row.style.display = text.includes(query) ? '' : 'none';
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


</div>
</body>
</html>
