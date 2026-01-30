<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Dashboard | Student Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-emerald-100 via-sky-100 to-indigo-200 p-4 md:p-6">

<!-- HEADER -->
<header class="sticky top-0 z-50 backdrop-blur-xl bg-white/80 shadow-lg rounded-2xl mb-8">
    <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <!-- LEFT: LOGO + TITLE -->
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/logo.jpg') }}"
                 class="h-16 w-16 rounded-full shadow-lg ring-4 ring-emerald-300"
                 alt="School Logo">
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-gray-800">Teacher Dashboard</h1>
                <p class="text-sm text-gray-500">Tugawe Elementary School</p>
            </div>
        </div>

        <!-- CENTER: SEARCH BAR -->
        <div class="flex-1 md:max-w-md w-full relative">
            <input type="text"
                   class="w-full pl-12 pr-4 py-3 rounded-3xl border border-gray-300 shadow-md focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400"
                   placeholder="Search student..."
                   onkeyup="globalSearch(this.value)">

           <!-- Search Icon SVG -->
<span class="absolute left-4 top-3.5 text-gray-400">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
    </svg>
</span>

        </div>

        <!-- RIGHT: USER DROPDOWN -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                    class="flex items-center gap-2 bg-white hover:bg-gray-100 px-4 py-2 rounded-xl shadow-md text-sm font-medium text-gray-700 transition">
                <span class="hidden md:block">Account</span>
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="open" @click.away="open = false" x-transition
                 class="absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50">
                <div class="px-4 py-3 border-b bg-gray-50">
                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name ?? 'User' }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                </div>

             <!-- Profile Link -->
<a href="{{ route('profile.edit') }}"
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
            👤 Profile
        </a>

        
        <!-- Divider -->
<div class="border-t"></div>

<!-- Logout Link -->
<a href="{{ route('logout') }}"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
   class="flex items-center gap-2 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition">

    <!-- Door/Logout Icon SVG -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
    </svg>
    Logout
</a>


                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            </div>
        </div>

    </div>
</header>

<!-- SECTIONS -->
<main class="max-w-7xl mx-auto space-y-10">

    @if($sections->isEmpty())
        <div class="bg-white rounded-3xl shadow-lg p-8 text-center text-gray-600">
            You are not assigned to any section yet.
        </div>
    @endif

    <div class="grid grid-cols-1 gap-12">
        @foreach($sections as $section)
            <div class="bg-white rounded-3xl shadow-2xl border border-gray-200 p-6 flex flex-col h-auto">

                <!-- Section Header -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between bg-gradient-to-r from-emerald-500 to-green-600 text-white px-6 py-4 rounded-2xl mb-6">
                    <div class="font-bold text-lg md:text-xl">
                        {{ $section->year_level }} - {{ $section->name }}
                    </div>
                    <span class="mt-2 md:mt-0 text-sm bg-white/20 px-4 py-1 rounded-full">
                        SY {{ $section->school_year ?? 'N/A' }}
                    </span>
                </div>

                <!-- Gender Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <div class="flex items-center gap-3 bg-blue-50 border border-blue-200 rounded-xl p-4 shadow-sm">
                        <div class="text-2xl"></div>
                        <div>
                            <p class="text-sm text-blue-500 font-medium">Male Students</p>
                            <p class="text-2xl font-extrabold text-blue-600">
                                {{ $section->students->where('sex', 'Male')->count() }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-pink-50 border border-pink-200 rounded-xl p-4 shadow-sm">
                        <div class="text-2xl"></div>
                        <div>
                            <p class="text-sm text-pink-500 font-medium">Female Students</p>
                            <p class="text-2xl font-extrabold text-pink-600">
                                {{ $section->students->where('sex', 'Female')->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Students Tables -->
                <div class="flex flex-col md:flex-row gap-6 flex-1 overflow-auto">

                    <!-- Male Students -->
                    <div class="flex-1 overflow-auto rounded-2xl border border-blue-200 shadow-sm">
                        <div class="bg-blue-100 text-blue-800 font-semibold px-4 py-2 rounded-t-2xl text-center">
                            Male Students
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm table-auto">
                                <thead class="bg-blue-50 sticky top-0">
                                    <tr class="text-blue-700">
                                        <th class="px-4 py-3 text-left">#</th>
                                        <th class="px-4 py-3 text-left">Name</th>
                                        <th class="px-4 py-3 text-left">LRN</th>
                                        <th class="px-4 py-3 text-left">Birthday</th>
                                        <th class="px-4 py-3 text-left">Email</th>
                                        <th class="px-4 py-3 text-left">Contact</th>
                                        <th class="px-4 py-3 text-left">Address</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @foreach($section->students->where('sex', 'Male') as $index => $student)
                                        <tr class="student-row hover:bg-blue-50 transition">
                                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                                            <td class="px-4 py-3 font-medium">{{ $student->first_name }} {{ $student->last_name }}</td>
                                            <td class="px-4 py-3">{{ $student->lrn }}</td>
                                            <td class="px-4 py-3">
                                                {{ $student->birthday ? \Carbon\Carbon::parse($student->birthday)->format('M d, Y') : 'N/A' }}
                                            </td>
                                            <td class="px-4 py-3 text-blue-600">{{ $student->email }}</td>
                                            <td class="px-4 py-3">{{ $student->contact_number ?? 'N/A' }}</td>
                                            <td class="px-4 py-3">{{ $student->address ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                    @if($section->students->where('sex', 'Male')->isEmpty())
                                        <tr><td colspan="7" class="text-center py-4 text-blue-500">No male students enrolled</td></tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Female Students -->
                    <div class="flex-1 overflow-auto rounded-2xl border border-pink-200 shadow-sm">
                        <div class="bg-pink-100 text-pink-800 font-semibold px-4 py-2 rounded-t-2xl text-center">
                            Female Students
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm table-auto">
                                <thead class="bg-pink-50 sticky top-0">
                                    <tr class="text-pink-700">
                                        <th class="px-4 py-3 text-left">#</th>
                                        <th class="px-4 py-3 text-left">Name</th>
                                        <th class="px-4 py-3 text-left">LRN</th>
                                        <th class="px-4 py-3 text-left">Birthday</th>
                                        <th class="px-4 py-3 text-left">Email</th>
                                        <th class="px-4 py-3 text-left">Contact</th>
                                        <th class="px-4 py-3 text-left">Address</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @foreach($section->students->where('sex', 'Female') as $index => $student)
                                        <tr class="student-row hover:bg-pink-50 transition">
                                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                                            <td class="px-4 py-3 font-medium">{{ $student->first_name }} {{ $student->last_name }}</td>
                                            <td class="px-4 py-3">{{ $student->lrn }}</td>
                                            <td class="px-4 py-3">
                                                {{ $student->birthday ? \Carbon\Carbon::parse($student->birthday)->format('M d, Y') : 'N/A' }}
                                            </td>
                                            <td class="px-4 py-3 text-pink-600">{{ $student->email }}</td>
                                            <td class="px-4 py-3">{{ $student->contact_number ?? 'N/A' }}</td>
                                            <td class="px-4 py-3">{{ $student->address ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                    @if($section->students->where('sex', 'Female')->isEmpty())
                                        <tr><td colspan="7" class="text-center py-4 text-pink-500">No female students enrolled</td></tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
</main>

<!-- Search Script -->
<script>
function globalSearch(value) {
    const filter = value.toLowerCase();
    document.querySelectorAll('.student-row').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(filter) ? '' : 'none';
    });
}
</script>

<script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
