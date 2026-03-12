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
                        <img src="{{ asset('images/logo.jpg') }}"
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
<div id="teacherModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl p-6 relative overflow-auto max-h-[90vh]">

        <!-- Close button -->
        <button onclick="closeTeacherModal()" 
                class="absolute top-3 right-4 text-xl font-bold text-gray-500 hover:text-red-500">
            ✕
        </button>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-2 mb-4">

            <!-- Edit -->
            <button id="editBtn" onclick="enableEditMode()" 
                class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.213 3 21l1.787-4.5 12.075-13.013z" />
                </svg>
            </button>

            <!-- Save -->
            <button id="saveBtn" onclick="saveTeacherChanges()" 
                class="bg-green-500 hover:bg-green-600 text-white p-2 rounded hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5 13l4 4L19 7" />
                </svg>
            </button>

            <!-- Cancel -->
            <button id="cancelBtn" onclick="cancelEditMode()" 
                class="bg-red-500 hover:bg-red-600 text-white p-2 rounded hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

        </div>

        <div id="teacherModalContent">
            <!-- Dynamic content -->
        </div>
    </div>
</div>


<script>
    const activeSchoolYear = @json($activeSchoolYear);

const teachers = @json($teachers->load('sections'));
let currentTeacher = null;
let originalTeacher = null;
let isEditing = false;

function openTeacherModal(id) {
    currentTeacher = JSON.parse(JSON.stringify(teachers.find(t => t.id === id)));
    originalTeacher = JSON.parse(JSON.stringify(currentTeacher));

    if (!currentTeacher) return;

    renderTeacherDocument();

    document.getElementById('teacherModal').classList.remove('hidden');
    document.getElementById('teacherModal').classList.add('flex');
}

function renderTeacherDocument() {


    let t = currentTeacher;

    const photoUrl = t.photo 
        ? `/storage/${t.photo}` 
        : `/images/photo-placeholder.png`;

    document.getElementById('teacherModalContent').innerHTML = `
        
        <!-- HEADER -->
        <div class="relative">

            <!-- Logos + Header -->
            <div class="flex items-center justify-center gap-4">
                <img src="{{ asset('images/logo1.png') }}" class="h-14 w-auto">
                
                <div class="text-center leading-tight">
                    <p class="font-bold uppercase text-xs">Republic of the Philippines</p>
                    <p class="font-bold uppercase text-sm">Department of Education</p>
                    <p class="text-xs">Division of Negros Oriental</p>
                </div>

                <img src="{{ asset('images/logo.jpg') }}" class="h-14 w-auto">
            </div>

            <!-- Teacher Photo (Top Right Vertical Rectangle) -->
            <div class="absolute top-0 right-0">
                <div class="w-28 h-40 border-2 border-gray-400 shadow-md bg-white overflow-hidden">
                    <img src="${photoUrl}" 
                        class="w-full h-full object-cover">
                </div>
            </div>
        </div>

        <hr class="my-6 border-gray-400">

        <!-- TEACHER DETAILS -->
        <div class="grid grid-cols-2 gap-8 text-sm">

            <!-- LEFT SIDE -->
            <div class="space-y-2">

                <p><strong>Teacher Name:</strong><br>
                    ${t.first_name} ${t.middle_name ?? ''} ${t.last_name} ${t.suffix ?? ''}
                </p>

                <p><strong>Current Position:</strong><br>
                    ${isEditing 
                        ? `<input id="position" value="${t.position ?? ''}" class="border px-2 py-1 w-full rounded">`
                        : (t.position ?? 'Teacher I')}
                </p>

                <p><strong>Teaching Experience (Years):</strong><br>
                    ${isEditing 
                        ? `<input id="years_experience" type="number" value="${t.years_experience ?? 0}" class="border px-2 py-1 w-full rounded">`
                        : (t.years_experience ?? 0)}
                </p>

                <p><strong>Teaching Experience (Grade Level):</strong><br>
                    ${isEditing 
                        ? `<input id="grade_experience" value="${t.grade_experience ?? ''}" class="border px-2 py-1 w-full rounded">`
                        : (t.grade_experience ?? '')}
                </p>

            </div>

            <!-- RIGHT SIDE -->
            <div class="space-y-2">

               <p><strong>Grade Level Assigned:</strong><br>
    ${t.sections && t.sections.length > 0
        ? t.sections.map(s => s.year_level).join(', ')
        : '-'}
</p>

                <p><strong>Enrollment (Male):</strong><br>
                    ${isEditing 
                        ? `<input id="male_enrollment" type="number" value="${t.male_enrollment ?? 0}" class="border px-2 py-1 w-full rounded">`
                        : (t.male_enrollment ?? 0)}
                </p>

                <p><strong>Enrollment (Female):</strong><br>
                    ${isEditing 
                        ? `<input id="female_enrollment" type="number" value="${t.female_enrollment ?? 0}" class="border px-2 py-1 w-full rounded">`
                        : (t.female_enrollment ?? 0)}
                </p>

                <p><strong>Active School Year:</strong><br>
                    ${activeSchoolYear?.name ?? '-'}
                </p>

            </div>
        </div>

        <!-- TEACHING LOAD SECTION -->
        <div class="mt-8">

            <h3 class="text-center font-bold text-sm mb-3">
                TEACHER'S PROGRAM / TEACHING LOAD
            </h3>
           

            <div class="overflow-auto">
                <table class="w-full border text-xs">
                 <thead>
    <tr class="bg-gray-200 text-center">
        <th class="border px-2 py-1">Time</th>
        <th class="border px-2 py-1">Minutes</th>
        <th class="border px-2 py-1">Subject</th>
        ${isEditing ? `<th class="border px-2 py-1 w-10">Action</th>` : ''}
    </tr>
</thead>
                    <tbody>
                        ${t.teaching_load?.length > 0 
                            ? t.teaching_load.map((l, index) => `
                       <tr>
    <td class="border px-2 py-1">
        ${isEditing 
            ? `<input data-index="${index}" data-field="time" value="${l.time}" class="border w-full px-1 rounded">`
            : l.time}
    </td>

    <td class="border px-2 py-1 text-center">
        ${isEditing 
            ? `<input data-index="${index}" data-field="minutes" value="${l.minutes}" class="border w-full px-1 rounded">`
            : l.minutes}
    </td>

    <td class="border px-2 py-1">
        ${isEditing 
            ? `<input data-index="${index}" data-field="subject" value="${l.subject}" class="border w-full px-1 rounded">`
            : l.subject}
    </td>

    ${isEditing ? `
        <td class="border text-center">
            <button onclick="removeTeachingRow(${index})"
    class="p-1 rounded hover:bg-red-100 text-red-500 hover:text-red-700 transition">
    
    <svg xmlns="http://www.w3.org/2000/svg" 
         class="w-4 h-4"
         fill="none" 
         viewBox="0 0 24 24" 
         stroke="currentColor" 
         stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 3h6a1 1 0 011 1v1H8V4a1 1 0 011-1z"/>
    </svg>

</button>
        </td>
    ` : ''}
</tr>
                            `).join('')
                            : '<tr><td colspan="3" class="border px-2 py-2 text-center">No load assigned</td></tr>'
                        }
                    </tbody>
                </table>

                ${isEditing ? `
                    <div class="mt-2 text-right">
                        <button onclick="addTeachingRow()" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded shadow">
                            +
                        </button>
                    </div>
                ` : ''}
            </div>
        </div>

        <!-- SIGNATURES -->
        <div class="grid grid-cols-3 gap-8 mt-12 text-center text-sm">

            <div>
                ${isEditing 
                    ? `<input id="prepared_by" value="${t.prepared_by ?? 'Principal'}" class="border px-2 py-1 w-full text-center rounded">`
                    : `<p class="border-t pt-2">Prepared by<br><strong>${t.prepared_by ?? 'Principal'}</strong></p>`}
            </div>

            <div>
                ${isEditing 
                    ? `<input id="conforme" value="${t.conforme ?? 'Adviser'}" class="border px-2 py-1 w-full text-center rounded">`
                    : `<p class="border-t pt-2">Conforme<br><strong>${t.conforme ?? 'Adviser'}</strong></p>`}
            </div>

            <div>
                ${isEditing 
                    ? `<input id="approved_by" value="${t.approved_by ?? 'Public School District Supervisor'}" class="border px-2 py-1 w-full text-center rounded">`
                    : `<p class="border-t pt-2">Approved by<br><strong>${t.approved_by ?? 'Public School District Supervisor'}</strong></p>`}
            </div>

        </div>
    `;
}


function enableEditMode() {
    isEditing = true;
    document.getElementById('editBtn').classList.add('hidden');
    document.getElementById('saveBtn').classList.remove('hidden');
    document.getElementById('cancelBtn').classList.remove('hidden');
    renderTeacherDocument();
}

function cancelEditMode() {
    isEditing = false;
    currentTeacher = JSON.parse(JSON.stringify(originalTeacher));
    document.getElementById('editBtn').classList.remove('hidden');
    document.getElementById('saveBtn').classList.add('hidden');
    document.getElementById('cancelBtn').classList.add('hidden');
    renderTeacherDocument();
}

function addTeachingRow() {
    if (!currentTeacher.teaching_load) {
        currentTeacher.teaching_load = [];
    }
    currentTeacher.teaching_load.push({ time: '', minutes: '', subject: '' });
    renderTeacherDocument();
}

function removeTeachingRow(index) {
    if (!currentTeacher.teaching_load) return;

    currentTeacher.teaching_load.splice(index, 1);

    renderTeacherDocument();
}



function saveTeacherChanges() {

    // collect teaching load inputs
    let teachingLoad = [];

document.querySelectorAll('[data-index]').forEach(input => {
    const index = input.dataset.index;
    const field = input.dataset.field;

    if (!teachingLoad[index]) {
        teachingLoad[index] = { time: '', minutes: '', subject: '' };
    }

    teachingLoad[index][field] = input.value;
});

currentTeacher.teaching_load = teachingLoad;

    let data = {
        position: document.getElementById('position')?.value,
        years_experience: document.getElementById('years_experience')?.value,
        grade_experience: document.getElementById('grade_experience')?.value,
        male_enrollment: document.getElementById('male_enrollment')?.value,
        female_enrollment: document.getElementById('female_enrollment')?.value,
        prepared_by: document.getElementById('prepared_by')?.value,
        conforme: document.getElementById('conforme')?.value,
        approved_by: document.getElementById('approved_by')?.value,
        teaching_load: currentTeacher.teaching_load
    };

    fetch(`/admin/teachers/${currentTeacher.id}/program`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(response => {
      if (response.success) {

    // ✅ Replace current teacher with fresh backend data
    currentTeacher = JSON.parse(JSON.stringify(response.teacher));
    originalTeacher = JSON.parse(JSON.stringify(response.teacher));

    // ✅ Update teachers array (so reopening modal stays updated)
    const teacherIndex = teachers.findIndex(t => t.id === currentTeacher.id);
    if (teacherIndex !== -1) {
        teachers[teacherIndex] = response.teacher;
    }

    isEditing = false;

    document.getElementById('editBtn').classList.remove('hidden');
    document.getElementById('saveBtn').classList.add('hidden');
    document.getElementById('cancelBtn').classList.add('hidden');

    renderTeacherDocument();

    alert('Teacher program updated successfully!');
}

    });
}

function closeTeacherModal() {
    isEditing = false;
    document.getElementById('teacherModal').classList.add('hidden');
    document.getElementById('teacherModal').classList.remove('flex');
}
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


<!-- ADD TEACHER MODAL -->
<div id="addTeacherModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl p-6 relative">

        <h2 class="text-xl font-bold text-gray-800 mb-4">Add New Teacher</h2>

        <form method="POST"
              action="{{ route('admin.teachers.store') }}"
              enctype="multipart/form-data"
              class="space-y-4">
            @csrf

            <!-- PHOTO UPLOAD -->
            <div class="flex flex-col items-center">
                <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-200 mb-2">
                    <img id="photoPreview"
                         src="https://ui-avatars.com/api/?name=Teacher"
                         class="w-full h-full object-cover">
                </div>

                <input type="file" name="photo"
                       accept="image/*"
                       onchange="previewTeacherPhoto(event)"
                       class="text-sm">
            </div>

            <!-- NAME FIELDS -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="first_name" placeholder="First Name" required
                       class="px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">

                <input type="text" name="middle_name" placeholder="Middle Name"
                       class="px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">

                <input type="text" name="last_name" placeholder="Last Name" required
                       class="px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">

                <input type="text" name="suffix" placeholder="Suffix (Jr., Sr.)"
                       class="px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">
            </div>

            <!-- BIRTHDAY -->
            <input type="date" name="birthday" required
                   class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">

            <!-- EMAIL -->
            <input type="email" name="email" placeholder="Email Address" required
                   class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">

            <!-- USERNAME -->
            <input type="text" name="username" placeholder="Username" required
                   class="w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">

            <!-- PASSWORD -->
            <div class="grid grid-cols-2 gap-4">
                <input type="password" name="password" placeholder="Password" required
                       class="px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">

                <input type="password" name="password_confirmation"
                       placeholder="Confirm Password" required
                       class="px-4 py-2 rounded-lg border focus:ring-2 focus:ring-indigo-400">
            </div>

            <!-- BUTTONS -->
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeAddTeacherModal()"
                        class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-lg">
                    Cancel
                </button>

                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow-md">
                    Save Teacher
                </button>
            </div>

        </form>

        <button onclick="closeAddTeacherModal()"
                class="absolute top-3 right-3 text-gray-500 hover:text-red-500 text-xl">
            ✕
        </button>
    </div>
</div>
<script>
function previewTeacherPhoto(event) {
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('photoPreview').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
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