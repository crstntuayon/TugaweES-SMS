<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students | Admin Dashboard</title>
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

    <!-- ENHANCED HEADER -->
    <header class="bg-white/80 backdrop-blur-xl shadow-lg border border-white/50 rounded-2xl px-8 py-6 flex flex-col lg:flex-row lg:items-center justify-between gap-6 sticky top-0 z-40">
        
        <!-- LEFT: Branding -->
        <div class="flex items-center gap-5">
            <a href="{{ route('admin.dashboard') }}"
               class="group p-3 rounded-xl bg-indigo-50 hover:bg-indigo-600 transition-all duration-300 shadow-sm hover:shadow-lg hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-6 w-6 text-indigo-600 group-hover:text-white transition-colors"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M15 19l-7-7 7-7"/>
                </svg>
            </a>

            <div class="flex items-center gap-4">
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
                    <div class="flex items-center gap-2 mb-1">
                        <h1 class="text-2xl font-black text-gray-900 tracking-tight">
                            Student Management
                        </h1>
                        <span class="px-2.5 py-0.5 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold">
                            {{ count($students) }}
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
        </div>

        <!-- RIGHT: Search & Actions -->
        <div class="flex items-center gap-4">
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text"
                       id="studentSearch"
                       placeholder="Search by name or ID..."
                       class="pl-12 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 w-72 transition-all duration-300 font-medium placeholder-gray-400 hover:bg-white">
            </div>

            <button onclick="openAddStudentModal()"
                    class="group relative overflow-hidden bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:shadow-indigo-500/40 transition-all duration-300 flex items-center gap-2 font-semibold">
                <svg class="w-5 h-5 transition-transform group-hover:rotate-90 duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <span>Add Student</span>
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-violet-600 translate-y-full group-hover:translate-y-0 transition-transform duration-300 -z-10"></div>
            </button>
        </div>
    </header>

    <!-- Success Notification -->
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

    <!-- ENHANCED STUDENTS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6 pb-8">
        
        @foreach($students->sortBy('last_name') as $index => $student)
        
        @php
            $enrollment = $student->enrollments()->where('school_year_id', $activeYear->id)->first();
            $status = $enrollment->status ?? 'N/A';
            
            $statusConfig = match($status) {
                'enrolled' => ['bg-emerald-50 text-emerald-700 border-emerald-200', 'bg-emerald-500', 'Enrolled'],
                'unenrolled' => ['bg-red-50 text-red-700 border-red-200', 'bg-red-500', 'Unenrolled'],
                'promoted' => ['bg-blue-50 text-blue-700 border-blue-200', 'bg-blue-500', 'Promoted'],
                'retained' => ['bg-amber-50 text-amber-700 border-amber-200', 'bg-amber-500', 'Retained'],
                'transferred' => ['bg-violet-50 text-violet-700 border-violet-200', 'bg-violet-500', 'Transferred'],
                default => ['bg-gray-50 text-gray-700 border-gray-200', 'bg-gray-500', 'N/A'],
            };
            
            $delay = ($index % 8) * 0.05;
        @endphp

        <!-- ENHANCED CARD -->
        <div class="group relative bg-white rounded-3xl shadow-sm border border-gray-100 hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-2 transition-all duration-500 overflow-hidden student-row"
             data-search="{{ strtolower($student->first_name.' '.$student->middle_name.' '.$student->last_name.' '.$student->school_id) }}"
             style="animation: fadeInUp 0.6s ease-out {{ $delay }}s both;">
            
            <!-- Status Indicator Strip -->
            <div class="absolute top-0 left-0 w-full h-1.5 {{ $statusConfig[1] }}"></div>
            
            <!-- Card Header with Gradient -->
            <div class="h-28 bg-gradient-to-br from-indigo-500/10 to-violet-500/10 relative overflow-hidden">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%236366f1\' fill-opacity=\'0.03\' fill-rule=\'evenodd\'%3E%3Ccircle cx=\'3\' cy=\'3\' r=\'3\'/%3E%3Ccircle cx=\'13\' cy=\'13\' r=\'3\'/%3E%3C/g%3E%3C/svg%3E')]"></div>
                
                <!-- Edit Button Only -->
                <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <button onclick="openEditStudentModal(this)"
                            data-id="{{ $student->id }}"
                            data-first="{{ $student->first_name }}"
                            data-middle="{{ $student->middle_name ?? '' }}"
                            data-last="{{ $student->last_name }}"
                            data-suffix="{{ $student->suffix ?? '' }}"
                            data-birthday="{{ $student->birthday }}"
                            data-email="{{ $student->email }}"
                            data-contact="{{ $student->contact_number ?? '' }}"
                            data-sex="{{ $student->sex ?? '' }}"
                            data-address="{{ $student->address ?? '' }}"
                            data-photo="{{ $student->photo ?? '' }}"
                            class="p-2 bg-white/90 backdrop-blur rounded-lg shadow-lg hover:bg-amber-50 transition-colors"
                            title="Edit Student">
                        <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Photo -->
            <div class="relative -mt-12 mb-4 flex justify-center">
                <div class="relative">
                    <div class="w-24 h-24 rounded-2xl p-1 bg-white shadow-xl">
                        <img src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/photo-placeholder.png') }}"
                             class="w-full h-full rounded-xl object-cover bg-gray-100"
                             alt="{{ $student->first_name }}">
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-7 h-7 {{ $statusConfig[1] }} rounded-full border-4 border-white shadow-md flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="px-6 pb-6 space-y-4">
                
                <!-- Name Section -->
                <div class="text-center space-y-1">
                    <h3 class="font-bold text-gray-900 text-lg leading-tight group-hover:text-indigo-600 transition-colors">
                        {{ $student->last_name }}, {{ $student->first_name }}
                    </h3>
                    <p class="text-sm text-gray-500 font-medium">
                        {{ $student->middle_name }} {{ $student->suffix }}
                    </p>
                </div>

                <!-- Meta Info -->
                <div class="flex items-center justify-center gap-3 text-xs">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100 text-gray-600 font-semibold">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                        </svg>
                        {{ $student->school_id }}
                    </span>
                </div>

                <!-- Section & Status -->
                <div class="space-y-2 pt-2">
                    <div class="flex items-center justify-between px-3 py-2 bg-gray-50 rounded-xl">
                        <span class="text-xs text-gray-500 font-medium">Section</span>
                        <span class="text-sm font-bold text-gray-800">
                            {{ $enrollment->section->name ?? 'Not Assigned' }}
                        </span>
                    </div>
                    
                    <div class="flex justify-center">
                        <span class="px-4 py-1.5 text-xs font-bold rounded-full border {{ $statusConfig[0] }} shadow-sm">
                            {{ $statusConfig[2] }}
                        </span>
                    </div>
                </div>

                <!-- School Forms Button -->
                <div class="pt-2">
                    <button onclick="toggleSchoolForms({{ $student->id }})"
                            class="w-full group/btn bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-3 rounded-xl text-sm font-semibold shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:shadow-indigo-500/40 transition-all duration-300 flex items-center justify-center gap-2 relative overflow-hidden">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>School Forms</span>
                        <svg class="w-4 h-4 transition-transform group-hover/btn:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- School Forms Dropdown -->
            <div id="schoolForms{{ $student->id }}"
                 class="hidden absolute bottom-24 left-4 right-4 bg-white border border-gray-100 rounded-2xl shadow-2xl overflow-hidden z-50 animate-dropdown">
                
                <div class="px-4 py-3 bg-gradient-to-r from-indigo-600 to-violet-600 text-white flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-sm font-bold">School Forms</p>
                    </div>
                    <span class="text-xs bg-white/20 px-2 py-0.5 rounded-full">{{ $student->first_name }}</span>
                </div>

                <div class="p-3 space-y-2">
                    <!-- SF9 - Report Card -->
                    <a href="{{ route('admin.sf9.show', $student->id) }}"
                       class="flex items-center gap-4 p-3 rounded-xl bg-gradient-to-r from-emerald-50 to-transparent hover:from-emerald-100 hover:to-emerald-50 transition-all duration-300 group/form border border-transparent hover:border-emerald-200">
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shadow-sm group-hover/form:scale-110 transition-transform">
                            <span class="font-black text-lg">SF9</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 text-sm">Learner's Progress Report</p>
                            <p class="text-xs text-gray-500">Report Card · Grades & Attendance</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover/form:text-emerald-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                    <!-- SF10 - Permanent Record -->
                    <a href="{{ route('admin.sf10.show', $student->id) }}"
                       class="flex items-center gap-4 p-3 rounded-xl bg-gradient-to-r from-blue-50 to-transparent hover:from-blue-100 hover:to-blue-50 transition-all duration-300 group/form border border-transparent hover:border-blue-200">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center shadow-sm group-hover/form:scale-110 transition-transform">
                            <span class="font-black text-lg">SF10</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 text-sm">Permanent Record</p>
                            <p class="text-xs text-gray-500">School Credentials · Historical Data</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover/form:text-blue-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="px-4 py-2 bg-gray-50 border-t border-gray-100">
                    <p class="text-xs text-gray-500 text-center">Official DepEd School Forms</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Empty State -->
    @if(count($students) === 0)
    <div class="text-center py-20 animate-fadeInUp">
        <div class="w-32 h-32 mx-auto mb-6 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center shadow-inner">
            <svg class="w-16 h-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">No students found</h3>
        <p class="text-gray-500 mb-6">Get started by adding your first student to the system.</p>
        <button onclick="openAddStudentModal()" class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30">
            Add First Student
        </button>
    </div>
    @endif

    <!-- No Search Results State -->
    <div id="noSearchResults" class="hidden text-center py-20">
        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-2">No matching students</h3>
        <p class="text-gray-500">Try adjusting your search terms.</p>
    </div>
</main>

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes dropdown {
    from {
        opacity: 0;
        transform: translateY(10px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.animate-dropdown {
    animation: dropdown 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

/* Smooth scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}
::-webkit-scrollbar-track {
    background: transparent;
}
::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}
::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Search highlight */
.student-row.hidden {
    display: none;
}
</style>

<script>
// Toggle School Forms Dropdown
function toggleSchoolForms(studentId) {
    const dropdown = document.getElementById('schoolForms' + studentId);
    const allDropdowns = document.querySelectorAll('[id^="schoolForms"]');
    
    // Close others
    allDropdowns.forEach(d => {
        if (d.id !== 'schoolForms' + studentId) {
            d.classList.add('hidden');
        }
    });
    
    // Toggle current
    dropdown.classList.toggle('hidden');
}

// Enhanced Search Functionality
document.getElementById('studentSearch').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('.student-row');
    let visibleCount = 0;
    
    cards.forEach(card => {
        const searchData = card.getAttribute('data-search');
        if (searchData.includes(searchTerm)) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    const noResults = document.getElementById('noSearchResults');
    if (visibleCount === 0 && searchTerm !== '') {
        noResults.classList.remove('hidden');
    } else {
        noResults.classList.add('hidden');
    }
});

// Close dropdowns when clicking outside
document.addEventListener('click', function(e) {
    const dropdowns = document.querySelectorAll('[id^="schoolForms"]');
    dropdowns.forEach(dropdown => {
        if (!dropdown.contains(e.target) && !e.target.closest('button[onclick^="toggleSchoolForms"]')) {
            dropdown.classList.add('hidden');
        }
    });
});
</script>




<!-- ================= ADD STUDENT MODAL ================= -->
<div id="addStudentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl p-6 relative overflow-y-auto max-h-[90vh]">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Add New Student</h2>
            <button type="button" onclick="closeAddStudentModal()" class="text-gray-500 hover:text-red-500 text-2xl font-bold">&times;</button>
        </div>

        <!-- FORM -->
        <form method="POST" action="{{ route('admin.students.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- NAMES + LRN -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <input type="text" name="first_name" placeholder="First Name" required value="{{ old('first_name') }}" class="px-4 py-2 rounded-lg border">
                <input type="text" name="middle_name" placeholder="Middle Name" value="{{ old('middle_name') }}" class="px-4 py-2 rounded-lg border">
                <input type="text" name="last_name" placeholder="Last Name" required value="{{ old('last_name') }}" class="px-4 py-2 rounded-lg border">
                <input type="text" name="suffix" placeholder="Suffix (Jr., Sr.)" value="{{ old('suffix') }}" class="px-4 py-2 rounded-lg border">
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

<script>
function toggleFormDropdown(studentId) {
    let dropdown = document.getElementById('formDropdown' + studentId);

    // Close other dropdowns first
    document.querySelectorAll('[id^="formDropdown"]').forEach(menu => {
        if(menu !== dropdown){
            menu.classList.add('hidden');
        }
    });

    dropdown.classList.toggle('hidden');
}

document.addEventListener('click', function(event) {

    document.querySelectorAll('[id^="formDropdown"]').forEach(dropdown => {

        let button = dropdown.parentElement.querySelector('button');

        if(!dropdown.contains(event.target) && !button.contains(event.target)){
            dropdown.classList.add('hidden');
        }

    });

});
</script>

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


          

            <!-- CONTACT NUMBER & ADDRESS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Contact Number -->
                <div class="mt-1 flex items-center gap-2">
    <!-- Visual +63 only -->
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

<script>
function formatPhone(input) {
    let numbers = input.value.replace(/\D/g, '').substring(0,10); // max 10 digits (without +63)
    
    // Format as XXX XXX XXXX
    let formatted = numbers;
    if (numbers.length > 3 && numbers.length <= 6) formatted = numbers.slice(0,3) + ' ' + numbers.slice(3);
    else if (numbers.length > 6) formatted = numbers.slice(0,3) + ' ' + numbers.slice(3,6) + ' ' + numbers.slice(6);
    
    input.value = formatted; // DO NOT prepend +63 here
}
</script>

               
            </div>

           

            <!-- PASSWORDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="password" name="password" placeholder="Password" required class="px-4 py-2 rounded-lg border">
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required class="px-4 py-2 rounded-lg border">
            </div>

            <!-- PROFILE PHOTO -->
            <div class="mb-3 mt-3">
                <label for="addPhoto" class="block text-sm font-medium text-gray-700">Profile Photo</label>
                <input type="file" name="photo" id="addPhoto" accept="image/*" class="mt-1 block w-full">
                <div class="mt-2">
                    <img id="addPhotoPreview" src="{{ asset('images/photo-placeholder.png') }}" class="w-24 h-24 object-cover rounded-full border" alt="Photo Preview">
                </div>
            </div>

            <!-- BUTTONS -->
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeAddStudentModal()" class="bg-gray-300 px-4 py-2 rounded-lg font-medium">Cancel</button>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg shadow-md font-medium">Save Student</button>
            </div>
        </form>
    </div>
</div>




<!-- ================= EDIT STUDENT MODAL ================= -->
<div id="editStudentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl p-6 relative overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-bold mb-4">Edit Student</h2>
        <form id="editStudentForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- NAME FIELDS -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="first_name" id="edit_student_first" placeholder="First Name" class="px-4 py-2 border rounded-lg" required>
                <input type="text" name="middle_name" id="edit_student_middle" placeholder="Middle Name" class="px-4 py-2 border rounded-lg">
                <input type="text" name="last_name" id="edit_student_last" placeholder="Last Name" class="px-4 py-2 border rounded-lg" required>
                <input type="text" name="suffix" id="edit_student_suffix" placeholder="Suffix" class="px-4 py-2 border rounded-lg">
            </div>

            <!-- BIRTHDAY FIELD -->
            <input type="date" name="birthday" id="edit_student_birthday" class="w-full mt-3 px-4 py-2 border rounded-lg" required>
           
           <!-- EMAIL FIELD (READONLY) -->
           <div class="relative mt-3">
    <label for="edit_student_email" class="block text-gray-700 text-sm font-medium mb-1">
        Email Address
    </label>
    <input type="email"
           name="email"
           id="edit_student_email"
           placeholder="Email Address"
          value="{{ old('email', $student->email ?? '') }}"
           readonly
           class="w-full mt-1 px-4 py-2 border rounded-lg bg-gray-100 cursor-not-allowed"
           onfocus="showEmailTooltip()">

    <!-- Tooltip -->
    <span id="emailTooltip"
          class="absolute left-2 top-full mt-1 text-xs text-white bg-gray-800 px-2 py-1 rounded opacity-0 transition-opacity duration-300 pointer-events-none">
        This field is uneditable
    </span>
</div>

<script>
function showEmailTooltip() {
    const tooltip = document.getElementById('emailTooltip');
    tooltip.classList.add('opacity-100'); // Show tooltip
    setTimeout(() => {
        tooltip.classList.remove('opacity-100'); // Hide after 2 seconds
    }, 2000);
}
</script>

       <!-- CONTACT NUMBER -->
            <input type="text" name="contact_number" id="edit_student_contact" placeholder="Contact Number" class="w-full mt-3 px-4 py-2 border rounded-lg">

       <!--SEX SELECTION-->
            <select name="sex" id="edit_student_sex" class="w-full mt-3 px-4 py-2 border rounded-lg" required>
                <option value="">Select Sex</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

        <!-- ADDRESS FIELD WITH SUGGESTIONS -->
            <div class="mt-3">
                <label for="edit_student_address" class="block text-gray-700 text-sm font-medium mb-1">Home Address</label>
                <input list="addresses_list" id="edit_student_address" name="address" placeholder="Enter your address" class="w-full px-4 py-2 rounded-lg border">
                <datalist id="addresses_list">
                    <option value="Bulak, Dauin, Negros Oriental">
                    <option value="Libjo, Dauin, Negros Oriental">
                    <option value="Lipayo, Dauin, Negros Oriental">
                    <option value="Mag-aso, Dauin, Negros Oriental">
                    <option value="Tugawe, Dauin, Negros Oriental">
                </datalist>
            </div>

            <!--EDIT PHOTO-->
            <div class="mb-3 mt-3">
                <label for="editPhoto" class="block text-sm font-medium text-gray-700">Profile Photo</label>
                <input type="file" name="photo" id="editPhoto" accept="image/*" class="mt-1 block w-full">
                <div class="mt-2">
                    <img id="photoPreview" src="{{ asset('images/photo-placeholder.png') }}" class="w-24 h-24 object-cover rounded-full border" alt="Photo Preview">
                </div>
            </div>


            <div class="flex justify-end gap-3 mt-4">
                <button type="button" onclick="closeEditStudentModal()" class="bg-gray-300 px-4 py-2 rounded-lg">Cancel</button>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg">Update</button>
            </div>
        </form>
        <button onclick="closeEditStudentModal()" class="absolute top-3 right-3 text-xl">✕</button>
    </div>
</div>

<script>
/* ------------------ MODAL FUNCTIONS ------------------ */
function openAddStudentModal() {
    document.getElementById('addStudentModal').classList.remove('hidden');
    document.getElementById('addStudentModal').classList.add('flex');
}
function closeAddStudentModal() {
    document.getElementById('addStudentModal').classList.add('hidden');
    document.getElementById('addStudentModal').classList.remove('flex');
}
function openEditStudentModal(button) {
    const modal = document.getElementById('editStudentModal');
    const form = document.getElementById('editStudentForm');
    form.action = `{{ url('admin/students') }}/${button.dataset.id}`;
    document.getElementById('edit_student_first').value = button.dataset.first;
    document.getElementById('edit_student_middle').value = button.dataset.middle || '';
    document.getElementById('edit_student_last').value = button.dataset.last;
    document.getElementById('edit_student_suffix').value = button.dataset.suffix || '';
    document.getElementById('edit_student_birthday').value = button.dataset.birthday || '';
    document.getElementById('edit_student_email').value = button.dataset.email || '';
    document.getElementById('edit_student_contact').value = button.dataset.contact || '';
    document.getElementById('edit_student_sex').value = button.dataset.sex || '';
    document.getElementById('edit_student_address').value = button.dataset.address || '';
    document.getElementById('photoPreview').src = button.dataset.photo ? `{{ asset('storage') }}/${button.dataset.photo}` : '{{ asset("images/photo-placeholder.png") }}';
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeEditStudentModal() {
    const modal = document.getElementById('editStudentModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

/* ------------------ PHOTO PREVIEW ------------------ */
document.getElementById('editPhoto').addEventListener('change', function(){
    const file = this.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = e => document.getElementById('photoPreview').src = e.target.result;
        reader.readAsDataURL(file);
    } else {
        document.getElementById('photoPreview').src = '{{ asset("images/photo-placeholder.png") }}';
    }
});
document.getElementById('addPhoto').addEventListener('change', function(){
    const file = this.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = e => document.getElementById('addPhotoPreview').src = e.target.result;
        reader.readAsDataURL(file);
    } else {
        document.getElementById('addPhotoPreview').src = '{{ asset("images/photo-placeholder.png") }}';
    }
});

/* ------------------ SEARCH FILTER ------------------ */
document.getElementById('studentSearch').addEventListener('input', function(){
    const query = this.value.toLowerCase();
    document.querySelectorAll('.student-row').forEach(row => {
        const text = row.dataset.search;
        row.style.display = text.includes(query) ? '' : 'none';
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


</div>
</body>
</html>
