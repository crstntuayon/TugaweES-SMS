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
                <p class="text-sm text-gray-500">Tugawe Elementary School</p>
            </div>
        </div>
     <div class="relative" x-data="{ open: false }">

    <!-- Trigger -->
    <button
        @click="open = !open"
        class="flex items-center gap-2 bg-white hover:bg-gray-100 px-4 py-2 rounded-lg shadow text-sm font-medium text-gray-700"
    >
        <span class="hidden md:block">
          Menu
        </span>
        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                  d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <!-- Dropdown -->
    <div
        x-show="open"
        @click.away="open = false"
        x-transition
        class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50"
    >

        <!-- User Info -->
        <div class="px-4 py-3 border-b">
            <p class="text-sm font-semibold text-gray-800">
                {{ auth()->user()->name ?? 'User' }}
            </p>
            <p class="text-xs text-gray-500 truncate">
                {{ auth()->user()->email }}
            </p>
        </div>

        <!-- Profile -->
        <a href="{{ route('profile.edit') }}"
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
            👤 Profile
        </a>

        <!-- Divider -->
        <div class="border-t"></div>

        <!-- Logout Link -->
<a href="{{ route('logout') }}"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
   class="flex items-center gap-2 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition">
    <!-- Door/Logout Icon SVG -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
    </svg>
    Logout
</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
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

<!-- ADD STUDENT MODAL -->
<div id="addStudentModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl p-6 relative overflow-y-auto max-h-[90vh]">

        <!-- MODAL HEADER -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Add New Student</h2>
            <button type="button" onclick="closeAddStudentModal()"
                    class="text-gray-500 hover:text-red-500 text-2xl font-bold">
                &times;
            </button>
        </div>

        <!-- STUDENT FORM -->
        <form method="POST" action="{{ route('admin.students.store') }}" class="space-y-4">
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

            <!-- ADDRESS -->
            <div>
                <textarea name="address" rows="2" placeholder="Home Address"
                          class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400">{{ old('address') }}</textarea>
            </div>

            <!-- SECTION + SCHOOL YEAR -->
            <div>
                <select name="section_id" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                    <option value="">-- Select Section --</option>
                    @if(isset($sections) && $sections->count())
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}"
                                {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                {{ $section->year_level }} - {{ $section->name }} ({{ $section->school_year }})
                            </option>
                        @endforeach
                    @else
                        <option value="">No sections available</option>
                    @endif
                </select>
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

</body>
</html>
