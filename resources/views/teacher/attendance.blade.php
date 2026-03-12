<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management | Tugawe Elementary School</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
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

    <!-- ================= MAIN CONTENT AREA ================= -->
    <main :class="sidebarOpen ? 'ml-72' : 'ml-20'" class="flex-1 transition-all duration-300">
        
        <!-- Top Header Bar -->
        <header class="bg-white border-b border-slate-200 sticky top-0 z-40 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('teacher.dashboard') }}" class="flex items-center gap-2 text-slate-500 hover:text-indigo-600 transition">
                        <i class="fas fa-arrow-left"></i>
                        <span class="text-sm font-medium"></span>
                    </a>
                    <div class="h-6 w-px bg-slate-300"></div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Daily Attendance Record</h1>
                        <p class="text-sm text-slate-500">School Form 2 (SF2) - DepEd Official Form</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-4">
                    <!-- School Year Badge -->
                    <div class="hidden md:flex items-center gap-2 bg-indigo-50 border border-indigo-200 rounded-lg px-3 py-1.5">
                        <i class="fas fa-calendar-alt text-indigo-600"></i>
                        <div>
                            <p class="text-[10px] text-indigo-600 font-semibold uppercase">Active School Year</p>
                            <p class="text-sm font-bold text-indigo-900">{{ $activeSchoolYear->name ?? '2024-2025' }}</p>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <button onclick="openModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition shadow-sm flex items-center gap-2">
                        <i class="fas fa-edit"></i>
                        <span class="hidden sm:inline">Record Attendance</span>
                    </button>
                    
                    <a href="{{ route('teacher.export', [$section->id, 'month'=>$month, 'year'=>$year]) }}" 
                       class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-medium transition shadow-sm flex items-center gap-2">
                        <i class="fas fa-file-pdf"></i>
                        <span class="hidden sm:inline">Export PDF</span>
                    </a>
                </div>
            </div>
        </header>

        <div class="p-6 space-y-6">
            
            <!-- Class Information Card -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-slate-50 to-white border-b border-slate-200 px-6 py-4">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-700">
                                <i class="fas fa-chalkboard-teacher text-2xl"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-slate-900">{{ $section->year_level ?? 'Grade 1' }} - {{ $section->name ?? 'Mabait' }}</h2>
                                <p class="text-sm text-slate-500">Class Adviser: <span class="font-semibold text-slate-700">{{ $section->adviser?->name ?? $fullName }}</span></p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-6 text-sm">
                            <div class="text-center">
                                <p class="text-slate-500 text-xs uppercase tracking-wider">Male</p>
                                <p class="font-bold text-blue-600 text-lg">{{ $students->where('sex', 'Male')->count() }}</p>
                            </div>
                            <div class="w-px h-8 bg-slate-200"></div>
                            <div class="text-center">
                                <p class="text-slate-500 text-xs uppercase tracking-wider">Female</p>
                                <p class="font-bold text-pink-600 text-lg">{{ $students->where('sex', 'Female')->count() }}</p>
                            </div>
                            <div class="w-px h-8 bg-slate-200"></div>
                            <div class="text-center">
                                <p class="text-slate-500 text-xs uppercase tracking-wider">Total</p>
                                <p class="font-bold text-slate-900 text-lg">{{ $students->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Month Navigation & Controls -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <form method="GET" class="flex items-center">
                            <div class="relative">
                                <input type="month" name="month" value="{{ sprintf('%04d-%02d', $year, $month) }}"
                                       onchange="this.form.submit()"
                                       class="pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                                <i class="fas fa-calendar absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            </div>
                        </form>
                        
                        <div class="flex items-center bg-slate-100 rounded-lg p-1">
                            <form method="GET" class="flex">
                                <input type="hidden" name="month" value="{{ $month > 1 ? $month - 1 : 12 }}">
                                <input type="hidden" name="year" value="{{ $month > 1 ? $year : $year - 1 }}">
                                <button class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-white rounded-md transition">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                            </form>
                            
                            <span class="px-4 py-1 font-semibold text-slate-700 min-w-[140px] text-center">
                                {{ \Carbon\Carbon::create($year, $month)->format('F Y') }}
                            </span>
                            
                            <form method="GET" class="flex">
                                <input type="hidden" name="month" value="{{ $month < 12 ? $month + 1 : 1 }}">
                                <input type="hidden" name="year" value="{{ $month < 12 ? $year : $year + 1 }}">
                                <button class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-white rounded-md transition">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Legend -->
                    <div class="flex items-center gap-4 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                            <span class="text-slate-600">Present</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                            <span class="text-slate-600">Late</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                            <span class="text-slate-600">Absent</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                            <span class="text-slate-600">Excused</span>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-center gap-3 shadow-sm animate-fade-in">
                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                    <i class="fas fa-check text-lg"></i>
                </div>
                <div>
                    <p class="font-semibold text-emerald-900">Success!</p>
                    <p class="text-sm text-emerald-700">{{ session('success') }}</p>
                </div>
                <button onclick="this.closest('.bg-emerald-50').remove()" class="ml-auto text-emerald-400 hover:text-emerald-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Students</p>
                            <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ $students->count() }}</h3>
                            <p class="text-xs text-slate-500 mt-1">Enrolled this school year</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">School Days</p>
                            <h3 class="text-2xl font-bold text-slate-900 mt-1">
                                @php
                                    $startOfMonth = \Carbon\Carbon::create($year, $month)->startOfMonth();
                                    $endOfMonth = \Carbon\Carbon::create($year, $month)->endOfMonth();
                                    $schoolDays = 0;
                                    for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
                                        if (!$date->isWeekend()) $schoolDays++;
                                    }
                                    echo $schoolDays;
                                @endphp
                            </h3>
                            <p class="text-xs text-slate-500 mt-1">This month</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                            <i class="fas fa-calendar-day text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Avg. Attendance</p>
                            <h3 class="text-2xl font-bold text-emerald-600 mt-1">94.2%</h3>
                            <p class="text-xs text-emerald-600 mt-1 flex items-center gap-1">
                                <i class="fas fa-arrow-up text-[10px]"></i>
                                <span>+2.1% from last month</span>
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                            <i class="fas fa-chart-pie text-xl"></i>
                        </div>
                    </div>
                </div>

               
            </div>

            <!-- Attendance Table -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/50 flex items-center justify-between">
                    <h3 class="font-bold text-slate-900 flex items-center gap-2">
                        <i class="fas fa-list text-slate-400"></i>
                        Daily Attendance Summary
                    </h3>
                    <div class="flex items-center gap-2 text-sm text-slate-500">
                        <i class="fas fa-info-circle"></i>
                        <span>Showing first 10 school days</span>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-3 text-left font-semibold text-slate-700 w-64">Student Name</th>
                                @php
                                    $displayDays = [];
                                    $count = 0;
                                    for($d = 1; $d <= $daysInMonth && $count < 10; $d++) {
                                        $dateObj = \Carbon\Carbon::create($year, $month, $d);
                                        if(!$dateObj->isWeekend()) {
                                            $displayDays[] = $d;
                                            $count++;
                                        }
                                    }
                                @endphp
                                @foreach($displayDays as $d)
                                    <th class="px-2 py-3 text-center font-semibold text-slate-700 w-12">
                                        <div class="flex flex-col items-center">
                                            <span class="text-xs text-slate-400">{{ \Carbon\Carbon::create($year, $month, $d)->format('D') }}</span>
                                            <span class="text-sm">{{ $d }}</span>
                                        </div>
                                    </th>
                                @endforeach
                                <th class="px-4 py-3 text-center font-semibold text-slate-700">Rate</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($students->take(8) as $student)
                            <tr class="hover:bg-slate-50/80 transition group">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/photo-placeholder.png') }}" 
                                             class="w-9 h-9 rounded-full object-cover ring-2 ring-white shadow-sm" alt="">
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $student->last_name }}, {{ $student->first_name }}</p>
                                            <p class="text-xs text-slate-500">ID: {{ $student->school_id }}</p>
                                        </div>
                                    </div>
                                </td>
                                @foreach($displayDays as $d)
                                    @php
                                        $dateObj = \Carbon\Carbon::create($year, $month, $d);
                                        $att = $student->attendances->firstWhere('date', $dateObj->format('Y-m-d'));
                                    @endphp
                                    <td class="px-2 py-3 text-center">
                                        @if($att)
                                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full text-xs font-bold shadow-sm
                                                {{ $att->status === 'present' ? 'bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200' : 
                                                   ($att->status === 'late' ? 'bg-amber-100 text-amber-700 ring-1 ring-amber-200' : 
                                                   ($att->status === 'absent' ? 'bg-rose-100 text-rose-700 ring-1 ring-rose-200' : 
                                                   'bg-blue-100 text-blue-700 ring-1 ring-blue-200')) }}">
                                                {{ $att->status === 'present' ? 'P' : ($att->status === 'late' ? 'L' : ($att->status === 'absent' ? 'A' : 'E')) }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-100 text-slate-400 text-xs">—</span>
                                        @endif
                                    </td>
                                @endforeach
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                        95%
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($students->count() > 8)
                <div class="px-6 py-3 border-t border-slate-200 bg-slate-50/50 text-center">
                    <button onclick="openModal()" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 transition flex items-center justify-center gap-2 mx-auto">
                        <span>View all {{ $students->count() }} students</span>
                        <i class="fas fa-arrow-right text-xs"></i>
                    </button>
                </div>
                @endif
            </div>

            <!-- Footer Info -->
            <div class="flex items-center justify-between text-xs text-slate-500 pt-4 border-t border-slate-200">
                <div class="flex items-center gap-4">
                    <span>DepEd Form 2 (SF2)</span>
                    <span>•</span>
                    <span>Republic of the Philippines</span>
                    <span>•</span>
                    <span>Department of Education</span>
                </div>
                <div>
                    <span>System Version 2.0</span>
                    <span class="mx-2">•</span>
                    <span>Last updated: {{ now()->format('M d, Y h:i A') }}</span>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- ================= ATTENDANCE MODAL - FULL SCREEN ================= -->
<div id="attendanceModal" class="fixed inset-0 bg-slate-900/50 hidden items-center justify-center z-50 backdrop-blur-sm">
    <div class="bg-white w-full max-w-[95vw] h-[90vh] rounded-2xl shadow-2xl flex flex-col overflow-hidden">
        
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-700">
                    <i class="fas fa-clipboard-list text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900">School Form 2 - Daily Attendance</h2>
                    <p class="text-sm text-slate-500">
                        {{ $section->year_level ?? 'Grade 1' }} - {{ $section->name ?? 'Section A' }} | 
                        <span class="font-semibold text-indigo-600">{{ \Carbon\Carbon::create($year, $month)->format('F Y') }}</span> |
                        School Year: <span class="font-semibold">{{ $activeSchoolYear->name ?? '2024-2025' }}</span>
                    </p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <button onclick="printAttendance()" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-full transition" title="Print">
                    <i class="fas fa-print text-lg"></i>
                </button>
                <button onclick="closeModal()" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-full transition" title="Close">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Modal Body -->
        <div class="flex-1 overflow-auto p-6 bg-slate-50">
            <form method="POST" action="{{ route('teacher.attendance.store', $section->id) }}">
                @csrf

                @php
                    $schoolDays = [];
                    for($d = 1; $d <= $daysInMonth; $d++) {
                        $dateObj = \Carbon\Carbon::create($year, $month, $d);
                        if(!$dateObj->isWeekend()) {
                            $schoolDays[] = $dateObj->format('Y-m-d');
                        }
                    }
                    $grouped = $students->sortBy('last_name')->groupBy('gender');
                @endphp

                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-100 sticky top-0 z-10">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-slate-700 border-b border-slate-200 w-72">Student Information</th>
                                @foreach($schoolDays as $date)
                                    <th class="px-2 py-3 text-center font-semibold text-slate-700 border-b border-slate-200 text-xs w-14">
                                        <div class="flex flex-col">
                                            <span class="text-slate-400 text-[10px]">{{ \Carbon\Carbon::parse($date)->format('D') }}</span>
                                            <span>{{ \Carbon\Carbon::parse($date)->format('d') }}</span>
                                        </div>
                                    </th>
                                @endforeach
                                <th class="px-4 py-3 text-center font-semibold text-slate-700 border-b border-slate-200 w-20">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($grouped as $gender => $genderStudents)
                                <tr class="bg-slate-50/80">
                                    <td colspan="{{ count($schoolDays) + 2 }}" class="px-4 py-2 text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center gap-2">
                                        <i class="fas fa-{{ $gender === 'Male' ? 'male text-blue-500' : 'female text-pink-500' }}"></i>
                                        {{ $gender }} Students ({{ $genderStudents->count() }})
                                    </td>
                                </tr>

                                @foreach($genderStudents as $student)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-4 py-3 border-r border-slate-100">
                                            <div class="flex items-center gap-3">
                                                <img src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/photo-placeholder.png') }}"
                                                     class="w-10 h-10 rounded-full object-cover ring-2 ring-white shadow-sm" alt="">
                                                <div>
                                                    <p class="font-semibold text-slate-900">{{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name ? substr($student->middle_name, 0, 1).'.' : '' }}</p>
                                                    <p class="text-xs text-slate-500">LRN: {{ $student->lrn ?? $student->school_id }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        @php $presentCount = 0; @endphp
                                        @foreach($schoolDays as $date)
                                            @php
                                                $att = $student->attendances->firstWhere('date', $date);
                                                $status = $att?->status ?? 'none';
                                                if($status === 'present' || $status === 'late') $presentCount++;
                                            @endphp
                                            <td class="px-1 py-2 text-center border-r border-slate-50">
                                                <select name="attendance[{{ $student->id }}][{{ $date }}]"
                                                        class="w-full px-1 py-1.5 text-xs font-bold rounded-lg border-0 cursor-pointer focus:ring-2 focus:ring-indigo-500 transition text-center appearance-none
                                                        {{ $status === 'present' ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' : 
                                                           ($status === 'late' ? 'bg-amber-100 text-amber-700 hover:bg-amber-200' : 
                                                           ($status === 'absent' ? 'bg-rose-100 text-rose-700 hover:bg-rose-200' : 
                                                           ($status === 'excused' ? 'bg-blue-100 text-blue-700 hover:bg-blue-200' :
                                                           'bg-slate-100 text-slate-500 hover:bg-slate-200'))) }}">
                                                    <option value="none" {{ $status === 'none' ? 'selected' : '' }}>—</option>
                                                    <option value="present" {{ $status === 'present' ? 'selected' : '' }}>P</option>
                                                    <option value="late" {{ $status === 'late' ? 'selected' : '' }}>L</option>
                                                    <option value="absent" {{ $status === 'absent' ? 'selected' : '' }}>A</option>
                                                    <option value="excused" {{ $status === 'excused' ? 'selected' : '' }}>E</option>
                                                </select>
                                            </td>
                                        @endforeach
                                        
                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold {{ $presentCount === count($schoolDays) ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                                {{ $presentCount }}/{{ count($schoolDays) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-between mt-6 pt-4 border-t border-slate-200">
                    <div class="flex items-center gap-4 text-sm text-slate-500">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded bg-emerald-100 border border-emerald-200"></span>
                            <span>Present</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded bg-amber-100 border border-amber-200"></span>
                            <span>Late</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded bg-rose-100 border border-rose-200"></span>
                            <span>Absent</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded bg-blue-100 border border-blue-200"></span>
                            <span>Excused</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="closeModal()" class="px-5 py-2.5 text-slate-700 font-medium rounded-xl hover:bg-slate-200 transition">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            Save Attendance Record
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openModal(){ 
    document.getElementById('attendanceModal').classList.remove('hidden'); 
    document.getElementById('attendanceModal').classList.add('flex'); 
    document.body.style.overflow = 'hidden';
}
function closeModal(){ 
    document.getElementById('attendanceModal').classList.remove('flex'); 
    document.getElementById('attendanceModal').classList.add('hidden'); 
    document.body.style.overflow = 'auto';
}
function printAttendance() {
    window.print();
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});

// Close on backdrop click
document.getElementById('attendanceModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>

<style>
@media print {
    body * { visibility: hidden; }
    #attendanceModal, #attendanceModal * { visibility: visible; }
    #attendanceModal { position: absolute; left: 0; top: 0; width: 100%; height: 100%; }
    .no-print { display: none !important; }
}
.animate-fade-in {
    animation: fadeIn 0.3s ease-out;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<!-- [Previous modals remain with similar styling improvements] -->

<!-- ENROLL STUDENT MODAL -->
<div id="enrollStudentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 relative mx-auto my-auto">
        <h2 class="text-xl font-bold mb-4">Enroll Student</h2>

        <form method="POST" action="{{ route('teacher.students.enroll') }}">
            @csrf
<label class="block text-gray-700 font-medium mb-2">Select Student</label>
<select name="student_id" required class="w-full px-4 py-2 border rounded-lg mb-4">
    <option value="">-- Choose Student --</option>
  @foreach($section->students as $student)
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


</body>
</html>