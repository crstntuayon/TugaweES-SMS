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
 

<!-- HEADER -->
<header class="sticky top-0 z-50 backdrop-blur bg-white/80 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/logo.jpg') }}"   class="mx-auto h-20 w-20 rounded-full shadow-lg mb-4 ring-4 ring-indigo-200" alt="School Logo">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Admin Dashboard</h1>
                <p class="text-sm text-gray-500">Tugawe Elementary School | Dauin District</p>
            </div>
        </div>


    
      <!-- MENU DROPDOWN -->
<div class="relative" x-data="{ open: false }">

    <!-- Trigger -->
    <button @click="open = !open"
        class="flex items-center gap-2 bg-white hover:bg-gray-100 px-4 py-2 rounded-xl shadow text-sm font-medium text-gray-700 transition">
        <span class="hidden md:block">Menu</span>
        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <!-- Dropdown -->
    <div x-show="open" @click.away="open = false" x-transition
        class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50">

        <!-- User Info -->
        <div class="px-4 py-3 border-b bg-gray-50">
            <p class="text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->name ?? 'User' }}</p>
            <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
        </div>

        <!-- Menu Items -->
        <div class="flex flex-col divide-y divide-gray-100">

          <!-- Profile -->
<a href="{{ route('profile.edit') }}"
   class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
    
    <!-- User Icon -->
    <svg xmlns="http://www.w3.org/2000/svg"
         width="18" height="18"
         viewBox="0 0 24 24"
         fill="none"
         stroke="currentColor"
         stroke-width="2"
         stroke-linecap="round"
         stroke-linejoin="round">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
        <circle cx="12" cy="7" r="4"/>
    </svg>

    <span>Profile</span>
</a>

<!-- Manage Users -->
<button type="button" onclick="openManageUsersModal()"
    class="w-full flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
    
    <!-- Users Icon -->
    <svg xmlns="http://www.w3.org/2000/svg"
         width="18" height="18"
         viewBox="0 0 24 24"
         fill="none"
         stroke="currentColor"
         stroke-width="2"
         stroke-linecap="round"
         stroke-linejoin="round">
        <path d="M17 21v-2a4 4 0 0 0-3-3.87"/>
        <path d="M7 21v-2a4 4 0 0 1 3-3.87"/>
        <circle cx="12" cy="7" r="4"/>
    </svg>

    <span>Manage Users</span>
</button>

<!-- Create New Admin -->
<button type="button" onclick="openAddAdminModal()"
    class="w-full flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600 transition">
    
    <!-- User Plus Icon -->
    <svg xmlns="http://www.w3.org/2000/svg"
         width="18" height="18"
         viewBox="0 0 24 24"
         fill="none"
         stroke="currentColor"
         stroke-width="2"
         stroke-linecap="round"
         stroke-linejoin="round">
        <path d="M16 21v-2a4 4 0 0 0-4-4H6"/>
        <circle cx="9" cy="7" r="4"/>
        <line x1="19" y1="8" x2="19" y2="14"/>
        <line x1="22" y1="11" x2="16" y2="11"/>
    </svg>

    <span>Create Admin</span>
</button>

             <!-- Issue School IDs Button -->
    
        <button 
    onclick="openSectionModal()"
    class="w-full flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
    
    <!-- ID Card Icon -->
    <svg xmlns="http://www.w3.org/2000/svg" 
         width="18" height="18" 
         viewBox="0 0 24 24" 
         fill="none" 
         stroke="currentColor" 
         stroke-width="2" 
         stroke-linecap="round" 
         stroke-linejoin="round">
        <rect x="2" y="5" width="20" height="14" rx="2"/>
        <circle cx="8" cy="12" r="2"/>
        <path d="M14 10h4"/>
        <path d="M14 14h4"/>
    </svg>

    <span>Issue School IDs</span>
</button>

<!-- Reports -->
<a href="{{ route('admin.reports') }}"
   class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
    
    <!-- Bar Chart Icon -->
    <svg xmlns="http://www.w3.org/2000/svg"
         width="18" height="18"
         viewBox="0 0 24 24"
         fill="none"
         stroke="currentColor"
         stroke-width="2"
         stroke-linecap="round"
         stroke-linejoin="round">
        <line x1="12" y1="20" x2="12" y2="10"/>
        <line x1="18" y1="20" x2="18" y2="4"/>
        <line x1="6" y1="20" x2="6" y2="16"/>
    </svg>

    <span>Reports</span>
</a>

 <!-- Buttons 
        <button onclick="openModal('adminAnnounceModal');"
                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
            📢 Announcements
        </button> -->

            <!-- Active School Year Selector -->
            <div class="px-4 py-3 bg-gray-50">
                <span class="block text-sm font-semibold text-gray-700 mb-2">Active School Year</span>
                <form action="{{ route('admin.schoolyears.activate') }}" method="POST">
                    @csrf
                    <select name="school_year" onchange="this.form.submit()"
                        class="w-full border px-3 py-2 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 text-sm">
                        @foreach($schoolYears as $year)
                            <option value="{{ $year->id }}" {{ $year->is_active ? 'selected' : '' }}>
                                {{ $year->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- Logout -->
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="flex items-center gap-2 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
                </svg>
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>

        </div>
    </div>
</div>

</header>

<main class="max-w-7xl mx-auto px-6 py-10">


 <!-- NAVIGATION TABS -->
    <div class="flex flex-wrap gap-3 mb-10">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm shadow">Dashboard</a>
        <a href="" class="px-4 py-2 rounded-lg bg-white hover:bg-indigo-50 text-gray-700 text-sm shadow">Students</a>
        <a href="" class="px-4 py-2 rounded-lg bg-white hover:bg-green-50 text-gray-700 text-sm shadow">Teachers</a>
        <a href="" class="px-4 py-2 rounded-lg bg-white hover:bg-yellow-50 text-gray-700 text-sm shadow">Sections</a>
    </div>

    <!-- STATS CARDS -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">

        <!-- Students Card -->
<div id="students-card" class="bg-white/90 backdrop-blur-lg rounded-3xl shadow-xl p-6 hover:scale-105 transition-transform duration-300 ease-in-out">

    <!-- HEADER -->
    <div class="flex items-center justify-between">
        <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Students</h2>
        <span class="bg-indigo-100 text-indigo-600 p-3 rounded-xl shadow-inner text-lg">🎓</span>
    </div>

    <!-- COUNT -->
    <p id="students-count" class="text-5xl font-extrabold text-indigo-600 mt-4 tracking-tight">
        {{ $totalStudents ?? 0 }}
    </p>

    <!-- LINK -->
    <a href="{{ route('admin.students.index') }}" 
       class="mt-4 inline-block text-sm font-medium text-indigo-600 hover:underline hover:text-indigo-800 transition">
       Manage Students →
    </a>

    <!-- ADD STUDENT BUTTON -->
   <button onclick="openAddStudentModal()" 
        class="mt-6 group w-full bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white rounded-2xl p-6 shadow-lg flex flex-col transition-transform duration-300 hover:scale-105">
    
    <div class="flex items-center justify-between">
        <h3 class="font-semibold text-lg">Add Student</h3>

        <!-- SVG Plus Icon -->
        <span class="bg-white/20 p-2 rounded-full shadow-sm transition group-hover:bg-white/30 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
        </span>
    </div>

    <p class="mt-2 text-sm text-indigo-100">Add new student with basic information</p>
</button>

</div>

        
           <!-- Teachers Card -->
<div id="teachers-card" class="bg-white/90 backdrop-blur-lg rounded-3xl shadow-xl p-6 hover:scale-105 transition-transform duration-300 ease-in-out">

    <!-- HEADER -->
    <div class="flex items-center justify-between">
        <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Teachers</h2>
        <span class="bg-green-100 text-green-600 p-3 rounded-xl shadow-inner text-lg">👩‍🏫</span>
    </div>

    <!-- COUNT -->
    <p id="teachers-count" class="text-5xl font-extrabold text-green-600 mt-4 tracking-tight">
        {{ $totalTeachers ?? 0 }}
    </p>

     <!-- LINK -->
    <a href="{{ route('admin.teachers.index') }}" 
       class="mt-4 inline-block text-sm font-medium text-green-600 hover:underline hover:text-green-800 transition">
       Manage Teachers →
    </a>

    <!-- ADD TEACHER BUTTON -->
   <button onclick="openAddTeacherModal()" 
        class="mt-6 group w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-2xl p-6 shadow-lg flex flex-col transition-transform duration-300 hover:scale-105">
    
    <div class="flex items-center justify-between">
        <h3 class="font-semibold text-lg">Add Teacher</h3>

        <!-- SVG Plus Icon -->
        <span class="bg-white/20 p-2 rounded-full shadow-sm transition group-hover:bg-white/30 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
        </span>
    </div>

    <p class="mt-2 text-sm text-green-100">Create teacher account</p>
</button>

</div>

   <!-- Sections Card -->
<div id="sections-card" class="bg-white/90 backdrop-blur-lg rounded-3xl shadow-xl p-6 hover:scale-105 transition-transform duration-300 ease-in-out">

    <!-- HEADER -->
    <div class="flex items-center justify-between">
        <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Sections</h2>
        <span class="bg-orange-100 text-orange-600 p-3 rounded-xl shadow-inner text-lg">🏫</span>
    </div>

    <!-- COUNT -->
    <p id="sections-count" class="text-5xl font-extrabold text-orange-600 mt-4 tracking-tight">
        {{ $totalSections ?? 0 }}
    </p>

    <!-- LINK -->
    <a href="{{ route('admin.sections.index') }}" 
       class="mt-4 inline-block text-sm font-medium text-orange-600 hover:underline hover:text-orange-800 transition">
       Manage Sections →
    </a>

    <!-- ADD SECTION BUTTON -->
   <button onclick="openAddSectionModal()" 
        class="mt-6 group w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-2xl p-6 shadow-lg flex flex-col transition-transform duration-300 hover:scale-105">
    
    <div class="flex items-center justify-between">
        <h3 class="font-semibold text-lg">Add Section</h3>
        <!-- SVG Plus Icon -->
        <span class="bg-white/20 p-2 rounded-full shadow-sm transition group-hover:bg-white/30 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
        </span>
    </div>

    <p class="mt-2 text-sm text-orange-100">Assign and Organize Sections</p>
</button>

</div>
    </section>


    

</main>



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
<div id="addStudentModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl p-6 relative overflow-y-auto max-h-[90vh]">

        <!-- MODAL HEADER -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Add New Student</h2>
            <button type="button" onclick="closeAddStudentModal()"
                    class="text-gray-500 hover:text-red-500 text-2xl font-bold">&times;</button>
        </div>

        <!-- STUDENT FORM -->
        <form method="POST" 
              action="{{ route('admin.students.store') }}" 
              enctype="multipart/form-data"
              class="space-y-4">

            @csrf

            <!-- NAME FIELDS -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <input type="text" name="first_name" placeholder="First Name" required
                       value="{{ old('first_name') }}"
                       class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                <input type="text" name="middle_name" placeholder="Middle Name"
                       value="{{ old('middle_name') }}"
                       class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                <input type="text" name="last_name" placeholder="Last Name" required
                       value="{{ old('last_name') }}"
                       class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                <input type="text" name="suffix" placeholder="Suffix (Jr., Sr.)"
                       value="{{ old('suffix') }}"
                       class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                <input type="text" name="lrn" placeholder="LRN" required
                       value="{{ old('lrn') }}"
                       class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
            </div>

            <!-- SEX SELECT -->
            <select name="sex" required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300">
                <option value="">-- Select Sex --</option>
                <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
            </select>

            <!-- BIRTHDAY -->
            <div>
                <label class="block text-sm text-gray-600 mb-1">Birthday</label>
                <input type="date" name="birthday" required
                       value="{{ old('birthday') }}"
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-pink-400 focus:border-pink-400">
            </div>

            <!-- EMAIL -->
            <div>
                <input type="email" name="email" placeholder="Email Address" required
                       value="{{ old('email') }}"
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
            </div>

            <!-- CONTACT NUMBER -->
            <div>
                <input type="text" name="contact_number" placeholder="Contact Number"
                       value="{{ old('contact_number') }}"
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-green-400 focus:border-green-400">
            </div>

            <!-- SCHOOL YEAR -->
<div>
    <label class="block text-sm text-gray-600 mb-1">School Year</label>
    <select name="school_year_id" required
            class="w-full px-4 py-2 rounded-lg border border-gray-300">
        <option value="">-- Select School Year --</option>
        @foreach($schoolYears as $year)
            <option value="{{ $year->id }}"
                {{ old('school_year_id') == $year->id ? 'selected' : '' }}>
                {{ $year->name }}
            </option>
        @endforeach
    </select>
</div>


            <!-- HOME ADDRESS -->
            <div>
                <label for="address" class="block text-gray-700 text-sm font-medium mb-1">Home Address</label>
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

            <!-- PASSWORD -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="password" name="password" placeholder="Password" required
                       class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required
                       class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
            </div>

            <!-- PHOTO UPLOAD -->
            <div class="mb-3 mt-3">
                <label for="editPhoto" class="block text-sm font-medium text-gray-700">Profile Photo</label>
                <input type="file" name="photo" id="editPhoto" accept="image/*" class="mt-1 block w-full">
                <div class="mt-2">
                    <img id="photoPreview" src="{{ asset('images/photo-placeholder.png') }}" class="w-24 h-24 object-cover rounded-full border" alt="Photo Preview">
                </div>
            </div>
            

            <!-- ACTION BUTTONS -->
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeAddStudentModal()"
                        class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-lg font-medium">
                    Cancel
                </button>
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow-md font-medium">
                    Save Student
                </button>
            </div>

        </form>
    </div>
</div>


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
            <input type="date" name="birthday" placeholder="Birthday" required
                   class="w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">

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

                            <td class="p-3">{{ $user->first_name }} {{ $user->last_name }}</td>
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
