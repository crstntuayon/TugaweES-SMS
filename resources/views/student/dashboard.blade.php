<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard | Tugawe Elementary School</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0d9488">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-teal-50 font-['Inter'] antialiased">

<!-- =================== NOTIFICATION TOAST =================== -->
@if(session('success'))
<div x-data="{ show: true }" 
     x-show="show"
     x-init="setTimeout(() => show = false, 5000)"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-4"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 translate-y-4"
     class="fixed top-6 right-6 z-50 bg-white border-l-4 border-green-500 shadow-xl rounded-lg p-4 flex items-center gap-3">
    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
    </div>
    <div>
        <p class="font-semibold text-gray-900">Success</p>
        <p class="text-sm text-gray-600">{{ session('success') }}</p>
    </div>
    <button @click="show = false" class="ml-4 text-gray-400 hover:text-gray-600">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
@endif

<!-- =================== HEADER =================== -->
<header class="sticky top-0 z-40 bg-white/80 backdrop-blur-xl border-b border-gray-200/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo & Brand -->
            <div class="flex items-center gap-4">
                <div class="relative">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-500 to-teal-600 flex items-center justify-center shadow-lg shadow-teal-500/30">
                        <img src="{{ asset('images/logo.png') }}" class="w-8 h-8 object-contain" alt="School Logo">
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></div>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-900 tracking-tight">Student Portal</h1>
                    <p class="text-xs text-gray-500">Tugawe Elementary School</p>
                </div>
            </div>

            <!-- Navigation -->
            <div class="flex items-center gap-4">
                <!-- Quick Actions -->
                <div class="hidden md:flex items-center gap-2">
                    <button onclick="openProfileModal()" class="p-2 rounded-lg hover:bg-gray-100 text-gray-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </button>
                </div>

                <!-- User Menu -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-3 p-2 rounded-xl hover:bg-gray-100 transition">
                        <img src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/photo-placeholder.png') }}" 
                             class="w-8 h-8 rounded-full object-cover border-2 border-gray-200" alt="Profile">
                        <div class="hidden md:block text-left">
                            <p class="text-sm font-semibold text-gray-900">{{ $student->first_name }}</p>
                            <p class="text-xs text-gray-500">Grade {{ str_replace('grade', '', $section->year_level) ?? 'N/A' }}</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Dropdown -->
                    <div x-show="open" 
                         x-cloak
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                         class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50">
                        
                        <div class="p-4 bg-gradient-to-br from-teal-50 to-white border-b border-gray-100">
                            <p class="font-bold text-gray-900">{{ $student->last_name }}, {{ $student->first_name }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user()->email ?? 'student@tugawe.edu.ph' }}</p>
                        </div>
                        
                        <div class="py-1">
                            <a href="#" onclick="openProfileModal(); open = false;" 
                               class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                My Profile
                            </a>
                            
                            <div class="border-t border-gray-100"></div>
                            
                            <a href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                               class="flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
                                </svg>
                                Sign Out
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
</header>

<!-- =================== MAIN CONTENT =================== -->
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

@if(!$section)
    <!-- Empty State -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 text-center">
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
        </div>
        <h2 class="text-xl font-bold text-gray-900 mb-2">Not Enrolled</h2>
        <p class="text-gray-500">You are not assigned to any section yet. Please contact your school administrator.</p>
    </div>
@else

    <!-- =================== HERO SECTION =================== -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-teal-600 via-teal-700 to-teal-800 shadow-2xl">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%23ffffff%22%20fill-opacity%3D%220.05%22%3E%3Cpath%20d%3D%22M36%2034v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6%2034v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6%204V0H4v4H0v2h4v4h2V6h4V4H6z%22%2F%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E')] opacity-20"></div>
        
        <div class="relative px-6 py-8 md:px-10 md:py-10">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <!-- Student Photo -->
                <div class="relative">
                    <div class="w-24 h-24 md:w-32 md:h-32 rounded-2xl bg-white p-2 shadow-xl rotate-3 hover:rotate-0 transition-transform duration-500">
                        <img src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/photo-placeholder.png') }}" 
                             class="w-full h-full rounded-xl object-cover" alt="Profile">
                    </div>
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 rounded-full border-4 border-teal-700 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Student Info -->
                <div class="text-center md:text-left flex-1 text-white">
                    <p class="text-teal-200 text-sm font-medium uppercase tracking-wider mb-1">Welcome back,</p>
                    <h2 class="text-2xl md:text-4xl font-bold mb-2">{{ $student->first_name }} {{ $student->last_name }}</h2>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 text-sm">
                        <span class="px-3 py-1 bg-white/20 backdrop-blur rounded-full">{{ $section->year_level }} - {{ $section->name }}</span>
                        <span class="px-3 py-1 bg-white/20 backdrop-blur rounded-full">LRN: {{ $student->lrn ?? $student->school_id ?? 'N/A' }}</span>
                        <span class="px-3 py-1 bg-green-500/80 rounded-full text-xs font-semibold">Active</span>
                    </div>
                </div>
                
                <!-- Quick Stats -->
                <div class="hidden lg:grid grid-cols-2 gap-3 text-white">
                    <div class="bg-white/10 backdrop-blur rounded-xl p-3 text-center">
                        <p class="text-2xl font-bold">{{ $student->grades->count() ?? 0 }}</p>
                        <p class="text-xs text-teal-200">Subjects</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur rounded-xl p-3 text-center">
                        <p class="text-2xl font-bold">{{ $student->attendances->count() ?? 0 }}</p>
                        <p class="text-xs text-teal-200">Attendance</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- =================== TEACHER INFO CARD =================== -->
    @if($section && $section->teacher)
    <div x-data="{ openTeacher: false }" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Class Adviser</p>
                    <h3 class="text-lg font-bold text-gray-900">{{ $section->teacher->name ?? 'Not Assigned' }}</h3>
                    <p class="text-sm text-gray-500">{{ $section->teacher->email ?? '' }}</p>
                </div>
            </div>
            <button @click="openTeacher = true" class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-medium hover:bg-indigo-100 transition">
                View Details
            </button>
        </div>

        <!-- Teacher Modal -->
        <div x-show="openTeacher" x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
            
            <div @click.away="openTeacher = false"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                
                <!-- Modal Header -->
                <div class="relative bg-gradient-to-br from-indigo-600 to-purple-700 p-8 text-white">
                    <button @click="openTeacher = false" class="absolute top-4 right-4 w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    
                    <div class="flex items-center gap-6">
                        <div class="w-24 h-24 rounded-2xl bg-white p-2 shadow-xl">
                            <img src="{{ $section->teacher->photo ? asset('storage/'.$section->teacher->photo) : asset('images/photo-placeholder.png') }}" 
                                 class="w-full h-full rounded-xl object-cover" alt="Teacher">
                        </div>
                        <div>
                            <p class="text-indigo-200 text-sm font-medium uppercase tracking-wider">Class Adviser</p>
                            <h2 class="text-2xl font-bold">{{ $section->teacher->name }}</h2>
                            <p class="text-indigo-200">{{ $section->year_level }} - {{ $section->name }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Modal Body -->
                <div class="p-8 space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Full Name</p>
                                <p class="font-semibold text-gray-900">{{ $section->teacher->first_name }} {{ $section->teacher->middle_name ?? '' }} {{ $section->teacher->last_name }} {{ $section->teacher->suffix ?? '' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-semibold text-gray-900">{{ $section->teacher->email ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Contact</p>
                                <p class="font-semibold text-gray-900">{{ $section->teacher->contact_number ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Position</p>
                                <p class="font-semibold text-gray-900">{{ $section->teacher->position ?? 'Teacher I' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">School Year</p>
                                <p class="font-semibold text-gray-900">{{ $section->schoolYear->name ?? '2024-2025' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Section</p>
                                <p class="font-semibold text-gray-900">{{ $section->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- =================== ACTION CARDS =================== -->
    <div class="grid md:grid-cols-2 gap-6">
        
       <!-- Report Card Button -->
<div x-data="{ openGrades: false }">
    <button @click="openGrades = true" 
            class="group w-full bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 text-left">
        <div class="flex items-start justify-between">
            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-100 to-teal-100 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <span class="px-3 py-1 bg-teal-50 text-teal-700 text-xs font-bold rounded-full">SF9</span>
        </div>
        <h3 class="mt-4 text-lg font-bold text-gray-900 group-hover:text-teal-600 transition-colors">View Report Card</h3>
        <p class="mt-1 text-sm text-gray-500">Check your academic performance and grades</p>
    </button>

    <!-- =================== GRADES MODAL - PRINTABLE =================== -->
    <div x-show="openGrades" x-cloak 
         class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 overflow-auto print-modal-container"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <!-- Print Container - Optimized for all paper sizes -->
        <div class="min-h-screen p-4 md:p-8 print:p-0 flex items-start justify-center">
            <div class="bg-white w-full max-w-[210mm] shadow-2xl print:shadow-none print:max-w-none print:w-full relative" id="gradesPrintArea">
                
                <!-- Screen-only controls - Colored Icons, No Backgrounds -->
                <div class="print:hidden sticky top-4 z-50 flex justify-end gap-3 mb-4">
                    <button onclick="printGrades()" 
                            class="p-2.5 text-blue-500 hover:text-blue-700 hover:bg-blue-50 rounded-full transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-200"
                            aria-label="Print Report Card">
                        <span class="sr-only">Print Report Card</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                    </button>
                    <button @click="openGrades = false" 
                            class="p-2.5 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-full transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-200"
                            aria-label="Close Report Card">
                        <span class="sr-only">Close Report Card</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Report Card Content -->
                <div class="p-6 md:p-10 print:p-4 border-4 border-double border-slate-900 m-2 print:m-0">
                    
                  <!-- Report Card Header - Centered Large Logos -->
<div class="text-center border-b-2 border-slate-900 pb-4 mb-4">
    <!-- Top Form Identifier -->
    <div class="flex items-center justify-between text-[10px] mb-3">
        <span class="font-semibold tracking-wider">SF9 - REPORT CARD</span>
        <span class="font-bold uppercase tracking-widest text-slate-800">Republic of the Philippines</span>
        <span class="font-semibold tracking-wider">DepEd Form 138</span>
    </div>
    
    <!-- Main Header - Centered Large Logos with Text Between -->
    <div class="flex items-center justify-center">
        <!-- Left Logo - DepEd (Larger) -->
        <div class="flex-shrink-0">
            <img src="{{ asset('images/logo1.png') }}" class="h-20 md:h-24 w-auto print:h-20" alt="DepEd Logo">
        </div>
        
        <!-- Center Text Block - Tighter spacing -->
        <div class="px-4 md:px-6">
            <p class="text-sm md:text-base font-black uppercase tracking-wider text-slate-900">Department of Education</p>
            <p class="text-xs md:text-sm text-slate-600 font-semibold">Division of Negros Oriental</p>
            <h1 class="text-lg md:text-xl font-black uppercase mt-1 text-slate-900 tracking-wide">Tugawe Elementary School</h1>
        </div>
        
        <!-- Right Logo - School (Larger) -->
        <div class="flex-shrink-0">
            <img src="{{ asset('images/logo.png') }}" class="h-20 md:h-24 w-auto print:h-20" alt="School Logo">
        </div>
    </div>
    
    <!-- Report Card Title -->
    <div class="mt-4">
        <h2 class="inline-block px-6 py-1.5 border-2 border-slate-900 text-sm md:text-base font-bold uppercase tracking-widest bg-slate-50">Report Card</h2>
        <p class="text-xs mt-2 text-slate-600">School Year: <span class="font-bold text-slate-900">{{ $activeSchoolYear->name ?? '2024-2025' }}</span></p>
    </div>
</div>

                    @php
                        $quarters = [1, 2, 3, 4];
                        $currentYear = $section->year_level;
                        $subjects = \App\Models\Subject::where('grade_level', $currentYear)->get();
                    @endphp

                    <!-- Student Info -->
                    <div class="border border-slate-900 p-3 mb-4 bg-slate-50">
                        <table class="w-full text-xs md:text-sm">
                            <tr>
                                <td class="py-1"><span class="font-semibold">Name:</span> <span class="uppercase font-bold">{{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name ?? '' }}</span></td>
                                <td class="py-1"><span class="font-semibold">LRN:</span> {{ $student->lrn ?? $student->school_id ?? 'N/A' }}</td>
                                <td class="py-1"><span class="font-semibold">Grade:</span> {{ $section->year_level }}</td>
                            </tr>
                            <tr>
                                <td class="py-1"><span class="font-semibold">Section:</span> {{ $section->name }}</td>
                                <td class="py-1" colspan="2"><span class="font-semibold">Adviser:</span> {{ $section->adviser?->name ?? 'TBA' }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Grades Table -->
                    <table class="w-full text-xs border-collapse border-2 border-slate-900 mb-4">
                        <thead>
                            <tr class="bg-slate-800 text-white">
                                <th class="border border-slate-600 px-2 py-2 text-left w-2/5">Learning Areas</th>
                                @foreach($quarters as $q)
                                    <th class="border border-slate-600 px-2 py-2 text-center w-[10%]">Q{{ $q }}</th>
                                @endforeach
                                <th class="border border-slate-600 px-2 py-2 text-center w-[12%] bg-indigo-700">Final</th>
                                <th class="border border-slate-600 px-2 py-2 text-center w-[12%]">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $quarterTotals = [1 => 0, 2 => 0, 3 => 0, 4 => 0];
                                $quarterCounts = [1 => 0, 2 => 0, 3 => 0, 4 => 0];
                                $finalGrades = [];
                            @endphp

                            @foreach($subjects as $subject)
                                @php
                                    $grades = $student->grades->where('subject_id', $subject->id)->keyBy('quarter');
                                    $qValues = [];
                                    $subjectSum = 0;
                                    $subjectCount = 0;

                                    foreach($quarters as $q){
                                        $grade = $grades[$q]->final_grade ?? $grades[$q]->grade ?? null;
                                        $qValues[$q] = $grade;
                                        if($grade !== null){
                                            $quarterTotals[$q] += $grade;
                                            $quarterCounts[$q]++;
                                            $subjectSum += $grade;
                                            $subjectCount++;
                                        }
                                    }

                                    $average = $subjectCount > 0 ? round($subjectSum / $subjectCount, 2) : null;
                                    $remarks = $average !== null ? ($average >= 75 ? 'Passed' : 'Failed') : '-';
                                    if($average !== null) $finalGrades[] = $average;
                                @endphp
                                <tr class="{{ $loop->even ? 'bg-slate-50' : 'bg-white' }}">
                                    <td class="border border-slate-400 px-2 py-1.5 font-medium">{{ $subject->name }}</td>
                                    @foreach($quarters as $q)
                                        <td class="border border-slate-400 px-2 py-1.5 text-center font-mono">
                                            {{ $qValues[$q] !== null ? number_format($qValues[$q], 0) : '—' }}
                                        </td>
                                    @endforeach
                                    <td class="border border-slate-400 px-2 py-1.5 text-center font-bold font-mono bg-indigo-50 {{ $average !== null ? ($average >= 75 ? 'text-green-700' : 'text-red-700') : '' }}">
                                        {{ $average !== null ? number_format($average, 2) : '—' }}
                                    </td>
                                    <td class="border border-slate-400 px-2 py-1.5 text-center text-[10px] uppercase font-semibold {{ $remarks === 'Passed' ? 'text-green-700 bg-green-50' : ($remarks === 'Failed' ? 'text-red-700 bg-red-50' : '') }}">
                                        {{ $remarks }}
                                    </td>
                                </tr>
                            @endforeach

                            @php
                                $generalAverages = [];
                                foreach($quarters as $q) {
                                    $generalAverages[$q] = $quarterCounts[$q] > 0 ? round($quarterTotals[$q] / $quarterCounts[$q], 2) : null;
                                }
                                $finalGeneralAverage = count($finalGrades) > 0 ? round(array_sum($finalGrades) / count($finalGrades), 2) : null;
                            @endphp

                            <tr class="bg-slate-200 font-bold">
                                <td class="border border-slate-600 px-2 py-2 uppercase">General Average</td>
                                @foreach($quarters as $q)
                                    <td class="border border-slate-600 px-2 py-2 text-center font-mono">
                                        {{ $generalAverages[$q] !== null ? number_format($generalAverages[$q], 2) : '—' }}
                                    </td>
                                @endforeach
                                <td class="border border-slate-600 px-2 py-2 text-center font-mono text-lg bg-indigo-100 {{ $finalGeneralAverage !== null ? ($finalGeneralAverage >= 75 ? 'text-green-800' : 'text-red-800') : '' }}">
                                    {{ $finalGeneralAverage !== null ? number_format($finalGeneralAverage, 2) : '—' }}
                                </td>
                                <td class="border border-slate-600 px-2 py-2 text-center text-[10px] uppercase {{ $finalGeneralAverage !== null ? ($finalGeneralAverage >= 75 ? 'text-green-800 bg-green-100' : 'text-red-800 bg-red-100') : '' }}">
                                    {{ $finalGeneralAverage !== null ? ($finalGeneralAverage >= 75 ? 'Promoted' : 'Retained') : '—' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Grading Scale -->
                    <div class="grid grid-cols-2 gap-4 mb-4 text-[10px]">
                        <div class="border border-slate-800 p-2">
                            <p class="font-bold uppercase mb-1 border-b border-slate-300 pb-1">Grading Scale</p>
                            <div class="grid grid-cols-2 gap-x-2 gap-y-0.5">
                                <span>90-100: <span class="font-semibold">Outstanding</span></span>
                                <span>85-89: <span class="font-semibold">Very Satisfactory</span></span>
                                <span>80-84: <span class="font-semibold">Satisfactory</span></span>
                                <span>75-79: <span class="font-semibold">Fairly Satisfactory</span></span>
                                <span class="col-span-2 text-red-600">Below 75: <span class="font-semibold">Did Not Meet</span></span>
                            </div>
                        </div>
                        <div class="border border-slate-800 p-2">
                            <p class="font-bold uppercase mb-1 border-b border-slate-300 pb-1">Attendance</p>
                            <div class="grid grid-cols-2 gap-2 text-center">
                                <div><span class="text-[9px] text-slate-500">Present</span><p class="font-bold">—</p></div>
                                <div><span class="text-[9px] text-slate-500">Absent</span><p class="font-bold">—</p></div>
                            </div>
                        </div>
                    </div>

                    <!-- Signatures -->
                    <div class="mt-6 pt-4 border-t-2 border-slate-800">
                        <p class="text-[10px] text-justify italic mb-4 text-slate-600">
                            I certify that this is a true record of <span class="font-bold not-italic">{{ $student->name }}</span> with LRN <span class="font-bold not-italic">{{ $student->lrn ?? 'N/A' }}</span>.
                        </p>
                        <div class="grid grid-cols-3 gap-4 text-center text-xs">
                            <div>
                                <div class="border-t border-slate-800 pt-1 mt-8"></div>
                                <p class="font-bold uppercase">{{ $section->adviser?->name ?? '_________________' }}</p>
                                <p class="text-slate-500">Class Adviser</p>
                            </div>
                            <div>
                                <div class="border-t border-slate-800 pt-1 mt-8"></div>
                                <p class="font-bold uppercase">School Principal</p>
                                <p class="text-slate-500">School Head</p>
                            </div>
                            <div>
                                <div class="border-t border-slate-800 pt-1 mt-8"></div>
                                <p class="font-bold uppercase">{{ $student->guardian?->name ?? '_________________' }}</p>
                                <p class="text-slate-500">Parent/Guardian</p>
                            </div>
                        </div>
                        <p class="text-[9px] text-right mt-4 text-slate-500">Date: {{ now()->format('F d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Attendance Button -->
<div x-data="{ openAttendance: false, selectedMonth: '{{ $student->attendances->first() ? \Carbon\Carbon::parse($student->attendances->first()->date)->format('F Y') : now()->format('F Y') }}' }">
    <button @click="openAttendance = true" 
            class="group w-full bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 text-left">
        <div class="flex items-start justify-between">
            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-amber-100 to-yellow-100 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
            <span class="px-3 py-1 bg-amber-50 text-amber-700 text-xs font-bold rounded-full">SF2</span>
        </div>
        <h3 class="mt-4 text-lg font-bold text-gray-900 group-hover:text-amber-600 transition-colors">View Attendance</h3>
        <p class="mt-1 text-sm text-gray-500">Track your daily attendance records</p>
    </button>

    @php
        $months = $student->attendances->groupBy(function ($a) {
            return \Carbon\Carbon::parse($a->date)->format('F Y');
        });
    @endphp

    <!-- =================== ATTENDANCE MODAL - PRINTABLE =================== -->
    <div x-show="openAttendance" x-cloak
         class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 overflow-auto print-modal-container"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="min-h-screen p-4 md:p-8 print:p-0 flex items-start justify-center">
            <div class="bg-white w-full max-w-[297mm] shadow-2xl print:shadow-none print:max-w-none print:w-full relative" id="attendancePrintArea">
                
                <!-- Screen Controls - Colored Icons, No Backgrounds -->
                <div class="print:hidden sticky top-4 z-50 flex justify-end gap-3 mb-4">
                    <button onclick="printAttendance()" 
                            class="p-2.5 text-blue-500 hover:text-blue-700 hover:bg-blue-50 rounded-full transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-200"
                            aria-label="Print Attendance Record">
                        <span class="sr-only">Print Attendance Record</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                    </button>
                    <button @click="openAttendance = false" 
                            class="p-2.5 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-full transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-200"
                            aria-label="Close Attendance Record">
                        <span class="sr-only">Close Attendance Record</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Attendance Content -->
                <div class="p-6 md:p-8 print:p-4 border-4 border-double border-slate-900 m-2 print:m-0">
                    
               <!-- Attendance Header - Centered Large Logos -->
<div class="text-center border-b-2 border-slate-900 pb-4 mb-4">
    <!-- Top Form Identifier -->
    <div class="flex items-center justify-between text-[10px] mb-3">
        <span class="font-semibold tracking-wider">SF2 - DAILY ATTENDANCE</span>
        <span class="font-bold uppercase tracking-widest text-slate-800">Republic of the Philippines</span>
        <span class="font-semibold tracking-wider">DepEd Form 2</span>
    </div>
    
    <!-- Main Header - Centered Large Logos with Text Between -->
    <div class="flex items-center justify-center">
        <!-- Left Logo - DepEd (Larger) -->
        <div class="flex-shrink-0">
            <img src="{{ asset('images/logo1.png') }}" class="h-20 md:h-24 w-auto print:h-20" alt="DepEd Logo">
        </div>
        
        <!-- Center Text Block - Tighter spacing -->
        <div class="px-4 md:px-6">
            <p class="text-sm md:text-base font-black uppercase tracking-wider text-slate-900">Department of Education</p>
            <p class="text-xs md:text-sm text-slate-600 font-semibold">Division of Negros Oriental</p>
            <h1 class="text-lg md:text-xl font-black uppercase mt-1 text-slate-900 tracking-wide">Tugawe Elementary School</h1>
        </div>
        
        <!-- Right Logo - School (Larger) -->
        <div class="flex-shrink-0">
            <img src="{{ asset('images/logo.png') }}" class="h-20 md:h-24 w-auto print:h-20" alt="School Logo">
        </div>
    </div>
    
    <!-- Attendance Title -->
    <div class="mt-4">
        <h2 class="inline-block px-4 py-1.5 border-2 border-slate-900 text-sm md:text-base font-bold uppercase tracking-widest bg-slate-50">Individual Attendance Record</h2>
        <p class="text-xs mt-2 text-slate-600">School Year: <span class="font-bold text-slate-900">{{ $activeSchoolYear->name ?? '2024-2025' }}</span></p>
    </div>
</div>
                    <!-- Student Info -->
                    <div class="border-2 border-slate-800 p-3 mb-4 bg-slate-50">
                        <table class="w-full text-xs">
                            <tr>
                                <td class="py-1"><span class="font-semibold">Name:</span> <span class="uppercase font-bold">{{ $student->last_name }}, {{ $student->first_name }}</span></td>
                                <td class="py-1"><span class="font-semibold">LRN:</span> {{ $student->lrn ?? 'N/A' }}</td>
                                <td class="py-1"><span class="font-semibold">Grade & Section:</span> {{ $section->year_level }} - {{ $section->name }}</td>
                            </tr>
                            <tr>
                                <td class="py-1" colspan="2">
                                    <span class="font-semibold">School Year:</span> {{ $activeSchoolYear->name ?? '2024-2025' }}
                                </td>
                                <td class="py-1">
                                    <span class="font-semibold">Month:</span>
                                    <select x-model="selectedMonth" class="bg-white border border-slate-400 rounded px-2 py-0.5 text-xs ml-1 print:hidden">
                                        @foreach ($months as $m => $records)
                                            <option value="{{ $m }}">{{ $m }}</option>
                                        @endforeach
                                    </select>
                                    <span class="hidden print:inline font-bold" x-text="selectedMonth"></span>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Legend -->
                    <div class="flex flex-wrap gap-3 text-[10px] font-semibold mb-3 border border-slate-300 p-2 bg-slate-50">
                        <span class="text-slate-600 uppercase mr-2">Legend:</span>
                        <span class="text-green-700">✓ Present</span>
                        <span class="text-yellow-700">L Late</span>
                        <span class="text-red-700">A Absent</span>
                        <span class="text-blue-700">E Excused</span>
                    </div>

                    <!-- Calendar Grid - PHP-based for reliability -->
                    <div class="space-y-6">
                        @foreach($months as $monthName => $attendanceRecords)
                        <div x-show="selectedMonth === '{{ $monthName }}'" x-cloak>
                          @php
    $daysInMonth = \Carbon\Carbon::parse($monthName)->daysInMonth;
    // Use format('N') to get ISO-8601 numeric representation of day (1=Monday, 7=Sunday)
    $firstDayOfMonth = (int)\Carbon\Carbon::parse($monthName)->firstOfMonth()->format('N');
    
    $statusColors = [
        'present' => 'text-green-600',
        'absent' => 'text-red-600',
        'late' => 'text-yellow-600',
        'excused' => 'text-blue-600'
    ];
    $statusSymbols = [
        'present' => '✓',
        'absent' => 'A',
        'late' => 'L',
        'excused' => 'E'
    ];
@endphp

                            <div class="border-2 border-slate-800">
                                <!-- Days Header -->
                                <div class="grid grid-cols-7 border-b-2 border-slate-800 bg-slate-200">
                                    @foreach(['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] as $day)
                                        <div class="text-center py-2 text-[10px] font-bold border-r border-slate-300 last:border-r-0">{{ $day }}</div>
                                    @endforeach
                                </div>
                                
                                <!-- Calendar -->
                                <div class="grid grid-cols-7 auto-rows-fr">
                                    @php
                                        // Empty cells before first day
                                        for($i = 1; $i < $firstDayOfMonth; $i++) {
                                            echo '<div class="border-r border-b border-slate-300 p-2 min-h-[50px] bg-slate-50"></div>';
                                        }
                                        
                                        // Days of month
                                        for($day = 1; $day <= $daysInMonth; $day++) {
                                            $date = \Carbon\Carbon::parse($monthName)->setDay($day);
                                            $record = $attendanceRecords->first(function($a) use ($date) {
                                                return \Carbon\Carbon::parse($a->date)->isSameDay($date);
                                            });
                                            $status = $record ? $record->status : null;
                                            $isWeekend = $date->isSaturday() || $date->isSunday();
                                    @endphp
                                        <div class="border-r border-b border-slate-300 p-2 min-h-[50px] relative {{ $isWeekend ? 'bg-slate-100' : 'bg-white' }}">
                                            <div class="text-[9px] font-bold text-slate-500">{{ $day }}</div>
                                            <div class="flex justify-center items-center h-6">
                                                @if($status)
                                                    <span class="text-base font-black {{ $statusColors[$status] ?? 'text-slate-300' }}">
                                                        {{ $statusSymbols[$status] ?? '—' }}
                                                    </span>
                                                @else
                                                    <span class="text-slate-300">—</span>
                                                @endif
                                            </div>
                                        </div>
                                    @php
                                        }
                                        
                                        // Fill remaining cells
                                        $totalCells = $firstDayOfMonth - 1 + $daysInMonth;
                                        $remaining = 7 - ($totalCells % 7);
                                        if($remaining < 7) {
                                            for($i = 0; $i < $remaining; $i++) {
                                                echo '<div class="border-r border-b border-slate-300 p-2 min-h-[50px] bg-slate-50"></div>';
                                            }
                                        }
                                    @endphp
                                </div>
                            </div>

                            <!-- Summary -->
                            <div class="mt-4">
                                <h3 class="text-xs font-bold uppercase mb-2 border-l-4 border-indigo-500 pl-2">Monthly Summary</h3>
                                <div class="grid grid-cols-6 gap-2">
                                    <div class="bg-slate-100 border border-slate-300 rounded p-2 text-center">
                                        <p class="text-[9px] uppercase">School Days</p>
                                        <p class="text-xl font-black">{{ $attendanceRecords->count() }}</p>
                                    </div>
                                    <div class="bg-green-50 border border-green-200 rounded p-2 text-center">
                                        <p class="text-[9px] uppercase text-green-700">Present</p>
                                        <p class="text-xl font-black text-green-700">{{ $attendanceRecords->where('status', 'present')->count() }}</p>
                                    </div>
                                    <div class="bg-yellow-50 border border-yellow-200 rounded p-2 text-center">
                                        <p class="text-[9px] uppercase text-yellow-700">Late</p>
                                        <p class="text-xl font-black text-yellow-700">{{ $attendanceRecords->where('status', 'late')->count() }}</p>
                                    </div>
                                    <div class="bg-red-50 border border-red-200 rounded p-2 text-center">
                                        <p class="text-[9px] uppercase text-red-700">Absent</p>
                                        <p class="text-xl font-black text-red-700">{{ $attendanceRecords->where('status', 'absent')->count() }}</p>
                                    </div>
                                    <div class="bg-blue-50 border border-blue-200 rounded p-2 text-center">
                                        <p class="text-[9px] uppercase text-blue-700">Excused</p>
                                        <p class="text-xl font-black text-blue-700">{{ $attendanceRecords->where('status', 'excused')->count() }}</p>
                                    </div>
                                    <div class="bg-indigo-50 border border-indigo-200 rounded p-2 text-center">
                                        <p class="text-[9px] uppercase text-indigo-700">Rate</p>
                                        @php
                                            $total = $attendanceRecords->count();
                                            $valid = $attendanceRecords->whereIn('status', ['present', 'late', 'excused'])->count();
                                            $rate = $total > 0 ? round(($valid / $total) * 100) : 0;
                                        @endphp
                                        <p class="text-xl font-black text-indigo-700">{{ $rate }}%</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Signatures -->
                    <div class="border-t-2 border-slate-800 pt-4 mt-6">
                        <p class="text-[10px] italic mb-3 text-slate-600">
                            I certify that the above attendance record is true and correct.
                        </p>
                        <div class="grid grid-cols-3 gap-4 text-center text-xs">
                            <div>
                                <div class="border-t border-slate-800 pt-1 mt-6"></div>
                                <p class="font-bold uppercase">{{ $section->adviser?->name ?? '_______________' }}</p>
                                <p class="text-slate-500">Class Adviser</p>
                            </div>
                            <div>
                                <div class="border-t border-slate-800 pt-1 mt-6"></div>
                                <p class="font-bold uppercase">School Principal</p>
                                <p class="text-slate-500">School Head</p>
                            </div>
                            <div>
                                <div class="border-t border-slate-800 pt-1 mt-6"></div>
                                <p class="font-bold uppercase">{{ $student->guardian?->name ?? '_______________' }}</p>
                                <p class="text-slate-500">Parent/Guardian</p>
                            </div>
                        </div>
                        <p class="text-[9px] text-right mt-3 text-slate-500">Generated: {{ now()->format('F d, Y') }} | SF2-DTR</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endif

</main>

<!-- =================== PROFILE MODAL =================== -->
<div id="profileModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto" x-data="{ editMode: false }">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-teal-600 to-teal-700 p-6 text-white relative">
            <h2 class="text-xl font-bold">My Profile</h2>
            <p class="text-teal-200 text-sm">Update your personal information</p>
            <button onclick="closeProfileModal()" class="absolute top-4 right-4 w-10 h-10 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PATCH')

            <!-- Photo -->
            <div class="flex items-center gap-6 mb-6">
                <div class="relative">
                    <img src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/photo-placeholder.png') }}" 
                         class="w-24 h-24 rounded-2xl object-cover shadow-lg" alt="Profile">
                    <div x-show="editMode" class="absolute inset-0 bg-black/50 rounded-2xl flex items-center justify-center">
                        <label class="cursor-pointer text-white text-center">
                            <svg class="w-8 h-8 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-xs">Change</span>
                            <input type="file" name="photo" class="hidden" accept="image/*">
                        </label>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-900">{{ $student->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $section->year_level ?? 'N/A' }} Student</p>
                </div>
            </div>

            <!-- Fields -->
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" name="first_name" value="{{ $student->first_name }}" :disabled="!editMode" 
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 mt-1 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 disabled:bg-gray-100 transition">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Middle Name</label>
                    <input type="text" name="middle_name" value="{{ $student->middle_name }}" :disabled="!editMode" 
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 mt-1 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 disabled:bg-gray-100 transition">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" name="last_name" value="{{ $student->last_name }}" :disabled="!editMode" 
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 mt-1 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 disabled:bg-gray-100 transition">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Suffix</label>
                    <input type="text" name="suffix" value="{{ $student->suffix }}" :disabled="!editMode" 
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 mt-1 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 disabled:bg-gray-100 transition">
                </div>
                <div>
    <label class="text-sm font-medium text-gray-700">Birthday</label>
    <input type="date" name="birthday" 
           value="{{ $student->birthday ? date('Y-m-d', strtotime($student->birthday)) : '' }}" 
           :disabled="!editMode" 
           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 mt-1 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 disabled:bg-gray-100 transition">
</div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Contact Number</label>
                    <input type="text" name="contact_number" value="{{ $student->contact_number }}" :disabled="!editMode" 
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 mt-1 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 disabled:bg-gray-100 transition">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" value="{{ auth()->user()->username }}" :disabled="!editMode" 
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 mt-1 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 disabled:bg-gray-100 transition">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Email</label>
                    <input type="email" value="{{ auth()->user()->email }}" disabled 
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 mt-1 bg-gray-200 cursor-not-allowed">
                </div>
                <div class="md:col-span-2" x-show="editMode">
                    <label class="text-sm font-medium text-gray-700">New Password <span class="text-gray-400 font-normal">(leave blank if not changing)</span></label>
                    <input type="password" name="password" placeholder="••••••••" 
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 mt-1 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition">
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-3 mt-8">
                <button type="button" x-show="!editMode" @click="editMode = true" 
                        class="px-6 py-2.5 bg-teal-600 text-white rounded-xl font-semibold hover:bg-teal-700 transition shadow-lg shadow-teal-500/30">
                    Edit Profile
                </button>
                <button type="button" x-show="editMode" @click="editMode = false" 
                        class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 transition">
                    Cancel
                </button>
                <button type="submit" x-show="editMode" 
                        class="px-6 py-2.5 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition shadow-lg shadow-green-500/30">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<!-- =================== SCRIPTS =================== -->
<script>
function openProfileModal() {
    document.getElementById('profileModal').classList.remove('hidden');
    document.getElementById('profileModal').classList.add('flex');
}

function closeProfileModal() {
    document.getElementById('profileModal').classList.remove('flex');
    document.getElementById('profileModal').classList.add('hidden');
}

// Optimized print functions for any paper size
function printGrades() {
    const printContent = document.getElementById('gradesPrintArea').innerHTML;
    const originalContent = document.body.innerHTML;
    
    document.body.innerHTML = `
        <div class="print-optimized">
            ${printContent}
        </div>
    `;
    
    window.print();
    document.body.innerHTML = originalContent;
    location.reload();
}

function printAttendance() {
    const printContent = document.getElementById('attendancePrintArea').innerHTML;
    const originalContent = document.body.innerHTML;
    
    document.body.innerHTML = `
        <div class="print-optimized landscape">
            ${printContent}
        </div>
    `;
    
    window.print();
    document.body.innerHTML = originalContent;
    location.reload();
}

// Close modals on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeProfileModal();
    }
});
</script>

<!-- Print Styles - Optimized for all paper sizes -->
<style>
@media print {
    @page {
        size: auto;
        margin: 5mm;
    }
    
    @page landscape {
        size: landscape;
        margin: 5mm;
    }
    
    * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        color-adjust: exact !important;
    }
    
    body {
        background: white;
        font-size: 10pt;
        line-height: 1.3;
    }
    
    .print-optimized {
        width: 100%;
        max-width: none;
        margin: 0;
        padding: 0;
    }
    
    .print-optimized.landscape {
        width: 100%;
    }
    
    /* Ensure tables fit */
    table {
        width: 100% !important;
        font-size: 9pt;
    }
    
    td, th {
        padding: 4px 6px !important;
    }
    
    /* Scale down if needed */
    .print-optimized > div {
        transform-origin: top left;
        width: 100% !important;
        max-width: none !important;
        margin: 0 !important;
        box-shadow: none !important;
        border-width: 2px !important;
    }
    
    /* Hide screen elements */
    .print\\:hidden,
    button,
    .no-print {
        display: none !important;
    }
    
    /* Show print elements */
    .hidden.print\\:inline,
    .hidden.print\\:block {
        display: inline !important;
    }
    
    /* Ensure images print */
    img {
        max-height: 60px !important;
        width: auto !important;
    }
    
    /* Prevent page breaks inside important elements */
    tr {
        page-break-inside: avoid;
    }
    
    /* Signatures at bottom */
    .border-t-2,
    .border-t {
        page-break-inside: avoid;
    }
}

/* Screen-only styles */
@media screen {
    .print-optimized {
        display: none;
    }
}
</style>

</body>
</html>