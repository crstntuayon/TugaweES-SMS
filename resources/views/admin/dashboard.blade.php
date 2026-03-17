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
$user = auth()->user();
$initials = $user 
    ? strtoupper(substr($user->first_name,0,1) . substr($user->last_name,0,1))
    : 'GU';
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
           @php
$user = auth()->user();
@endphp

<p class="text-sm font-bold text-gray-900 leading-tight truncate">
    {{ $user->first_name ?? 'Guest' }}
    {{ $user->last_name ?? '' }}
</p>

<p class="text-xs text-gray-500 truncate mt-0.5">
    {{ $user->email ?? 'guest@example.com' }}
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

    <!-- Graduation 
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
    </a> -->

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

   <!-- MAIN CONTENT -->
<main class="flex-1 p-8 space-y-8 overflow-y-auto h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-indigo-50/30">

    <!-- ENHANCED HEADER -->
    <header class="bg-white/80 backdrop-blur-xl shadow-lg border border-white/50 rounded-2xl px-8 py-6 flex items-center justify-between">
        <div class="flex items-center gap-5">
            <div class="relative">
                <img src="{{ asset('images/logo.png') }}"
                     class="h-14 w-14 rounded-2xl shadow-lg ring-4 ring-indigo-100 object-cover">
                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 rounded-full border-3 border-white shadow-sm flex items-center justify-center">
                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>

            <div>
                <h1 class="text-2xl font-black text-gray-900 tracking-tight">Admin Dashboard</h1>
                <p class="text-sm text-gray-500 font-medium flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Tugawe Elementary School • Dauin District
                </p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="flex items-center gap-3">
            <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-indigo-50 rounded-xl border border-indigo-100">
                <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                <span class="text-sm font-medium text-indigo-700">System Online</span>
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

    <!-- PAGE CONTENT -->
    <div class="max-w-7xl mx-auto w-full space-y-8">

        <!-- ENHANCED NAVIGATION TABS -->
        <nav class="flex flex-wrap gap-2 p-2 bg-white/60 backdrop-blur-sm rounded-2xl border border-gray-200/60 shadow-sm">
            <a href="{{ route('admin.dashboard') }}" 
               class="group flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold shadow-lg shadow-indigo-500/30 transition-all duration-300 hover:shadow-xl hover:shadow-indigo-500/40">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('admin.students.index') }}" 
               class="group flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white hover:bg-indigo-50 text-gray-700 hover:text-indigo-600 text-sm font-medium shadow-sm hover:shadow-md transition-all duration-300 border border-gray-200 hover:border-indigo-200">
                <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Students
            </a>
            <a href="{{ route('admin.teachers.index') }}" 
               class="group flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white hover:bg-emerald-50 text-gray-700 hover:text-emerald-600 text-sm font-medium shadow-sm hover:shadow-md transition-all duration-300 border border-gray-200 hover:border-emerald-200">
                <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Teachers
            </a>
            <a href="{{ route('admin.sections.index') }}" 
               class="group flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white hover:bg-amber-50 text-gray-700 hover:text-amber-600 text-sm font-medium shadow-sm hover:shadow-md transition-all duration-300 border border-gray-200 hover:border-amber-200">
                <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                Sections
            </a>
        </nav>

        <!-- ENHANCED DASHBOARD CARDS -->
        <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

            <!-- STUDENTS CARD -->
            <div class="group bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-1 transition-all duration-500">
                <div class="h-32 bg-gradient-to-br from-indigo-500 to-violet-600 relative overflow-hidden p-6">
                    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
                    
                    <div class="relative flex items-start justify-between">
                        <div>
                            <p class="text-indigo-100 text-sm font-medium mb-1">Total Students</p>
                            <p class="text-4xl font-black text-white">
                                {{ number_format($totalStudents ?? 0) }}
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Active Students</span>
                        <span class="text-sm font-bold text-indigo-600">{{ $totalStudents ?? 0 }} students</span>
                    </div>

                    <div class="h-px bg-gray-100"></div>

                    <a href="{{ route('admin.students.index') }}" 
                       class="flex items-center justify-between text-sm font-semibold text-gray-700 hover:text-indigo-600 transition-colors group/link">
                        <span>Manage Students</span>
                        <svg class="w-4 h-4 transition-transform group-hover/link:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                    <button onclick="openAddStudentModal()" 
                            class="w-full group/btn relative overflow-hidden bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl px-4 py-3 shadow-lg shadow-indigo-500/30 transition-all duration-300 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span class="font-semibold">Add New Student</span>
                    </button>
                </div>
            </div>

            <!-- TEACHERS CARD -->
            <div class="group bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-2xl hover:shadow-emerald-500/10 hover:-translate-y-1 transition-all duration-500">
                <div class="h-32 bg-gradient-to-br from-emerald-500 to-teal-600 relative overflow-hidden p-6">
                    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
                    
                    <div class="relative flex items-start justify-between">
                        <div>
                            <p class="text-emerald-100 text-sm font-medium mb-1">Total Teachers</p>
                            <p class="text-4xl font-black text-white">
                                {{ number_format($totalTeachers ?? 0) }}
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Active Faculty</span>
                        <span class="text-sm font-bold text-emerald-600">{{ $totalTeachers ?? 0 }} teachers</span>
                    </div>

                    <div class="h-px bg-gray-100"></div>

                    <a href="{{ route('admin.teachers.index') }}" 
                       class="flex items-center justify-between text-sm font-semibold text-gray-700 hover:text-emerald-600 transition-colors group/link">
                        <span>Manage Teachers</span>
                        <svg class="w-4 h-4 transition-transform group-hover/link:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                    <button onclick="openAddTeacherModal()" 
                            class="w-full group/btn relative overflow-hidden bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl px-4 py-3 shadow-lg shadow-emerald-500/30 transition-all duration-300 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span class="font-semibold">Add New Teacher</span>
                    </button>
                </div>
            </div>

            <!-- SECTIONS CARD -->
            <div class="group bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-2xl hover:shadow-amber-500/10 hover:-translate-y-1 transition-all duration-500">
                <div class="h-32 bg-gradient-to-br from-amber-500 to-orange-600 relative overflow-hidden p-6">
                    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
                    
                    <div class="relative flex items-start justify-between">
                        <div>
                            <p class="text-amber-100 text-sm font-medium mb-1">Total Sections</p>
                            <p class="text-4xl font-black text-white">
                                {{ number_format($totalSections ?? 0) }}
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Class Sections</span>
                        <span class="text-sm font-bold text-amber-600">{{ $totalSections ?? 0 }} sections</span>
                    </div>

                    <div class="h-px bg-gray-100"></div>

                    <a href="{{ route('admin.sections.index') }}" 
                       class="flex items-center justify-between text-sm font-semibold text-gray-700 hover:text-amber-600 transition-colors group/link">
                        <span>Manage Sections</span>
                        <svg class="w-4 h-4 transition-transform group-hover/link:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                    <button onclick="openAddSectionModal()" 
                            class="w-full group/btn relative overflow-hidden bg-amber-500 hover:bg-amber-600 text-white rounded-xl px-4 py-3 shadow-lg shadow-amber-500/30 transition-all duration-300 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span class="font-semibold">Create Section</span>
                    </button>
                </div>
            </div>

        </section>

    </div>
</main>


    </div>
</div>



<!-- ENHANCED ADD TEACHER MODAL -->
<div id="addTeacherModal"
     class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 transition-all duration-300"
     onclick="if(event.target === this) closeAddTeacherModal()">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto m-4 transform transition-all duration-300 scale-100">
        
        <!-- Header -->
        <div class="sticky top-0 bg-white border-b border-gray-100 px-8 py-5 flex items-center justify-between z-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Add New Teacher</h2>
                    <p class="text-sm text-gray-500">Create a new teacher account with complete profile information</p>
                </div>
            </div>
            <button onclick="closeAddTeacherModal()"
                    class="w-8 h-8 rounded-lg hover:bg-gray-100 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form method="POST"
              action="{{ route('admin.teachers.store') }}"
              enctype="multipart/form-data"
              class="p-8 space-y-6"
              id="teacherForm">

            @csrf

            <!-- Profile Photo Section -->
            <div class="flex flex-col items-center pb-6 border-b border-gray-100">
                <div class="relative group cursor-pointer" onclick="document.getElementById('photoInput').click()">
                    <div class="w-32 h-32 rounded-full overflow-hidden bg-gradient-to-br from-indigo-100 to-purple-100 border-4 border-white shadow-lg group-hover:shadow-xl transition-all duration-300">
                        <img id="photoPreview"
                             src="https://ui-avatars.com/api/?name=Teacher&background=6366f1&color=fff&size=128"
                             class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                    </div>
                    <div class="absolute inset-0 rounded-full bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center shadow-md">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                </div>
                <input type="file" id="photoInput" name="photo" accept="image/*"
                       onchange="previewTeacherPhoto(event)" class="hidden">
                <p class="mt-3 text-sm text-gray-500">Click to upload photo</p>
                <p class="text-xs text-gray-400">JPG, PNG up to 2MB</p>
            </div>

            <!-- Personal Information Section -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-1 h-5 bg-indigo-600 rounded-full"></div>
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Personal Information</h3>
                </div>

                <!-- Name Fields -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-gray-700">First Name <span class="text-red-500">*</span></label>
                        <input type="text" name="first_name" placeholder="Juan" required
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm">
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-gray-700">Middle Name</label>
                        <input type="text" name="middle_name" placeholder="Dela Cruz"
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm">
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-gray-700">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" name="last_name" placeholder="Santos" required
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm">
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-gray-700">Suffix</label>
                        <select name="suffix" 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm bg-white">
                            <option value="">None</option>
                            <option value="Jr.">Jr.</option>
                            <option value="Sr.">Sr.</option>
                            <option value="II">II</option>
                            <option value="III">III</option>
                            <option value="IV">IV</option>
                            <option value="PhD">PhD</option>
                            <option value="MD">MD</option>
                            <option value="DDS">DDS</option>
                        </select>
                    </div>
                </div>

                <!-- Birthday, Sex, and Contact Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                   <!-- FIXED BIRTHDAY INPUT - Remove onkeydown blocker -->
<div class="space-y-1">
    <label class="text-xs font-medium text-gray-700">Birthday <span class="text-red-500">*</span></label>
    <input type="date" name="birthday" required
           max="9999-12-31"
           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm">
</div>

<!-- FIXED SEX VALUES - Check what your validation expects -->
<div class="space-y-1">
    <label class="text-xs font-medium text-gray-700">Sex <span class="text-red-500">*</span></label>
    <div class="flex gap-3">
        <label class="flex-1 cursor-pointer">
            <!-- Try lowercase if validation fails -->
            <input type="radio" name="sex" value="male" required class="peer sr-only">
            <div class="px-4 py-2.5 rounded-lg border border-gray-300 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:text-indigo-700 text-center text-sm transition-all hover:bg-gray-50">
                <span class="flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Male
                </span>
            </div>
        </label>
        <label class="flex-1 cursor-pointer">
            <input type="radio" name="sex" value="female" required class="peer sr-only">
            <div class="px-4 py-2.5 rounded-lg border border-gray-300 peer-checked:border-pink-500 peer-checked:bg-pink-50 peer-checked:text-pink-700 text-center text-sm transition-all hover:bg-gray-50">
                <span class="flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Female
                </span>
            </div>
        </label>
    </div>
</div>

                    <!-- NEW: Contact Number -->
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-gray-700">Contact Number <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <input type="tel" name="contact_number" placeholder="09123456789" required
                                   pattern="[0-9]{11}" 
                                   maxlength="11"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm">
                        </div>
                        <p class="text-xs text-gray-500">11 digits, numbers only</p>
                    </div>
                </div>
            </div>

            <!-- Contact Information Section -->
            <div class="space-y-4 pt-6 border-t border-gray-100">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-1 h-5 bg-indigo-600 rounded-full"></div>
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Contact Information</h3>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-medium text-gray-700">Email Address <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                        <input type="email" name="email" placeholder="teacher@school.edu" required
                               class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm">
                    </div>
                </div>

                <!-- Address Fields - MADE ALL REQUIRED TO ENSURE THEY'RE SAVED -->
                <div class="space-y-3">
                    <label class="text-xs font-medium text-gray-700">Complete Address <span class="text-red-500">*</span></label>
                    <input type="text" name="street_address" placeholder="Street Address (e.g., 123 Main St)" required
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm">
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <input type="text" name="city" placeholder="City" required
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm">
                        <input type="text" name="state_province" placeholder="State/Province" required
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm">
                        <input type="text" name="postal_code" placeholder="Postal Code" required
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm">
                    </div>
                    <input type="text" name="country" placeholder="Country" value="Philippines" required
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm">
                </div>
            </div>

            <!-- Account Credentials Section -->
            <div class="space-y-4 pt-6 border-t border-gray-100">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-1 h-5 bg-indigo-600 rounded-full"></div>
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Account Credentials</h3>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-medium text-gray-700">Username <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <input type="text" name="username" placeholder="juan.santos" required
                               class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Username will be used for login</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="password" id="password" name="password" placeholder="••••••••" required
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm pr-10"
                                   oninput="checkPasswordStrength(this.value)">
                            <button type="button" onclick="togglePassword('password', this)"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                        <!-- Password Strength Indicator -->
                        <div class="flex gap-1 mt-2" id="strengthBars">
                            <div class="h-1 flex-1 rounded-full bg-gray-200 transition-colors duration-300"></div>
                            <div class="h-1 flex-1 rounded-full bg-gray-200 transition-colors duration-300"></div>
                            <div class="h-1 flex-1 rounded-full bg-gray-200 transition-colors duration-300"></div>
                            <div class="h-1 flex-1 rounded-full bg-gray-200 transition-colors duration-300"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1" id="strengthText">Enter at least 8 characters</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-gray-700">Confirm Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all text-sm pr-10"
                                   oninput="checkPasswordMatch()">
                            <button type="button" onclick="togglePassword('password_confirmation', this)"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="text-xs text-red-500 mt-1 hidden" id="matchError">Passwords do not match</p>
                        <p class="text-xs text-green-600 mt-1 hidden" id="matchSuccess">Passwords match</p>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="sticky bottom-0 bg-white border-t border-gray-100 pt-6 flex justify-end gap-3">
                <button type="button" onclick="closeAddTeacherModal()"
                        class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all transform hover:scale-105 active:scale-95 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Save Teacher
                </button>
            </div>

        </form>
    </div>
</div>

<script>
// Enhanced Photo Preview
function previewTeacherPhoto(event) {
    const file = event.target.files[0];
    if (!file) return;
    
    // Validate file size (2MB max)
    if (file.size > 2 * 1024 * 1024) {
        alert('File size must be less than 2MB');
        event.target.value = '';
        return;
    }
    
    const reader = new FileReader();
    reader.onload = function(e) {
        const img = document.getElementById('photoPreview');
        img.src = e.target.result;
        img.classList.add('scale-105');
        setTimeout(() => img.classList.remove('scale-105'), 300);
    };
    reader.readAsDataURL(file);
}

// Toggle Password Visibility
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';
    
    // Update icon
    btn.innerHTML = isPassword 
        ? `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>`
        : `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>`;
}

// Password Strength Checker
function checkPasswordStrength(password) {
    const bars = document.getElementById('strengthBars').children;
    const text = document.getElementById('strengthText');
    
    let strength = 0;
    if (password.length >= 8) strength++;
    if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
    if (password.match(/[0-9]/)) strength++;
    if (password.match(/[^a-zA-Z0-9]/)) strength++;
    
    const colors = ['bg-gray-200', 'bg-red-500', 'bg-yellow-500', 'bg-blue-500', 'bg-green-500'];
    const texts = ['Enter at least 8 characters', 'Weak', 'Fair', 'Good', 'Strong'];
    
    for (let i = 0; i < 4; i++) {
        bars[i].className = `h-1 flex-1 rounded-full transition-colors duration-300 ${i < strength ? colors[strength] : 'bg-gray-200'}`;
    }
    
    text.textContent = texts[strength];
    text.className = `text-xs mt-1 ${strength <= 1 ? 'text-red-500' : strength === 2 ? 'text-yellow-600' : strength === 3 ? 'text-blue-600' : 'text-green-600'}`;
}

// Password Match Checker
function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirm = document.getElementById('password_confirmation').value;
    const error = document.getElementById('matchError');
    const success = document.getElementById('matchSuccess');
    
    if (!confirm) {
        error.classList.add('hidden');
        success.classList.add('hidden');
        return;
    }
    
    if (password !== confirm) {
        error.classList.remove('hidden');
        success.classList.add('hidden');
    } else {
        error.classList.add('hidden');
        success.classList.remove('hidden');
    }
}

// Modal Controls with Animation
function openAddTeacherModal() {
    const modal = document.getElementById('addTeacherModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
    
    // Animate in
    setTimeout(() => {
        modal.querySelector('div').classList.remove('scale-95', 'opacity-0');
        modal.querySelector('div').classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeAddTeacherModal() {
    const modal = document.getElementById('addTeacherModal');
    const content = modal.querySelector('div');
    
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
        // Reset form
        modal.querySelector('form').reset();
        document.getElementById('photoPreview').src = 'https://ui-avatars.com/api/?name=Teacher&background=6366f1&color=fff&size=128';
        document.getElementById('strengthBars').innerHTML = `
            <div class="h-1 flex-1 rounded-full bg-gray-200"></div>
            <div class="h-1 flex-1 rounded-full bg-gray-200"></div>
            <div class="h-1 flex-1 rounded-full bg-gray-200"></div>
            <div class="h-1 flex-1 rounded-full bg-gray-200"></div>
        `;
        document.getElementById('strengthText').textContent = 'Enter at least 8 characters';
        document.getElementById('strengthText').className = 'text-xs text-gray-500 mt-1';
        document.getElementById('matchError').classList.add('hidden');
        document.getElementById('matchSuccess').classList.add('hidden');
    }, 300);
}

// Close on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !document.getElementById('addTeacherModal').classList.contains('hidden')) {
        closeAddTeacherModal();
    }
});
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
<div id="addStudentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl p-6 relative overflow-y-auto max-h-[90vh]">

        <!-- MODAL HEADER -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Add New Student</h2>
            <button type="button" onclick="closeAddStudentModal()" class="text-gray-500 hover:text-red-500 text-2xl font-bold">&times;</button>
        </div>

        <!-- STUDENT FORM -->
        <form method="POST" action="{{ route('admin.students.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- NAMES + LRN -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <input type="text" name="first_name" placeholder="First Name" required value="{{ old('first_name') }}" class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                <input type="text" name="middle_name" placeholder="Middle Name" value="{{ old('middle_name') }}" class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                <input type="text" name="last_name" placeholder="Last Name" required value="{{ old('last_name') }}" class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                <input type="text" name="suffix" placeholder="Suffix (Jr., Sr.)" value="{{ old('suffix') }}" class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">

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

          
            <!-- CONTACT NUMBER & HOME ADDRESS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- CONTACT NUMBER -->
                 
                <div class="flex items-center gap-2 mt-1">
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

            </div>

           

            <!-- PASSWORDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="password" name="password" placeholder="Password" required class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
            </div>

          <!-- PROFILE PHOTO (Add Student) -->
<div class="mb-3 mt-3">
    <label for="addPhoto" class="block text-sm font-medium text-gray-700">Profile Photo</label>
    <input type="file" name="photo" id="addPhoto" accept="image/*" class="mt-1 block w-full">
    <div class="mt-2">
        <img id="addPhotoPreview" src="{{ asset('images/photo-placeholder.png') }}" class="w-24 h-24 object-cover rounded-full border" alt="Photo Preview">
    </div>
</div>

<script>
document.getElementById('addPhoto').addEventListener('change', function(event) {
    const preview = document.getElementById('addPhotoPreview');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        }
        reader.readAsDataURL(file);
    } else {
        // Reset to placeholder if no file selected
        preview.src = "{{ asset('images/photo-placeholder.png') }}";
    }
});
</script>

            <!-- ACTION BUTTONS -->
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeAddStudentModal()" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-lg font-medium">Cancel</button>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow-md font-medium">Save Student</button>
            </div>
        </form>
    </div>
</div>

<!-- ================= SCRIPTS ================= -->
<script>
const prefix = '120231';

function handleLRNInput(input) {
    let numbers = input.value.replace(/\D/g, '');
    let typed = numbers.slice(prefix.length, prefix.length + 6); // max 6 digits
    input.value = prefix + typed;
}

function preventPrefixDeletion(event) {
    const input = event.target;
    const cursorPos = input.selectionStart;

    if ((event.key === 'Backspace' && cursorPos <= prefix.length) ||
        (event.key === 'Delete' && cursorPos < prefix.length)) {
        event.preventDefault();
        input.setSelectionRange(prefix.length, prefix.length);
    }
}

function formatPhone(input) {
    let numbers = input.value.replace(/\D/g, '').substring(0,10);
    let formatted = numbers;
    if (numbers.length > 3 && numbers.length <= 6) formatted = numbers.slice(0,3) + ' ' + numbers.slice(3);
    else if (numbers.length > 6) formatted = numbers.slice(0,3) + ' ' + numbers.slice(3,6) + ' ' + numbers.slice(6);
    input.value = formatted; // +63 shown only visually, not included in input
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