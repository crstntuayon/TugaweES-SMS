<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sections | Student Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-100 via-blue-100 to-sky-200">
 

<div class="flex h-screen bg-gray-100 overflow-hidden" x-data="{ sidebarOpen: true }">


<!-- SIDEBAR -->
<aside
x-data="{ sidebarOpen: true, activeDropdown: null }"
class="bg-white/90 backdrop-blur-2xl shadow-2xl shadow-indigo-500/5 border-r border-gray-200/80 
flex flex-col transition-all duration-500 ease-[cubic-bezier(0.4,0,0.2,1)]
h-screen sticky top-0 z-50"
:class="sidebarOpen ? 'w-72' : 'w-20'"
>

<!-- HEADER -->
<div class="flex items-center justify-between p-5 border-b border-gray-100">
    <div class="flex items-center gap-3 overflow-hidden" x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/30">
            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
        </div>
        <span class="font-black text-gray-900 text-lg tracking-tight whitespace-nowrap">
            Admin Panel
        </span>
    </div>

    <button
    @click="sidebarOpen = !sidebarOpen"
    class="p-2.5 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 hover:scale-110 transition-all duration-300 ml-auto"
    :class="!sidebarOpen && 'mx-auto'">
        <svg xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5 text-gray-600 transition-transform duration-500"
        :class="!sidebarOpen && 'rotate-180'"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
        </svg>
    </button>
</div>


<!-- USER PROFILE -->
<div class="p-5 border-b border-gray-100">
    @php
    $first = auth()->user()->first_name;
    $last = auth()->user()->last_name;
    $initials = strtoupper(substr($first,0,1) . substr($last,0,1));
    @endphp

    <div class="flex items-center gap-4" :class="!sidebarOpen && 'justify-center'">
        <div class="relative group">
            <!-- Avatar -->
            <div class="w-12 h-12 flex items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500 via-indigo-600 to-violet-600 text-white font-bold text-lg shadow-lg shadow-indigo-500/30 group-hover:shadow-xl group-hover:shadow-indigo-500/40 transition-all duration-300 group-hover:scale-105">
                {{ $initials }}
            </div>
            <!-- Online indicator -->
            <span class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-500 border-3 border-white rounded-full shadow-sm"></span>
            <!-- Hover tooltip -->
            <div class="absolute left-full ml-3 px-3 py-1.5 bg-gray-900 text-white text-xs font-medium rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap pointer-events-none" x-show="!sidebarOpen">
                Online
            </div>
        </div>

        <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300 delay-100" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="overflow-hidden">
            <p class="text-sm font-bold text-gray-900 leading-tight truncate">
                {{ auth()->user()->first_name }}
                {{ auth()->user()->last_name }}
            </p>
            <p class="text-xs text-gray-500 truncate mt-0.5">
                {{ auth()->user()->email }}
            </p>
            <span class="inline-flex items-center gap-1.5 mt-2 px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold uppercase tracking-wider">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Administrator
            </span>
        </div>
    </div>
</div>


<!-- NAVIGATION -->
<div class="flex flex-col gap-1 p-4 flex-1 overflow-y-auto scrollbar-thin">
    
    <!-- Section Label -->
    <div class="px-3 mb-2" x-show="sidebarOpen">
        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Main Menu</span>
    </div>

    <!-- Dashboard -->
    <a href="{{ route('admin.dashboard') }}"
    class="group relative flex items-center gap-3.5 px-3.5 py-3 rounded-xl transition-all duration-300 ease-out
    {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-indigo-600 to-violet-600 text-white shadow-lg shadow-indigo-500/30' : 'hover:bg-indigo-50/80 hover:text-indigo-600' }}"
    :class="!sidebarOpen && 'justify-center'">
        
        <div class="relative">
            <svg xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 transition-transform duration-300 {{ request()->routeIs('admin.dashboard') ? '' : 'group-hover:scale-110' }}"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24">
                <path d="M3 13h8V3H3zM13 21h8V11h-8zM13 3h8v6h-8zM3 21h8v-6H3z"/>
            </svg>
            <!-- Active indicator -->
            @if(request()->routeIs('admin.dashboard'))
            <span class="absolute -top-1 -right-1 w-2 h-2 bg-white rounded-full animate-pulse"></span>
            @endif
        </div>

        <span class="font-medium text-sm whitespace-nowrap" x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-x-2" x-transition:enter-end="opacity-100 translate-x-0">Dashboard</span>
        
        <!-- Tooltip for collapsed state -->
        <div class="absolute left-full ml-4 px-3 py-2 bg-gray-900 text-white text-xs font-medium rounded-xl opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap pointer-events-none shadow-xl" x-show="!sidebarOpen">
            Dashboard
            <div class="absolute left-0 top-1/2 -translate-x-1 -translate-y-1/2 border-4 border-transparent border-r-gray-900"></div>
        </div>
    </a>

    <!-- Profile -->
    <a href="{{ route('profile.edit') }}"
    class="group relative flex items-center gap-3.5 px-3.5 py-3 rounded-xl hover:bg-indigo-50/80 hover:text-indigo-600 transition-all duration-300 ease-out {{ request()->routeIs('profile.edit') ? 'bg-indigo-50 text-indigo-600' : '' }}"
    :class="!sidebarOpen && 'justify-center'">
        
        <svg xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5 transition-transform duration-300 group-hover:scale-110"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        viewBox="0 0 24 24">
            <circle cx="12" cy="7" r="4"/>
            <path d="M5.5 21a7.5 7.5 0 0 1 13 0"/>
        </svg>

        <span class="font-medium text-sm whitespace-nowrap" x-show="sidebarOpen" x-transition>Profile</span>
        
        <div class="absolute left-full ml-4 px-3 py-2 bg-gray-900 text-white text-xs font-medium rounded-xl opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap pointer-events-none shadow-xl" x-show="!sidebarOpen">
            Profile
            <div class="absolute left-0 top-1/2 -translate-x-1 -translate-y-1/2 border-4 border-transparent border-r-gray-900"></div>
        </div>
    </a>

    <!-- Section Label -->
    <div class="px-3 mt-6 mb-2" x-show="sidebarOpen">
        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Management</span>
    </div>

    <!-- Manage Users -->
    <button onclick="openManageUsersModal()"
    class="group relative flex items-center gap-3.5 px-3.5 py-3 rounded-xl hover:bg-indigo-50/80 hover:text-indigo-600 transition-all duration-300 ease-out w-full text-left"
    :class="!sidebarOpen && 'justify-center'">
        
        <svg xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5 transition-transform duration-300 group-hover:scale-110"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        viewBox="0 0 24 24">
            <path d="M17 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M7 21v-2a4 4 0 0 1 3-3.87"/>
            <circle cx="12" cy="7" r="4"/>
        </svg>

        <span class="font-medium text-sm whitespace-nowrap" x-show="sidebarOpen" x-transition>Manage Users</span>
        
        <div class="absolute left-full ml-4 px-3 py-2 bg-gray-900 text-white text-xs font-medium rounded-xl opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap pointer-events-none shadow-xl" x-show="!sidebarOpen">
            Manage Users
            <div class="absolute left-0 top-1/2 -translate-x-1 -translate-y-1/2 border-4 border-transparent border-r-gray-900"></div>
        </div>
    </button>

    <!-- Create Admin -->
    <button onclick="openAddAdminModal()"
    class="group relative flex items-center gap-3.5 px-3.5 py-3 rounded-xl hover:bg-emerald-50/80 hover:text-emerald-600 transition-all duration-300 ease-out w-full text-left"
    :class="!sidebarOpen && 'justify-center'">
        
        <div class="relative">
            <svg xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 transition-transform duration-300 group-hover:scale-110"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            <span class="absolute -top-1 -right-1 w-2 h-2 bg-emerald-500 rounded-full border-2 border-white"></span>
        </div>

        <span class="font-medium text-sm whitespace-nowrap" x-show="sidebarOpen" x-transition>Create Admin</span>
        
        <div class="absolute left-full ml-4 px-3 py-2 bg-gray-900 text-white text-xs font-medium rounded-xl opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap pointer-events-none shadow-xl" x-show="!sidebarOpen">
            Create Admin
            <div class="absolute left-0 top-1/2 -translate-x-1 -translate-y-1/2 border-4 border-transparent border-r-gray-900"></div>
        </div>
    </button>

    <!-- Reports -->
    <a href="{{ route('admin.reports') }}"
    class="group relative flex items-center gap-3.5 px-3.5 py-3 rounded-xl hover:bg-violet-50/80 hover:text-violet-600 transition-all duration-300 ease-out {{ request()->routeIs('admin.reports') ? 'bg-violet-50 text-violet-600' : '' }}"
    :class="!sidebarOpen && 'justify-center'">
        
        <svg xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5 transition-transform duration-300 group-hover:scale-110"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        viewBox="0 0 24 24">
            <path d="M3 3v18h18"/>
            <path d="M7 15l4-4 4 4 5-5"/>
        </svg>

        <span class="font-medium text-sm whitespace-nowrap" x-show="sidebarOpen" x-transition>Reports</span>
        
        <div class="absolute left-full ml-4 px-3 py-2 bg-gray-900 text-white text-xs font-medium rounded-xl opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap pointer-events-none shadow-xl" x-show="!sidebarOpen">
            Reports
            <div class="absolute left-0 top-1/2 -translate-x-1 -translate-y-1/2 border-4 border-transparent border-r-gray-900"></div>
        </div>
    </a>

    <!-- Graduation -->
    <a href="{{ route('admin.students.graduation') }}"
    class="group relative flex items-center gap-3.5 px-3.5 py-3 rounded-xl hover:bg-amber-50/80 hover:text-amber-600 transition-all duration-300 ease-out {{ request()->routeIs('admin.students.graduation') ? 'bg-amber-50 text-amber-600' : '' }}"
    :class="!sidebarOpen && 'justify-center'">
        
        <svg xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5 transition-transform duration-300 group-hover:scale-110"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        viewBox="0 0 24 24">
            <path d="M22 10L12 5 2 10l10 5 10-5z"/>
            <path d="M6 12v5a6 3 0 0 0 12 0v-5"/>
        </svg>

        <span class="font-medium text-sm whitespace-nowrap" x-show="sidebarOpen" x-transition>Graduation</span>
        
        <div class="absolute left-full ml-4 px-3 py-2 bg-gray-900 text-white text-xs font-medium rounded-xl opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap pointer-events-none shadow-xl" x-show="!sidebarOpen">
            Graduation
            <div class="absolute left-0 top-1/2 -translate-x-1 -translate-y-1/2 border-4 border-transparent border-r-gray-900"></div>
        </div>
    </a>

    <!-- Issue School IDs -->
    <button onclick="openSectionModal()"
    class="group relative flex items-center gap-3.5 px-3.5 py-3 rounded-xl hover:bg-cyan-50/80 hover:text-cyan-600 transition-all duration-300 ease-out w-full text-left"
    :class="!sidebarOpen && 'justify-center'">
        
        <svg xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5 transition-transform duration-300 group-hover:scale-110"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        viewBox="0 0 24 24">
            <rect x="3" y="6" width="18" height="12" rx="2"/>
            <path d="M7 10h6M7 14h4"/>
        </svg>

        <span class="font-medium text-sm whitespace-nowrap" x-show="sidebarOpen" x-transition>Issue School IDs</span>
        
        <div class="absolute left-full ml-4 px-3 py-2 bg-gray-900 text-white text-xs font-medium rounded-xl opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap pointer-events-none shadow-xl" x-show="!sidebarOpen">
            Issue School IDs
            <div class="absolute left-0 top-1/2 -translate-x-1 -translate-y-1/2 border-4 border-transparent border-r-gray-900"></div>
        </div>
    </button>

    <!-- SCHOOL YEAR -->
    <div class="mt-6 mx-2" x-show="sidebarOpen" x-transition>
        <div class="bg-gradient-to-br from-gray-50 to-gray-100/50 p-4 rounded-2xl border border-gray-200/60 shadow-inner">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Active School Year</span>
            </div>

            <form action="{{ route('admin.schoolyears.activate') }}" method="POST">
                @csrf
                <div class="relative">
                    <select
                    name="school_year"
                    onchange="this.form.submit()"
                    class="w-full appearance-none bg-white border border-gray-200 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all cursor-pointer hover:border-indigo-300 shadow-sm">
                        @foreach($schoolYears as $year)
                        <option value="{{ $year->id }}" {{ $year->is_active ? 'selected' : '' }}>
                            {{ $year->name }}
                        </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- LOGOUT -->
<div class="p-4 border-t border-gray-100 mt-auto">
    <a href="{{ route('logout') }}"
    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
    class="group flex items-center gap-3.5 px-3.5 py-3 rounded-xl text-red-600 hover:bg-red-50 transition-all duration-300 ease-out"
    :class="!sidebarOpen && 'justify-center'">
        
        <div class="relative">
            <svg xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 transition-transform duration-300 group-hover:scale-110"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                <path d="M16 17l5-5-5-5"/>
                <path d="M21 12H9"/>
            </svg>
        </div>

        <span class="font-medium text-sm whitespace-nowrap" x-show="sidebarOpen" x-transition>Logout</span>
        
        <div class="absolute left-full ml-4 px-3 py-2 bg-red-600 text-white text-xs font-medium rounded-xl opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap pointer-events-none shadow-xl" x-show="!sidebarOpen">
            Logout
            <div class="absolute left-0 top-1/2 -translate-x-1 -translate-y-1/2 border-4 border-transparent border-r-red-600"></div>
        </div>
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</div>

</aside>

 <main class="flex-1 p-8 space-y-8 overflow-y-auto h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-indigo-50/30">

<!-- ================= ENHANCED HEADER ================= -->
<header class="sticky top-0 z-50 backdrop-blur-xl bg-white/70 border border-white/50 shadow-lg rounded-2xl">
    <div class="max-w-7xl mx-auto px-8 py-5">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            <!-- LEFT: Back + Logo + Title -->
            <div class="flex items-center gap-5">
                <a href="{{ route('admin.dashboard') }}"
                   class="group p-3 rounded-xl bg-indigo-50 hover:bg-indigo-600 text-indigo-600 hover:text-white shadow-sm hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:-translate-x-1" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>

                <div class="relative">
                    <img src="{{ asset('images/logo.jpg') }}"
                         class="h-14 w-14 rounded-2xl shadow-lg ring-4 ring-indigo-100 object-cover">
                    <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 rounded-full border-3 border-white shadow-sm flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>

                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl font-black text-gray-900 tracking-tight">Teaching Assignment</h1>
                        <span class="px-2.5 py-0.5 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">
                            {{ $sections->flatten(1)->count() }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 font-medium flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Tugawe Elementary School
                    </p>
                </div>
            </div>

            <!-- RIGHT: Actions -->
            <div class="flex items-center gap-4">
                <!-- Stats Summary -->
                <div class="hidden md:flex items-center gap-4 px-4 py-2 bg-gray-50 rounded-xl border border-gray-200">
                    <div class="text-center">
                        <p class="text-lg font-black text-gray-900">{{ $sections->flatten(1)->count() }}</p>
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Sections</p>
                    </div>
                    <div class="w-px h-8 bg-gray-300"></div>
                    <div class="text-center">
                        <p class="text-lg font-black text-gray-900">{{ $sections->flatten(1)->sum(fn($s) => $s->students->count()) }}</p>
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Students</p>
                    </div>
                </div>

                <button onclick="openAddSectionModal()"
                    class="group relative overflow-hidden bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:shadow-indigo-500/40 transition-all duration-300 flex items-center gap-2">
                    <svg class="w-5 h-5 transition-transform group-hover:rotate-90 duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <span>Add Section</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-violet-600 translate-y-full group-hover:translate-y-0 transition-transform duration-300 -z-10"></div>
                </button>
            </div>

        </div>
    </div>
</header>

<!-- Toast Notification -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    
    Toast.fire({
        icon: 'success',
        title: "{{ session('success') }}",
        background: '#ffffff',
        color: '#374151'
    });
});
</script>
@endif

<!-- ================= ENHANCED SECTIONS ================= -->
<div class="space-y-6" id="sectionsContainer">
@forelse($sections as $teacherName => $teacherSections)
@php
    $totalStudents = $teacherSections->sum(fn($s) => $s->students->count());
    $teacherId = optional($teacherSections->first()->teacher)->id;
    $initials = collect(explode(' ', $teacherName))->map(fn($n) => strtoupper(substr($n, 0, 1)))->take(2)->join('');
    $groupId = 'teacher-group-' . $loop->index;
@endphp

<div class="group bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500 animate-fadeIn" data-group-id="{{ $groupId }}">

    <!-- Teacher Header -->
    <button onclick="toggleGroup('{{ $groupId }}')"
            class="w-full flex justify-between items-center px-6 py-5 bg-gradient-to-r from-indigo-50/80 to-violet-50/80 hover:from-indigo-100 hover:to-violet-100 transition-all duration-300 border-b border-gray-100 group-header"
            id="header-{{ $groupId }}">

        <div class="flex items-center gap-4">
            <!-- Avatar -->
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-indigo-500/30">
                {{ $initials }}
            </div>
            
            <div class="text-left">
                <h2 class="text-lg font-bold text-gray-900 group-hover:text-indigo-700 transition-colors">{{ $teacherName }}</h2>
                <div class="flex items-center gap-3 mt-1">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-indigo-100 text-indigo-700 text-xs font-semibold">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        {{ $teacherSections->count() }} section{{ $teacherSections->count() > 1 ? 's' : '' }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        {{ $totalStudents }} student{{ $totalStudents > 1 ? 's' : '' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            @if($teacherId)
            <a href="{{ route('export.teacher', $teacherId) }}"
               onclick="event.stopPropagation()"
               class="group/export flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm font-semibold shadow-lg shadow-emerald-500/30 hover:shadow-xl transition-all duration-300">
                <svg class="w-4 h-4 transition-transform group-hover/export:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export
            </a>
            @endif
            
            <div class="w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center transition-transform duration-300" id="icon-{{ $groupId }}">
                <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </div>
    </button>

    <!-- Expandable Content - Visible by default -->
    <div class="group-content bg-white" id="content-{{ $groupId }}" style="display: block;">
        <div class="p-6">
            <div class="overflow-x-auto rounded-2xl border border-gray-200 shadow-sm">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50/80">
                        <tr>
                            <th class="px-5 py-4 text-left font-bold text-gray-700 text-xs uppercase tracking-wider">Section</th>
                            <th class="px-5 py-4 text-left font-bold text-gray-700 text-xs uppercase tracking-wider">Students</th>
                            <th class="px-5 py-4 text-left font-bold text-gray-700 text-xs uppercase tracking-wider">Capacity</th>
                            <th class="px-5 py-4 text-left font-bold text-gray-700 text-xs uppercase tracking-wider">Teacher</th>
                            <th class="px-5 py-4 text-left font-bold text-gray-700 text-xs uppercase tracking-wider">Year Level</th>
                            <th class="px-5 py-4 text-left font-bold text-gray-700 text-xs uppercase tracking-wider">School Year</th>
                            <th class="px-5 py-4 text-center font-bold text-gray-700 text-xs uppercase tracking-wider w-24">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @foreach($teacherSections as $section)
                        @php 
                            $count = $section->students->count();
                            $full = $count >= $section->capacity;
                            $percent = min(100, ($count / max(1, $section->capacity)) * 100);
                            $statusColor = $full ? 'bg-red-500' : ($percent > 80 ? 'bg-amber-500' : 'bg-emerald-500');
                        @endphp

                        <tr class="hover:bg-indigo-50/50 transition-colors duration-200">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs">
                                        {{ substr($section->name, 0, 1) }}
                                    </div>
                                    <span class="font-semibold text-gray-900">{{ $section->name }}</span>
                                </div>
                            </td>

                            <td class="px-5 py-4">
                                <button onclick="loadStudents({{ $section->id }})"
                                        class="group inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-semibold transition-colors">
                                    <span class="group-hover:underline">{{ $count }}</span>
                                    <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </td>

                            <td class="px-5 py-4">
                                <div class="w-full max-w-[120px]">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <span class="text-xs font-bold {{ $full ? 'text-red-600' : 'text-gray-600' }}">
                                            {{ $count }}/{{ $section->capacity }}
                                        </span>
                                        <span class="text-[10px] font-medium {{ $full ? 'text-red-500' : 'text-gray-400' }}">
                                            {{ round($percent) }}%
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                        <div class="h-full rounded-full {{ $statusColor }} transition-all duration-500" style="width: {{ $percent }}%"></div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-4">
                                <form method="POST" action="{{ route('sections.assignTeacher', $section) }}" class="inline-block" onclick="event.stopPropagation()">
                                    @csrf
                                    @method('PUT')
                                    <div class="relative">
                                        <select name="teacher_id" onchange="this.form.submit()"
                                                class="appearance-none bg-white border border-gray-200 rounded-lg pl-3 pr-8 py-2 text-sm font-medium text-gray-700 hover:border-indigo-400 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all cursor-pointer min-w-[140px]">
                                            <option value="">Unassigned</option>
                                            @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}" @selected($teacher->id == $section->teacher_id)>
                                                {{ $teacher->first_name }} {{ $teacher->last_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </form>
                            </td>

                            <td class="px-5 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-gray-100 text-gray-700 text-xs font-semibold">
                                    {{ $section->year_level }}
                                </span>
                            </td>
                            
                            <td class="px-5 py-4 text-gray-600">
                                {{ $section->schoolYear?->name ?? 'N/A' }}
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="openEditSectionModal({{ $section->id }}, '{{ $section->name }}', '{{ $section->year_level }}', '{{ $section->school_year }}')"
                                            class="p-2 rounded-lg text-amber-500 hover:bg-amber-50 hover:text-amber-700 transition-all duration-200 hover:scale-110"
                                            title="Edit Section">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>

                                    <button onclick="showDeleteModal({{ $section->id }})"
                                            class="p-2 rounded-lg text-red-500 hover:bg-red-50 hover:text-red-700 transition-all duration-200 hover:scale-110"
                                            title="Delete Section">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@empty
<!-- Enhanced Empty State -->
<div class="text-center py-20 animate-fadeIn">
    <div class="w-32 h-32 mx-auto mb-6 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center shadow-inner">
        <svg class="w-16 h-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
        </svg>
    </div>
    <h3 class="text-xl font-bold text-gray-900 mb-2">No sections found</h3>
    <p class="text-gray-500 mb-6 max-w-md mx-auto">Get started by creating your first section for teacher assignments.</p>
    <button onclick="openAddSectionModal()" class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30 inline-flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Create First Section
    </button>
</div>
@endforelse
</div>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
    animation: fadeIn 0.5s ease-out forwards;
}
</style>

<script>
// Initialize groups on page load
document.addEventListener('DOMContentLoaded', function() {
    // Check localStorage for collapsed states
    const collapsedGroups = JSON.parse(localStorage.getItem('collapsedTeacherGroups') || '[]');
    
    // Apply collapsed state to saved groups
    collapsedGroups.forEach(groupId => {
        collapseGroup(groupId, false); // false = don't save to localStorage (already there)
    });
});

function toggleGroup(groupId) {
    const content = document.getElementById('content-' + groupId);
    const header = document.getElementById('header-' + groupId);
    const icon = document.getElementById('icon-' + groupId);
    
    // Check if currently hidden
    const isCollapsed = content.style.display === 'none';
    
    if (isCollapsed) {
        // Expand
        expandGroup(groupId);
        saveGroupState(groupId, false);
    } else {
        // Collapse
        collapseGroup(groupId);
        saveGroupState(groupId, true);
    }
}

function expandGroup(groupId) {
    const content = document.getElementById('content-' + groupId);
    const header = document.getElementById('header-' + groupId);
    const icon = document.getElementById('icon-' + groupId);
    
    content.style.display = 'block';
    header.classList.remove('bg-indigo-100');
    icon.style.transform = 'rotate(0deg)';
}

function collapseGroup(groupId, save = true) {
    const content = document.getElementById('content-' + groupId);
    const header = document.getElementById('header-' + groupId);
    const icon = document.getElementById('icon-' + groupId);
    
    content.style.display = 'none';
    header.classList.add('bg-indigo-100');
    icon.style.transform = 'rotate(-90deg)';
}

function saveGroupState(groupId, isCollapsed) {
    let collapsedGroups = JSON.parse(localStorage.getItem('collapsedTeacherGroups') || '[]');
    
    if (isCollapsed) {
        if (!collapsedGroups.includes(groupId)) {
            collapsedGroups.push(groupId);
        }
    } else {
        collapsedGroups = collapsedGroups.filter(id => id !== groupId);
    }
    
    localStorage.setItem('collapsedTeacherGroups', JSON.stringify(collapsedGroups));
}
</script>
</main>

<!-- ================= EDIT SECTION MODAL ================= -->
<div id="editSectionModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
  <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 relative">

    <h2 class="text-xl font-bold text-gray-800 mb-4">Edit Section</h2>

    <form id="editSectionForm" method="POST" class="space-y-4" action="{{ route('admin.sections.update', $section->id ?? 0) }}">
      @csrf
      @method('PUT')

      <!-- SECTION NAME -->
      <input id="edit_name" name="name" required
             value="{{ old('name', $section->name ?? '') }}"
             class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400"
             placeholder="Section Name">

      <!-- YEAR LEVEL -->
      <select id="edit_year_level" name="year_level" required
              class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">
        @php
          $levels = ['Kindergarten', 'Grade 1','Grade 2','Grade 3','Grade 4','Grade 5','Grade 6'];
        @endphp
        @foreach($levels as $level)
          <option value="{{ $level }}" {{ (old('year_level', $section->year_level ?? '') == $level) ? 'selected' : '' }}>
            {{ $level }}
          </option>
        @endforeach
      </select>

      <!-- SCHOOL YEAR -->
      <select id="edit_school_year" name="school_year_id" required
              class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">
        <option value="">-- Select School Year --</option>
        @foreach($schoolYears as $year)
          <option value="{{ $year->id }}"
                  {{ (old('school_year_id', $section->school_year_id ?? '') == $year->id) ? 'selected' : '' }}>
            {{ $year->name }}
          </option>
        @endforeach
      </select>

      <!-- Buttons -->
      <div class="flex justify-end gap-3 pt-4">
        <button type="button" onclick="closeEditSectionModal()"
                class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-lg">
          Cancel
        </button>

        <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg">
          Update Section
        </button>
      </div>
    </form>

    <!-- Close Modal Button -->
    <button onclick="closeEditSectionModal()"
            class="absolute top-3 right-3 text-gray-500 hover:text-red-500 text-xl">✕</button>
  </div>
</div>


<!-- DELETE MODAL -->
<div id="deleteModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-2xl text-center">
        <h3 class="text-lg font-bold mb-4">Confirm Deletion</h3>
        <p class="mb-6 text-gray-700">Are you sure you want to delete this teacher? This action will happen in <span id="deleteCountdown">5</span> seconds.</p>

        <div class="flex justify-center gap-4">
            <button onclick="cancelDelete()" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-lg">Cancel</button>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                    Delete Now
                </button>
            </form>
        </div>
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


<!-- ================= SCRIPTS ================= -->
<script>
function toggleGroup(btn){
    const content = btn.nextElementSibling;
    const teacherName = btn.querySelector('h2').innerText;

    content.classList.toggle('hidden');
    btn.querySelector('.rotate-icon').classList.toggle('rotate-180');

    // Save state in localStorage
    const expanded = JSON.parse(localStorage.getItem('expandedTeachers') || '{}');
    expanded[teacherName] = !content.classList.contains('hidden');
    localStorage.setItem('expandedTeachers', JSON.stringify(expanded));
}

function openEditSectionModal(id, name, year, sy){
    edit_name.value = name;
    edit_year_level.value = year;
    edit_school_year.value = sy;
    editSectionForm.action = `/admin/sections/${id}`;
    editSectionModal.classList.remove('hidden');
    editSectionModal.classList.add('flex');
}

function closeEditSectionModal(){
    editSectionModal.classList.add('hidden');
}


// SECTION MODAL FUNCTIONS

    function openAddSectionModal() {
        document.getElementById('addSectionModal').classList.remove('hidden');
        document.getElementById('addSectionModal').classList.add('flex');
    }

    function closeAddSectionModal() {
        document.getElementById('addSectionModal').classList.add('hidden');
    }

// DELETE MODAL LOGIC
 let deleteTimeout;

    function showDeleteModal(sectionId) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const countdownEl = document.getElementById('deleteCountdown');

        form.action = `/admin/sections/${sectionId}`;

        let counter = 5;
        countdownEl.textContent = counter;
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        deleteTimeout = setInterval(() => {
            counter--;
            countdownEl.textContent = counter;
            if(counter <= 0){
                clearInterval(deleteTimeout);
                form.submit();
            }
        }, 1000);
    }

    function cancelDelete() {
        clearInterval(deleteTimeout);
        document.getElementById('deleteModal').classList.add('hidden');
    }



// Restore expanded sections on page load
document.addEventListener('DOMContentLoaded', () => {
    const expanded = JSON.parse(localStorage.getItem('expandedTeachers') || '{}');

    document.querySelectorAll('.teacher-card').forEach(card => {
        const btn = card.querySelector('button');
        const content = card.querySelector('.group-content');
        const teacherName = btn.querySelector('h2').innerText;

        if(expanded[teacherName]){
            content.classList.remove('hidden');
            btn.querySelector('.rotate-icon').classList.add('rotate-180');
        }
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

@foreach($allSections as $section)
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



</body>
</html>