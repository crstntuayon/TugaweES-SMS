<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Dashboard | Student Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-slate-50 min-h-screen font-['Inter'] antialiased text-slate-800">



<!-- ================= REALISTIC SCHOOL MANAGEMENT UI ================= -->
<div x-data="{ sidebarOpen: true, currentTime: new Date().toLocaleTimeString() }" class="flex min-h-screen" x-init="setInterval(() => currentTime = new Date().toLocaleTimeString(), 1000)">

    <!-- Professional Sidebar -->
    <aside 
        :class="sidebarOpen ? 'w-72' : 'w-20'" 
        class="fixed left-0 top-0 h-screen bg-white border-r border-slate-200 z-50 flex flex-col shadow-lg transition-all duration-300 ease-in-out"
    >
        <!-- School Brand Header -->
        <div class="h-20 border-b border-slate-100 flex items-center px-4 gap-3 bg-gradient-to-r from-indigo-600 to-indigo-700">
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 transition">
                <i class="fas fa-bars text-lg"></i>
            </button>
            
            <div x-show="sidebarOpen" x-transition class="flex items-center gap-3 overflow-hidden">
                <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-graduation-cap text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-white font-bold text-sm leading-tight">Tugawe Elementary</h1>
                    <p class="text-indigo-200 text-xs">School Management</p>
                </div>
            </div>
        </div>

        <!-- User Profile Summary -->
        <div class="p-4 border-b border-slate-100 bg-slate-50/50">
            <div class="flex items-center gap-3" x-show="sidebarOpen" x-transition>
                @php
                    $user = auth()->user();
                    $teacher = $user->teacher ?? null;
                    $fullName = trim(($teacher->first_name ?? $user->first_name ?? '') . ' ' . ($teacher->last_name ?? $user->last_name ?? ''));
                    $initials = strtoupper(substr($teacher->first_name ?? $user->first_name ?? 'T', 0, 1) . substr($teacher->last_name ?? $user->last_name ?? 'E', 0, 1));
                @endphp
                <img src="{{ $teacher && $teacher->photo ? asset('storage/'.$teacher->photo) : asset('images/photo-placeholder.png') }}" 
                     class="w-12 h-12 rounded-full object-cover ring-2 ring-white shadow-sm" alt="Profile">
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-slate-900 text-sm truncate">{{ $fullName ?: 'Teacher Name' }}</p>
                    <p class="text-xs text-slate-500 truncate">{{ $user->email ?? 'teacher@tugawe.edu.ph' }}</p>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-100 text-emerald-700 mt-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1 animate-pulse"></span>
                        Online
                    </span>
                </div>
            </div>
            
            <!-- Collapsed View -->
            <div x-show="!sidebarOpen" class="flex justify-center">
                <img src="{{ $teacher && $teacher->photo ? asset('storage/'.$teacher->photo) : asset('images/photo-placeholder.png') }}" 
                     class="w-10 h-10 rounded-full object-cover ring-2 ring-white shadow-sm" alt="Profile">
            </div>
        </div>

       <!-- Navigation Menu -->
<nav class="flex-1 py-4 px-3 space-y-1 overflow-y-auto">
    <div class="px-3 mb-2 text-xs font-semibold text-slate-400 uppercase tracking-wider" x-show="sidebarOpen">Main Menu</div>
    
    <a href="{{ route('teacher.dashboard') }}"  
       class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-indigo-50 text-indigo-700 font-medium transition group relative overflow-hidden">
        <div class="absolute inset-0 bg-indigo-100 opacity-0 group-hover:opacity-100 transition"></div>
        <i class="fas fa-home text-lg relative z-10 w-6 text-center"></i>
        <span x-show="sidebarOpen" class="relative z-10">Home</span>
    </a>

    <button @click="document.getElementById('enrollStudentModal').classList.remove('hidden');"
            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 font-medium transition group">
        <i class="fas fa-user-plus text-lg w-6 text-center text-blue-600"></i>
        <span x-show="sidebarOpen">Enroll Student</span>
    </button>

    <button @click="document.getElementById('announcementModal').classList.remove('hidden');"
            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 font-medium transition group">
        <i class="fas fa-bullhorn text-lg w-6 text-center text-purple-600"></i>
        <span x-show="sidebarOpen">Announcements</span>
    </button>

    <!-- School Forms Dropdown -->
    <div x-data="{ schoolFormsOpen: false }" class="relative">
        <button @click="schoolFormsOpen = !schoolFormsOpen"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 font-medium transition group">
            <i class="fas fa-file-alt text-lg w-6 text-center text-emerald-600"></i>
            <span x-show="sidebarOpen" class="flex-1 text-left">School Forms</span>
            <i x-show="sidebarOpen" 
               :class="schoolFormsOpen ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"
               class="text-xs transition-transform duration-200"></i>
        </button>
        
        <!-- Dropdown Menu -->
        <div x-show="schoolFormsOpen && sidebarOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="ml-9 mt-1 space-y-1">
            
            <a href="{{ route('teacher.school-forms.sf1') }}" 
               class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                <span class="w-6 text-center font-semibold text-xs bg-emerald-100 text-emerald-700 rounded px-1.5 py-0.5">SF1</span>
                <span>School Register</span>
            </a>
            
        <!-- SF2 -->
       <a href="{{ route('teacher.school-forms.sf2') }}"
           class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
            <span class="w-6 text-center font-semibold text-xs bg-emerald-100 text-emerald-700 rounded px-1.5 py-0.5">SF2</span>
            <span>Daily Attendance</span>
        </a>
            
          <!--  <a href="#" 
               class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                <span class="w-6 text-center font-semibold text-xs bg-emerald-100 text-emerald-700 rounded px-1.5 py-0.5">SF3</span>
                <span>Books Issued</span>
            </a> -->
            
            <a href="{{ route('teacher.school-forms.sf4') }}" 
               class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                <span class="w-6 text-center font-semibold text-xs bg-emerald-100 text-emerald-700 rounded px-1.5 py-0.5">SF4</span>
                <span>Monthly Attendance</span>
            </a>
            
            <a href="{{ route('teacher.school-forms.sf5') }}"
                class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                  <span class="w-6 text-center font-semibold text-xs bg-emerald-100 text-emerald-700 rounded px-1.5 py-0.5">SF5</span>
                  <span>Report on Promotion</span>
            </a>
            
            <a href="{{ route('teacher.school-forms.sf6')}}" 
               class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                <span class="w-6 text-center font-semibold text-xs bg-emerald-100 text-emerald-700 rounded px-1.5 py-0.5">SF6</span>
                <span>Summarized Report</span>
            </a>
            
           <a href="{{ route('teacher.school-forms.sf7')}}" 
               class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                <span class="w-6 text-center font-semibold text-xs bg-emerald-100 text-emerald-700 rounded px-1.5 py-0.5">SF7</span>
                <span>School Personnel</span>
            </a>
            
             <a href="{{ route('teacher.school-forms.sf8')}}" 
               class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                <span class="w-6 text-center font-semibold text-xs bg-emerald-100 text-emerald-700 rounded px-1.5 py-0.5">SF8</span>
                <span>Health/Nutrition</span>
            </a>
        </div>
    </div>
</nav>
            <div class="mt-6 px-3 mb-2 text-xs font-semibold text-slate-400 uppercase tracking-wider" x-show="sidebarOpen">System</div>

            <button @click="document.getElementById('profileModal').classList.remove('hidden');"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 font-medium transition group">
                <i class="fas fa-cog text-lg w-6 text-center"></i>
                <span x-show="sidebarOpen">Profile Settings</span>
            </button>
        </nav>

        <!-- Footer Info -->
        <div class="p-4 border-t border-slate-200 bg-slate-50">
            <div x-show="sidebarOpen" class="space-y-3">
                <div class="flex items-center justify-between text-xs text-slate-500">
                    <span>Current Time</span>
                    <span class="font-mono font-medium" x-text="currentTime"></span>
                </div>
                <div class="flex items-center justify-between text-xs">
                    <span class="text-slate-500">School Year</span>
                    <span class="font-bold text-indigo-700 bg-indigo-50 px-2 py-1 rounded">{{ $activeSchoolYear->name ?? '2024-2025' }}</span>
                </div>
                <div class="flex items-center justify-between text-xs">
                    <span class="text-slate-500">Quarter</span>
                    <span class="font-bold text-emerald-700 bg-emerald-50 px-2 py-1 rounded">Q{{ $activeQuarter ?? '1' }}</span>
                </div>
            </div>
            
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="mt-3 flex items-center gap-3 px-3 py-2.5 rounded-xl text-rose-600 hover:bg-rose-50 font-medium transition text-sm">
                <i class="fas fa-sign-out-alt w-6 text-center"></i>
                <span x-show="sidebarOpen">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </aside>


   <div class="flex-1 transition-all duration-300" :class="sidebarOpen ? 'ml-72' : 'ml-20'">
    
    <header class="h-50 bg-white border-b border-gray-200 flex items-center px-8 sticky top-0 z-40">
        <div x-show="sidebarOpen" class="px-6 py-6 border-b border-gray-50 bg-gray-50/50">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" class="h-10 w-10 rounded-full ring-2 ring-emerald-300 shadow-sm">
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


   <!-- Quiz Button -->
<a href="{{ route('teacher.quizzes', $section) }}"
   class="bg-white text-indigo-600 font-semibold px-5 py-2 rounded-xl shadow hover:scale-105 transition transform">
   🧠 Quizzes
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
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm shadow transition-all duration-200 hover:shadow-lg">
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
                                        <tr class="hover:bg-blue-50/70 transition-colors duration-200 group">

                                            <td class="px-4 py-4 text-gray-500 w-10 font-medium">
                                                {{ $index + 1 }}
                                            </td>

                                            <td class="px-4 py-4">
                                                <div class="flex items-center gap-3">
                                                    <img
                                                        src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/photo-placeholder.png') }}"
                                                        class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-md group-hover:scale-105 transition-transform duration-200">

                                                    <div>
                                                        <p class="font-semibold text-gray-800 text-sm">
                                                            {{ $student->last_name }},
                                                            {{ $student->first_name }}
                                                            {{ $student->middle_name ? ' '.$student->middle_name[0].'.' : '' }}
                                                            {{ $student->suffix ? ' '.$student->suffix : '' }}
                                                        </p>
                                                        <p class="text-xs text-gray-400 font-mono tracking-wide">
                                                            {{ $student->school_id }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- ACTION DROPDOWN -->
                                            <td class="px-4 py-4 text-right">
                                                <div class="relative" x-data="{ open: false }">
                                                    <button 
                                                        @click="open = !open" 
                                                        @click.away="open = false"
                                                        class="inline-flex items-center gap-1 bg-slate-800 hover:bg-slate-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium shadow-md hover:shadow-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-1">
                                                        <span>Actions</span>
                                                        <svg class="w-3 h-3 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                        </svg>
                                                    </button>

                                                    <!-- Dropdown Menu -->
                                                    <div 
                                                        x-show="open" 
                                                        x-transition:enter="transition ease-out duration-200"
                                                        x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                        x-transition:leave="transition ease-in duration-150"
                                                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                                        x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                                                        class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden max-h-96 overflow-y-auto"
                                                        style="display: none;">
                                                        
                                                        <!-- SF Forms Group -->
                                                        <div class="bg-gray-50 px-3 py-2 text-xs font-bold text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                                            School Forms (SF1-SF10)
                                                        </div>
                                                        
                                                        <div class="grid grid-cols-1 gap-0.5 p-1">
                                                            <!-- SF1-SF5 
                                                            
                                                            <a href="{{ route('teacher.school-forms.sf2', $section->id) }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg transition-colors duration-150">
                                                                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold shrink-0">2</span>
                                                                <span class="truncate">SF2 - Daily Attendance</span>
                                                            </a> -->


                                                            <a href="{{ route('teacher.school-forms.sf3', $student->id) }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg transition-colors duration-150">
                                                                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold shrink-0">3</span>
                                                                <span class="truncate">SF3 - Books Issued/Returned</span>
                                                            </a>


                                                            <!--<a href="{{ route('teacher.school-forms.sf4', $student->id) }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg transition-colors duration-150">
                                                                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold shrink-0">4</span>
                                                                <span class="truncate">SF4 - Monthly Attendance</span>
                                                            </a> 


                                                            -- BOTH WORKING IN SIDEBAR AND IN MALE ACTION DROPDOWN --
                                                           <a href="{{ route('teacher.school-forms.sf5', $section->id) }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg transition-colors duration-150">
                                                                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold shrink-0">5</span>
                                                                <span class="truncate">SF5 - Report on Promotion/Learning Progress/Achievements</span>
                                                            </a> 
                                                            <a href="{{ route('teacher.school-forms.sf6', $student->id) }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg transition-colors duration-150">
                                                                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold shrink-0">6</span>
                                                                <span class="truncate">SF6 - Summarized Report</span>
                                                            </a> 
                                                            <a href="{{ route('teacher.school-forms.sf7', $student->id) }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg transition-colors duration-150">
                                                                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold shrink-0">7</span>
                                                                <span class="truncate">SF7 - School Personnel</span>
                                                            </a> 
                                                            <a href="{{ route('teacher.school-forms.sf8', $student->id) }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg transition-colors duration-150">
                                                                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold shrink-0">8</span>
                                                                <span class="truncate">SF8 - Health/Nutrition</span>
                                                            </a> -->


                                                            <a href="{{ route('teacher.school-forms.sf9', $student->id) }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg transition-colors duration-150">
                                                                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold shrink-0">9</span>
                                                                <span class="truncate">SF9 - Progress Report Card</span>
                                                            </a>
                                                            <a href="{{ route('teacher.school-forms.sf10', $student->id) }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg transition-colors duration-150">
                                                                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold shrink-0">10</span>
                                                                <span class="truncate">SF10 - Permanent Academic Record</span>
                                                            </a>
                                                        </div>

                                                        <!-- Divider -->
                                                        <div class="border-t border-gray-100 my-1"></div>

                                                        <!-- Unenroll Action -->
                                                        <div class="p-1">
                                                            <form action="{{ route('teacher.students.unenroll', $student->id) }}" method="POST" onsubmit="return confirm('Unenroll {{ $student->first_name }} {{ $student->last_name }}? This action cannot be undone.')">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-150 text-left">
                                                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                                    </svg>
                                                                    <span>Unenroll Student</span>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-8 text-gray-400">
                                                <div class="flex flex-col items-center gap-2">
                                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                    </svg>
                                                    <span>No male students enrolled</span>
                                                </div>
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
                                        <tr class="hover:bg-pink-50/70 transition-colors duration-200 group">

                                            <td class="px-4 py-4 text-gray-500 w-10 font-medium">
                                                {{ $index + 1 }}
                                            </td>

                                            <td class="px-4 py-4">
                                                <div class="flex items-center gap-3">
                                                    <img
                                                        src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/photo-placeholder.png') }}"
                                                        class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-md group-hover:scale-105 transition-transform duration-200">

                                                    <div>
                                                        <p class="font-semibold text-gray-800 text-sm">
                                                            {{ $student->last_name }},
                                                            {{ $student->first_name }}
                                                            {{ $student->middle_name ? ' '.$student->middle_name[0].'.' : '' }}
                                                            {{ $student->suffix ? ' '.$student->suffix : '' }}
                                                        </p>
                                                        <p class="text-xs text-gray-400 font-mono tracking-wide">
                                                            {{ $student->school_id }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- ACTION DROPDOWN -->
                                            <td class="px-4 py-4 text-right">
                                                <div class="relative" x-data="{ open: false }">
                                                    <button 
                                                        @click="open = !open" 
                                                        @click.away="open = false"
                                                        class="inline-flex items-center gap-1 bg-slate-800 hover:bg-slate-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium shadow-md hover:shadow-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-1">
                                                        <span>Actions</span>
                                                        <svg class="w-3 h-3 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                        </svg>
                                                    </button>

                                                    <!-- Dropdown Menu -->
                                                    <div 
                                                        x-show="open" 
                                                        x-transition:enter="transition ease-out duration-200"
                                                        x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                        x-transition:leave="transition ease-in duration-150"
                                                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                                        x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                                                        class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden max-h-96 overflow-y-auto"
                                                        style="display: none;">
                                                        
                                                          <!-- SF Forms Group -->
                                                        <div class="bg-gray-50 px-3 py-2 text-xs font-bold text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                                            School Forms (SF1-SF10)
                                                        </div>
                                                        
                                                        <div class="grid grid-cols-1 gap-0.5 p-1">
                                                            <!-- SF1-SF5 
                                                           
                                                            <a href="{{ route('teacher.school-forms.sf2', $section->id) }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg transition-colors duration-150">
                                                                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold shrink-0">2</span>
                                                                <span class="truncate">SF2 - Daily Attendance</span>
                                                            </a> --> 

                                                            
                                                            <a href="{{ route('teacher.school-forms.sf3', $student->id) }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg transition-colors duration-150">
                                                                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold shrink-0">3</span>
                                                                <span class="truncate">SF3 - Books Issued/Returned</span>
                                                            </a>


                                                            <!-- <a href="{{ route('teacher.school-forms.sf4', $student->id) }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg transition-colors duration-150">
                                                                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold shrink-0">4</span>
                                                                <span class="truncate">SF4 - Monthly Attendance</span>
                                                            </a> 

                                                            
                                                            -- BOTH WORKING IN SIDEBAR AND IN FEMALE ACTION DROPDOWN --
                                                            <a href="{{ route('teacher.school-forms.sf5', $section->id) }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg transition-colors duration-150">
                                                                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold shrink-0">5</span>
                                                                <span class="truncate">SF5 - Report on Promotion/Learning Progress/Achievements</span>
                                                            </a> 
                                                            <a href="{{ route('teacher.school-forms.sf6', $student->id) }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg transition-colors duration-150">
                                                                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold shrink-0">6</span>
                                                                <span class="truncate">SF6 - Summarized Report</span>
                                                            </a>
                                                            <a href="{{ route('teacher.school-forms.sf7', $student->id) }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg transition-colors duration-150">
                                                                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold shrink-0">7</span>
                                                                <span class="truncate">SF7 - School Personnel</span>
                                                            </a> 
                                                            <a href="{{ route('teacher.school-forms.sf8', $student->id) }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg transition-colors duration-150">
                                                                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold shrink-0">8</span>
                                                                <span class="truncate">SF8 - Health/Nutrition</span>
                                                            </a> -->


                                                            <a href="{{ route('teacher.school-forms.sf9', $student->id) }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg transition-colors duration-150">
                                                                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold shrink-0">9</span>
                                                                <span class="truncate">SF9 - Progress Report Card</span>
                                                            </a>
                                                            <a href="{{ route('teacher.school-forms.sf10', $student->id) }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 rounded-lg transition-colors duration-150">
                                                                <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold shrink-0">10</span>
                                                                <span class="truncate">SF10 - Permanent Academic Record</span>
                                                            </a>
                                                        </div>
                                                        
                                                        <!-- Divider -->
                                                        <div class="border-t border-gray-100 my-1"></div>

                                                        <!-- Unenroll Action -->
                                                        <div class="p-1">
                                                            <form action="{{ route('teacher.students.unenroll', $student->id) }}" method="POST" onsubmit="return confirm('Unenroll {{ $student->first_name }} {{ $student->last_name }}? This action cannot be undone.')">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-150 text-left">
                                                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                                    </svg>
                                                                    <span>Unenroll Student</span>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-8 text-gray-400">
                                                <div class="flex flex-col items-center gap-2">
                                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                    </svg>
                                                    <span>No female students enrolled</span>
                                                </div>
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


<!-- ADDED MARCH  16, 2025 -- NOT IN USE -- START-->

 <!--Enhanced Quiz Modal -->
<div id="quizModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 transition-all duration-300">
    
    <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl transform scale-95 opacity-0 transition-all duration-300" id="quizModalContent">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    Record Quiz Score
                </h2>
                <button type="button" onclick="closeQuizModal()" class="text-white/80 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <form action="{{ route('teacher.quiz.store') }}" method="POST" class="p-6">
            @csrf
            <input type="hidden" name="section_id" value="{{ $section->id }}">

            <!-- Quiz Title -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Quiz Title</label>
                <input type="text" name="quiz_title" required 
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none transition-all"
                    placeholder="e.g., Midterm Exam, Chapter 3 Quiz">
            </div>

            <!-- Student Selection with Search -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Students <span class="text-xs font-normal text-gray-500">({{ count($students) }} enrolled)</span>
                </label>
                
                <!-- Search Filter -->
                <div class="relative mb-2">
                    <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" id="studentSearch" placeholder="Search students..." 
                        class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none"
                        onkeyup="filterStudents()">
                </div>

                <!-- Student List Container -->
                <div class="border border-gray-200 rounded-lg max-h-48 overflow-y-auto bg-gray-50" id="studentListContainer">
                    @forelse($students as $index => $student)
                        <div class="student-item flex items-center p-3 hover:bg-white border-b border-gray-100 last:border-b-0 cursor-pointer transition-colors"
                             onclick="selectStudent('{{ $student->id }}', '{{ $student->name }}', this)">
                            
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-purple-400 to-indigo-500 flex items-center justify-center text-white text-xs font-bold mr-3">
                                {{ strtoupper(substr($student->name, 0, 1)) }}
                            </div>
                            
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">{{ $student->name }}</p>
                                <p class="text-xs text-gray-500">ID: {{ $student->student_id ?? $student->id }}</p>
                            </div>
                            
                            <div class="check-indicator hidden">
                                <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-gray-500 text-sm">
                            No students enrolled in this section
                        </div>
                    @endforelse
                </div>
                
                <!-- Hidden Input for Selected Student -->
                <input type="hidden" name="student_id" id="selectedStudentId" required>
                <p id="selectedStudentDisplay" class="mt-2 text-sm text-purple-600 font-medium hidden">
                    Selected: <span></span>
                </p>
            </div>

            <!-- Score Inputs -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Score</label>
                    <input type="number" name="score" required min="0" 
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none text-center font-bold text-lg"
                        placeholder="0">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Total Score</label>
                    <input type="number" name="total_score" required min="1" 
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none text-center font-bold text-lg"
                        placeholder="100">
                </div>
            </div>

            <!-- Date -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Date</label>
                <input type="date" name="date" required 
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none"
                    value="{{ date('Y-m-d') }}">
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeQuizModal()"
                    class="px-5 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors">
                    Cancel
                </button>
                <button type="submit" id="saveBtn"
                    class="px-5 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-lg font-medium shadow-lg shadow-purple-500/30 transition-all transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                    Save Score
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openQuizModal() {
        const modal = document.getElementById('quizModal');
        const content = document.getElementById('quizModalContent');
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Trigger animation
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
        
        // Disable save button until student is selected
        document.getElementById('saveBtn').disabled = true;
    }

    function closeQuizModal() {
        const modal = document.getElementById('quizModal');
        const content = document.getElementById('quizModalContent');
        
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            resetForm();
        }, 300);
    }

    function selectStudent(id, name, element) {
        // Remove previous selection
        document.querySelectorAll('.student-item').forEach(item => {
            item.classList.remove('bg-purple-50', 'border-purple-200');
            item.querySelector('.check-indicator').classList.add('hidden');
        });
        
        // Add selection to clicked item
        element.classList.add('bg-purple-50', 'border-purple-200');
        element.querySelector('.check-indicator').classList.remove('hidden');
        
        // Update hidden input and display
        document.getElementById('selectedStudentId').value = id;
        const display = document.getElementById('selectedStudentDisplay');
        display.classList.remove('hidden');
        display.querySelector('span').textContent = name;
        
        // Enable save button
        document.getElementById('saveBtn').disabled = false;
    }

    function filterStudents() {
        const searchTerm = document.getElementById('studentSearch').value.toLowerCase();
        const items = document.querySelectorAll('.student-item');
        
        items.forEach(item => {
            const name = item.querySelector('p.text-sm').textContent.toLowerCase();
            const id = item.querySelector('p.text-xs').textContent.toLowerCase();
            
            if (name.includes(searchTerm) || id.includes(searchTerm)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function resetForm() {
        document.querySelector('form').reset();
        document.querySelectorAll('.student-item').forEach(item => {
            item.classList.remove('bg-purple-50', 'border-purple-200');
            item.querySelector('.check-indicator').classList.add('hidden');
        });
        document.getElementById('selectedStudentDisplay').classList.add('hidden');
        document.getElementById('saveBtn').disabled = true;
        document.getElementById('studentSearch').value = '';
        filterStudents(); // Reset filter
    }

    // Close modal on backdrop click
    document.getElementById('quizModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeQuizModal();
        }
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const studentId = document.getElementById('selectedStudentId').value;
        if (!studentId) {
            e.preventDefault();
            alert('Please select a student');
            return false;
        }
    });
</script>
<!-- END -->


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




</html>
