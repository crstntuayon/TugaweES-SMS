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
                <p class="text-sm text-gray-500">Tugawe Elementary School | Dauin District</p>
            </div>
        </div>

        <!-- CENTER: SEARCH BAR -->
        <div class="flex-1 md:max-w-md w-full relative">
            <input type="text"
                   class="w-full pl-12 pr-4 py-3 rounded-3xl border border-gray-300 shadow-md focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400"
                   placeholder="Search student..."
                   onkeyup="globalSearch(this.value)">
           <span class="absolute left-4 top-3.5 text-gray-400">
               <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                   <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
               </svg>
           </span>
        </div>

        <!-- USER DROPDOWN -->
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

                <a href="{{ route('profile.edit') }}"
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">👤 Profile</a>

                <a href="#" @click="document.getElementById('enrollStudentModal').classList.remove('hidden'); open = false;"
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600">➕ Enroll Student</a>

                <div class="border-t"></div>

                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="flex items-center gap-2 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition">
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
                    <div class="font-bold text-lg md:text-xl">{{ $section->year_level }} - {{ $section->name }}</div>
                    <span class="mt-2 md:mt-0 text-sm bg-white/20 px-4 py-1 rounded-full">
                        SY {{ $section->school_year ?? 'N/A' }}
                    </span>
                </div>

                <!-- Section Actions -->
<div class="flex flex-wrap gap-2 mb-4">
    <a href="{{ route('teacher.attendance', $section->id) }}"
       class="bg-yellow-500 text-white px-4 py-2 rounded-xl hover:bg-yellow-600 transition">
       📝 Attendance
    </a>
    <a href="{{ route('teacher.grades', $section->id) }}"
       class="bg-indigo-500 text-white px-4 py-2 rounded-xl hover:bg-indigo-600 transition">
       📊 Grades
    </a>
</div>


                <!-- Gender Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <div class="flex items-center gap-3 bg-blue-50 border border-blue-200 rounded-xl p-4 shadow-sm">
                        <div>
                            <p class="text-sm text-blue-500 font-medium">Male Students</p>
                            <p class="text-2xl font-extrabold text-blue-600">{{ $section->students->where('sex','Male')->count() }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-pink-50 border border-pink-200 rounded-xl p-4 shadow-sm">
                        <div>
                            <p class="text-sm text-pink-500 font-medium">Female Students</p>
                            <p class="text-2xl font-extrabold text-pink-600">{{ $section->students->where('sex','Female')->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Students Table -->
                <div class="overflow-auto rounded-2xl border border-gray-200 shadow-sm">
                    <table class="min-w-full text-sm table-auto">
                        <thead class="bg-gray-50 sticky top-0">
                            <tr class="text-gray-700">
                                <th class="px-4 py-3">No.</th>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">LRN</th>
                                <th class="px-4 py-3">Birthday</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Contact</th>
                                <th class="px-4 py-3">Address</th>
                                <th class="px-4 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse($section->students as $index => $student)
                                <tr class="student-row hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                                    <!-- STUDENT -->
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-4">
                                    <img
                                        src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/photo-placeholder.png') }}"
                                        class="w-12 h-12 rounded-full object-cover shadow"
                                        alt="Photo">

                                    <div>
                                        <p class="font-semibold text-gray-800 leading-tight">
                                            {{ $student->first_name }}
                                            {{ $student->middle_name }}
                                            {{ $student->last_name }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            S-ID: {{ $student->school_id }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                                    <td class="px-4 py-3">{{ $student->lrn }}</td>
                                    <td class="px-4 py-3">{{ $student->birthday ? \Carbon\Carbon::parse($student->birthday)->format('M d, Y') : 'N/A' }}</td>
                                    <td class="px-4 py-3 text-blue-600">{{ $student->email }}</td>
                                    <td class="px-4 py-3">{{ $student->contact_number ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $student->address ?? 'N/A' }}</td>
                                    <td class="flex gap-2">
    {{-- If student is currently enrolled --}}
    @if($student->section_id === $section->id)

        {{-- UNENROLL --}}
        <form action="{{ route('teacher.students.unenroll', $student->id) }}"
              method="POST"
              onsubmit="return confirm('Unenroll this student?')">
            @csrf
            @method('PUT')
            <button class="bg-red-500 text-white px-3 py-1 rounded text-sm">
                Unenroll
            </button>
        </form>

    @else

        {{-- RE-ENROLL --}}
        <button
            onclick="openReEnrollModal({{ $student->id }})"
            class="bg-green-600 text-white px-3 py-1 rounded text-sm">
            Re-Enroll
        </button>

    @endif
</td>

                                </tr>
                            @empty
                                <tr><td colspan="8" class="text-center py-4 text-gray-500">No students enrolled</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        @endforeach
    </div>
</main>



<!-- ENROLL STUDENT MODAL -->
<div id="enrollStudentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 relative mx-auto my-auto">
        <h2 class="text-xl font-bold mb-4">Enroll Student</h2>

        <form method="POST" action="{{ route('teacher.students.enroll') }}">
            @csrf

            <label class="block text-gray-700 font-medium mb-2">Select Student</label>
            <select name="student_id" required class="w-full px-4 py-2 border rounded-lg mb-4">
    <option value="">-- Choose Student --</option>
    @foreach($students as $student)
        <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
    @endforeach
</select>

            <label class="block text-gray-700 font-medium mb-2">Select Section</label>
            <select name="section_id" required class="w-full px-4 py-2 border rounded-lg mb-4">
                <option value="">-- Choose Section --</option>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}">{{ $section->year_level }} - {{ $section->name }}</option>
                @endforeach
            </select>

            <div class="flex justify-end gap-3 mt-4">
                <button type="button" onclick="document.getElementById('enrollStudentModal').classList.add('hidden');"
                        class="bg-gray-300 px-4 py-2 rounded-lg">Cancel</button>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg">Enroll</button>
            </div>
        </form>

        <button onclick="document.getElementById('enrollStudentModal').classList.add('hidden');"
                class="absolute top-3 right-3 text-xl">✕</button>
    </div>
</div>

<!-- RE-ENROLL MODAL -->
<div id="reEnrollModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 relative">

        <h2 class="text-lg font-bold mb-4">Re-Enroll Student</h2>

        <form method="POST" action="{{ route('teacher.students.enroll') }}">
            @csrf

            {{-- Student ID (auto-filled) --}}
            <input type="hidden" name="student_id" id="reEnrollStudentId">

            <label class="block text-gray-700 font-medium mb-2">
                Select Section
            </label>

            <select name="section_id" required class="w-full border rounded-lg px-4 py-2 mb-4">
                @foreach($sections as $section)
                    <option value="{{ $section->id }}">
                        {{ $section->year_level }} - {{ $section->name }}
                    </option>
                @endforeach
            </select>

            <div class="flex justify-end gap-3">
                <button type="button"
                        onclick="closeReEnrollModal()"
                        class="bg-gray-300 px-4 py-2 rounded">
                    Cancel
                </button>
                <button type="submit"
                        class="bg-green-600 text-white px-5 py-2 rounded">
                    Re-Enroll
                </button>
            </div>
        </form>

        <button onclick="closeReEnrollModal()"
                class="absolute top-3 right-4 text-xl">
            ✕
        </button>
    </div>
</div>
<script>
    function openReEnrollModal(studentId) {
        document.getElementById('reEnrollStudentId').value = studentId;
        document.getElementById('reEnrollModal').classList.remove('hidden');
        document.getElementById('reEnrollModal').classList.add('flex');
    }

    function closeReEnrollModal() {
        document.getElementById('reEnrollModal').classList.add('hidden');
        document.getElementById('reEnrollModal').classList.remove('flex');
    }
</script>

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
@if(session('success'))
    <div id="alertBox"
         class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-opacity duration-500">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div id="alertBox"
         class="fixed top-5 right-5 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-opacity duration-500">
        {{ session('error') }}
    </div>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alert = document.getElementById('alertBox');

        if (alert) {
            setTimeout(() => {
                alert.classList.add('opacity-0');
            }, 2500);

            setTimeout(() => {
                alert.remove();
            }, 3000);
        }
    });
</script>

</html>
