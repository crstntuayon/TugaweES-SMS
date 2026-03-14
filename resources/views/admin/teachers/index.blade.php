<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teachers | Admin Dashboard</title>
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


 <main class="flex-1 p-8 space-y-8 overflow-y-auto h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-emerald-50/30">

    <!-- ENHANCED HEADER -->
    <header class="sticky top-0 z-50 backdrop-blur-xl bg-white/70 border border-white/50 shadow-lg rounded-2xl">
        <div class="max-w-7xl mx-auto px-8 py-5">

            <!-- TOP ROW -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                <!-- LEFT: BACK + LOGO + TITLE -->
                <div class="flex items-center gap-5">
                    <a href="{{ route('admin.dashboard') }}"
                       class="group p-3 rounded-xl bg-emerald-50 hover:bg-emerald-500 text-emerald-600 hover:text-white shadow-sm hover:shadow-lg transition-all duration-300 hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:-translate-x-1" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>

                    <div class="relative">
                        <img src="{{ asset('images/logo.png') }}"
                             class="h-14 w-14 rounded-2xl shadow-lg ring-4 ring-emerald-100 object-cover"
                             alt="School Logo">
                        <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 rounded-full border-3 border-white shadow-sm flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center gap-3">
                            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Teacher Management</h1>
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                                {{ count($teachers) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 font-medium flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Tugawe Elementary School
                        </p>
                    </div>
                </div>

                <!-- RIGHT: SEARCH + ADD BUTTON -->
                <div class="flex flex-col sm:flex-row items-center gap-4 w-full sm:w-auto">

                    <!-- ENHANCED SEARCH -->
                    <div class="relative group w-full sm:w-72">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" id="teacherSearch" placeholder="Search by name or email..."
                               class="pl-12 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl w-full focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all duration-300 font-medium placeholder-gray-400 hover:bg-white"
                               onkeyup="filterTeachers()">
                    </div>

                    <!-- ENHANCED ADD BUTTON -->
                    <button onclick="openAddTeacherModal()"
                            class="group relative overflow-hidden bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg shadow-emerald-500/30 hover:shadow-xl hover:shadow-emerald-500/40 transition-all duration-300 whitespace-nowrap flex items-center gap-2">
                        <svg class="w-5 h-5 transition-transform group-hover:rotate-90 duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span>Add Teacher</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-teal-600 translate-y-full group-hover:translate-y-0 transition-transform duration-300 -z-10"></div>
                    </button>

                </div>

            </div>
        </div>
    </header>

    <!-- ENHANCED SUCCESS ALERT -->
    @if(session('success'))
    <div id="successAlert"
         class="flex items-center justify-between gap-4 bg-emerald-50 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-2xl shadow-lg shadow-emerald-500/10 transition-all duration-500 animate-slideIn">

        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-6 w-6 text-emerald-600"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <p class="font-bold text-emerald-900">Success!</p>
                <span class="text-emerald-700">
                    {{ session('success') }}
                </span>
            </div>
        </div>

        <button onclick="closeSuccessAlert()"
                class="w-8 h-8 rounded-full hover:bg-emerald-100 flex items-center justify-center text-emerald-600 hover:text-emerald-800 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <style>
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-slideIn {
        animation: slideIn 0.4s ease-out forwards;
    }
    </style>

    <script>
    function closeSuccessAlert(){
        const alert = document.getElementById('successAlert');
        if(alert){
            alert.classList.add('opacity-0', 'translate-x-full');
            setTimeout(() => alert.remove(), 500);
        }
    }

    // auto-hide after 5 seconds
    setTimeout(() => {
        closeSuccessAlert();
    }, 5000);
    </script>
    @endif

    <!-- ENHANCED TEACHERS GRID -->
    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl border border-gray-100 p-8">

        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Teachers List</h2>
                    <p class="text-sm text-gray-500">Manage faculty members and their profiles</p>
                </div>
            </div>
            
            <!-- Grid View Toggle (Optional) -->
            <div class="hidden sm:flex items-center gap-2 bg-gray-100 p-1 rounded-lg">
                <button class="p-2 rounded-md bg-white shadow-sm text-gray-700">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- TEACHERS GRID -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            @forelse($teachers->sortBy('last_name')->values() as $index => $teacher)
            
            @php
                $delay = ($index % 8) * 0.05;
                $initials = strtoupper(substr($teacher->first_name, 0, 1) . substr($teacher->last_name, 0, 1));
            @endphp

            <!-- ENHANCED CARD -->
            <div class="group relative bg-white rounded-3xl shadow-sm border border-gray-100 hover:shadow-2xl hover:shadow-emerald-500/10 hover:-translate-y-2 transition-all duration-500 overflow-hidden animate-fadeIn"
                 style="animation-delay: {{ $delay }}s"
                 data-teacher-name="{{ strtolower($teacher->first_name.' '.$teacher->middle_name.' '.$teacher->last_name) }}"
                 data-teacher-email="{{ strtolower($teacher->email) }}">

                <!-- Card Header with Gradient -->
                <div class="h-24 bg-gradient-to-br from-emerald-500/10 to-teal-500/10 relative overflow-hidden">
                    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%2310b981\' fill-opacity=\'0.03\' fill-rule=\'evenodd\'%3E%3Ccircle cx=\'3\' cy=\'3\' r=\'3\'/%3E%3Ccircle cx=\'13\' cy=\'13\' r=\'3\'/%3E%3C/g%3E%3C/svg%3E')]"></div>
                </div>

                <!-- Photo -->
                <div class="relative -mt-10 mb-4 flex justify-center">
                    <div class="relative">
                        @if($teacher->photo)
                            <div class="w-20 h-20 rounded-2xl p-1 bg-white shadow-xl">
                                <img src="{{ asset('storage/'.$teacher->photo) }}"
                                     class="w-full h-full rounded-xl object-cover bg-gray-100"
                                     alt="{{ $teacher->first_name }}">
                            </div>
                        @else
                            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white text-xl font-bold shadow-xl">
                                {{ $initials }}
                            </div>
                        @endif
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-emerald-500 rounded-full border-4 border-white shadow-md flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="px-6 pb-6 text-center space-y-3">
                    
                    <!-- Name -->
                    <div>
                        <h3 class="font-bold text-gray-900 text-lg leading-tight group-hover:text-emerald-600 transition-colors">
                            {{ $teacher->first_name }} {{ $teacher->middle_name }}
                        </h3>
                        <p class="font-bold text-gray-800 text-lg">
                            {{ $teacher->last_name }} {{ $teacher->suffix }}
                        </p>
                    </div>

                    <!-- Email -->
                    <div class="flex items-center justify-center gap-2 text-sm text-gray-500 bg-gray-50 rounded-lg py-2 px-3 mx-4">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span class="truncate">{{ $teacher->email }}</span>
                    </div>

                    <!-- Action Button -->
                    <div class="pt-2">
                        <button onclick="openTeacherModal({{ $teacher->id }})"
                                class="w-full group/btn bg-gray-900 hover:bg-emerald-600 text-white px-4 py-3 rounded-xl text-sm font-semibold shadow-lg shadow-gray-900/20 hover:shadow-emerald-500/30 transition-all duration-300 flex items-center justify-center gap-2 relative overflow-hidden">
                            <span class="relative z-10 flex items-center gap-2">
                                View Profile
                                <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-teal-600 translate-y-full group-hover/btn:translate-y-0 transition-transform duration-300"></div>
                        </button>
                    </div>
                </div>
            </div>

            @empty

            <!-- ENHANCED EMPTY STATE -->
            <div class="col-span-full text-center py-20 animate-fadeIn">
                <div class="w-32 h-32 mx-auto mb-6 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center shadow-inner">
                    <svg class="w-16 h-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No teachers found</h3>
                <p class="text-gray-500 mb-6 max-w-md mx-auto">Get started by adding your first teacher to the system.</p>
                <button onclick="openAddTeacherModal()" class="bg-emerald-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-emerald-700 transition shadow-lg shadow-emerald-500/30 inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add First Teacher
                </button>
            </div>

            @endforelse

        </div>
    </div>

    <!-- No Search Results State -->
    <div id="noSearchResults" class="hidden text-center py-20">
        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-2">No matching teachers</h3>
        <p class="text-gray-500">Try adjusting your search terms.</p>
    </div>
</main>

<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.6s ease-out forwards;
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
</style>

<script>
// Enhanced Filter Function
function filterTeachers() {
    const input = document.getElementById('teacherSearch');
    const filter = input.value.toLowerCase();
    const cards = document.querySelectorAll('[data-teacher-name]');
    let visibleCount = 0;

    cards.forEach(card => {
        const name = card.getAttribute('data-teacher-name');
        const email = card.getAttribute('data-teacher-email');
        
        if (name.includes(filter) || email.includes(filter)) {
            card.style.display = "";
            visibleCount++;
        } else {
            card.style.display = "none";
        }
    });

    const noResults = document.getElementById('noSearchResults');
    const gridContainer = document.querySelector('.grid');
    
    if (visibleCount === 0 && filter !== '') {
        noResults.classList.remove('hidden');
        gridContainer.classList.add('hidden');
    } else {
        noResults.classList.add('hidden');
        gridContainer.classList.remove('hidden');
    }
}
</script>


<!-- Teacher Profile Modal -->
<div id="teacherModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50 p-4 overflow-auto backdrop-blur-sm">
    <div class="bg-white rounded-lg shadow-2xl w-full max-w-5xl relative overflow-hidden flex flex-col max-h-[95vh]">
        
        <!-- Icon Toolbar -->
        <div class="no-print bg-slate-100 border-b border-slate-300 px-4 py-3 flex justify-between items-center sticky top-0 z-10">
            <div class="flex items-center gap-2">
                <span class="font-bold text-slate-700 text-sm tracking-wide uppercase">Teacher Profile</span>
                <span id="editIndicator" class="hidden bg-amber-400 text-amber-900 text-xs px-2 py-0.5 rounded font-bold uppercase tracking-wider">Edit Mode</span>
            </div>
            
            <div class="flex items-center gap-2">
                <!-- Edit Icon - Yellow -->
                <button id="editBtn" onclick="enableEditMode()" 
                    class="w-9 h-9 rounded bg-yellow-400 text-yellow-900 flex items-center justify-center shadow-sm" 
                    title="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.213 3 21l1.787-4.5 12.075-13.013z" />
                    </svg>
                </button>

                <!-- Save Icon - Green -->
                <button id="saveBtn" onclick="saveTeacherChanges()" 
                    class="hidden w-9 h-9 rounded bg-green-500 text-white flex items-center justify-center shadow-sm" 
                    title="Save">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </button>

                <!-- Cancel Icon - Red -->
                <button id="cancelBtn" onclick="cancelEditMode()" 
                    class="hidden w-9 h-9 rounded bg-red-500 text-white flex items-center justify-center shadow-sm" 
                    title="Cancel">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Print Icon - Blue -->
                <button onclick="printTeacherProfile()" 
                    class="w-9 h-9 rounded bg-blue-600 text-white flex items-center justify-center shadow-sm" 
                    title="Print">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                </button>

                <!-- Close Icon - Gray -->
                <button onclick="closeTeacherModal()" 
                    class="w-9 h-9 rounded bg-slate-500 text-white flex items-center justify-center shadow-sm" 
                    title="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="overflow-auto flex-1 bg-white p-4" id="teacherModalContent"></div>
    </div>
</div>

<style>
    /* Print Styles - Optimized for Legal/A4 */
    @media print {
        @page {
            size: auto;
            margin: 8mm;
        }
        
        body * {
            visibility: hidden;
        }
        
        #teacherModal,
        #teacherModal * {
            visibility: visible;
        }
        
        #teacherModal {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            min-height: 100%;
            overflow: visible;
            background: white;
            padding: 0;
            display: block !important;
            z-index: 99999;
        }
        
        .no-print {
            display: none !important;
        }
        
        #teacherModalContent {
            overflow: visible;
            padding: 0;
            width: 100%;
            max-width: 100%;
        }
        
        .main-table {
            width: 100% !important;
            max-width: 100% !important;
            font-size: 8.5pt !important;
            border: 1.5pt solid #1e40af !important;
        }
        
        .main-table th,
        .main-table td {
            padding: 3pt 5pt !important;
            border: 0.5pt solid #64748b !important;
        }
        
        .header-cell {
            padding: 6pt !important;
        }
        
        .photo-cell {
            width: 90pt !important;
            height: 110pt !important;
        }
        
        .signature-grid {
            page-break-inside: avoid;
        }
        
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }

    /* Main Table Styles */
    .main-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 9.5pt;
        border: 2px solid #1e40af;
        background: white;
    }

    .main-table th,
    .main-table td {
        border: 1px solid #64748b;
        padding: 5px 8px;
        vertical-align: middle;
    }

    .header-cell {
        background: #1e40af;
        color: white;
        text-align: center;
        font-weight: bold;
        font-size: 11pt;
        padding: 10px;
    }

    .section-head {
        background: #475569;
        color: white;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 9pt;
        letter-spacing: 0.5px;
    }

    .label {
        background: #f1f5f9;
        font-weight: 600;
        width: 15%;
        color: #334155;
        font-size: 9pt;
        white-space: nowrap;
    }

    .photo-cell {
        width: 120px;
        height: 150px;
        padding: 0 !important;
        text-align: center;
        vertical-align: middle;
        background: #f8fafc;
        border: 2px solid #1e40af;
    }

    .photo-cell img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .photo-upload {
        width: 100%;
        height: 100%;
        background: #eff6ff;
        border: 2px dashed #3b82f6;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        gap: 4px;
        position: relative;
        overflow: hidden;
    }

    .photo-upload:hover {
        background: #dbeafe;
    }

    .photo-upload img {
        position: absolute;
        top: 0;
        left: 0;
    }

    .photo-hint {
        position: relative;
        z-index: 10;
        background: rgba(255,255,255,0.9);
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 8pt;
        color: #2563eb;
        pointer-events: none;
    }

    /* Nested Table for Teaching Load */
    .nested-table {
        width: 100%;
        border-collapse: collapse;
    }

    .nested-table th,
    .nested-table td {
        border: 1px solid #64748b;
        padding: 4px 6px;
        text-align: center;
        font-size: 9pt;
    }

    .nested-table th {
        background: #e2e8f0;
        font-weight: 600;
        color: #334155;
    }

    .nested-table tbody tr:nth-child(even) {
        background: #f8fafc;
    }

    /* Edit Mode Styles */
    .edit-input {
        width: 100%;
        border: 2px solid #fbbf24;
        background: #fef3c7;
        padding: 3px 6px;
        font-size: 9pt;
        font-family: inherit;
        border-radius: 3px;
        transition: all 0.15s ease;
    }

    .edit-input:focus {
        outline: none;
        border-color: #f59e0b;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.2);
    }

    .edit-input::placeholder {
        color: #9ca3af;
        font-size: 8pt;
    }

    select.edit-input {
        cursor: pointer;
    }

    /* Action Buttons */
    .icon-btn {
        width: 24px;
        height: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border-radius: 4px;
        border: none;
        transition: transform 0.1s;
    }

    .icon-btn:active {
        transform: scale(0.95);
    }

    .icon-del { 
        background: #dc2626; 
        color: white; 
    }
    
    .icon-del:hover {
        background: #b91c1c;
    }

    .icon-add { 
        background: #2563eb; 
        color: white; 
    }
    
    .icon-add:hover {
        background: #1d4ed8;
    }

    /* Signature Section */
    .signature-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 15px;
    }

    .signature-block {
        text-align: center;
    }

    .signature-line {
        border-top: 1px solid #000;
        padding-top: 6px;
        margin-top: 50px;
        min-height: 60px;
    }

    .signature-label {
        font-size: 8pt;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        margin-top: 4px;
    }

    .stamp-box {
        width: 80px;
        height: 80px;
        border: 2px solid #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 7pt;
        text-align: center;
        margin-left: auto;
    }

    /* Countdown Notification */
    .countdown-notif {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #16a34a;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10000;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
        font-weight: 500;
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    .countdown-bar {
        width: 40px;
        height: 40px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .countdown-bar svg {
        transform: rotate(-90deg);
        width: 40px;
        height: 40px;
    }

    .countdown-bar circle {
        fill: none;
        stroke-width: 3;
    }

    .countdown-bar .bg {
        stroke: rgba(255,255,255,0.3);
    }

    .countdown-bar .progress {
        stroke: white;
        stroke-linecap: round;
        stroke-dasharray: 113;
        stroke-dashoffset: 0;
        transition: stroke-dashoffset 1s linear;
    }

    .countdown-text {
        position: absolute;
        font-size: 12px;
        font-weight: bold;
    }

    /* Utility Classes */
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .font-bold { font-weight: 700; }
    .text-blue-900 { color: #1e3a8a; }
    .text-gray-500 { color: #6b7280; }
    .text-gray-600 { color: #4b5563; }
    .bg-gray-50 { background: #f9fafb; }
    .italic { font-style: italic; }
    .mb-2 { margin-bottom: 8px; }
    .mb-3 { margin-bottom: 12px; }
    .mt-4 { margin-top: 16px; }
    .mt-8 { margin-top: 32px; }
    .p-2 { padding: 8px; }
    .py-3 { padding-top: 12px; padding-bottom: 12px; }
    .flex { display: flex; }
    .flex-col { flex-direction: column; }
    .items-center { align-items: center; }
    .justify-center { justify-content: center; }
    .justify-between { justify-content: space-between; }
    .gap-2 { gap: 8px; }
    .gap-3 { gap: 12px; }
    .w-full { width: 100%; }
    .w-16 { width: 64px; }
    .w-20 { width: 80px; }
    .w-24 { width: 96px; }
    .h-10 { height: 40px; }
    .h-auto { height: auto; }
    .hidden { display: none; }
</style>

<script>
// Global State
const activeSchoolYear = @json($activeSchoolYear);
const teachers = @json($teachers->load('sections'));
let currentTeacher = null;
let originalTeacher = null;
let isEditing = false;
let photoFile = null;

/**
 * Open modal with teacher data
 */
function openTeacherModal(teacherId) {
    const found = teachers.find(t => t.id === teacherId);
    if (!found) {
        console.error('Teacher not found:', teacherId);
        return;
    }
    
    currentTeacher = JSON.parse(JSON.stringify(found));
    originalTeacher = JSON.parse(JSON.stringify(found));
    photoFile = null;
    isEditing = false;
    
    renderTeacherDocument();
    
    const modal = document.getElementById('teacherModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

/**
 * Close modal and reset state
 */
function closeTeacherModal() {
    isEditing = false;
    photoFile = null;
    currentTeacher = null;
    
    const modal = document.getElementById('teacherModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
    
    resetToolbar();
}

/**
 * Reset toolbar buttons to initial state
 */
function resetToolbar() {
    document.getElementById('editBtn').classList.remove('hidden');
    document.getElementById('saveBtn').classList.add('hidden');
    document.getElementById('cancelBtn').classList.add('hidden');
    document.getElementById('editIndicator').classList.add('hidden');
}

/**
 * Main render function - builds the entire document
 */
function renderTeacherDocument() {
    const t = currentTeacher;
    if (!t) return;

    const photoUrl = t.photo ? `/storage/${t.photo}` : `/images/photo-placeholder.png`;
    const totalStudents = (parseInt(t.male_enrollment) || 0) + (parseInt(t.female_enrollment) || 0);
    const totalMinutes = calculateTotalMinutes(t.teaching_load);
    const totalHours = (totalMinutes / 60).toFixed(2);

    const gradeLevels = extractUniqueGrades(t.sections);
    const sectionNames = extractSectionNames(t.sections);

    const content = document.getElementById('teacherModalContent');
    content.innerHTML = `
        <div class="print-container">
            <table class="main-table">
                ${renderHeader()}
                ${renderPersonalInfo(t, photoUrl, gradeLevels, sectionNames)}
                ${renderAssignmentInfo(t, totalStudents)}
                ${renderTeachingLoad(t, totalMinutes, totalHours)}
                ${renderCertification(t)}
            </table>
        </div>
    `;
}

/**
 * Render document header with logos
 */
function renderHeader() {
    return `
        <tr>
            <td colspan="5" class="header-cell">
                <div class="flex items-center justify-center gap-3 mb-1">
                    <img src="{{ asset('images/logo1.png') }}" class="h-10 w-auto" onerror="this.style.display='none'" alt="Logo 1">
                    <div>
                        <div class="text-xs uppercase tracking-widest">Republic of the Philippines</div>
                        <div class="text-base font-bold">DEPARTMENT OF EDUCATION</div>
                        <div class="text-xs">Division of Negros Oriental • Dauin District</div>
                    </div>
                    <img src="{{ asset('images/logo.png') }}" class="h-10 w-auto" onerror="this.style.display='none'" alt="Logo 2">
                </div>
                <div class="text-sm font-normal mt-1">TEACHER'S PROFILE AND TEACHING LOAD</div>
                <div class="text-xs font-normal">School Year: ${activeSchoolYear?.name || '2024-2025'}</div>
            </td>
        </tr>
    `;
}

/**
 * Render Section I: Personal Information
 */
function renderPersonalInfo(t, photoUrl, gradeLevels, sectionNames) {
    const fullName = isEditing 
        ? renderNameInputs(t)
        : formatFullName(t);
    
    return `
        <tr>
            <td colspan="5" class="section-head">I. Personal Information</td>
        </tr>
        <tr>
            <td rowspan="5" class="photo-cell">
                ${renderPhotoCell(t, photoUrl)}
            </td>
            <td class="label">Full Name:</td>
            <td colspan="3">${fullName}</td>
        </tr>
        <tr>
            <td class="label">Position:</td>
            <td>${renderField('position', t.position || 'Teacher I', 'text')}</td>
            <td class="label" style="width: 12%;">Employee ID:</td>
            <td>${renderField('employee_id', t.employee_id, 'text')}</td>
        </tr>
        <tr>
            <td class="label">Date of Birth:</td>
            <td>
                ${isEditing 
                    ? `<input type="date" id="birthday" value="${t.birthday || ''}" class="edit-input">`
                    : (t.birthday ? formatDate(t.birthday) : '-')
                }
            </td>

<td class="label">Sex:</td>
<td>
    @if($teacher->sex == 'M' || $teacher->sex == 'Male')
        Male
    @elseif($teacher->sex == 'F' || $teacher->sex == 'Female')
        Female
    @else
        {{ $teacher->sex }}
    @endif
</td>


        </tr>
        <tr>
            <td class="label">Contact Number:</td>
            <td colspan="3">${renderField('contact_number', t.contact_number, 'text')}</td>
        </tr>
        <tr>
            <td class="label">Address:</td>
            <td colspan="3">${renderField('address', t.address, 'text', null, 'Complete Address')}</td>
        </tr>
    `;
}

/**
 * Render photo cell with upload functionality in edit mode
 */
function renderPhotoCell(t, photoUrl) {
    if (!isEditing) {
        return `<img src="${photoUrl}" id="teacherPhoto" alt="Teacher Photo" onerror="this.src='/images/photo-placeholder.png'">`;
    }
    
    return `
        <div class="photo-upload" onclick="document.getElementById('photoInput').click()">
            <img src="${photoUrl}" id="teacherPhoto" style="${!t.photo ? 'opacity: 0.3' : ''}" alt="Teacher Photo">
            <div class="photo-hint">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Click to change
            </div>
            <input type="file" id="photoInput" accept="image/*" class="hidden" onchange="handlePhotoUpload(this)">
        </div>
    `;
}

/**
 * Render name inputs for edit mode
 */
function renderNameInputs(t) {
    return `
        <div class="flex gap-2">
            <input type="text" id="first_name" value="${escapeHtml(t.first_name || '')}" class="edit-input" placeholder="First">
            <input type="text" id="middle_name" value="${escapeHtml(t.middle_name || '')}" class="edit-input" placeholder="Middle">
            <input type="text" id="last_name" value="${escapeHtml(t.last_name || '')}" class="edit-input" placeholder="Last">
            <input type="text" id="suffix" value="${escapeHtml(t.suffix || '')}" class="edit-input w-16" placeholder="Suffix">
        </div>
    `;
}

/**
 * Render assignment and enrollment section
 */
function renderAssignmentInfo(t, totalStudents) {
    return `
        <tr>
            <td colspan="5" class="section-head">II. Assignment and Enrollment Data</td>
        </tr>
        <tr>
            <td class="label">School:</td>
            <td colspan="2">${renderField('field-school', t.school || 'Tugawe Elementary School', 'text')}</td>
            <td class="label">District:</td>
            <td>${renderField('field-district', t.district || 'Dauin District', 'text')}</td>
        </tr>
        <tr>
            <td class="label">Division:</td>
            <td colspan="2">${renderField('field-division', t.division || 'Negros Oriental', 'text')}</td>
            <td class="label">Region:</td>
            <td>${renderField('field-region', t.region || 'NIR - Negros Island Region', 'text')}</td>
        </tr>
        <tr>
            <td class="label">Grade Level Assigned:</td>
            <td colspan="4">${renderField('grade_levels', extractUniqueGrades(t.sections), 'text', null, 'e.g., Kindergarten, Grade 1')}</td>
        </tr>
        <tr>
            <td class="label">Section(s) Handled:</td>
            <td colspan="4">${renderField('section_names', extractSectionNames(t.sections), 'text', null, 'e.g., Section A, Section B')}</td>
        </tr>
        <tr>
            <td class="label">Teaching Experience:</td>
            <td>
                ${isEditing 
                    ? `<input type="number" id="years_experience" value="${t.years_experience || 0}" class="edit-input w-20" min="0"> years`
                    : `${t.years_experience || 0} years`
                }
            </td>
            <td class="label">Grade Level Exp:</td>
            <td colspan="2">${renderField('grade_experience', t.grade_experience, 'text', null, 'e.g., K-6')}</td>
        </tr>
        <tr>
            <td class="label">Male Students:</td>
            <td>${renderField('male_enrollment', t.male_enrollment || 0, 'number', null, null, 'w-20')}</td>
            <td class="label">Female Students:</td>
            <td>${renderField('female_enrollment', t.female_enrollment || 0, 'number', null, null, 'w-20')}</td>
            <td class="font-bold text-blue-900 text-center">Total: ${totalStudents}</td>
        </tr>
    `;
}

/**
 * Render teaching load table
 */
function renderTeachingLoad(t, totalMinutes, totalHours) {
    const loadRows = t.teaching_load?.length > 0 
        ? t.teaching_load.map((load, index) => renderTeachingRow(load, index)).join('')
        : `<tr><td colspan="${isEditing ? 6 : 5}" class="py-3 text-gray-500 italic">No teaching load assigned</td></tr>`;

    return `
        <tr>
            <td colspan="5" class="section-head">III. Teacher's Program / Teaching Load</td>
        </tr>
        <tr>
            <td colspan="5" style="padding: 0;">
                <table class="nested-table">
                    <thead>
                        <tr>
                            <th style="width: 12%;">Time</th>
                            <th style="width: 10%;">Minutes</th>
                            <th style="width: 25%;">Subject/Activity</th>
                            <th style="width: 18%;">Grade/Section</th>
                            <th style="width: 25%;">Remarks</th>
                            ${isEditing ? '<th style="width: 10%;">Action</th>' : ''}
                        </tr>
                    </thead>
                    <tbody>
                        ${loadRows}
                    </tbody>
                    ${isEditing ? `
                        <tfoot>
                            <tr>
                                <td colspan="6" class="text-right p-2">
                                    <button type="button" class="icon-btn icon-add" onclick="addTeachingRow()" title="Add Row">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        </tfoot>
                    ` : ''}
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="5" class="text-right font-bold text-sm" style="background: #f8fafc;">
                Total: <span class="text-blue-900 text-base">${totalMinutes}</span> minutes 
                (<span class="text-blue-900 text-base">${totalHours}</span> hours) per week
            </td>
        </tr>
    `;
}

/**
 * Render single teaching load row
 */
function renderTeachingRow(load, index) {
    if (isEditing) {
        return `
            <tr>
                <td><input type="text" data-index="${index}" data-field="time" value="${escapeHtml(load.time || '')}" class="edit-input text-center" placeholder="8:00-9:00"></td>
                <td><input type="number" data-index="${index}" data-field="minutes" value="${load.minutes || ''}" class="edit-input text-center" min="0" onchange="updateTotalMinutes()"></td>
                <td><input type="text" data-index="${index}" data-field="subject" value="${escapeHtml(load.subject || '')}" class="edit-input" placeholder="Subject"></td>
                <td><input type="text" data-index="${index}" data-field="grade_section" value="${escapeHtml(load.grade_section || '')}" class="edit-input" placeholder="Grade/Section"></td>
                <td><input type="text" data-index="${index}" data-field="remarks" value="${escapeHtml(load.remarks || '')}" class="edit-input" placeholder="Remarks"></td>
                <td>
                    <button type="button" class="icon-btn icon-del" onclick="removeTeachingRow(${index})" title="Remove">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </td>
            </tr>
        `;
    }
    
    return `
        <tr>
            <td>${load.time || ''}</td>
            <td>${load.minutes || ''}</td>
            <td class="text-left">${load.subject || ''}</td>
            <td>${load.grade_section || ''}</td>
            <td class="text-left">${load.remarks || ''}</td>
        </tr>
    `;
}

/**
 * Render certification and signatures section
 */
function renderCertification(t) {
    const preparedBy = isEditing 
        ? `<input type="text" id="prepared_by" value="${escapeHtml(t.prepared_by || '')}" class="edit-input text-center mb-2" placeholder="Name & Position">`
        : '';
        
    const conforme = isEditing
        ? `<input type="text" id="conforme" value="${escapeHtml(t.conforme || '')}" class="edit-input text-center mb-2" placeholder="Name & Position">`
        : '';
        
    const approvedBy = isEditing
        ? `<input type="text" id="approved_by" value="${escapeHtml(t.approved_by || 'Public Schools District Supervisor')}" class="edit-input text-center mb-2" placeholder="Name & Position">`
        : '';

    return `
        <tr>
            <td colspan="5" class="section-head">IV. Certification and Signatures</td>
        </tr>
        <tr>
            <td colspan="5" style="padding: 15px;">
                <p class="italic text-gray-600 mb-3" style="font-size: 8.5pt;">
                    I hereby certify that the above information is true and correct to the best of my knowledge. 
                    Any false statement may result in disciplinary action.
                </p>
                
                <div class="signature-grid">
                    <div class="signature-block">
                        ${preparedBy}
                        <div class="signature-line">
                            <div class="font-bold text-sm">${!isEditing ? (t.prepared_by || '') : ''}</div>
                            <div class="signature-label">Prepared by</div>
                        </div>
                    </div>
                    <div class="signature-block">
                        ${conforme}
                        <div class="signature-line">
                            <div class="font-bold text-sm">${!isEditing ? (t.conforme || '') : ''}</div>
                            <div class="signature-label">Conforme</div>
                        </div>
                    </div>
                    <div class="signature-block">
                        ${approvedBy}
                        <div class="signature-line">
                            <div class="font-bold text-sm">${!isEditing ? (t.approved_by || 'Public Schools District Supervisor') : ''}</div>
                            <div class="signature-label">Approved by</div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex justify-between items-end">
                    <div style="font-size: 8.5pt;">
                        <span class="text-gray-600">Date Prepared:</span>
                        <span class="font-bold ml-2">${new Date().toLocaleDateString('en-PH', {month: 'long', day: 'numeric', year: 'numeric'})}</span>
                    </div>
                    <div class="stamp-box">
                        Official<br>Stamp
                    </div>
                </div>
            </td>
        </tr>
    `;
}

/**
 * Helper: Render editable or display field
 */
function renderField(id, value, type = 'text', displayValue = null, placeholder = null, widthClass = '') {
    const display = displayValue !== null ? displayValue : (value || '-');
    
    if (!isEditing) return display;
    
    const placeholderAttr = placeholder ? `placeholder="${placeholder}"` : '';
    const widthAttr = widthClass ? `class="edit-input ${widthClass}"` : 'class="edit-input"';
    
    if (type === 'date') {
        return `<input type="date" id="${id}" value="${value || ''}" class="edit-input">`;
    }
    if (type === 'number') {
        return `<input type="number" id="${id}" value="${value || 0}" ${widthAttr} min="0" ${placeholderAttr}>`;
    }
    
    return `<input type="text" id="${id}" value="${escapeHtml(value || '')}" ${widthAttr} ${placeholderAttr}>`;
}

/**
 * Helper: Render sex dropdown or display
 */
function renderSexField(sex) {
    if (!isEditing) return sex || '-';
    
    return `
        <select id="sex" class="edit-input">
            <option value="">Select...</option>
            <option value="Male" ${sex === 'Male' ? 'selected' : ''}>Male</option>
            <option value="Female" ${sex === 'Female' ? 'selected' : ''}>Female</option>
        </select>
    `;
}

/**
 * Handle photo file upload preview
 */
function handlePhotoUpload(input) {
    if (!input.files || !input.files[0]) return;
    
    const file = input.files[0];
    const maxSize = 2 * 1024 * 1024; // 2MB
    
    if (file.size > maxSize) {
        alert('Photo must be less than 2MB');
        input.value = '';
        return;
    }
    
    photoFile = file;
    const reader = new FileReader();
    
    reader.onload = function(e) {
        const img = document.getElementById('teacherPhoto');
        if (img) {
            img.src = e.target.result;
            img.style.opacity = '1';
        }
    };
    
    reader.onerror = function() {
        alert('Failed to read photo file');
    };
    
    reader.readAsDataURL(file);
}

/**
 * Calculate total minutes from teaching load
 */
function calculateTotalMinutes(loads) {
    if (!loads || !Array.isArray(loads)) return 0;
    return loads.reduce((sum, load) => sum + (parseInt(load.minutes) || 0), 0);
}

/**
 * Extract unique grade levels from sections
 */
function extractUniqueGrades(sections) {
    if (!sections || !Array.isArray(sections) || sections.length === 0) return '';
    const grades = [...new Set(sections.map(s => s.year_level).filter(Boolean))];
    return grades.join(', ');
}

/**
 * Extract section names
 */
function extractSectionNames(sections) {
    if (!sections || !Array.isArray(sections) || sections.length === 0) return '';
    return sections.map(s => s.name).filter(Boolean).join(', ');
}

/**
 * Format full name from parts
 */
function formatFullName(t) {
    const parts = [t.first_name, t.middle_name, t.last_name, t.suffix].filter(Boolean);
    return parts.join(' ') || '-';
}

/**
 * Format date for display
 */
function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    if (isNaN(date.getTime())) return '-';
    return date.toLocaleDateString('en-US', {month: 'long', day: 'numeric', year: 'numeric'});
}

/**
 * Escape HTML to prevent XSS
 */
function escapeHtml(text) {
    if (text === null || text === undefined) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

/**
 * Enable edit mode
 */
function enableEditMode() {
    isEditing = true;
    document.getElementById('editBtn').classList.add('hidden');
    document.getElementById('saveBtn').classList.remove('hidden');
    document.getElementById('cancelBtn').classList.remove('hidden');
    document.getElementById('editIndicator').classList.remove('hidden');
    renderTeacherDocument();
}

/**
 * Cancel edit mode and revert changes
 */
function cancelEditMode() {
    isEditing = false;
    photoFile = null;
    currentTeacher = JSON.parse(JSON.stringify(originalTeacher));
    resetToolbar();
    renderTeacherDocument();
}

/**
 * Add new teaching load row
 */
function addTeachingRow() {
    if (!currentTeacher.teaching_load) {
        currentTeacher.teaching_load = [];
    }
    currentTeacher.teaching_load.push({
        time: '',
        minutes: '',
        subject: '',
        grade_section: '',
        remarks: ''
    });
    renderTeacherDocument();
}

/**
 * Remove teaching load row
 */
function removeTeachingRow(index) {
    if (!currentTeacher.teaching_load) return;
    currentTeacher.teaching_load.splice(index, 1);
    renderTeacherDocument();
}

/**
 * Update total minutes display (live calculation)
 */
function updateTotalMinutes() {
    let total = 0;
    document.querySelectorAll('[data-field="minutes"]').forEach(input => {
        total += parseInt(input.value) || 0;
    });
    
    const display = document.getElementById('total-minutes');
    if (display) {
        display.textContent = total;
    }
}

/**
 * Collect all form data for submission
 */
function collectFormData() {
    const teachingLoad = [];
    const byIndex = {};
    
    // Collect teaching load data
    document.querySelectorAll('[data-index]').forEach(el => {
        const idx = el.dataset.index;
        const field = el.dataset.field;
        if (!byIndex[idx]) byIndex[idx] = {};
        byIndex[idx][field] = el.value;
    });
    
    Object.values(byIndex).forEach(item => {
        if (item.time || item.subject) {
            teachingLoad.push({
                time: item.time || '',
                minutes: parseInt(item.minutes) || 0,
                subject: item.subject || '',
                grade_section: item.grade_section || '',
                remarks: item.remarks || ''
            });
        }
    });

    return {
        first_name: getValue('first_name'),
        middle_name: getValue('middle_name'),
        last_name: getValue('last_name'),
        suffix: getValue('suffix'),
        position: getValue('position'),
        employee_id: getValue('employee_id'),
        birthdate: getValue('birthdate'),
        sex: getValue('sex'),
        contact_number: getValue('contact_number'),
        address: getValue('address'),
        school: getValue('field-school'),
        district: getValue('field-district'),
        division: getValue('field-division'),
        region: getValue('field-region'),
        grade_levels: getValue('grade_levels'),
        section_names: getValue('section_names'),
        years_experience: parseInt(getValue('years_experience')) || 0,
        grade_experience: getValue('grade_experience'),
        male_enrollment: parseInt(getValue('male_enrollment')) || 0,
        female_enrollment: parseInt(getValue('female_enrollment')) || 0,
        prepared_by: getValue('prepared_by'),
        conforme: getValue('conforme'),
        approved_by: getValue('approved_by'),
        teaching_load: teachingLoad
    };
}

/**
 * Helper: Get value from input or fallback to current teacher data
 */
function getValue(id) {
    const el = document.getElementById(id);
    return el ? el.value : (currentTeacher[id] || '');
}

/**
 * Save teacher changes to server
 */
async function saveTeacherChanges() {
    const data = collectFormData();
    const formData = new FormData();
    
    // Append all data
    Object.keys(data).forEach(key => {
        if (key === 'teaching_load') {
            formData.append(key, JSON.stringify(data[key]));
        } else {
            formData.append(key, data[key] || '');
        }
    });
    
    // Append photo if changed
    if (photoFile) {
        formData.append('photo', photoFile);
    }

    // Show loading state
    const saveBtn = document.getElementById('saveBtn');
    const originalContent = saveBtn.innerHTML;
    saveBtn.innerHTML = `<svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>`;
    saveBtn.disabled = true;

    try {
        const response = await fetch(`/admin/teachers/${currentTeacher.id}/program`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        });

        const result = await response.json();

        if (!response.ok) {
            throw new Error(result.message || `Server error: ${response.status}`);
        }

        if (result.success) {
            // Update local data
            currentTeacher = JSON.parse(JSON.stringify(result.teacher));
            originalTeacher = JSON.parse(JSON.stringify(result.teacher));
            
            // Update teachers array
            const idx = teachers.findIndex(t => t.id === currentTeacher.id);
            if (idx !== -1) teachers[idx] = result.teacher;
            
            // Exit edit mode
            isEditing = false;
            photoFile = null;
            resetToolbar();
            renderTeacherDocument();
            
            showCountdownNotification('✓ Profile saved successfully!', 3);
        } else {
            alert('Save failed: ' + (result.message || 'Unknown error'));
        }
    } catch (error) {
        console.error('Save error:', error);
        alert('Failed to save changes: ' + error.message);
    } finally {
        saveBtn.innerHTML = originalContent;
        saveBtn.disabled = false;
    }
}

/**
 * Show countdown notification
 */
function showCountdownNotification(message, seconds) {
    // Remove existing
    const existing = document.querySelector('.countdown-notif');
    if (existing) existing.remove();

    const circumference = 2 * Math.PI * 18;
    
    const notif = document.createElement('div');
    notif.className = 'countdown-notif';
    notif.innerHTML = `
        <span>${message}</span>
        <div class="countdown-bar">
            <svg viewBox="0 0 40 40">
                <circle class="bg" cx="20" cy="20" r="18"></circle>
                <circle class="progress" cx="20" cy="20" r="18" 
                    style="stroke-dasharray: ${circumference}; stroke-dashoffset: 0;"></circle>
            </svg>
            <span class="countdown-text">${seconds}</span>
        </div>
    `;
    
    document.body.appendChild(notif);
    
    const progressCircle = notif.querySelector('.progress');
    const countdownText = notif.querySelector('.countdown-text');
    
    let remaining = seconds;
    const interval = setInterval(() => {
        remaining--;
        countdownText.textContent = remaining;
        
        const offset = circumference - (remaining / seconds) * circumference;
        progressCircle.style.strokeDashoffset = offset;
        
        if (remaining <= 0) {
            clearInterval(interval);
            notif.style.animation = 'slideIn 0.3s ease reverse';
            setTimeout(() => notif.remove(), 300);
        }
    }, 1000);
}

/**
 * Print the teacher profile
 */
function printTeacherProfile() {
    window.print();
}

// Keyboard shortcuts
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        if (isEditing) {
            cancelEditMode();
        } else {
            closeTeacherModal();
        }
    }
    
    // Ctrl+S to save when editing
    if (e.ctrlKey && e.key === 's' && isEditing) {
        e.preventDefault();
        saveTeacherChanges();
    }
});
</script>





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



<!-- EDIT MODAL -->
<div id="editTeacherModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
<div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl p-6 relative">

<h2 class="text-xl font-bold mb-4">Edit Teacher</h2>

<form id="editTeacherForm" method="POST">
@csrf
@method('PUT')

<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
<input type="text" name="first_name" id="edit_first" placeholder="First Name" class="px-4 py-2 border rounded-lg">
<input type="text" name="middle_name" id="edit_middle" placeholder="Middle Name" class="px-4 py-2 border rounded-lg">
<input type="text" name="last_name" id="edit_last" placeholder="Last Name" class="px-4 py-2 border rounded-lg">
<input type="text" name="suffix" id="edit_suffix" placeholder="Suffix (Jr., Sr.)" class="px-4 py-2 border rounded-lg">
</div>

<input type="date" name="birthday" id="edit_birthday"
       class="w-full mt-3 px-4 py-2 border rounded-lg">

<input type="email" name="email" placeholder="Email Address" id="edit_email"
       class="w-full mt-3 px-4 py-2 border rounded-lg">

<input type="text" name="username" placeholder="Username" id="edit_username"
       class="w-full mt-3 px-4 py-2 border rounded-lg">

<div class="flex justify-end gap-3 mt-4">
<button type="button" onclick="closeEditTeacherModal()"
        class="bg-gray-300 px-4 py-2 rounded-lg">
Cancel
</button>
<button type="submit"
        class="bg-indigo-600 text-white px-6 py-2 rounded-lg">
Update
</button>
</div>
</form>

<button onclick="closeEditTeacherModal()"
        class="absolute top-3 right-3 text-xl">✕</button>

</div>
</div>

<script>
function openEditTeacherModal(el) {
    const modal = document.getElementById('editTeacherModal');
    const form = document.getElementById('editTeacherForm');

    // Set form action to the correct PUT route
    form.action = `/admin/teachers/${el.dataset.id}`;

    // Fill the fields
    document.getElementById('edit_first').value = el.dataset.first;
    document.getElementById('edit_middle').value = el.dataset.middle;
    document.getElementById('edit_last').value = el.dataset.last;
    document.getElementById('edit_suffix').value = el.dataset.suffix;
    document.getElementById('edit_birthday').value = el.dataset.birthday;
    document.getElementById('edit_email').value = el.dataset.email;
    document.getElementById('edit_username').value = el.dataset.username;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeEditTeacherModal() {
    document.getElementById('editTeacherModal').classList.add('hidden');
}

</script>


<script>
    let deleteTimeout;

    function showDeleteModal(teacherId) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const countdownEl = document.getElementById('deleteCountdown');

        form.action = `/admin/teachers/${teacherId}`;

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




      function openAddTeacherModal() {
        document.getElementById('addTeacherModal').classList.remove('hidden');
        document.getElementById('addTeacherModal').classList.add('flex');
    }

    function closeAddTeacherModal() {
        document.getElementById('addTeacherModal').classList.add('hidden');
    }
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



</body>
</html>