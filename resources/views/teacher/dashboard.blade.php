<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Dashboard | Student Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- MODERN DESIGN SYSTEM -->
    <style>
        :root {
            --primary-50: #eff6ff;
            --primary-100: #dbeafe;
            --primary-200: #bfdbfe;
            --primary-300: #93c5fd;
            --primary-400: #60a5fa;
            --primary-500: #3b82f6;
            --primary-600: #2563eb;
            --primary-700: #1d4ed8;
            --primary-800: #1e40af;
            --primary-900: #1e3a8a;
            
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
            
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --shadow-2xl: 0 25px 50px -12px rgb(0 0 0 / 0.25);
            
            --radius-sm: 0.375rem;
            --radius: 0.5rem;
            --radius-md: 0.75rem;
            --radius-lg: 1rem;
            --radius-xl: 1.5rem;
            --radius-2xl: 2rem;
        }
        
        /* Smooth scrolling */
        html { scroll-behavior: smooth; }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--gray-100); }
        ::-webkit-scrollbar-thumb { background: var(--gray-300); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--gray-400); }
        
        /* Glassmorphism utility */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        /* Modern card hover effect */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }
        
        /* Text gradient */
        .text-gradient {
            background: linear-gradient(135deg, var(--primary-600), var(--primary-800));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Animated background gradient */
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient-shift 8s ease infinite;
        }
        
        /* Modern input focus */
        .input-modern:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        /* Button press effect */
        .btn-press:active {
            transform: scale(0.98);
        }
        
        /* Fade in animation */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }
        
        /* Stagger children animation */
        .stagger-children > * {
            opacity: 0;
            animation: fadeInUp 0.5s ease-out forwards;
        }
        .stagger-children > *:nth-child(1) { animation-delay: 0.1s; }
        .stagger-children > *:nth-child(2) { animation-delay: 0.2s; }
        .stagger-children > *:nth-child(3) { animation-delay: 0.3s; }
        .stagger-children > *:nth-child(4) { animation-delay: 0.4s; }
    </style>
</head>

<body class="bg-slate-50 min-h-screen font-['Inter'] antialiased text-slate-800">



<!-- ================= REALISTIC SCHOOL MANAGEMENT UI ================= -->
<div x-data="{ sidebarOpen: true, currentTime: new Date().toLocaleTimeString() }" class="flex min-h-screen bg-slate-50" x-init="setInterval(() => currentTime = new Date().toLocaleTimeString(), 1000)">

    <!-- Professional Sidebar -->
    <aside 
        :class="sidebarOpen ? 'w-72' : 'w-20'" 
        class="fixed left-0 top-0 h-screen bg-white/95 backdrop-blur-xl border-r border-slate-200/80 z-50 flex flex-col shadow-2xl shadow-slate-200/50 transition-all duration-500 ease-[cubic-bezier(0.4,0,0.2,1)]"
    >
        <!-- School Brand Header -->
        <div class="h-20 border-b border-slate-100 flex items-center px-4 gap-3 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 animate-gradient relative overflow-hidden">
            <!-- Decorative circles -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-2xl"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-blue-400/20 rounded-full translate-y-1/2 -translate-x-1/2 blur-xl"></div>
            
            <button @click="sidebarOpen = !sidebarOpen" class="p-2.5 rounded-xl text-white/90 hover:text-white hover:bg-white/20 transition-all duration-300 relative z-10 btn-press">
                <i class="fas fa-bars text-lg"></i>
            </button>
            
            <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-[-10px]" x-transition:enter-end="opacity-100 translate-x-0" class="flex items-center gap-3 overflow-hidden relative z-10">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur-sm border border-white/30 shadow-lg">
                    <i class="fas fa-graduation-cap text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-white font-bold text-sm leading-tight tracking-tight">Tugawe Elementary</h1>
                    <p class="text-blue-200 text-xs font-medium tracking-wide">School Management</p>
                </div>
            </div>
        </div>

        <!-- User Profile Summary -->
        <div class="p-4 border-b border-slate-100 bg-gradient-to-b from-slate-50 to-white">
            <div class="flex items-center gap-3" x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300 delay-100" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                @php
                    $user = auth()->user();
                    $teacher = $user->teacher ?? null;
                    $fullName = trim(($teacher->first_name ?? $user->first_name ?? '') . ' ' . ($teacher->last_name ?? $user->last_name ?? ''));
                    $initials = strtoupper(substr($teacher->first_name ?? $user->first_name ?? 'T', 0, 1) . substr($teacher->last_name ?? $user->last_name ?? 'E', 0, 1));
                @endphp
                <div class="relative">
                    <img src="{{ $teacher && $teacher->photo ? asset('storage/'.$teacher->photo) : asset('images/photo-placeholder.png') }}" 
                         class="w-12 h-12 rounded-full object-cover ring-2 ring-white shadow-lg shadow-slate-200" alt="Profile">
                    <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-500 border-2 border-white rounded-full"></div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-slate-800 text-sm truncate">{{ $fullName ?: 'Teacher Name' }}</p>
                    <p class="text-xs text-slate-500 truncate font-medium">{{ $user->email ?? 'teacher@tugawe.edu.ph' }}</p>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-blue-100 text-blue-700 mt-1.5 border border-blue-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5 animate-pulse"></span>
                        Online
                    </span>
                </div>
            </div>
            
            <!-- Collapsed View -->
            <div x-show="!sidebarOpen" class="flex justify-center" x-transition>
                <div class="relative">
                    <img src="{{ $teacher && $teacher->photo ? asset('storage/'.$teacher->photo) : asset('images/photo-placeholder.png') }}" 
                         class="w-10 h-10 rounded-full object-cover ring-2 ring-white shadow-lg" alt="Profile">
                    <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-500 border-2 border-white rounded-full"></div>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 py-6 px-3 space-y-1 overflow-y-auto">
            <div class="px-3 mb-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider" x-show="sidebarOpen">Main Menu</div>
            
            <!-- Home -->
            <a href="{{ route('teacher.dashboard') }}"  
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-blue-50 text-blue-700 font-semibold transition-all duration-300 group relative overflow-hidden shadow-sm shadow-blue-100">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-100 to-blue-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center shadow-md shadow-blue-200 relative z-10">
                    <i class="fas fa-home text-sm"></i>
                </div>
                <span x-show="sidebarOpen" class="relative z-10 text-sm">Home</span>
            </a>

            <!-- Enroll Student -->
          <button @click="openEnrollModal()"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all duration-300 group btn-press">
                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 shadow-sm">
                    <i class="fas fa-user-plus text-sm"></i>
                </div>
                <span x-show="sidebarOpen" class="text-sm">Enroll Student</span>
            </button>

            <!-- Announcements -->
           <button @click="openAnnouncementModal()"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all duration-300 group btn-press">
                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 shadow-sm">
                    <i class="fas fa-bullhorn text-sm"></i>
                </div>
                <span x-show="sidebarOpen" class="text-sm">Announcements</span>
            </button>

            <!-- School Forms Dropdown -->
            <div x-data="{ schoolFormsOpen: false }" class="relative">
                <button @click="schoolFormsOpen = !schoolFormsOpen"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all duration-300 group btn-press">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 shadow-sm">
                        <i class="fas fa-file-alt text-sm"></i>
                    </div>
                    <span x-show="sidebarOpen" class="flex-1 text-left text-sm">School Forms</span>
                    <i x-show="sidebarOpen" 
                       :class="schoolFormsOpen ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"
                       class="text-xs text-slate-400 transition-transform duration-300"></i>
                </button>
                
                <!-- Dropdown Menu -->
                <div x-show="schoolFormsOpen && sidebarOpen" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform -translate-y-4 scale-95"
                     x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 transform -translate-y-4 scale-95"
                     class="ml-11 mt-2 space-y-1 bg-slate-50/50 rounded-xl p-2 border border-slate-100">
                    
                    <!-- SF1 -->
                    <a href="{{ route('teacher.school-forms.sf1') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-white hover:text-blue-700 hover:shadow-sm transition-all duration-200 group/item">
                        <span class="w-6 h-6 rounded-md bg-blue-100 text-blue-700 flex items-center justify-center text-[10px] font-bold group-hover/item:bg-blue-600 group-hover/item:text-white transition-colors">SF1</span>
                        <span class="font-medium">School Register</span>
                    </a>
                    
                    <!-- SF2 -->
                    <a href="{{ route('teacher.school-forms.sf2') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-white hover:text-blue-700 hover:shadow-sm transition-all duration-200 group/item">
                        <span class="w-6 h-6 rounded-md bg-blue-100 text-blue-700 flex items-center justify-center text-[10px] font-bold group-hover/item:bg-blue-600 group-hover/item:text-white transition-colors">SF2</span>
                        <span class="font-medium">Daily Attendance</span>
                    </a>
                    
                    <!-- SF4 -->
                    <a href="{{ route('teacher.school-forms.sf4') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-white hover:text-blue-700 hover:shadow-sm transition-all duration-200 group/item">
                        <span class="w-6 h-6 rounded-md bg-blue-100 text-blue-700 flex items-center justify-center text-[10px] font-bold group-hover/item:bg-blue-600 group-hover/item:text-white transition-colors">SF4</span>
                        <span class="font-medium">Monthly Attendance</span>
                    </a>
                    
                    <!-- SF5 -->
                    <a href="{{ route('teacher.school-forms.sf5') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-white hover:text-blue-700 hover:shadow-sm transition-all duration-200 group/item">
                        <span class="w-6 h-6 rounded-md bg-blue-100 text-blue-700 flex items-center justify-center text-[10px] font-bold group-hover/item:bg-blue-600 group-hover/item:text-white transition-colors">SF5</span>
                        <span class="font-medium">Report on Promotion</span>
                    </a>
                    
                    <!-- SF6 -->
                    <a href="{{ route('teacher.school-forms.sf6')}}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-white hover:text-blue-700 hover:shadow-sm transition-all duration-200 group/item">
                        <span class="w-6 h-6 rounded-md bg-blue-100 text-blue-700 flex items-center justify-center text-[10px] font-bold group-hover/item:bg-blue-600 group-hover/item:text-white transition-colors">SF6</span>
                        <span class="font-medium">Summarized Report</span>
                    </a>
                    
                    <!-- SF7 -->
                    <a href="{{ route('teacher.school-forms.sf7')}}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-white hover:text-blue-700 hover:shadow-sm transition-all duration-200 group/item">
                        <span class="w-6 h-6 rounded-md bg-blue-100 text-blue-700 flex items-center justify-center text-[10px] font-bold group-hover/item:bg-blue-600 group-hover/item:text-white transition-colors">SF7</span>
                        <span class="font-medium">School Personnel</span>
                    </a>
                    
                    <!-- SF8 -->
                    <a href="{{ route('teacher.school-forms.sf8')}}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-slate-600 hover:bg-white hover:text-blue-700 hover:shadow-sm transition-all duration-200 group/item">
                        <span class="w-6 h-6 rounded-md bg-blue-100 text-blue-700 flex items-center justify-center text-[10px] font-bold group-hover/item:bg-blue-600 group-hover/item:text-white transition-colors">SF8</span>
                        <span class="font-medium">Health/Nutrition</span>
                    </a>
                </div>
            </div>

            <!-- System Section -->
            <div class="mt-8 px-3 mb-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider" x-show="sidebarOpen">System</div>

            <!-- Profile Settings -->
            <button @click="openProfileModal()"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition-all duration-300 group btn-press">
                <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center group-hover:bg-slate-800 group-hover:text-white transition-all duration-300 shadow-sm">
                    <i class="fas fa-cog text-sm"></i>
                </div>
                <span x-show="sidebarOpen" class="text-sm">Profile Settings</span>
            </button>
        </nav>

        <!-- Footer Info -->
        <div class="p-4 border-t border-slate-100 bg-slate-50/80 backdrop-blur-sm">
            <div x-show="sidebarOpen" class="space-y-3">
                <div class="flex items-center justify-between text-xs text-slate-500 font-medium">
                    <span>Current Time</span>
                    <span class="font-mono text-slate-700 bg-white px-2 py-1 rounded-md border border-slate-200 shadow-sm" x-text="currentTime"></span>
                </div>
                <div class="flex items-center justify-between text-xs">
                    <span class="text-slate-500 font-medium">School Year</span>
                    <span class="font-bold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-md border border-blue-100 shadow-sm">{{ $activeSchoolYear->name ?? '2024-2025' }}</span>
                </div>
                <div class="flex items-center justify-between text-xs">
                    <span class="text-slate-500 font-medium">Quarter</span>
                    <span class="font-bold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-md border border-blue-100 shadow-sm">Q{{ $activeQuarter ?? '1' }}</span>
                </div>
            </div>
            
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="mt-4 flex items-center gap-3 px-3 py-2.5 rounded-xl text-rose-600 hover:bg-rose-50 font-semibold transition-all duration-300 text-sm group btn-press border border-transparent hover:border-rose-100">
                <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center group-hover:bg-rose-600 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-sign-out-alt text-sm"></i>
                </div>
                <span x-show="sidebarOpen">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
    </aside>


<div class="flex-1 transition-all duration-500 ease-in-out" :class="sidebarOpen ? 'ml-72' : 'ml-20'">
    
    <!-- Enhanced Header with Glassmorphism -->
    <header class="h-20 bg-white/80 backdrop-blur-xl border-b border-gray-200/50 flex items-center justify-between px-8 sticky top-0 z-40 shadow-sm">
        <div class="flex items-center gap-4">

            <div>
                <h1 class="text-xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">Teacher Dashboard</h1>
                <p class="text-xs text-gray-500 font-medium">Tugawe Elementary School</p>
            </div>
        </div>

        <div x-show="sidebarOpen" class="px-6 py-3 bg-gray-50/80 rounded-2xl border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <img src="{{ asset('images/logo.png') }}" class="h-10 w-10 rounded-full ring-2 ring-blue-300 shadow-md object-cover">
                    <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                </div>
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
                    <p class="text-xs text-gray-500 truncate font-medium">Teacher</p>
                </div>
            </div>
        </div>
    </header>

    <div class="p-8 max-w-7xl mx-auto">

        @if($sections->isEmpty())
            <!-- Enhanced Empty State -->
            <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 p-12 text-center border border-gray-100">
                <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-inner">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">No Sections Assigned</h3>
                <p class="text-gray-500 max-w-sm mx-auto">You are not assigned to any section yet. Please contact the school administrator.</p>
            </div>
        @endif

        <div class="space-y-10">
            @foreach($sections as $section)

            <!-- Enhanced Section Card -->
            <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden group hover:shadow-2xl hover:shadow-gray-200/60 transition-all duration-500">

                <!-- Enhanced Section Header -->
                <div class="bg-gradient-to-r from-cyan-600 via-blue-600 to-indigo-600 text-white p-8 relative overflow-hidden">
                    <!-- Decorative Elements -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2 blur-2xl"></div>
                    
                    <div class="relative flex flex-col md:flex-row md:justify-between md:items-center gap-6">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <span class="px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm text-xs font-semibold border border-white/30">
                                    {{ $section->schoolYear?->name ?? 'Current Year' }}
                                </span>
                            </div>
                            <h2 class="text-3xl font-bold tracking-tight">
                                {{ $section->year_level }} - {{ $section->name }}
                            </h2>
                        </div>

                        <div class="flex gap-3 flex-wrap">
                            <a href="{{ route('teacher.attendance', $section->id) }}"
                               class="group/btn bg-white/10 hover:bg-white backdrop-blur-sm text-white hover:text-blue-600 font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-black/10 hover:shadow-xl transition-all duration-300 flex items-center gap-2 border border-white/20">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                                Attendance
                            </a>

                            <a href="{{ route('teacher.grades', $section->id) }}"
                               class="group/btn bg-white/10 hover:bg-white backdrop-blur-sm text-white hover:text-blue-600 font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-black/10 hover:shadow-xl transition-all duration-300 flex items-center gap-2 border border-white/20">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Grades
                            </a>

                            <a href="{{ route('teacher.quizzes', $section) }}"
                               class="group/btn bg-white hover:bg-gray-50 text-blue-600 font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-white/25 hover:shadow-xl hover:shadow-white/30 transition-all duration-300 flex items-center gap-2 transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                                Quizzes
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 p-6 bg-gradient-to-b from-gray-50 to-white">
                    <div class="bg-white rounded-2xl p-6 shadow-lg shadow-gray-200/50 border border-gray-100 text-center relative group/card hover:shadow-xl hover:shadow-gray-200/60 transition-all duration-300 hover:-translate-y-1">
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg shadow-blue-500/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500 font-medium mt-8 mb-1">Total Students</p>
                        <p class="text-4xl font-bold text-gray-900 bg-gradient-to-br from-gray-900 to-gray-600 bg-clip-text text-transparent">
                            {{ $section->students->count() }}
                        </p>

                        <!-- Enhanced Unenroll All Button -->
                        <form action="{{ route('teacher.sections.unenrollAll', $section->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to unenroll all students in this section?')"
                              class="mt-4">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                    class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-red-500/25 hover:shadow-xl hover:shadow-red-500/30 transition-all duration-300 flex items-center justify-center gap-2 group/btn">
                                <svg class="w-4 h-4 group-hover/btn:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Unenroll All
                            </button>
                        </form>
                    </div>

                    
                </div>

                <!-- STUDENTS (SIDE BY SIDE) -->
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                        {{-- ================= MALE STUDENTS ================= --}}
                        <div class="bg-white rounded-2xl border border-blue-100 shadow-lg shadow-blue-100/50 flex flex-col overflow-hidden">
                            <!-- Enhanced Card Header -->
                            <div class="bg-gradient-to-r from-blue-50 to-blue-100/50 px-6 py-5 border-b border-blue-100">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-blue-500 shadow-lg shadow-blue-500/30 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-blue-900">Male Students</h3>
                                    </div>
                                    <span class="text-sm bg-blue-500 text-white px-4 py-1.5 rounded-full font-semibold shadow-md shadow-blue-500/20">
                                        {{ $section->students->where('sex','Male')->count() }}
                                    </span>
                                </div>
                            </div>

                            <!-- Enhanced Table -->
                            <div class="overflow-auto flex-1 max-h-[500px]">
                                <table class="min-w-full text-sm">
                                    <tbody class="divide-y divide-gray-100">

                                        @php
                                            $maleStudents = $section->students
                                                ->where('sex', 'Male')
                                                ->sortBy(function($student) {
                                                    return $student->last_name . ' ' . $student->first_name;
                                                });
                                        @endphp

                                        @forelse($maleStudents as $index => $student)
                                            <tr class="hover:bg-blue-50/50 transition-all duration-200 group">

                                                <td class="px-4 py-4 text-gray-400 w-12 font-semibold text-center">
                                                    {{ $index + 1 }}
                                                </td>

                                                <td class="px-4 py-4">
                                                    <div class="flex items-center gap-4">
                                                        <div class="relative">
                                                            <img
                                                                src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/photo-placeholder.png') }}"
                                                                class="w-12 h-12 rounded-full object-cover ring-2 ring-white shadow-md group-hover:scale-110 group-hover:shadow-lg transition-all duration-300">
                                                            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-blue-500 rounded-full border-2 border-white"></div>
                                                        </div>

                                                        <div>
                                                            <p class="font-bold text-gray-900 text-sm">
                                                                {{ $student->last_name }},
                                                                {{ $student->first_name }}
                                                                {{ $student->middle_name ? ' '.$student->middle_name[0].'.' : '' }}
                                                                {{ $student->suffix ? ' '.$student->suffix : '' }}
                                                            </p>
                                                            <p class="text-xs text-gray-500 font-mono tracking-wider mt-0.5">
                                                                {{ $student->school_id }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>

                                                <!-- Enhanced ACTION DROPDOWN -->
                                                <td class="px-4 py-4 text-right">
                                                    <div class="relative" x-data="{ open: false }">
                                                        <button 
                                                            @click="open = !open" 
                                                            @click.away="open = false"
                                                            class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-xl text-xs font-semibold shadow-lg shadow-gray-900/20 hover:shadow-xl hover:shadow-gray-900/30 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                                                            <span>Actions</span>
                                                            <svg class="w-4 h-4 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                            </svg>
                                                        </button>

                                                        <!-- Enhanced Dropdown Menu -->
                                                        <div 
                                                            x-show="open" 
                                                            x-transition:enter="transition ease-out duration-300"
                                                            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                            x-transition:leave="transition ease-in duration-200"
                                                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                                            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                                                            class="absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-2xl shadow-gray-900/20 border border-gray-100 z-50 overflow-hidden max-h-96 overflow-y-auto"
                                                            style="display: none;">
                                                            
                                                            <!-- SF Forms Group -->
                                                            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider sticky top-0 z-10 border-b border-gray-200">
                                                                School Forms (SF1-SF10)
                                                            </div>
                                                            
                                                            <div class="p-2 space-y-1">
                                                                <a href="{{ route('teacher.school-forms.sf3', $student->id) }}" class="flex items-center gap-3 px-3 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-xl transition-all duration-200 group/item">
                                                                    <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-100 to-blue-200 text-blue-700 flex items-center justify-center text-xs font-bold shadow-sm">3</span>
                                                                    <span class="font-medium truncate">SF3 - Books Issued/Returned</span>
                                                                    <svg class="w-4 h-4 ml-auto opacity-0 group-hover/item:opacity-100 transition-opacity text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                                    </svg>
                                                                </a>

                                                                <a href="{{ route('teacher.school-forms.sf9', $student->id) }}" class="flex items-center gap-3 px-3 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-xl transition-all duration-200 group/item">
                                                                    <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-100 to-blue-200 text-blue-700 flex items-center justify-center text-xs font-bold shadow-sm">9</span>
                                                                    <span class="font-medium truncate">SF9 - Progress Report Card</span>
                                                                    <svg class="w-4 h-4 ml-auto opacity-0 group-hover/item:opacity-100 transition-opacity text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                                    </svg>
                                                                </a>
                                                                
                                                                <a href="{{ route('teacher.school-forms.sf10', $student->id) }}" class="flex items-center gap-3 px-3 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-xl transition-all duration-200 group/item">
                                                                    <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-100 to-blue-200 text-blue-700 flex items-center justify-center text-xs font-bold shadow-sm">10</span>
                                                                    <span class="font-medium truncate">SF10 - Permanent Academic Record</span>
                                                                    <svg class="w-4 h-4 ml-auto opacity-0 group-hover/item:opacity-100 transition-opacity text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                                    </svg>
                                                                </a>
                                                            </div>

                                                            <!-- Divider -->
                                                            <div class="border-t border-gray-200 my-1"></div>

                                                            <!-- Unenroll Action -->
                                                            <div class="p-2">
                                                                <form action="{{ route('teacher.students.unenroll', $student->id) }}" method="POST" onsubmit="return confirm('Unenroll {{ $student->first_name }} {{ $student->last_name }}? This action cannot be undone.')">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-3 text-sm text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200 text-left group/item">
                                                                        <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center">
                                                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                                            </svg>
                                                                        </div>
                                                                        <span class="font-medium">Unenroll Student</span>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center py-12">
                                                    <div class="flex flex-col items-center gap-3">
                                                        <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center">
                                                            <svg class="w-8 h-8 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                            </svg>
                                                        </div>
                                                        <span class="text-gray-500 font-medium">No male students enrolled</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- ================= FEMALE STUDENTS ================= --}}
                        <div class="bg-white rounded-2xl border border-pink-100 shadow-lg shadow-pink-100/50 flex flex-col overflow-hidden">
                            <!-- Enhanced Card Header -->
                            <div class="bg-gradient-to-r from-pink-50 to-pink-100/50 px-6 py-5 border-b border-pink-100">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-pink-500 shadow-lg shadow-pink-500/30 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-pink-900">Female Students</h3>
                                    </div>
                                    <span class="text-sm bg-pink-500 text-white px-4 py-1.5 rounded-full font-semibold shadow-md shadow-pink-500/20">
                                        {{ $section->students->where('sex','Female')->count() }}
                                    </span>
                                </div>
                            </div>

                            <!-- Enhanced Table -->
                            <div class="overflow-auto flex-1 max-h-[500px]">
                                <table class="min-w-full text-sm">
                                    <tbody class="divide-y divide-gray-100">

                                        @php
                                            $femaleStudents = $section->students
                                                ->where('sex', 'Female')
                                                ->sortBy(function($student) {
                                                    return $student->last_name . ' ' . $student->first_name;
                                                });
                                        @endphp

                                        @forelse($femaleStudents as $index => $student)
                                            <tr class="hover:bg-pink-50/50 transition-all duration-200 group">

                                                <td class="px-4 py-4 text-gray-400 w-12 font-semibold text-center">
                                                    {{ $index + 1 }}
                                                </td>

                                                <td class="px-4 py-4">
                                                    <div class="flex items-center gap-4">
                                                        <div class="relative">
                                                            <img
                                                                src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/photo-placeholder.png') }}"
                                                                class="w-12 h-12 rounded-full object-cover ring-2 ring-white shadow-md group-hover:scale-110 group-hover:shadow-lg transition-all duration-300">
                                                            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-pink-500 rounded-full border-2 border-white"></div>
                                                        </div>

                                                        <div>
                                                            <p class="font-bold text-gray-900 text-sm">
                                                                {{ $student->last_name }},
                                                                {{ $student->first_name }}
                                                                {{ $student->middle_name ? ' '.$student->middle_name[0].'.' : '' }}
                                                                {{ $student->suffix ? ' '.$student->suffix : '' }}
                                                            </p>
                                                            <p class="text-xs text-gray-500 font-mono tracking-wider mt-0.5">
                                                                {{ $student->school_id }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>

                                                <!-- Enhanced ACTION DROPDOWN -->
                                                <td class="px-4 py-4 text-right">
                                                    <div class="relative" x-data="{ open: false }">
                                                        <button 
                                                            @click="open = !open" 
                                                            @click.away="open = false"
                                                            class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-xl text-xs font-semibold shadow-lg shadow-gray-900/20 hover:shadow-xl hover:shadow-gray-900/30 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                                                            <span>Actions</span>
                                                            <svg class="w-4 h-4 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                            </svg>
                                                        </button>

                                                        <!-- Enhanced Dropdown Menu -->
                                                        <div 
                                                            x-show="open" 
                                                            x-transition:enter="transition ease-out duration-300"
                                                            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                            x-transition:leave="transition ease-in duration-200"
                                                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                                            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                                                            class="absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-2xl shadow-gray-900/20 border border-gray-100 z-50 overflow-hidden max-h-96 overflow-y-auto"
                                                            style="display: none;">
                                                            
                                                            <!-- SF Forms Group -->
                                                            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider sticky top-0 z-10 border-b border-gray-200">
                                                                School Forms (SF1-SF10)
                                                            </div>
                                                            
                                                            <div class="p-2 space-y-1">
                                                                <a href="{{ route('teacher.school-forms.sf3', $student->id) }}" class="flex items-center gap-3 px-3 py-3 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-700 rounded-xl transition-all duration-200 group/item">
                                                                    <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-pink-100 to-pink-200 text-pink-700 flex items-center justify-center text-xs font-bold shadow-sm">3</span>
                                                                    <span class="font-medium truncate">SF3 - Books Issued/Returned</span>
                                                                    <svg class="w-4 h-4 ml-auto opacity-0 group-hover/item:opacity-100 transition-opacity text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                                    </svg>
                                                                </a>

                                                                <a href="{{ route('teacher.school-forms.sf9', $student->id) }}" class="flex items-center gap-3 px-3 py-3 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-700 rounded-xl transition-all duration-200 group/item">
                                                                    <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-pink-100 to-pink-200 text-pink-700 flex items-center justify-center text-xs font-bold shadow-sm">9</span>
                                                                    <span class="font-medium truncate">SF9 - Progress Report Card</span>
                                                                    <svg class="w-4 h-4 ml-auto opacity-0 group-hover/item:opacity-100 transition-opacity text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                                    </svg>
                                                                </a>
                                                                
                                                                <a href="{{ route('teacher.school-forms.sf10', $student->id) }}" class="flex items-center gap-3 px-3 py-3 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-700 rounded-xl transition-all duration-200 group/item">
                                                                    <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-pink-100 to-pink-200 text-pink-700 flex items-center justify-center text-xs font-bold shadow-sm">10</span>
                                                                    <span class="font-medium truncate">SF10 - Permanent Academic Record</span>
                                                                    <svg class="w-4 h-4 ml-auto opacity-0 group-hover/item:opacity-100 transition-opacity text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                                    </svg>
                                                                </a>
                                                            </div>

                                                            <!-- Divider -->
                                                            <div class="border-t border-gray-200 my-1"></div>

                                                            <!-- Unenroll Action -->
                                                            <div class="p-2">
                                                                <form action="{{ route('teacher.students.unenroll', $student->id) }}" method="POST" onsubmit="return confirm('Unenroll {{ $student->first_name }} {{ $student->last_name }}? This action cannot be undone.')">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-3 text-sm text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200 text-left group/item">
                                                                        <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center">
                                                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                                            </svg>
                                                                        </div>
                                                                        <span class="font-medium">Unenroll Student</span>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center py-12">
                                                    <div class="flex flex-col items-center gap-3">
                                                        <div class="w-16 h-16 bg-pink-50 rounded-2xl flex items-center justify-center">
                                                            <svg class="w-8 h-8 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                            </svg>
                                                        </div>
                                                        <span class="text-gray-500 font-medium">No female students enrolled</span>
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

            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Enhanced ENROLL STUDENT MODAL -->
<div id="enrollStudentModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-3xl shadow-2xl shadow-black/20 w-full max-w-lg relative mx-auto my-auto transform scale-95 opacity-0 transition-all duration-300" id="enrollModalContent">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6 rounded-t-3xl">
            <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                Enroll Student
            </h2>
        </div>

        <form method="POST" action="{{ route('teacher.students.enroll') }}" class="p-6 space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Select Student</label>
                <div class="relative">
                    <select name="student_id" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 outline-none transition-all appearance-none bg-gray-50">
                        <option value="">-- Choose Student --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">
                                {{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name ? ' '.$student->middle_name[0].'.' : '' }} {{ $student->suffix ? ' '.$student->suffix : '' }} ({{ $student->school_id }})    
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Select Section</label>
                <div class="relative">
                    <select name="section_id" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 outline-none transition-all appearance-none bg-gray-50">
                        <option value="">-- Choose Section --</option>
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}">{{ $section->year_level }} - {{ $section->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeEnrollModal()"
                        class="px-6 py-2.5 rounded-xl text-gray-700 hover:bg-gray-100 font-semibold transition-all">Cancel</button>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl font-semibold shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:shadow-indigo-500/40 transition-all transform hover:-translate-y-0.5">Enroll</button>
            </div>
        </form>

        <button onclick="closeEnrollModal()" class="absolute top-4 right-4 w-8 h-8 bg-white/20 hover:bg-white/30 rounded-lg flex items-center justify-center text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>

<script>
function openEnrollModal() {
    const modal = document.getElementById('enrollStudentModal');
    const content = document.getElementById('enrollModalContent');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeEnrollModal() {
    const modal = document.getElementById('enrollStudentModal');
    const content = document.getElementById('enrollModalContent');
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}
</script>

<!-- Enhanced ANNOUNCEMENT MODAL -->
<div id="announcementModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-3xl rounded-3xl shadow-2xl shadow-black/20 relative transform scale-95 opacity-0 transition-all duration-300 max-h-[90vh] overflow-hidden flex flex-col" id="announcementModalContent">
        
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6 flex items-center justify-between flex-shrink-0">
            <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                    </svg>
                </div>
                Announcements
            </h2>
            <button onclick="closeAnnouncementModal()" class="w-8 h-8 bg-white/20 hover:bg-white/30 rounded-lg flex items-center justify-center text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="overflow-y-auto p-6 space-y-6">
            <!-- Enhanced Form -->
            <form action="{{ route('teacher.announcements.store') }}" method="POST" class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-6 border border-indigo-100">
                @csrf
                
                <!-- Header -->
                <h3 class="text-sm font-bold text-indigo-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 bg-indigo-600 rounded-full"></span>
                    Create New Announcement
                </h3>

                <!-- Title & Urgency Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" placeholder="Enter announcement title..." required
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 outline-none transition-all bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Priority</label>
                        <div class="flex items-center gap-3 p-3 bg-white rounded-xl border border-gray-200">
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <div class="relative">
                                    <input type="checkbox" name="is_urgent" value="1" class="peer sr-only">
                                    <div class="w-10 h-6 bg-gray-200 rounded-full peer peer-checked:bg-red-500 transition-colors"></div>
                                    <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-4"></div>
                                </div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-red-600 transition-colors">Urgent</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Content <span class="text-red-500">*</span></label>
                    <textarea name="content" rows="4" placeholder="Write your announcement details here..." required
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 outline-none transition-all resize-none bg-white"></textarea>
                </div>

                <!-- Target Audience & Grade Level Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Target Audience</label>
                        <div class="relative">
                            <select name="target_audience" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 outline-none transition-all appearance-none bg-white pr-10">
                                <option value="all">All Users</option>
                                <option value="students">Students Only</option>
                                <option value="parents">Parents Only</option>
                                <option value="teachers">Teachers Only</option>
                                <option value="admin">Administrators Only</option>
                                <option value="specific_section">Specific Section</option>
                            </select>
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Grade Level</label>
                        <div class="relative">
                            <select name="grade_level"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 outline-none transition-all appearance-none bg-white pr-10">
                                <option value="">All Grade Levels</option>
                                <option value="kinder">Kindergarten</option>
                                <option value="grade_1">Grade 1</option>
                                <option value="grade_2">Grade 2</option>
                                <option value="grade_3">Grade 3</option>
                                <option value="grade_4">Grade 4</option>
                                <option value="grade_5">Grade 5</option>
                                <option value="grade_6">Grade 6</option>
                            </select>
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Selection (shown when target_audience is specific_section) -->
                <div class="mb-4" x-data="{ showSection: false }" x-init="$watch('showSection', value => {
                    const targetSelect = document.querySelector('select[name=target_audience]');
                    targetSelect.addEventListener('change', (e) => {
                        showSection = e.target.value === 'specific_section';
                    });
                })">
                    <div x-show="showSection" x-transition class="p-4 bg-indigo-100/50 rounded-xl border border-indigo-200">
                        <label class="block text-xs font-bold text-indigo-900 uppercase tracking-wider mb-1.5">Select Section</label>
                        <div class="relative">
                            <select name="section_id"
                                    class="w-full px-4 py-3 rounded-xl border border-indigo-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 outline-none transition-all appearance-none bg-white pr-10">
                                <option value="">-- Choose Section --</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->year_level }} - {{ $section->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Type & Pin Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Announcement Type</label>
                        <div class="flex gap-2 p-1 bg-white rounded-xl border border-gray-200">
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="type" value="admin" class="peer sr-only" checked>
                                <div class="text-center py-2 rounded-lg text-sm font-medium text-gray-600 peer-checked:bg-indigo-600 peer-checked:text-white transition-all">
                                    Official
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="type" value="teacher" class="peer sr-only">
                                <div class="text-center py-2 rounded-lg text-sm font-medium text-gray-600 peer-checked:bg-purple-600 peer-checked:text-white transition-all">
                                    Teacher Note
                                </div>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Pin to Top</label>
                        <div class="flex items-center gap-3 p-3 bg-white rounded-xl border border-gray-200 h-[46px]">
                            <label class="flex items-center gap-2 cursor-pointer group w-full">
                                <div class="relative">
                                    <input type="checkbox" name="is_pinned" value="1" class="peer sr-only">
                                    <div class="w-10 h-6 bg-gray-200 rounded-full peer peer-checked:bg-amber-500 transition-colors"></div>
                                    <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-4"></div>
                                </div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-amber-600 transition-colors flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path>
                                    </svg>
                                    Pin this announcement
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl font-semibold shadow-lg shadow-indigo-500/30 hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Post Announcement
                </button>
            </form>

            <!-- Enhanced List -->
            <div class="space-y-3">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                    <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                    Recent Announcements
                </h3>
                
                @forelse($announcements as $announcement)
                <div x-data="{ editing: false, expanded: false }" 
                     class="bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden"
                     :class="{ 'ring-2 ring-amber-400': {{ $announcement->is_pinned ? 'true' : 'false' }}, 'ring-2 ring-red-400': {{ $announcement->is_urgent ? 'true' : 'false' }} }">
                    
                    <!-- Announcement Header -->
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center gap-2 flex-wrap">
                                <!-- Pinned Badge -->
                                @if($announcement->is_pinned)
                                <span class="px-2 py-0.5 bg-amber-100 text-amber-700 rounded-md text-xs font-bold flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path>
                                    </svg>
                                    PINNED
                                </span>
                                @endif
                                
                                <!-- Urgent Badge -->
                                @if($announcement->is_urgent)
                                <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded-md text-xs font-bold flex items-center gap-1 animate-pulse">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    URGENT
                                </span>
                                @endif
                                
                                <!-- Type Badge -->
                                <span class="px-2 py-0.5 {{ $announcement->type === 'admin' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }} rounded-md text-xs font-bold uppercase">
                                    {{ $announcement->type }}
                                </span>
                            </div>
                            
                            <div class="flex items-center gap-1">
                                <button @click="editing = true" class="text-indigo-600 hover:text-indigo-700 text-sm font-semibold px-3 py-1 rounded-lg hover:bg-indigo-50 transition-colors">Edit</button>
                                <form action="{{ route('teacher.announcements.destroy', $announcement->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this announcement?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600 text-sm font-semibold px-2 py-1 rounded-lg hover:bg-red-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <h4 class="font-bold text-gray-900 text-lg mb-1">{{ $announcement->title }}</h4>
                        
                        <!-- Meta Info -->
                        <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500 mb-3">
                            <span class="px-2 py-1 bg-gray-100 rounded-lg flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ $announcement->user->name ?? 'Unknown' }}
                            </span>
                            <span>•</span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $announcement->created_at->format('M d, Y h:i A') }}
                            </span>
                            @if($announcement->target_audience !== 'all')
                            <span>•</span>
                            <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 rounded border border-indigo-100">
                                {{ ucwords(str_replace('_', ' ', $announcement->target_audience)) }}
                            </span>
                            @endif
                            @if($announcement->grade_level)
                            <span>•</span>
                            <span class="px-2 py-0.5 bg-green-50 text-green-600 rounded border border-green-100">
                                {{ ucwords(str_replace('_', ' ', $announcement->grade_level)) }}
                            </span>
                            @endif
                        </div>
                        
                        <p class="text-gray-600 leading-relaxed" :class="expanded ? '' : 'line-clamp-3'">{{ $announcement->content }}</p>
                        
                        @if(strlen($announcement->content) > 150)
                        <button @click="expanded = !expanded" class="mt-2 text-indigo-600 hover:text-indigo-700 text-sm font-medium flex items-center gap-1">
                            <span x-text="expanded ? 'Show less' : 'Read more'"></span>
                            <svg class="w-4 h-4 transition-transform" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        @endif
                    </div>
                    
                    <!-- Edit Mode -->
                    <div x-show="editing" class="p-5 bg-gray-50 border-t border-gray-100 space-y-3" x-cloak>
                        <input type="text" x-ref="title" value="{{ $announcement->title }}" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-indigo-500 outline-none font-semibold">
                        <textarea x-ref="content" rows="4" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-indigo-500 outline-none resize-none">{{ $announcement->content }}</textarea>
                        
                        <div class="grid grid-cols-2 gap-3">
                            <select x-ref="target_audience" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm">
                                <option value="all" {{ $announcement->target_audience == 'all' ? 'selected' : '' }}>All Users</option>
                                <option value="students" {{ $announcement->target_audience == 'students' ? 'selected' : '' }}>Students</option>
                                <option value="parents" {{ $announcement->target_audience == 'parents' ? 'selected' : '' }}>Parents</option>
                                <option value="teachers" {{ $announcement->target_audience == 'teachers' ? 'selected' : '' }}>Teachers</option>
                            </select>
                            <select x-ref="grade_level" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm">
                                <option value="">All Grades</option>
                                <option value="kinder" {{ $announcement->grade_level == 'kinder' ? 'selected' : '' }}>Kinder</option>
                                <option value="grade_1" {{ $announcement->grade_level == 'grade_1' ? 'selected' : '' }}>Grade 1</option>
                                <option value="grade_2" {{ $announcement->grade_level == 'grade_2' ? 'selected' : '' }}>Grade 2</option>
                                <option value="grade_3" {{ $announcement->grade_level == 'grade_3' ? 'selected' : '' }}>Grade 3</option>
                                <option value="grade_4" {{ $announcement->grade_level == 'grade_4' ? 'selected' : '' }}>Grade 4</option>
                                <option value="grade_5" {{ $announcement->grade_level == 'grade_5' ? 'selected' : '' }}>Grade 5</option>
                                <option value="grade_6" {{ $announcement->grade_level == 'grade_6' ? 'selected' : '' }}>Grade 6</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" x-ref="is_urgent" {{ $announcement->is_urgent ? 'checked' : '' }} class="w-4 h-4 text-red-600 rounded">
                                <span class="text-sm text-gray-700">Mark as urgent</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" x-ref="is_pinned" {{ $announcement->is_pinned ? 'checked' : '' }} class="w-4 h-4 text-amber-500 rounded">
                                <span class="text-sm text-gray-700">Pin to top</span>
                            </label>
                        </div>
                        
                        <div class="flex gap-2 pt-2">
                            <button @click="updateAnnouncement({{ $announcement->id }}, {
                                title: $refs.title.value, 
                                content: $refs.content.value,
                                target_audience: $refs.target_audience.value,
                                grade_level: $refs.grade_level.value,
                                is_urgent: $refs.is_urgent.checked ? 1 : 0,
                                is_pinned: $refs.is_pinned.checked ? 1 : 0
                            }); editing = false" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-colors">Save Changes</button>
                            <button @click="editing = false" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-300 transition-colors">Cancel</button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 bg-gray-50 rounded-2xl border border-gray-200 border-dashed">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                    </svg>
                    <p class="text-gray-500 font-medium">No announcements yet</p>
                    <p class="text-gray-400 text-sm">Create your first announcement above</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
function openAnnouncementModal() {
    const modal = document.getElementById('announcementModal');
    const content = document.getElementById('announcementModalContent');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeAnnouncementModal() {
    const modal = document.getElementById('announcementModal');
    const content = document.getElementById('announcementModalContent');
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}

// Enhanced update function to handle all fields
function updateAnnouncement(id, data) {
    // If data is an object (from edit form), use it directly
    const payload = typeof data === 'object' ? data : { title: arguments[1], content: arguments[2] };
    
    fetch(`/teacher/announcements/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || '{{ csrf_token() }}'
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            alert('Failed to update announcement');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        window.location.reload(); // Fallback to reload on error
    });
}

// Close modal on backdrop click
document.getElementById('announcementModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAnnouncementModal();
    }
});
</script>

<!-- Enhanced PROFILE MODAL -->
<div id="profileModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-3xl shadow-2xl shadow-black/20 w-full max-w-2xl max-h-[90vh] overflow-y-auto transform scale-95 opacity-0 transition-all duration-300" id="profileModalContent" x-data="{ editMode: false }">
        @php $teacher = auth()->user()->teacher; @endphp
        
        <div class="bg-gradient-to-r from-slate-800 to-slate-900 px-8 py-6 sticky top-0 z-10">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    My Profile
                </h2>
                <button onclick="closeProfileModal()" class="w-8 h-8 bg-white/10 hover:bg-white/20 rounded-lg flex items-center justify-center text-white transition-colors border border-white/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            @method('PATCH')
            
            <!-- Enhanced Photo -->
            <div class="flex items-center gap-6">
                <div class="relative group">
                    <img src="{{ $teacher && $teacher->photo ? asset('storage/'.$teacher->photo) : asset('images/photo-placeholder.png') }}" 
                         class="w-28 h-28 rounded-2xl object-cover shadow-xl ring-4 ring-gray-100">
                    <div x-show="editMode" class="absolute inset-0 bg-black/50 rounded-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer" style="display: none;">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <input type="file" name="photo" class="hidden" x-show="editMode">
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">{{ $teacher->first_name ?? '' }} {{ $teacher->last_name ?? '' }}</h3>
                    <p class="text-gray-500">Teacher at Tugawe Elementary School</p>
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold mt-2">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                        Active
                    </span>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">First Name</label>
                    <input type="text" name="first_name" value="{{ $teacher->first_name ?? '' }}" :disabled="!editMode"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 disabled:bg-gray-100 disabled:text-gray-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 outline-none transition-all font-medium">
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Middle Name</label>
                    <input type="text" name="middle_name" value="{{ $teacher->middle_name ?? '' }}" :disabled="!editMode"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 disabled:bg-gray-100 disabled:text-gray-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 outline-none transition-all font-medium">
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Last Name</label>
                    <input type="text" name="last_name" value="{{ $teacher->last_name ?? '' }}" :disabled="!editMode"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 disabled:bg-gray-100 disabled:text-gray-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 outline-none transition-all font-medium">
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Suffix</label>
                    <input type="text" name="suffix" value="{{ $teacher->suffix ?? '' }}" :disabled="!editMode"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 disabled:bg-gray-100 disabled:text-gray-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 outline-none transition-all font-medium">
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Birthday</label>
                    <input type="date" name="birthday" value="{{ $teacher->birthday ?? '' }}" :disabled="!editMode"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 disabled:bg-gray-100 disabled:text-gray-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 outline-none transition-all font-medium">
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Username</label>
                    <input type="text" name="username" value="{{ auth()->user()->username }}" :disabled="!editMode"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 disabled:bg-gray-100 disabled:text-gray-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 outline-none transition-all font-medium">
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Contact Number</label>
                    <input type="text" name="contact_number" value="{{ $teacher->contact_number ?? '' }}" :disabled="!editMode"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 disabled:bg-gray-100 disabled:text-gray-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 outline-none transition-all font-medium">
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Email</label>
                    <input type="email" value="{{ auth()->user()->email }}" disabled
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-200 text-gray-500 cursor-not-allowed font-medium">
                </div>
            </div>
            
            <div x-show="editMode" class="space-y-1" style="display: none;">
                <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">New Password</label>
                <input type="password" name="password" placeholder="Leave blank to keep current password"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 outline-none transition-all">
            </div>
            
            <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                <button type="button" x-show="!editMode" @click="editMode = true"
                        class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl font-semibold shadow-lg shadow-indigo-500/30 hover:shadow-xl transition-all transform hover:-translate-y-0.5">Edit Profile</button>
                <button type="button" x-show="editMode" @click="editMode = false"
                        class="px-6 py-2.5 rounded-xl text-gray-700 hover:bg-gray-100 font-semibold transition-all" style="display: none;">Cancel</button>
                <button type="submit" x-show="editMode"
                        class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-xl font-semibold shadow-lg shadow-green-500/30 hover:shadow-xl transition-all transform hover:-translate-y-0.5" style="display: none;">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
function openProfileModal() {
    const modal = document.getElementById('profileModal');
    const content = document.getElementById('profileModalContent');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeProfileModal() {
    const modal = document.getElementById('profileModal');
    const content = document.getElementById('profileModalContent');
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}
</script>

<!-- Enhanced RE-ENROLL MODAL -->
<div id="reEnrollModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="bg-white rounded-3xl shadow-2xl shadow-black/20 w-full max-w-md transform scale-95 opacity-0 transition-all duration-300" id="reEnrollModalContent">
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 p-6 rounded-t-3xl">
            <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
                Re-Enroll Student
            </h2>
        </div>
        <form method="POST" action="{{ route('teacher.students.enroll') }}" class="p-6 space-y-5">
            @csrf
            <input type="hidden" name="student_id" id="reEnrollStudentId">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Select Section</label>
                <div class="relative">
                    <select name="section_id" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-4 focus:ring-green-500/20 outline-none transition-all appearance-none bg-gray-50">
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}">{{ $section->year_level }} - {{ $section->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeReEnrollModal()" class="px-6 py-2.5 rounded-xl text-gray-700 hover:bg-gray-100 font-semibold transition-all">Cancel</button>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-xl font-semibold shadow-lg shadow-green-500/30 hover:shadow-xl transition-all transform hover:-translate-y-0.5">Re-Enroll</button>
            </div>
        </form>
    </div>
</div>

<script>
function openReEnrollModal(studentId) {
    document.getElementById('reEnrollStudentId').value = studentId;
    const modal = document.getElementById('reEnrollModal');
    const content = document.getElementById('reEnrollModalContent');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeReEnrollModal() {
    const modal = document.getElementById('reEnrollModal');
    const content = document.getElementById('reEnrollModalContent');
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}
</script>

<!-- Enhanced Quiz Modal -->
<div id="quizModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 transition-all duration-300">
    
    <div class="bg-white rounded-3xl shadow-2xl shadow-black/20 w-full max-w-md transform scale-95 opacity-0 transition-all duration-300" id="quizModalContent">
        
        <!-- Enhanced Header -->
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-5 rounded-t-3xl">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-white flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    Record Quiz Score
                </h2>
                <button type="button" onclick="closeQuizModal()" class="w-8 h-8 bg-white/20 hover:bg-white/30 rounded-lg flex items-center justify-center text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        
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
