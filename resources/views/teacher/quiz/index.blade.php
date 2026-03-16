<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Manager - {{ $section->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    colors: {
                        primary: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                        },
                        success: {
                            50: '#f0fdf4',
                            500: '#22c55e',
                            600: '#16a34a',
                        },
                        warning: {
                            50: '#fffbeb',
                            500: '#f59e0b',
                            600: '#d97706',
                        },
                        danger: {
                            50: '#fef2f2',
                            500: '#ef4444',
                            600: '#dc2626',
                        }
                    },
                    boxShadow: {
                        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                        'glow': '0 0 20px rgba(99, 102, 241, 0.15)',
                    }
                }
            }
        }
    </script>

    <style>
        /* Base Styles */
        body { 
            font-family: 'Inter', system-ui, sans-serif;
            background: #f8fafc;
            color: #1e293b;
        }
        
        /* Smooth Scrolling */
        html { scroll-behavior: smooth; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { 
            background: #cbd5e1; 
            border-radius: 3px; 
        }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Modern Data Table */
        .data-table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }
        
        .data-table th {
            background: #f8fafc;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            padding: 0.875rem 1rem;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }
        
        .data-table td {
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.2s ease;
        }
        
        .data-table tbody tr:hover td {
            background: #f8fafc;
        }
        
        .data-table tbody tr:hover .sticky-col {
            background: #f1f5f9;
        }
        
        /* Sticky Column */
        .sticky-col {
            position: sticky;
            left: 0;
            z-index: 20;
            background: white;
            box-shadow: 4px 0 6px -1px rgba(0, 0, 0, 0.05);
        }
        
        /* Modern Input Fields */
        .input-modern {
            width: 100%;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            background: white;
        }
        
        .input-modern:hover { border-color: #cbd5e1; }
        .input-modern:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        
        /* Score Input Specific */
        .score-input {
            text-align: center;
            font-family: 'JetBrains Mono', monospace;
            font-weight: 500;
            max-width: 80px;
        }
        
        /* Modern Cards */
        .card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border: 1px solid #f1f5f9;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        /* Stat Cards */
        .stat-card {
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .stat-card:hover::before { opacity: 1; }
        
        /* Modern Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
        }
        
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 12px -1px rgba(79, 70, 229, 0.3);
        }
        
        .btn-secondary {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }
        
        .btn-secondary:hover {
            background: #e2e8f0;
            border-color: #cbd5e1;
        }
        
        .btn-ghost {
            background: transparent;
            color: #64748b;
        }
        
        .btn-ghost:hover {
            background: #f1f5f9;
            color: #475569;
        }
        
        /* Floating Action Button */
        .fab {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 50;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .fab-btn {
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .fab-btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            color: white;
        }
        
        .fab-btn-primary:hover {
            transform: scale(1.1) rotate(90deg);
            box-shadow: 0 20px 25px -5px rgba(79, 70, 229, 0.3);
        }
        
        .fab-btn-secondary {
            background: white;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }
        
        .fab-btn-secondary:hover {
            transform: scale(1.1);
            color: #4f46e5;
            border-color: #4f46e5;
        }
        
        /* Modal */
        .modal-backdrop {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
        }
        
        .modal-content {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            transform: scale(0.95);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .modal-active .modal-content {
            transform: scale(1);
            opacity: 1;
        }
        
        /* Success Toast */
        .toast {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            z-index: 100;
            animation: slideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        /* Grade Badges */
        .grade-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            font-family: 'JetBrains Mono', monospace;
        }
        
        .grade-high {
            background: #dcfce7;
            color: #166534;
        }
        
        .grade-medium {
            background: #fef3c7;
            color: #92400e;
        }
        
        .grade-low {
            background: #fee2e2;
            color: #991b1b;
        }
        
        /* Sidebar */
        .sidebar {
            background: white;
            border-right: 1px solid #e2e8f0;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.02);
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            color: #64748b;
            font-weight: 500;
            transition: all 0.2s ease;
            margin-bottom: 0.25rem;
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
        }
        
        .nav-item:hover {
            background: #f1f5f9;
            color: #475569;
        }
        
        .nav-item.active {
            background: #eef2ff;
            color: #4f46e5;
        }
        
        /* Avatar */
        .avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }
        
        .empty-state-icon {
            width: 5rem;
            height: 5rem;
            margin: 0 auto 1.5rem;
            background: #f1f5f9;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
        }
    </style>
</head>
<body class="antialiased">

    <!-- Success Toast -->
    @if(session('success'))
    <div id="successToast" class="toast">
        <div class="bg-white border-l-4 border-success-500 rounded-lg shadow-2xl p-4 flex items-start gap-3 max-w-sm">
            <div class="bg-success-50 rounded-full p-2 flex-shrink-0">
                <svg class="w-5 h-5 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div class="flex-1">
                <h4 class="font-semibold text-gray-900">Success</h4>
                <p class="text-sm text-gray-600 mt-1">{{ session('success') }}</p>
            </div>
            <button onclick="closeToast()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
    @endif

    <!-- Layout -->
    <div x-data="{ sidebarOpen: true }" class="flex min-h-screen">
        
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-72' : 'w-20'" 
               class="sidebar fixed left-0 top-0 h-screen z-40 flex flex-col transition-all duration-300">
            
            <!-- Brand -->
            <div class="h-16 flex items-center px-4 gap-3 border-b border-gray-100">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg hover:bg-gray-100 transition">
                    <i class="fas fa-bars text-gray-600"></i>
                </button>
                <div x-show="sidebarOpen" class="flex items-center gap-3" x-transition>
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary-600 to-primary-700 flex items-center justify-center text-white">
                        <i class="fas fa-graduation-cap text-sm"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-gray-900 text-sm">Tugawe Elementary</h1>
                        <p class="text-xs text-gray-500">School System</p>
                    </div>
                </div>
            </div>

            <!-- User -->
            <div class="p-4 border-b border-gray-100">
                <div class="flex items-center gap-3" x-show="sidebarOpen" x-transition>
                    @php
                        $user = auth()->user();
                        $teacher = $user->teacher ?? null;
                        $fullName = trim(($teacher->first_name ?? $user->first_name ?? '') . ' ' . ($teacher->last_name ?? $user->last_name ?? ''));
                        $initials = strtoupper(substr($teacher->first_name ?? $user->first_name ?? 'T', 0, 1) . substr($teacher->last_name ?? $user->last_name ?? 'E', 0, 1));
                    @endphp
                    <img src="{{ $teacher && $teacher->photo ? asset('storage/'.$teacher->photo) : asset('images/photo-placeholder.png') }}" 
                         class="w-10 h-10 rounded-full object-cover ring-2 ring-white shadow-sm" alt="">
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm text-gray-900 truncate">{{ $fullName ?: 'Teacher' }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $user->email ?? 'teacher@school.edu' }}</p>
                    </div>
                </div>
                <div x-show="!sidebarOpen" class="flex justify-center">
                    <div class="avatar">{{ $initials ?? 'T' }}</div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-3 overflow-y-auto">
                <div x-show="sidebarOpen" class="px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu</div>
                
                <a href="{{ route('teacher.dashboard') }}" class="nav-item active">
                    <i class="fas fa-home w-5 text-center"></i>
                    <span x-show="sidebarOpen">Home</span>
                </a>
                
                <!-- FIXED: Use onclick instead of Alpine dispatch -->
                <button type="button" onclick="openModal('enrollStudentModal')" class="nav-item">
                    <i class="fas fa-user-plus w-5 text-center text-blue-500"></i>
                    <span x-show="sidebarOpen">Enroll Student</span>
                </button>
                
                <button type="button" onclick="openModal('announcementModal')" class="nav-item">
                    <i class="fas fa-bullhorn w-5 text-center text-purple-500"></i>
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
                
                <div x-show="sidebarOpen" class="mt-6 px-3 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Settings</div>
                
                <button type="button" onclick="openModal('profileModal')" class="nav-item">
                    <i class="fas fa-cog w-5 text-center"></i>
                    <span x-show="sidebarOpen">Profile Settings</span>
                </button>
            </nav>

            <!-- Footer Info -->
        <div class="p-4 border-t border-gray-100 bg-gray-50">
    <div x-show="sidebarOpen" class="space-y-3">
        
        <!-- Live Clock -->
        <div class="flex items-center justify-between text-xs text-gray-500">
            <span>Current Time</span>
            <span class="font-mono font-medium text-gray-700" 
                  x-data="{ currentTime: new Date().toLocaleTimeString() }" 
                  x-init="setInterval(() => currentTime = new Date().toLocaleTimeString(), 1000)"
                  x-text="currentTime">
            </span>
        </div>
                <div class="flex items-center justify-between text-xs">
                    <span class="text-slate-500">School Year</span>
                    <span class="font-bold text-indigo-700 bg-indigo-50 px-2 py-1 rounded">{{ $activeSchoolYear->name ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center justify-between text-xs">
                    <span class="text-slate-500">Quarter</span>
                    <span class="font-bold text-emerald-700 bg-emerald-50 px-2 py-1 rounded">Q{{ $activeQuarter ?? 'N/A' }}</span>
                </div>
            </div>
                
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="mt-3 flex items-center gap-3 px-3 py-2 rounded-lg text-rose-600 hover:bg-rose-50 font-medium transition text-sm">
                    <i class="fas fa-sign-out-alt w-5 text-center"></i>
                    <span x-show="sidebarOpen">Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            </div>
        </aside>

        <!-- Main Content -->
        <main :class="sidebarOpen ? 'ml-72' : 'ml-20'" class="flex-1 p-6 lg:p-8 transition-all duration-300">
            
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                    <span>Dashboard</span>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span class="text-gray-900 font-medium">Quiz Manager</span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $section->name }}</h1>
                        <p class="text-gray-500 mt-1">{{ $section->code ?? 'Section ' . $section->id }} • Manage student quiz scores and track performance</p>
                    </div>

                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Students -->
                <div class="card stat-card p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Students</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $studentsWithStats->count() }}</p>
                            <p class="text-xs text-gray-400 mt-2">Enrolled in section</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Quizzes -->
                <div class="card stat-card p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Quizzes</p>
                            <p class="text-3xl font-bold text-gray-900">{{ count($quizTitles) }}</p>
                            <p class="text-xs text-gray-400 mt-2">Created this term</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600">
                            <i class="fas fa-clipboard-list text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Class Average -->
                <div class="card stat-card p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Class Average</p>
                            @php $totalAvg = $studentsWithStats->avg('quiz_stats.average'); @endphp
                            <p class="text-3xl font-bold {{ $totalAvg >= 75 ? 'text-success-600' : ($totalAvg >= 60 ? 'text-warning-600' : 'text-danger-600') }}">
                                {{ number_format($totalAvg, 1) }}%
                            </p>
                            <p class="text-xs text-gray-400 mt-2">Across all quizzes</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl {{ $totalAvg >= 75 ? 'bg-success-50 text-success-600' : ($totalAvg >= 60 ? 'bg-warning-50 text-warning-600' : 'bg-danger-50 text-danger-600') }} flex items-center justify-center">
                            <i class="fas fa-chart-line text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Passing Rate -->
                <div class="card stat-card p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Passing Rate</p>
                            @php
                                $passing = $studentsWithStats->where('quiz_stats.average', '>=', 75)->count();
                                $rate = $studentsWithStats->count() > 0 ? ($passing / $studentsWithStats->count()) * 100 : 0;
                            @endphp
                            <p class="text-3xl font-bold {{ $rate >= 75 ? 'text-success-600' : ($rate >= 60 ? 'text-warning-600' : 'text-danger-600') }}">
                                {{ number_format($rate, 1) }}%
                            </p>
                            <p class="text-xs text-gray-400 mt-2">Students passing (≥75%)</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl {{ $rate >= 75 ? 'bg-success-50 text-success-600' : ($rate >= 60 ? 'bg-warning-50 text-warning-600' : 'bg-danger-50 text-danger-600') }} flex items-center justify-center">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grade Sheet Card -->
            <div class="card overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-primary-50 flex items-center justify-center text-primary-600">
                            <i class="fas fa-table"></i>
                        </div>
                        <div>
                            <h2 class="font-semibold text-gray-900">Grade Sheet</h2>
                            <p class="text-sm text-gray-500">Click any score cell to edit • Auto-saves on change</p>
                        </div>
                    </div>
                   <!-- <div class="flex items-center gap-2">
                        <button class="btn btn-secondary text-sm">
                            <i class="fas fa-download"></i>
                            <span>Export</span>
                        </button>
                        <button class="btn btn-ghost text-sm">
                            <i class="fas fa-filter"></i>
                        </button>
                    </div> -->
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="sticky-col text-left">Student</th>
                                <th class="w-16 text-center">No.</th>
                                @forelse($quizTitles as $title)
                                    <th class="text-center min-w-[120px]">
                                        <div class="truncate max-w-[140px]" title="{{ $title }}">{{ $title }}</div>
                                    </th>
                                @empty
                                    <th class="text-center text-gray-400">No quizzes created yet</th>
                                @endforelse
                                <th class="text-center bg-gray-50/50">Total</th>
                                <th class="text-center bg-gray-50/50">Average</th>
                                <th class="text-center w-20">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($studentsWithStats as $index => $student)
                                <tr data-student-id="{{ $student->id }}">
                                    <td class="sticky-col bg-white">
                                        <div class="flex items-center gap-3">
                                            <div class="avatar w-8 h-8 text-xs">
                                                {{ strtoupper(substr($student->first_name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $student->name }}</div>
                                                <div class="text-xs text-gray-500">ID: {{ $student->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center text-gray-400 font-mono text-sm">{{ $index + 1 }}</td>

                                    @foreach($quizTitles as $title)
                                        @php $quiz = $student->quiz_lookup->get($title); @endphp
                                        <td class="text-center">
                                            @if($quiz)
                                                <div class="flex flex-col items-center gap-1">
                                                    <input type="number" 
                                                        class="input-modern score-input py-1.5"
                                                        value="{{ $quiz->score }}"
                                                        data-quiz-id="{{ $quiz->id }}"
                                                        onchange="updateScore(this, {{ $quiz->id }}, 'score')"
                                                        min="0" step="0.01">
                                                    <span class="text-xs text-gray-400 font-mono">/ {{ $quiz->total_score }}</span>
                                                </div>
                                            @else
                                                <span class="text-gray-300 text-sm">—</span>
                                            @endif
                                        </td>
                                    @endforeach

                                    @if(count($quizTitles) === 0)
                                        <td class="text-center text-gray-300">—</td>
                                    @endif

                                    <td class="text-center bg-gray-50/30">
                                        <span class="font-mono font-semibold text-gray-700" id="total-{{ $student->id }}">
                                            {{ $student->quiz_stats['total_score'] }}/{{ $student->quiz_stats['total_possible'] }}
                                        </span>
                                    </td>
                                    
                                    <td class="text-center bg-gray-50/30">
                                        @php $avg = $student->quiz_stats['average']; @endphp
                                        <span class="grade-badge {{ $avg >= 75 ? 'grade-high' : ($avg >= 60 ? 'grade-medium' : 'grade-low') }}" id="avg-{{ $student->id }}">
                                            {{ $avg }}%
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <button onclick="viewStudentHistory({{ $student->id }})" 
                                            class="p-2 rounded-lg text-gray-400 hover:text-primary-600 hover:bg-primary-50 transition-all"
                                            title="View History">
                                            <i class="fas fa-history"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($quizTitles) + 5 }}" class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-users-slash text-3xl"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No Students Enrolled</h3>
                                        <p class="text-gray-500 text-sm mb-4">This section doesn't have any students yet.</p>
                                        <button onclick="openModal('addQuizModal')" class="btn btn-primary text-sm">
                                            <i class="fas fa-plus"></i>
                                            <span>Add First Quiz</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Floating Action Buttons -->
    <div class="fab">
        <a href="{{ route('teacher.dashboard') }}" class="fab-btn fab-btn-secondary" title="Back to Dashboard">
            <i class="fas fa-arrow-left"></i>
        </a>
        <button onclick="openModal('addQuizModal')" class="fab-btn fab-btn-primary" title="Add New Quiz">
            <i class="fas fa-plus"></i>
        </button>
        
    </div>

    <!-- Add Quiz Modal -->
    <div id="addQuizModal" class="fixed inset-0 modal-backdrop hidden items-center justify-center z-50 p-4">
        <div class="modal-content w-full max-w-4xl max-h-[90vh] flex flex-col">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-primary-600 to-primary-700 rounded-t-lg">
                <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-plus-circle"></i>
                    Add New Quiz
                </h2>
                <button onclick="closeModal('addQuizModal')" class="text-white/80 hover:text-white transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Form -->
            <form action="{{ route('teacher.quiz.store') }}" method="POST" class="flex-1 overflow-hidden flex flex-col">
                @csrf
                <input type="hidden" name="section_id" value="{{ $section->id }}">

                <div class="p-6 overflow-y-auto flex-1">
                    <!-- Quiz Info -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quiz Title</label>
                            <input type="text" name="quiz_title" required 
                                class="input-modern"
                                placeholder="e.g., Midterm Examination">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Total Score</label>
                            <input type="number" name="default_total" id="defaultTotal" required min="1" 
                                class="input-modern"
                                placeholder="100"
                                onchange="updateAllTotals(this.value)">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                            <input type="date" name="date" required 
                                class="input-modern"
                                value="{{ date('Y-m-d') }}">
                        </div>
                    </div>

                    <!-- Student Scores -->
                    <div class="card border-0 shadow-sm bg-gray-50/50">
                        <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="font-semibold text-gray-900">Student Scores</h3>
                            <span class="text-sm text-gray-500">{{ $studentsWithStats->count() }} students</span>
                        </div>
                        
                        <div class="max-h-96 overflow-y-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-100 sticky top-0">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-medium text-gray-600">Student</th>
                                        <th class="px-4 py-3 text-center font-medium text-gray-600 w-32">Score</th>
                                        <th class="px-4 py-3 text-center font-medium text-gray-600 w-32">Total</th>
                                        <th class="px-4 py-3 text-center font-medium text-gray-600 w-24">Grade</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @foreach($studentsWithStats as $index => $student)
                                        <tr class="hover:bg-gray-50/50">
                                            <td class="px-4 py-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="avatar w-7 h-7 text-xs">
                                                        {{ strtoupper(substr($student->first_name, 0, 1)) }}
                                                    </div>
                                                    <span class="font-medium text-gray-900">{{ $student->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-2 py-2">
                                                <input type="number" 
                                                    name="scores[{{ $index }}][score]" 
                                                    class="input-modern score-input"
                                                    placeholder="0" min="0" step="0.01"
                                                    oninput="calculatePercentage(this, {{ $index }})">
                                                <input type="hidden" name="scores[{{ $index }}][student_id]" value="{{ $student->id }}">
                                            </td>
                                            <td class="px-2 py-2">
                                                <input type="number" 
                                                    name="scores[{{ $index }}][total_score]" 
                                                    class="input-modern score-input total-input"
                                                    placeholder="100" min="1"
                                                    data-index="{{ $index }}"
                                                    oninput="calculatePercentage(this, {{ $index }}, 'total')">
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <span class="font-mono text-sm text-gray-500 percentage-display" id="pct-{{ $index }}">—</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="p-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('addQuizModal')" class="btn btn-secondary">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Save Quiz
                    </button>
                </div>
            </form>
        </div>
    </div>

  <!-- Profile Modal -->
<div id="profileModal" class="fixed inset-0 modal-backdrop hidden items-center justify-center z-50 p-4">
    <div class="modal-content w-full max-w-3xl max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">Profile Settings</h2>
                <button onclick="closeModal('profileModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="profileForm">
                @csrf @method('PATCH')
                
                @php $teacher = auth()->user()->teacher; @endphp
                
                <!-- Photo Section -->
                <div class="flex items-center gap-4 mb-6" id="profilePhotoSection">
                    <div class="relative">
                        <img src="{{ $teacher && $teacher->photo ? asset('storage/'.$teacher->photo) : asset('images/photo-placeholder.png') }}"
                             class="w-24 h-24 rounded-full object-cover ring-4 ring-gray-100" id="profilePreview">
                        <div class="absolute -bottom-2 -right-2 hidden" id="photoInputWrapper">
                            <label for="photoInput" class="cursor-pointer bg-primary-600 text-white p-2 rounded-full hover:bg-primary-700 transition shadow-lg">
                                <i class="fas fa-camera text-sm"></i>
                            </label>
                            <input type="file" name="photo" id="photoInput" class="hidden" accept="image/*">
                        </div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $teacher->first_name ?? '' }} {{ $teacher->last_name ?? '' }}</h3>
                        <p class="text-sm text-gray-500">Teacher</p>
                        <p class="text-xs text-gray-400 mt-1">Click edit to update photo</p>
                    </div>
                </div>

                <!-- Personal Information Section -->
                <div class="bg-gray-50 rounded-xl p-4 mb-4">
                    <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                        <i class="fas fa-user text-primary-500"></i>
                        Personal Information
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- First Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-500">*</span></label>
                            <input type="text" name="first_name" value="{{ $teacher->first_name ?? '' }}"
                                   class="input-modern profile-input" disabled required>
                        </div>
                        
                        <!-- Middle Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Middle Name</label>
                            <input type="text" name="middle_name" value="{{ $teacher->middle_name ?? '' }}"
                                   class="input-modern profile-input" disabled placeholder="Optional">
                        </div>
                        
                        <!-- Last Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Last Name <span class="text-red-500">*</span></label>
                            <input type="text" name="last_name" value="{{ $teacher->last_name ?? '' }}"
                                   class="input-modern profile-input" disabled required>
                        </div>
                        
                        <!-- Suffix -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Suffix</label>
                            <select name="suffix" class="input-modern profile-input" disabled>
                                <option value="">None</option>
                                <option value="Jr." {{ ($teacher->suffix ?? '') == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                                <option value="Sr." {{ ($teacher->suffix ?? '') == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                                <option value="II" {{ ($teacher->suffix ?? '') == 'II' ? 'selected' : '' }}>II</option>
                                <option value="III" {{ ($teacher->suffix ?? '') == 'III' ? 'selected' : '' }}>III</option>
                                <option value="IV" {{ ($teacher->suffix ?? '') == 'IV' ? 'selected' : '' }}>IV</option>
                                <option value="V" {{ ($teacher->suffix ?? '') == 'V' ? 'selected' : '' }}>V</option>
                                <option value="PhD" {{ ($teacher->suffix ?? '') == 'PhD' ? 'selected' : '' }}>PhD</option>
                                <option value="MD" {{ ($teacher->suffix ?? '') == 'MD' ? 'selected' : '' }}>MD</option>
                                <option value="DDS" {{ ($teacher->suffix ?? '') == 'DDS' ? 'selected' : '' }}>DDS</option>
                                <option value="RN" {{ ($teacher->suffix ?? '') == 'RN' ? 'selected' : '' }}>RN</option>
                            </select>
                        </div>
                        
                        <!-- Birthday -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Birthday</label>
                            <input type="date" name="birthday" value="{{ $teacher->birthday ?? '' }}"
                                   class="input-modern profile-input" disabled>
                        </div>
                        
                        <!-- Contact Number -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                            <input type="tel" name="contact_number" value="{{ $teacher->contact_number ?? '' }}"
                                   class="input-modern profile-input" disabled placeholder="09XX XXX XXXX">
                        </div>
                    </div>
                </div>

                <!-- Account Information Section -->
                <div class="bg-gray-50 rounded-xl p-4 mb-4">
                    <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                        <i class="fas fa-lock text-primary-500"></i>
                        Account Information
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Username -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Username <span class="text-red-500">*</span></label>
                            <input type="text" name="username" value="{{ auth()->user()->username ?? '' }}"
                                   class="input-modern profile-input" disabled required>
                            <p class="text-xs text-gray-500 mt-1">Used for login</p>
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" value="{{ auth()->user()->email }}" disabled
                                   class="input-modern bg-gray-100 cursor-not-allowed">
                            <p class="text-xs text-gray-500 mt-1">Contact admin to change email</p>
                        </div>
                        
                        <!-- Password (Hidden by default) -->
                        <div class="hidden password-field">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                            <input type="password" name="current_password" 
                                   class="input-modern" placeholder="Required to change password">
                        </div>
                        
                        <div class="hidden password-field">
                            <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                            <input type="password" name="password" 
                                   class="input-modern" placeholder="Min 8 characters">
                        </div>
                        
                        <div class="hidden password-field">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                            <input type="password" name="password_confirmation" 
                                   class="input-modern" placeholder="Re-type new password">
                        </div>
                    </div>
                    
                    <!-- Change Password Toggle -->
                    <div class="mt-3 hidden" id="changePasswordToggle">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" id="enablePasswordChange" class="rounded text-primary-600 focus:ring-primary-500">
                            <span class="text-sm text-gray-700">Change Password</span>
                        </label>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="button" id="editProfileBtn" onclick="toggleProfileEdit(true)" class="btn btn-primary">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Profile
                    </button>
                    <button type="button" id="cancelProfileBtn" onclick="toggleProfileEdit(false)" class="btn btn-secondary hidden">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </button>
                    <button type="submit" id="saveProfileBtn" class="btn btn-primary hidden">
                        <i class="fas fa-save mr-2"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleProfileEdit(enable) {
    const inputs = document.querySelectorAll('.profile-input');
    const editBtn = document.getElementById('editProfileBtn');
    const cancelBtn = document.getElementById('cancelProfileBtn');
    const saveBtn = document.getElementById('saveProfileBtn');
    const photoWrapper = document.getElementById('photoInputWrapper');
    const passwordToggle = document.getElementById('changePasswordToggle');
    const passwordFields = document.querySelectorAll('.password-field');
    
    if (enable) {
        // Enable editing
        inputs.forEach(input => {
            input.disabled = false;
            input.classList.add('bg-white', 'border-primary-300');
            input.classList.remove('bg-gray-50');
        });
        
        editBtn.classList.add('hidden');
        cancelBtn.classList.remove('hidden');
        saveBtn.classList.remove('hidden');
        photoWrapper.classList.remove('hidden');
        passwordToggle.classList.remove('hidden');
        
    } else {
        // Disable editing (cancel)
        inputs.forEach(input => {
            input.disabled = true;
            input.classList.remove('bg-white', 'border-primary-300');
            input.classList.add('bg-gray-50');
        });
        
        editBtn.classList.remove('hidden');
        cancelBtn.classList.add('hidden');
        saveBtn.classList.add('hidden');
        photoWrapper.classList.add('hidden');
        passwordToggle.classList.add('hidden');
        
        // Hide password fields
        passwordFields.forEach(field => field.classList.add('hidden'));
        document.getElementById('enablePasswordChange').checked = false;
        
        // Reset form
        document.getElementById('profileForm').reset();
    }
}

// Password change toggle
document.getElementById('enablePasswordChange')?.addEventListener('change', function() {
    const passwordFields = document.querySelectorAll('.password-field');
    passwordFields.forEach(field => {
        field.classList.toggle('hidden', !this.checked);
    });
});

// Photo preview
document.getElementById('photoInput')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profilePreview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>

    <!-- Enroll Student Modal -->
    <div id="enrollStudentModal" class="fixed inset-0 modal-backdrop hidden items-center justify-center z-50 p-4">
        <div class="modal-content w-full max-w-lg">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900">Enroll Student</h2>
                    <button onclick="closeModal('enrollStudentModal')" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <form method="POST" action="{{ route('teacher.students.enroll') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Select Student</label>
                            <select name="student_id" required class="input-modern">
                                <option value="">Choose a student...</option>
                                @foreach($section->students as $student)
                                    <option value="{{ $student->id }}">
                                        {{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name ? substr($student->middle_name, 0, 1) . '.' : '' }} ({{ $student->school_id }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Select Section</label>
                            <select name="section_id" required class="input-modern">
                                <option value="">Choose a section...</option>
                                @foreach($sections as $sect)
                                    <option value="{{ $sect->id }}">{{ $sect->year_level }} - {{ $sect->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" onclick="closeModal('enrollStudentModal')" class="btn btn-secondary">Cancel</button>
                        <button type="submit" class="btn btn-primary">Enroll Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Announcement Modal -->
    <div id="announcementModal" class="fixed inset-0 modal-backdrop hidden items-center justify-center z-50 p-4">
        <div class="modal-content w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900">Announcements</h2>
                <button onclick="closeModal('announcementModal')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto p-6">
                <form action="{{ route('teacher.announcements.store') }}" method="POST" class="mb-6">
                    @csrf
                    <div class="space-y-3">
                        <input type="text" name="title" placeholder="Announcement title..." required class="input-modern">
                        <textarea name="message" rows="3" placeholder="Write your announcement..." required class="input-modern"></textarea>
                        <div class="flex justify-end">
                            <button type="submit" class="btn btn-primary text-sm">
                                <i class="fas fa-paper-plane"></i>
                                Post Announcement
                            </button>
                        </div>
                    </div>
                </form>

                <div class="space-y-3">
                    @foreach($announcements as $announcement)
                        <div class="card p-4 border-l-4 border-primary-500">
                            <h4 class="font-semibold text-gray-900">{{ $announcement->title }}</h4>
                            <p class="text-sm text-gray-600 mt-1">{{ $announcement->content }}</p>
                            <div class="flex items-center justify-between mt-3 text-xs text-gray-400">
                                <span>By {{ $announcement->user->name }}</span>
                                <span>{{ $announcement->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        // Universal Modal Functions
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                // Small delay to allow display:flex to apply before adding animation class
                setTimeout(() => {
                    modal.classList.add('modal-active');
                }, 10);
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('modal-active');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }, 300);
            }
        }

        // Close modal when clicking backdrop
        document.querySelectorAll('.modal-backdrop').forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    const modalId = modal.id;
                    closeModal(modalId);
                }
            });
        });

        // Toast
        function closeToast() {
            const toast = document.getElementById('successToast');
            if (toast) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => toast.remove(), 300);
            }
        }
        
        @if(session('success'))
        setTimeout(closeToast, 5000);
        @endif

        // Profile Edit Toggle
        function toggleProfileEdit(editMode) {
            const inputs = document.querySelectorAll('.profile-input');
            const photoWrapper = document.getElementById('photoInputWrapper');
            const passwordField = document.getElementById('passwordField');
            const editBtn = document.getElementById('editProfileBtn');
            const cancelBtn = document.getElementById('cancelProfileBtn');
            const saveBtn = document.getElementById('saveProfileBtn');

            inputs.forEach(input => {
                input.disabled = !editMode;
            });

            if (editMode) {
                photoWrapper.classList.remove('hidden');
                passwordField.classList.remove('hidden');
                editBtn.classList.add('hidden');
                cancelBtn.classList.remove('hidden');
                saveBtn.classList.remove('hidden');
            } else {
                photoWrapper.classList.add('hidden');
                passwordField.classList.add('hidden');
                editBtn.classList.remove('hidden');
                cancelBtn.classList.add('hidden');
                saveBtn.classList.add('hidden');
            }
        }

        // Quiz Form Logic
        function updateAllTotals(value) {
            document.querySelectorAll('.total-input').forEach(input => input.value = value);
            document.querySelectorAll('.score-input').forEach((input, index) => calculatePercentage(input, index));
        }

        function calculatePercentage(input, index, type = 'score') {
            const row = input.closest('tr');
            const scoreInput = row.querySelector('input[name*="[score]"]');
            const totalInput = row.querySelector('input[name*="[total_score]"]');
            const score = parseFloat(scoreInput?.value) || 0;
            const total = parseFloat(totalInput?.value) || 1;
            const pct = total > 0 ? ((score / total) * 100).toFixed(1) : 0;
            
            const display = document.getElementById(`pct-${index}`);
            if (display) {
                display.textContent = pct + '%';
                display.className = `font-mono text-sm percentage-display ${pct >= 75 ? 'text-success-600' : pct >= 60 ? 'text-warning-600' : 'text-danger-600'}`;
            }
        }

        // Score Update
        async function updateScore(input, quizId, field) {
            const value = input.value;
            const originalValue = input.getAttribute('value');
            
            try {
                const response = await fetch(`/teacher/quiz/${quizId}/update`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ [field]: value })
                });

                const data = await response.json();
                
                if (data.success) {
                    input.style.backgroundColor = '#dcfce7';
                    setTimeout(() => input.style.backgroundColor = '', 1000);
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                input.value = originalValue;
                alert('Failed to update: ' + error.message);
            }
        }

        function viewStudentHistory(studentId) {
            alert('View history for student ' + studentId);
        }

        // Escape key to close modals
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-backdrop').forEach(modal => {
                    if (!modal.classList.contains('hidden')) {
                        closeModal(modal.id);
                    }
                });
            }
        });
    </script>
</body>
</html>