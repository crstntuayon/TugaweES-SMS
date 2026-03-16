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
                            <p class="font-bold text-gray-900">{{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name }} {{ $student->suffix }}</p>
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
                    <h2 class="text-2xl md:text-4xl font-bold mb-2">{{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }} {{ $student->suffix }}</h2>
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
                        <p class="text-xs text-teal-200">Grades</p>
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
    <h3 class="text-lg font-bold text-gray-900">
        {{ $section?->teacher 
            ? $section->teacher->last_name . ', ' . $section->teacher->first_name . ' ' . ($section->teacher->middle_name ? substr($section->teacher->middle_name, 0, 1) . '. ' : '') . ($section->teacher->suffix ?? '')
            : 'Not Assigned' 
        }}
    </h3>
    <p class="text-sm text-gray-500">{{ $section?->teacher?->email ?? '' }}</p>
</div>
            </div>
            <button @click="openTeacher = true" class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-medium hover:bg-indigo-100 transition">
                View Details
            </button>
        </div>

<!-- Teacher Modal - Enhanced Profile Display -->
<div x-show="openTeacher" x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-slate-900/70 backdrop-blur-md flex items-center justify-center z-50 p-4">
    
    <div @click.away="openTeacher = false"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         class="bg-white rounded-3xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-hidden">
        
        <!-- Cover Photo / Header Background -->
        <div class="relative h-32 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-700">
            <!-- Decorative Pattern -->
            <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 20px 20px;"></div>
            
            <!-- Close Button -->
            <button @click="openTeacher = false" 
                    class="absolute top-4 right-4 w-10 h-10 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-full flex items-center justify-center transition-all duration-200 hover:rotate-90 group">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <!-- Profile Section -->
        <div class="relative px-8 pb-8">
            <!-- Profile Picture - Overlapping Header -->
            <div class="relative -mt-16 mb-6 flex justify-between items-end">
                <div class="relative">
                  <div class="w-32 h-32 rounded-2xl bg-white p-1.5 shadow-xl ring-4 ring-white overflow-hidden">
    @if($section?->teacher?->photo)
        <img src="{{ asset('storage/teachers/' . basename($section->teacher->photo)) }}" 
             class="w-full h-full rounded-xl object-cover bg-slate-100" 
             alt="{{ $section->teacher->first_name }}"
             onerror="this.onerror=null; this.src='{{ asset('images/photo-placeholder.png') }}';">
    @else
        <div class="w-full h-full rounded-xl bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
            <span class="text-3xl font-bold text-indigo-600">
                {{ substr($section?->teacher?->first_name ?? 'T', 0, 1) }}{{ substr($section?->teacher?->last_name ?? 'A', 0, 1) }}
            </span>
        </div>
    @endif
</div>
                    <!-- Online Status Indicator -->
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 border-4 border-white rounded-full flex items-center justify-center shadow-lg" title="Active">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Quick Action Buttons -->
                <div class="flex gap-3 mb-2">
                    @if($section?->teacher?->email)
                    <a href="mailto:{{ $section->teacher->email }}" 
                       class="flex items-center gap-2 px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-xl font-medium transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span class="hidden sm:inline">Email</span>
                    </a>
                    @endif
                    
                    @if($section?->teacher?->contact_number)
                    <a href="tel:{{ $section->teacher->contact_number }}" 
                       class="flex items-center gap-2 px-4 py-2 bg-green-50 hover:bg-green-100 text-green-700 rounded-xl font-medium transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span class="hidden sm:inline">Call</span>
                    </a>
                    @endif
                </div>
            </div>
            
            <!-- Teacher Info Header -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-2">
                    <h2 class="text-2xl font-bold text-slate-900">
                        {{ $section?->teacher?->last_name ?? 'Not' }}, {{ $section?->teacher?->first_name ?? 'Assigned' }} {{ $section?->teacher?->middle_name}}
                    </h2>
                    @if($section?->teacher?->suffix)
                        <span class="px-2 py-1 bg-slate-100 text-slate-600 text-xs font-bold rounded-lg uppercase tracking-wider">
                            {{ $section->teacher->suffix }}
                        </span>
                    @endif
                </div>
                
                <div class="flex flex-wrap items-center gap-4 text-sm">
                    <span class="flex items-center gap-1.5 text-slate-600">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        {{ $section?->teacher?->position ?? 'Class Adviser' }}
                    </span>
                    <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                    <span class="flex items-center gap-1.5 text-slate-600">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Grade {{ $section?->year_level ?? 'N/A' }} - {{ $section?->name ?? 'N/A' }}
                    </span>
                </div>
            </div>
            
            <!-- Contact Information Cards -->
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Primary Contact Info -->
                <div class="space-y-4">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Contact Information</h3>
                    
                    @if($section?->teacher?->email)
                    <div class="group flex items-center gap-4 p-4 bg-slate-50 hover:bg-blue-50 rounded-2xl transition-colors duration-200 cursor-pointer" onclick="window.location.href='mailto:{{ $section->teacher->email }}'">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-slate-500 font-medium mb-0.5">Email Address</p>
                            <p class="text-sm font-semibold text-slate-900 truncate">{{ $section->teacher->email }}</p>
                        </div>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                    @endif
                    
                    @if($section?->teacher?->contact_number)
                    <div class="group flex items-center gap-4 p-4 bg-slate-50 hover:bg-green-50 rounded-2xl transition-colors duration-200 cursor-pointer" onclick="window.location.href='tel:{{ $section->teacher->contact_number }}'">
                        <div class="w-12 h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-slate-500 font-medium mb-0.5">Phone Number</p>
                            <p class="text-sm font-semibold text-slate-900">{{ $section->teacher->contact_number }}</p>
                        </div>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                    @else
                    <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl opacity-60">
                        <div class="w-12 h-12 rounded-xl bg-slate-200 text-slate-400 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-medium mb-0.5">Phone Number</p>
                            <p class="text-sm font-semibold text-slate-400">Not provided</p>
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Professional Info -->
                <div class="space-y-4">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Professional Details</h3>
                    
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center pb-3 border-b border-slate-200">
                                <span class="text-sm text-slate-500">Position</span>
                                <span class="text-sm font-semibold text-slate-900">{{ $section?->teacher?->position ?? 'Teacher I' }}</span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b border-slate-200">
                                <span class="text-sm text-slate-500">School Year</span>
                                <span class="text-sm font-semibold text-slate-900">{{ $section?->schoolYear?->name ?? '2024-2025' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-500">Section</span>
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold rounded-lg">
                                    {{ $section?->name ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Info (if available) -->
                    @if($section?->teacher?->employee_id || $section?->teacher?->specialization)
                    <div class="p-4 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl border border-indigo-100">
                        @if($section?->teacher?->employee_id)
                        <div class="flex items-center gap-3 mb-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                            </svg>
                            <div>
                                <p class="text-xs text-indigo-600 font-medium">Employee ID</p>
                                <p class="text-sm font-bold text-indigo-900">{{ $section->teacher->employee_id }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Footer -->
            <div class="mt-8 pt-6 border-t border-slate-200 flex justify-between items-center text-xs text-slate-400">
                <span>Last updated: {{ now()->format('F d, Y') }}</span>
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    Verified Teacher
                </span>
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
        
        <!-- Print Container -->
        <div class="min-h-screen p-4 md:p-8 print:p-0 flex items-start justify-center">
            <div class="bg-white w-full max-w-[210mm] shadow-2xl print:shadow-none print:max-w-none print:w-full relative" id="gradesPrintArea">
                
                <!-- Screen-only controls -->
                <div class="print:hidden sticky top-4 z-50 flex justify-end gap-3 mb-4">
                    <button @click="window.print()" 
                            class="p-2.5 text-blue-500 hover:text-blue-700 hover:bg-blue-50 rounded-full transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-200"
                            title="Print Report Card">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                <!-- Report Card Content - SF9 Style -->
                <div class="sf9-wrapper print:m-0">
                    <div class="sf9-container print:border-black print:m-0" id="sf9Form">
                        
                        <!-- HEADER WITH DUAL SCHOOL LOGOS LEFT, DEPED LOGO RIGHT -->
                        <div class="official-header">
                            <table style="border: none; width: 100%; margin-bottom: 5px;">
                                <tr style="border: none;">
                                    <!-- LEFT SIDE: Dual School Logos -->
                                    <td style="border: none; width: 25%; text-align: right; vertical-align: middle; padding-right: 8px;">
                                        <div style="display: inline-flex; align-items: center; gap: 5px;">
                                            <img src="{{ asset('images/logo1.png') }}" 
                                                 onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2275%22 height=%2275%22><rect fill=%22%23006633%22 width=%2275%22 height=%2275%22 rx=%2237.5%22/><text fill=%22white%22 x=%2237.5%22 y=%2242%22 text-anchor=%22middle%22 font-size=%2210%22 font-weight=%22bold%22>LOGO1</text></svg>'"
                                                 class="logo" alt="School Logo 1" style="display: inline-block; width: 75px; height: 75px;">
                                            <img src="{{ asset('images/logo.png') }}" 
                                                 onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2275%22 height=%2275%22><rect fill=%22%23008000%22 width=%2275%22 height=%2275%22 rx=%2237.5%22/><text fill=%22white%22 x=%2237.5%22 y=%2242%22 text-anchor=%22middle%22 font-size=%2210%22 font-weight=%22bold%22>LOGO2</text></svg>'"
                                                 class="logo" alt="School Logo 2" style="display: inline-block; width: 75px; height: 75px;">
                                        </div>
                                    </td>
                                    
                                    <!-- CENTER: Text -->
                                    <td style="border: none; width: 50%; text-align: center; vertical-align: middle;">
                                        <p class="govt-name">Republic of the Philippines</p>
                                        <p class="dept-name">Department of Education</p>
                                        <div class="form-title">Learner's Progress Report Card</div>
                                        <div class="form-number">School Form 9 (SF9)</div>
                                    </td>
                                    
                                    <!-- RIGHT SIDE: DepEd Logo -->
                                    <td style="border: none; width: 25%; text-align: left; vertical-align: middle; padding-left: 8px;">
                                        <div style="display: inline-flex; align-items: center; gap: 5px;">
                                            <img src="{{ asset('images/DepEd.jpg') }}" 
                                                 onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2285%22 height=%2285%22><circle fill=%22%23003366%22 cx=%2242.5%22 cy=%2242.5%22 r=%2242.5%22/><text fill=%22white%22 x=%2242.5%22 y=%2248%22 text-anchor=%22middle%22 font-size=%2212%22 font-weight=%22bold%22>DepEd</text></svg>'"
                                                 class="logo" alt="DepEd Logo" style="display: inline-block; width: 85px; height: 85px;">
                                            <img src="{{ asset('images/Bagong Pilipinas.jpg') }}" 
                                                 onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2260%22 height=%2260%22><circle fill=%22%23003366%22 cx=%2230%22 cy=%2230%22 r=%2230%22/><text fill=%22white%22 x=%2230%22 y=%2235%22 text-anchor=%22middle%22 font-size=%229%22 font-weight=%22bold%22>BP</text></svg>'"
                                                 class="logo" alt="Bagong Pilipinas Logo" style="display: inline-block; width: 60px; height: 60px;">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- SCHOOL INFO -->
                        <div class="compact-section">
                            <table style="font-size: 8.5pt;">
                                <tr>
                                    <td style="width: 50%;">
                                        <strong>Region:</strong> {{ $schoolInfo->region ?? 'NIR - Negros Island Region' }}
                                    </td>
                                    <td style="width: 50%;">
                                        <strong>Schools Division:</strong> {{ $schoolInfo->division ?? 'Division of Negros Oriental' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>District:</strong> {{ $schoolInfo->district ?? 'Dauin District' }}
                                    </td>
                                    <td>
                                        <strong>School Name:</strong> {{ $schoolInfo->name ?? config('app.school_name', 'Tugawe Elementary School') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>School Year:</strong> {{ $activeSchoolYear->name ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <strong>Grade Level:</strong> {{ $section->year_level ?? 'N/A' }} &nbsp;&nbsp;
                                        <strong>Section:</strong> {{ $section->name ?? '-' }}
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- LEARNER INFO -->
                        <div class="compact-section">
                            <table style="font-size: 8.5pt;">
                                <tr>
                                    <td style="width: 40%;">
                                        <strong>Name:</strong> 
                                        <span class="uppercase">{{ strtoupper($student->last_name . ', ' . $student->first_name . ' ' . $student->middle_name) }}</span>
                                        {{ $student->suffix }}
                                    </td>
                                    <td style="width: 30%;">
                                        <strong>Sex:</strong> 
                                        @if($student->sex == 'M')
                                            Male
                                        @elseif($student->sex == 'F')
                                            Female
                                        @else
                                            {{ $student->sex }}
                                        @endif
                                    </td>
                                    <td style="width: 30%;">
                                        <strong>LRN:</strong> {{ $student->lrn ?? $student->school_id }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Age:</strong> 
                                        <span style="font-weight: bold; color: #059669;">
                                            {{ $student->age ?? '' }}
                                        </span>
                                    </td>
                                    <td colspan="2">
                                        <strong>Date of Birth:</strong> 
                                        {{ $student->birthday ? date('F d, Y', strtotime($student->birthday)) : '' }}
                                    </td>
                                </tr>
                            </table>
                        </div>

                        @php
                            $quarters = [1, 2, 3, 4];
                            $currentYear = $section->year_level;
                            $subjects = \App\Models\Subject::where('grade_level', $currentYear)->get();
                            
                            // Try to get core values if model exists, otherwise empty collection
                            try {
                                $studentCoreValues = \App\Models\StudentCoreValue::where('student_id', $student->id)
                                    ->where('school_year_id', $activeSchoolYear->id ?? null)
                                    ->get()
                                    ->keyBy(function($item) {
                                        return $item->core_value . '_' . $item->behavior_statement . '_Q' . $item->quarter;
                                    });
                            } catch (\Exception $e) {
                                $studentCoreValues = collect();
                            }
                        @endphp

                        <!-- PART I: ACADEMIC PROGRESS - VIEW ONLY -->
                        <div class="compact-section">
                            <div style="font-size: 9pt; font-weight: bold; margin-bottom: 4px; text-transform: uppercase; background: #e5e7eb; padding: 3px;">
                                Report on Learning Progress and Achievement
                            </div>
                            
                            <table class="grades-table" style="font-size: 8.5pt;">
                                <thead>
                                    <tr style="background: #f3f4f6;">
                                        <th style="width: 32%; text-align: left; padding-left: 6px;">Learning Areas</th>
                                        @foreach($quarters as $q)
                                            <th style="width: 8%;">Q{{ $q }}</th>
                                        @endforeach
                                        <th style="width: 10%;">Final Rating</th>
                                        <th style="width: 16%;">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalFinal = 0;
                                        $subjectCount = 0;
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
                                            if($average !== null) {
                                                $finalGrades[] = $average;
                                                $totalFinal += $average;
                                            }
                                        @endphp
                                        <tr class="{{ $loop->even ? 'bg-slate-50' : 'bg-white' }}">
                                            <td style="text-align: left; padding-left: 6px;">{{ $subject->name }}</td>
                                            @foreach($quarters as $q)
                                                <td style="text-align: center; font-weight: {{ $qValues[$q] ? 'bold' : 'normal' }}; color: {{ $qValues[$q] ? ($qValues[$q] >= 75 ? '#059669' : '#dc2626') : '#9ca3af' }};">
                                                    {{ $qValues[$q] ?? '—' }}
                                                </td>
                                            @endforeach
                                            <td style="text-align: center; font-weight: bold; font-size: 9pt; color: {{ $average !== null ? ($average >= 75 ? '#059669' : '#dc2626') : '#9ca3af' }};">
                                                {{ $average !== null ? round($average) : '—' }}
                                            </td>
                                            <td style="text-align: center; font-weight: {{ $average !== null ? 'bold' : 'normal' }}; color: {{ $average !== null ? ($average >= 75 ? '#059669' : '#dc2626') : '#9ca3af' }};">
                                                {{ $average !== null ? ($average >= 75 ? 'Passed' : 'Failed') : '—' }}
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if(count($subjects) > 0)
                                        @php
                                            $generalAverages = [];
                                            foreach($quarters as $q) {
                                                $generalAverages[$q] = $quarterCounts[$q] > 0 ? round($quarterTotals[$q] / $quarterCounts[$q], 2) : null;
                                            }
                                            $finalGeneralAverage = count($finalGrades) > 0 ? round(array_sum($finalGrades) / count($finalGrades), 2) : null;
                                        @endphp

                                        <!-- Quarterly Average Row -->
                                        <tr style="background: #f9fafb; font-weight: bold;">
                                            <td style="text-align: left; padding-left: 6px; font-style: italic;">Quarterly Average</td>
                                            @foreach($quarters as $q)
                                                @php $qAvg = $quarterCounts[$q] > 0 ? round($quarterTotals[$q]/$quarterCounts[$q]) : null; @endphp
                                                <td style="text-align: center; color: {{ $qAvg ? ($qAvg >= 75 ? '#059669' : '#dc2626') : '#9ca3af' }};">
                                                    {{ $qAvg ?? '—' }}
                                                </td>
                                            @endforeach
                                            <td colspan="2"></td>
                                        </tr>

                                        <tr style="background: #f3f4f6; font-weight: bold; border-top: 2pt solid black;">
                                            <td colspan="5" style="text-align: right; padding-right: 10px;">General Average</td>
                                            <td style="text-align: center; font-size: 10pt; color: {{ $finalGeneralAverage >= 75 ? '#059669' : '#dc2626' }};">
                                                {{ $finalGeneralAverage ? round($finalGeneralAverage) : '—' }}
                                            </td>
                                            <td style="text-align: center; font-weight: bold; color: {{ $finalGeneralAverage >= 75 ? '#059669' : '#dc2626' }};">
                                                {{ $finalGeneralAverage ? ($finalGeneralAverage >= 75 ? 'PASSED' : 'FAILED') : '—' }}
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <!-- Grading Scale -->
                            <table style="font-size: 7.5pt; margin-top: 4px;">
                                <tr style="background: #f9fafb;">
                                    <td style="width: 20%; text-align: center; font-weight: bold;">Descriptors</td>
                                    <td style="width: 15%; text-align: center; font-weight: bold;">Grading Scale</td>
                                    <td style="width: 15%; text-align: center; font-weight: bold;">Remarks</td>
                                    <td style="width: 20%; text-align: center; font-weight: bold;">Descriptors</td>
                                    <td style="width: 15%; text-align: center; font-weight: bold;">Grading Scale</td>
                                    <td style="width: 15%; text-align: center; font-weight: bold;">Remarks</td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">Outstanding</td>
                                    <td style="text-align: center;">90-100</td>
                                    <td style="text-align: center;" rowspan="2">Passed</td>
                                    <td style="text-align: center;">Fairly Satisfactory</td>
                                    <td style="text-align: center;">75-79</td>
                                    <td style="text-align: center;" rowspan="2">Passed</td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">Very Satisfactory</td>
                                    <td style="text-align: center;">85-89</td>
                                    <td style="text-align: center; color: #dc2626;">Did Not Meet Expectations</td>
                                    <td style="text-align: center; color: #dc2626;">Below 75</td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">Satisfactory</td>
                                    <td style="text-align: center;">80-84</td>
                                    <td style="text-align: center;">Passed</td>
                                    <td colspan="3"></td>
                                </tr>
                            </table>
                        </div>

                        <!-- PART II: CORE VALUES - DYNAMIC FROM DATABASE (SAFE) -->
                        <div class="compact-section">
                            <div style="font-size: 9pt; font-weight: bold; margin-bottom: 4px; text-transform: uppercase; background: #e5e7eb; padding: 3px;">
                                Report on Learner's Observed Values
                            </div>
                            
                            @php
                                // Define core values structure with behavior statements
                                $coreValuesStructure = [
                                    [
                                        'name' => 'Maka-Diyos',
                                        'statements' => [
                                            'Expresses one\'s spiritual beliefs while respecting the spiritual beliefs of others',
                                            'Shows adherence to ethical principles by upholding truth'
                                        ]
                                    ],
                                    [
                                        'name' => 'Makatao',
                                        'statements' => [
                                            'Is sensitive to individual, social, and cultural differences',
                                            'Demonstrates contributions toward solidarity'
                                        ]
                                    ],
                                    [
                                        'name' => 'Makakalikasan',
                                        'statements' => [
                                            'Cares for the environment and utilizes resources wisely, judiciously, and economically'
                                        ]
                                    ],
                                    [
                                        'name' => 'Makabansa',
                                        'statements' => [
                                            'Demonstrates pride in being a Filipino; exercises the rights and responsibilities of a Filipino citizen',
                                            'Demonstrates appropriate behavior in carrying out activities in the school, community, and country'
                                        ]
                                    ]
                                ];
                            @endphp

                            <table class="values-table" style="font-size: 8pt;">
                                <thead>
                                    <tr style="background: #f3f4f6;">
                                        <th style="width: 12%;">Core Values</th>
                                        <th style="width: 48%;">Behavior Statements</th>
                                        <th style="width: 10%;">Q1</th>
                                        <th style="width: 10%;">Q2</th>
                                        <th style="width: 10%;">Q3</th>
                                        <th style="width: 10%;">Q4</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($coreValuesStructure as $coreValue)
                                        @php $statementCount = count($coreValue['statements']); @endphp
                                        
                                        @foreach($coreValue['statements'] as $index => $statement)
                                            <tr>
                                                @if($index === 0)
                                                    <td rowspan="{{ $statementCount }}" style="font-weight: bold; vertical-align: top;">{{ $coreValue['name'] }}</td>
                                                @endif
                                                <td>{{ $statement }}</td>
                                                
                                                @foreach([1, 2, 3, 4] as $quarter)
                                                    @php
                                                        // Look up actual value from database if model exists
                                                        $mark = null;
                                                        if ($studentCoreValues->isNotEmpty()) {
                                                            $record = $studentCoreValues->first(function($item) use ($coreValue, $statement, $quarter) {
                                                                return $item->core_value === $coreValue['name'] 
                                                                    && $item->behavior_statement === $statement
                                                                    && $item->quarter == $quarter;
                                                            });
                                                            $mark = $record->mark ?? null;
                                                        }
                                                    @endphp
                                                    <td style="text-align: center; font-weight: {{ $mark ? 'bold' : 'normal' }}; color: {{ $mark ? '#059669' : '#9ca3af' }};">
                                                        {{ $mark ?? '—' }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>

                            <div style="font-size: 7.5pt; margin-top: 3px; text-align: center;">
                                <strong>Marking:</strong> 
                                <span style="margin-left: 10px;">AO = Always Observed (95-100)</span>
                                <span style="margin-left: 10px;">SO = Sometimes Observed (85-94)</span>
                                <span style="margin-left: 10px;">RO = Rarely Observed (75-84)</span>
                                <span style="margin-left: 10px;">NO = Not Observed (Below 75)</span>
                            </div>
                        </div>

                        <!-- PART III: ATTENDANCE - DYNAMIC FROM DATABASE -->
                        <div class="compact-section">
                            <div style="font-size: 9pt; font-weight: bold; margin-bottom: 4px; text-transform: uppercase; background: #e5e7eb; padding: 3px;">
                                Attendance Record
                            </div>
                            
                            @php
                            $months = ['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'Total'];
                            
                            // Get student's monthly attendance from existing attendance records
                            $studentAttendance = $student->attendances()
                                ->where('school_year_id', $activeSchoolYear->id ?? null)
                                ->selectRaw('MONTH(date) as month, 
                                    SUM(CASE WHEN status = "present" OR status = "late" THEN 1 ELSE 0 END) as present_days,
                                    SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent_days,
                                    COUNT(*) as total_days')
                                ->groupBy('month')
                                ->get()
                                ->keyBy('month');
                            
                            // Map month numbers to names (school year: June = 0, July = 1, etc.)
                            $monthMap = [6 => 0, 7 => 1, 8 => 2, 9 => 3, 10 => 4, 11 => 5, 12 => 6, 1 => 7, 2 => 8, 3 => 9, 4 => 10];
                            
                            $attendanceData = [];
                            foreach($monthMap as $monthNum => $index) {
                                $record = $studentAttendance->get($monthNum);
                                $attendanceData[$index] = [
                                    'present' => $record->present_days ?? null,
                                    'absent' => $record->absent_days ?? null,
                                    'total' => $record->total_days ?? null
                                ];
                            }
                            
                            // Calculate totals
                            $totalPresent = 0;
                            $totalAbsent = 0;
                            foreach($attendanceData as $data) {
                                $totalPresent += $data['present'] ?? 0;
                                $totalAbsent += $data['absent'] ?? 0;
                            }
                            @endphp
                            
                            <table class="attendance-table" style="font-size: 8pt;">
                                <tr style="background: #f9fafb;">
                                    <td style="width: 16%; font-weight: bold;">No. of School Days</td>
                                    @foreach($months as $index => $month)
                                    <td style="width: 7%; text-align: center;">
                                        @if($month === 'Total')
                                            {{ $totalPresent + $totalAbsent > 0 ? $totalPresent + $totalAbsent : '—' }}
                                        @else
                                            {{ $attendanceData[$index]['total'] ?? '—' }}
                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">No. of Days Present</td>
                                    @foreach($months as $index => $month)
                                    <td style="text-align: center; font-weight: {{ ($attendanceData[$index]['present'] ?? 0) > 0 ? 'bold' : 'normal' }}; color: {{ ($attendanceData[$index]['present'] ?? 0) > 0 ? '#059669' : '#9ca3af' }};">
                                        @if($month === 'Total')
                                            {{ $totalPresent > 0 ? $totalPresent : '—' }}
                                        @else
                                            {{ $attendanceData[$index]['present'] ?? '—' }}
                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">No. of Times Absent</td>
                                    @foreach($months as $index => $month)
                                    <td style="text-align: center; font-weight: {{ ($attendanceData[$index]['absent'] ?? 0) > 0 ? 'bold' : 'normal' }}; color: {{ ($attendanceData[$index]['absent'] ?? 0) > 0 ? '#dc2626' : '#9ca3af' }};">
                                        @if($month === 'Total')
                                            {{ $totalAbsent > 0 ? $totalAbsent : '—' }}
                                        @else
                                            {{ $attendanceData[$index]['absent'] ?? '—' }}
                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                            </table>
                        </div>

                        <!-- PARENT'S SIGNATURE - VIEW ONLY -->
                        <div class="compact-section">
                            <div style="font-size: 9pt; font-weight: bold; margin-bottom: 4px; text-transform: uppercase; background: #e5e7eb; padding: 3px;">
                                Parent/Guardian's Signature
                            </div>
                            <table style="font-size: 8.5pt;">
                                <tr>
                                    <td style="width: 20%; font-weight: bold;">1st Quarter:</td>
                                    <td style="border-bottom: 1px solid black; width: 80%; color: #6b7280;">
                                        _________________
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">2nd Quarter:</td>
                                    <td style="border-bottom: 1px solid black; color: #6b7280;">
                                        _________________
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">3rd Quarter:</td>
                                    <td style="border-bottom: 1px solid black; color: #6b7280;">
                                        _________________
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">4th Quarter:</td>
                                    <td style="border-bottom: 1px solid black; color: #6b7280;">
                                        _________________
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- CERTIFICATION - VIEW ONLY -->
                        <div style="border: 1pt solid black; padding: 6px; margin-bottom: 6px; font-size: 8.5pt;">
                            <p style="text-align: justify; margin-bottom: 8px;">
                                I certify that this is a true record of <strong>{{ $student->first_name }} {{ $student->last_name }}</strong>, 
                                a pupil of this school. He/She is eligible for admission to Grade _______.
                            </p>
                            
                            <table style="border: none; margin-top: 10px;">
                                <tr style="border: none;">
                                    <td style="border: none; width: 50%; text-align: center;">
                                        <div style="border-top: 1pt solid black; width: 80%; margin: 0 auto; padding-top: 4px;">
                                            <strong>{{ $section->adviser?->name ?? '_________________' }}</strong>
                                        </div>
                                        <div style="font-size: 7.5pt;">Class Adviser</div>
                                    </td>
                                    <td style="border: none; width: 50%; text-align: center;">
                                        <div style="border-top: 1pt solid black; width: 80%; margin: 0 auto; padding-top: 4px;">
                                            <strong>{{ $schoolInfo->principal ?? '_________________' }}</strong>
                                        </div>
                                        <div style="font-size: 7.5pt;">School Principal</div>
                                    </td>
                                </tr>
                            </table>
                            
                            <div style="text-align: right; margin-top: 8px; font-size: 8.5pt;">
                                Date: {{ now()->format('F d, Y') }}
                            </div>
                        </div>

                        <!-- CANCELLATION OF ELIGIBILITY - VIEW ONLY -->
                        <div style="border: 1pt solid black; padding: 4px; background: #f9fafb; font-size: 7.5pt;">
                            <div style="font-weight: bold; margin-bottom: 3px;">Cancellation of Eligibility to Transfer</div>
                            <div style="display: flex; justify-content: space-between;">
                                <span>Admitted in: _________________</span>
                                <span>Date: _________________</span>
                            </div>
                            <div style="text-align: right; margin-top: 4px;">
                                <div style="display: inline-block; text-align: center; width: 150px;">
                                    <div style="border-top: 1pt solid black; padding-top: 2px;">Principal</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* SF9 Matching Styles */
    .sf9-wrapper {
        width: 210mm;
        max-width: 100%;
        margin: 0 auto;
        background: white;
    }

    .sf9-container {
        border: 1.5pt solid black;
        background: white;
        padding: 12px;
        position: relative;
        min-height: 297mm;
    }

    /* Header Styles */
    .official-header {
        text-align: center;
        margin-bottom: 6px;
        padding: 5px 0;
    }

    .official-header .govt-name {
        font-size: 11pt;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        line-height: 1.1;
    }

    .official-header .dept-name {
        font-size: 13pt;
        font-weight: bold;
        text-transform: uppercase;
        margin-top: 1px;
        line-height: 1.1;
    }

    .official-header .form-title {
        font-size: 15pt;
        font-weight: bold;
        text-transform: uppercase;
        margin-top: 3px;
        line-height: 1.1;
    }

    .official-header .form-number {
        font-size: 10pt;
        margin-top: 1px;
        line-height: 1.1;
    }

    /* Logo sizing */
    .logo {
        object-fit: contain;
        display: inline-block;
    }

    /* Compact spacing */
    .compact-section {
        margin-bottom: 6px;
    }

    /* Table styles */
    table {
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        border: 1pt solid black;
        padding: 3px 4px;
        vertical-align: middle;
    }

    .grades-table td, .grades-table th {
        padding: 2px 3px;
        font-size: 8.5pt;
    }

    .values-table td, .values-table th {
        padding: 2px 3px;
        font-size: 7.5pt;
    }

    .attendance-table td, .attendance-table th {
        padding: 2px;
        font-size: 7.5pt;
    }

    .text-center { text-align: center; }
    .uppercase { text-transform: uppercase; }

    /* Print optimizations */
    @media print {
        @page {
            size: auto;
            margin: 0;
        }
        
        body { 
            background: white; 
            padding: 0;
            margin: 0;
        }
        
        .sf9-wrapper {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        .sf9-container {
            box-shadow: none;
            border: 1.5pt solid black;
            width: 100% !important;
            max-width: 100% !important;
            height: 100vh !important;
            max-height: 100vh !important;
            padding: 10px !important;
            margin: 0 !important;
        }
        
        .print-modal-container {
            background: white !important;
        }
        
        .logo {
            max-width: 80px !important;
            max-height: 80px !important;
        }
    }

    /* Hide Alpine.js cloaked elements */
    [x-cloak] {
        display: none !important;
    }
</style>

<!-- Attendance Button - Enhanced with SF2 Design -->
<div x-data="{ openAttendance: false, selectedMonth: '{{ $student->attendances->first() ? \Carbon\Carbon::parse($student->attendances->first()->date)->format('F Y') : now()->format('F Y') }}' }">
    
    <!-- Enhanced Card Button - SF2 Style -->
    <button @click="openAttendance = true" 
            class="group w-full bg-white rounded-xl shadow-sm border border-slate-200 p-6 
                   hover:shadow-lg hover:-translate-y-0.5 hover:border-blue-300 
                   transition-all duration-300 text-left relative overflow-hidden">
        
        <!-- Subtle gradient overlay on hover -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        
        <div class="relative flex items-start justify-between">
            <!-- Icon Container - SF2 Primary Color Scheme -->
            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-100 to-blue-50 
                        flex items-center justify-center group-hover:scale-110 transition-transform duration-300 
                        shadow-sm border border-blue-100">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
            
            <!-- SF2 Badge Style -->
            <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded-full border border-blue-100 
                         group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                SF2
            </span>
        </div>
        
        <!-- Text Content - SF2 Typography -->
        <div class="relative mt-4">
            <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-700 transition-colors duration-300">
                View Attendance
            </h3>
            <p class="mt-1 text-sm text-slate-500 group-hover:text-slate-600">
                Track your daily attendance records
            </p>
        </div>
        
        <!-- Progress indicator bar (SF2 style) -->
        <div class="absolute bottom-0 left-0 h-1 bg-gradient-to-r from-blue-500 to-blue-300 w-0 group-hover:w-full transition-all duration-500"></div>
    </button>

    @php
        $months = $student->attendances->groupBy(function ($a) {
            return \Carbon\Carbon::parse($a->date)->format('F Y');
        });
    @endphp

    <!-- =================== ATTENDANCE MODAL - ENHANCED SF2 STYLE =================== -->
    <div x-show="openAttendance" x-cloak
         class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-50 overflow-auto print-modal-container"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="min-h-screen p-4 md:p-8 print:p-0 flex items-start justify-center">
            <div class="bg-white w-full max-w-[297mm] shadow-2xl rounded-lg print:shadow-none print:max-w-none print:w-full relative" 
                 id="attendancePrintArea">
                
                <!-- Screen Controls - SF2 Style Floating Buttons -->
                <div class="print:hidden sticky top-4 z-50 flex justify-end gap-3 mb-4">
                    <button onclick="printAttendance()" 
                            class="p-3 bg-white text-blue-600 hover:text-blue-700 hover:bg-blue-50 
                                   rounded-full shadow-lg border border-slate-200 transition-all duration-200 
                                   focus:outline-none focus:ring-2 focus:ring-blue-300 group"
                            aria-label="Print Attendance Record">
                        <span class="sr-only">Print Attendance Record</span>
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                    </button>
                    <button @click="openAttendance = false" 
                            class="p-3 bg-white text-red-500 hover:text-red-700 hover:bg-red-50 
                                   rounded-full shadow-lg border border-slate-200 transition-all duration-200 
                                   focus:outline-none focus:ring-2 focus:ring-red-300 group"
                            aria-label="Close Attendance Record">
                        <span class="sr-only">Close Attendance Record</span>
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Attendance Content - SF2 Styled Container -->
                <div class="p-6 md:p-8 print:p-4 border-4 border-double border-slate-800 m-2 print:m-0 bg-white">
                    
                    <!-- Enhanced Header - SF2 Style with Logos -->
                    <div class="text-center border-b-2 border-slate-800 pb-4 mb-4 bg-gradient-to-b from-slate-50 to-white">
                        <!-- Top Form Identifier -->
                        <div class="flex items-center justify-between text-[10px] mb-3 font-semibold tracking-wider text-slate-600">
                            <span class="bg-slate-100 px-2 py-1 rounded">SF2 - DAILY ATTENDANCE</span>
                            <span class="uppercase tracking-widest text-slate-800 font-bold">Republic of the Philippines</span>
                            <span class="bg-slate-100 px-2 py-1 rounded">DepEd Form 2</span>
                        </div>
                        
                        <!-- Main Header - Centered Large Logos -->
                        <div class="flex items-center justify-center gap-6">
                            <!-- Left Logo - DepEd -->
                            <div class="flex-shrink-0 p-2 bg-white rounded-lg shadow-sm border border-slate-100">
                                <img src="{{ asset('images/logo1.png') }}" class="h-20 md:h-24 w-auto print:h-20 object-contain" alt="DepEd Logo">
                            </div>
                            
                            <!-- Center Text Block -->
                            <div class="px-4 md:px-6 space-y-1">
                                <p class="text-sm md:text-base font-black uppercase tracking-wider text-slate-900">Department of Education</p>
                                <p class="text-xs md:text-sm text-slate-600 font-semibold">Division of Negros Oriental</p>
                                <h1 class="text-lg md:text-2xl font-black uppercase mt-2 text-slate-900 tracking-wide bg-blue-50 inline-block px-4 py-1 rounded-lg border border-blue-100">
                                    Tugawe Elementary School
                                </h1>
                            </div>
                            
                            <!-- Right Logo - School -->
                            <div class="flex-shrink-0 p-2 bg-white rounded-lg shadow-sm border border-slate-100">
                                <img src="{{ asset('images/logo.png') }}" class="h-20 md:h-24 w-auto print:h-20 object-contain" alt="School Logo">
                            </div>
                        </div>
                        
                        <!-- Attendance Title - SF2 Style -->
                        <div class="mt-4">
                            <h2 class="inline-block px-6 py-2 border-2 border-slate-800 text-sm md:text-base font-bold uppercase tracking-widest bg-gradient-to-r from-blue-50 to-white text-slate-800 rounded shadow-sm">
                                Individual Attendance Record
                            </h2>
                            <p class="text-xs mt-2 text-slate-600 font-medium">
                                School Year: <span class="font-bold text-slate-900 text-sm">{{ $activeSchoolYear->name ?? '2024-2025' }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- Enhanced Student Info - SF2 Style -->
                    <div class="border-2 border-slate-800 p-4 mb-4 bg-gradient-to-r from-slate-50 to-white rounded-sm shadow-sm">
                        <table class="w-full text-xs md:text-sm">
                            <tr>
                                <td class="py-2 pr-4">
                                    <span class="font-semibold text-slate-600">Name:</span> 
                                    <span class="uppercase font-bold text-slate-900 text-sm">{{ $student->last_name }}, {{ $student->first_name }}</span>
                                </td>
                                <td class="py-2 pr-4">
                                    <span class="font-semibold text-slate-600">LRN:</span> 
                                    <span class="font-mono text-slate-900">{{ $student->lrn ?? 'N/A' }}</span>
                                </td>
                                <td class="py-2">
                                    <span class="font-semibold text-slate-600">Grade & Section:</span> 
                                    <span class="font-bold text-slate-900">{{ $section->year_level }} - {{ $section->name }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2" colspan="2">
                                    <span class="font-semibold text-slate-600">School Year:</span> 
                                    <span class="text-slate-900">{{ $activeSchoolYear->name ?? '2024-2025' }}</span>
                                </td>
                                <td class="py-2">
                                    <span class="font-semibold text-slate-600">Month:</span>
                                    <select x-model="selectedMonth" 
                                            class="bg-white border border-slate-300 rounded px-3 py-1 text-xs ml-1 print:hidden focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition-all">
                                        @foreach ($months as $m => $records)
                                            <option value="{{ $m }}">{{ $m }}</option>
                                        @endforeach
                                    </select>
                                    <span class="hidden print:inline font-bold text-slate-900" x-text="selectedMonth"></span>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Enhanced Legend - SF2 Style -->
                    <div class="flex flex-wrap gap-4 text-[11px] font-semibold mb-4 border border-slate-300 p-3 bg-slate-50 rounded shadow-sm">
                        <span class="text-slate-600 uppercase tracking-wider mr-2 flex items-center">Legend:</span>
                        <span class="flex items-center gap-1.5 px-2 py-1 bg-white rounded border border-green-200 text-green-700 shadow-sm">
                            <span class="w-4 h-4 bg-green-100 rounded flex items-center justify-center text-xs font-bold">✓</span> Present
                        </span>
                        <span class="flex items-center gap-1.5 px-2 py-1 bg-white rounded border border-yellow-200 text-yellow-700 shadow-sm">
                            <span class="w-4 h-4 bg-yellow-100 rounded flex items-center justify-center text-xs font-bold">L</span> Late
                        </span>
                        <span class="flex items-center gap-1.5 px-2 py-1 bg-white rounded border border-red-200 text-red-700 shadow-sm">
                            <span class="w-4 h-4 bg-red-100 rounded flex items-center justify-center text-xs font-bold">A</span> Absent
                        </span>
                        <span class="flex items-center gap-1.5 px-2 py-1 bg-white rounded border border-blue-200 text-blue-700 shadow-sm">
                            <span class="w-4 h-4 bg-blue-100 rounded flex items-center justify-center text-xs font-bold">E</span> Excused
                        </span>
                    </div>

                    <!-- Calendar Grid - Enhanced SF2 Style -->
                    <div class="space-y-6">
                        @foreach($months as $monthName => $attendanceRecords)
                        <div x-show="selectedMonth === '{{ $monthName }}'" x-cloak>
                            @php
                                $daysInMonth = \Carbon\Carbon::parse($monthName)->daysInMonth;
                                $firstDayOfMonth = (int)\Carbon\Carbon::parse($monthName)->firstOfMonth()->format('N');
                                
                                $statusColors = [
                                    'present' => 'text-green-600 bg-green-50',
                                    'absent' => 'text-red-600 bg-red-50',
                                    'late' => 'text-yellow-600 bg-yellow-50',
                                    'excused' => 'text-blue-600 bg-blue-50'
                                ];
                                $statusSymbols = [
                                    'present' => '✓',
                                    'absent' => 'A',
                                    'late' => 'L',
                                    'excused' => 'E'
                                ];
                            @endphp

                            <div class="border-2 border-slate-800 shadow-lg rounded-sm overflow-hidden">
                                <!-- Days Header - SF2 Style -->
                                <div class="grid grid-cols-7 border-b-2 border-slate-800 bg-gradient-to-r from-slate-200 to-slate-100">
                                    @foreach(['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] as $day)
                                        <div class="text-center py-3 text-[11px] font-bold border-r border-slate-300 last:border-r-0 text-slate-700 uppercase tracking-wider">
                                            {{ $day }}
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Calendar Grid -->
                                <div class="grid grid-cols-7 auto-rows-fr bg-white">
                                    @php
                                        // Empty cells before first day
                                        for($i = 1; $i < $firstDayOfMonth; $i++) {
                                            echo '<div class="border-r border-b border-slate-200 p-2 min-h-[60px] bg-slate-50/50"></div>';
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
                                        <div class="border-r border-b border-slate-200 p-2 min-h-[60px] relative {{ $isWeekend ? 'bg-slate-100' : 'bg-white hover:bg-slate-50' }} transition-colors">
                                            <div class="text-[10px] font-bold text-slate-400 mb-1">{{ $day }}</div>
                                            <div class="flex justify-center items-center h-8">
                                                @if($status)
                                                    <span class="w-8 h-8 flex items-center justify-center rounded-lg text-lg font-black {{ $statusColors[$status] ?? 'text-slate-300' }} shadow-sm border border-current border-opacity-20">
                                                        {{ $statusSymbols[$status] ?? '—' }}
                                                    </span>
                                                @else
                                                    <span class="text-slate-200 text-lg">—</span>
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
                                                echo '<div class="border-r border-b border-slate-200 p-2 min-h-[60px] bg-slate-50/50"></div>';
                                            }
                                        }
                                    @endphp
                                </div>
                            </div>

                            <!-- Enhanced Summary - SF2 Stats Style -->
                            <div class="mt-6">
                                <h3 class="text-xs font-bold uppercase mb-3 border-l-4 border-blue-500 pl-3 text-slate-700 tracking-wider">
                                    Monthly Summary
                                </h3>
                                <div class="grid grid-cols-6 gap-3">
                                    <div class="bg-gradient-to-br from-slate-100 to-white border border-slate-300 rounded-lg p-3 text-center shadow-sm hover:shadow-md transition-shadow">
                                        <p class="text-[10px] uppercase text-slate-500 font-semibold mb-1">School Days</p>
                                        <p class="text-2xl font-black text-slate-700">{{ $attendanceRecords->count() }}</p>
                                    </div>
                                    <div class="bg-gradient-to-br from-green-50 to-white border border-green-200 rounded-lg p-3 text-center shadow-sm hover:shadow-md transition-shadow">
                                        <p class="text-[10px] uppercase text-green-600 font-semibold mb-1">Present</p>
                                        <p class="text-2xl font-black text-green-600">{{ $attendanceRecords->where('status', 'present')->count() }}</p>
                                    </div>
                                    <div class="bg-gradient-to-br from-yellow-50 to-white border border-yellow-200 rounded-lg p-3 text-center shadow-sm hover:shadow-md transition-shadow">
                                        <p class="text-[10px] uppercase text-yellow-600 font-semibold mb-1">Late</p>
                                        <p class="text-2xl font-black text-yellow-600">{{ $attendanceRecords->where('status', 'late')->count() }}</p>
                                    </div>
                                    <div class="bg-gradient-to-br from-red-50 to-white border border-red-200 rounded-lg p-3 text-center shadow-sm hover:shadow-md transition-shadow">
                                        <p class="text-[10px] uppercase text-red-600 font-semibold mb-1">Absent</p>
                                        <p class="text-2xl font-black text-red-600">{{ $attendanceRecords->where('status', 'absent')->count() }}</p>
                                    </div>
                                    <div class="bg-gradient-to-br from-blue-50 to-white border border-blue-200 rounded-lg p-3 text-center shadow-sm hover:shadow-md transition-shadow">
                                        <p class="text-[10px] uppercase text-blue-600 font-semibold mb-1">Excused</p>
                                        <p class="text-2xl font-black text-blue-600">{{ $attendanceRecords->where('status', 'excused')->count() }}</p>
                                    </div>
                                    <div class="bg-gradient-to-br from-indigo-50 to-white border border-indigo-200 rounded-lg p-3 text-center shadow-sm hover:shadow-md transition-shadow">
                                        <p class="text-[10px] uppercase text-indigo-600 font-semibold mb-1">Rate</p>
                                        @php
                                            $total = $attendanceRecords->count();
                                            $valid = $attendanceRecords->whereIn('status', ['present', 'late', 'excused'])->count();
                                            $rate = $total > 0 ? round(($valid / $total) * 100) : 0;
                                        @endphp
                                        <p class="text-2xl font-black text-indigo-600">{{ $rate }}%</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Enhanced Signatures - SF2 Style -->
                    <div class="border-t-2 border-slate-800 pt-6 mt-8 bg-gradient-to-b from-white to-slate-50">
                        <p class="text-[11px] italic mb-4 text-slate-600 font-medium">
                            I certify that the above attendance record is true and correct.
                        </p>
                        <div class="grid grid-cols-3 gap-6 text-center text-xs">
                            <div class="bg-white p-3 rounded border border-slate-200 shadow-sm">
                                <div class="border-t-2 border-slate-800 pt-2 mt-8 mb-2"></div>
                                <p class="font-bold uppercase text-slate-900">{{ $section->adviser?->name ?? '_______________' }}</p>
                                <p class="text-slate-500 text-[10px] uppercase tracking-wider mt-1">Class Adviser</p>
                            </div>
                            <div class="bg-white p-3 rounded border border-slate-200 shadow-sm">
                                <div class="border-t-2 border-slate-800 pt-2 mt-8 mb-2"></div>
                                <p class="font-bold uppercase text-slate-900">School Principal</p>
                                <p class="text-slate-500 text-[10px] uppercase tracking-wider mt-1">School Head</p>
                            </div>
                            <div class="bg-white p-3 rounded border border-slate-200 shadow-sm">
                                <div class="border-t-2 border-slate-800 pt-2 mt-8 mb-2"></div>
                                <p class="font-bold uppercase text-slate-900">{{ $student->guardian?->name ?? '_______________' }}</p>
                                <p class="text-slate-500 text-[10px] uppercase tracking-wider mt-1">Parent/Guardian</p>
                            </div>
                        </div>
                        <p class="text-[9px] text-right mt-4 text-slate-400 font-medium">
                            Generated: {{ now()->format('F d, Y') }} | SF2-DTR
                        </p>
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