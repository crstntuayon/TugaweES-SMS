<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grades | Teacher Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-emerald-100 via-sky-100 to-indigo-200">

<!-- SweetAlert -->
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

<div x-data="{ sidebarOpen: true }" class="flex min-h-screen">

    <!-- ================= SIDEBAR ================= -->
<aside 
    :class="sidebarOpen ? 'w-72' : 'w-20'" 
    class="fixed left-0 top-0 h-screen bg-white border-r border-gray-200 z-50 flex flex-col shadow-sm overflow-y-auto transition-all duration-300 ease-in-out"
>
    <!-- Sidebar Header -->
    <div class="p-4 flex items-center gap-3 h-24 border-b border-gray-50">

        <!-- Hamburger Button -->
        <button @click="sidebarOpen = !sidebarOpen" 
                class="p-2 rounded-full hover:bg-gray-100 text-gray-600 transition shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- Logo + User Info -->
        <div x-show="sidebarOpen" x-transition class="flex flex-col gap-2 overflow-hidden">

           

            <!-- User Info -->
            @php
                $user = auth()->user();
                $fullName = trim(($user->first_name ?? '') . ' ' . ($user->middle_name ?? '') . ' ' . ($user->last_name ?? '') . ' ' . ($user->suffix ?? ''));
                $initials = collect(explode(' ', $fullName))->map(fn($n) => $n ? strtoupper($n[0]) : '')->join('');
            @endphp

            <div class="flex items-center gap-2">
                <!-- Profile Picture or Initials -->
                @if($user && $user->photo)
                    <img src="{{ asset('storage/'.$user->photo) }}" 
                         alt="Profile" 
                         class="w-10 h-10 rounded-full object-cover shadow-md">
                @else
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-500 text-white font-bold shadow-md text-sm">
                        {{ $initials ?: 'T' }}
                    </div>
                @endif

                <!-- Username / Full Name -->
                <div class="flex flex-col overflow-hidden">
                    <span class="text-sm font-bold text-gray-800 truncate">{{ $user->name ?? 'Teacher' }}</span>
                    <span class="text-xs text-gray-500 truncate">{{ $fullName ?: 'N/A' }}</span>
                </div>
            </div>

        </div>
    </div>

    <!-- Sidebar Nav -->
    <nav class="flex-1 mt-4 px-3 space-y-1">
        <!-- Home -->
        <a href="{{ route('teacher.dashboard') }}"  class="flex items-center gap-4 p-3 rounded-r-full bg-blue-50 text-blue-700 transition group hover:scale-[1.02]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6m2 12H5a2 2 0 01-2-2V7a2 2 0 012-2h2"/>
            </svg>
            <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Home</span>
        </a>

        <!-- My Profile -->
        <button @click="document.getElementById('profileModal').classList.remove('hidden'); document.getElementById('profileModal').classList.add('flex');"
                class="w-full flex items-center gap-4 p-3 rounded-r-full text-gray-600 hover:bg-gray-100 transition group hover:scale-[1.02]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A9 9 0 1118.879 6.196 9 9 0 015.121 17.804zM12 12a3 3 0 100-6 3 3 0 000 6z"/>
            </svg>
            <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">My Profile</span>
        </button>

        <!-- Enroll Student -->
        <button @click="document.getElementById('enrollStudentModal').classList.remove('hidden');"
                class="w-full flex items-center gap-4 p-3 rounded-r-full text-gray-600 hover:bg-gray-100 transition group hover:scale-[1.02]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Enroll Student</span>
        </button>

        <!-- Announcements -->
        <button @click="document.getElementById('announcementModal').classList.remove('hidden');"
                class="w-full flex items-center gap-4 p-3 rounded-r-full text-gray-600 hover:bg-gray-100 transition group hover:scale-[1.02]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Announcements</span>
        </button>
    </nav>

    <!-- Logout -->
    <div class="p-3 border-t border-gray-100">
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="flex items-center gap-4 p-3 rounded-r-full text-red-500 hover:bg-red-50 transition group hover:scale-[1.02]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1"/>
            </svg>
            <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
    </div>
</aside>


<!-- ================= MAIN CONTENT ================= -->
<main :class="sidebarOpen ? 'ml-72' : 'ml-20'" class="flex-1 p-6 transition-all duration-300 space-y-8 bg-gradient-to-br from-slate-50 to-gray-100 min-h-screen">

    <!-- ================= MODERN HEADER ================= -->
    <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/50 p-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 transition-all duration-500 hover:shadow-xl hover:shadow-indigo-500/5 group">

        <!-- Left Section: Back + Title -->
        <div class="flex items-center gap-6">
            <!-- Back Button -->
            <a href="{{ route('teacher.dashboard') }}"
               class="flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-50 to-violet-50 text-indigo-600 font-medium hover:from-indigo-600 hover:to-violet-600 hover:text-white hover:scale-110 hover:rotate-1 transition-all duration-300 shadow-sm hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="2.5"
                     stroke="currentColor"
                     class="w-6 h-6 transition-transform duration-300 group-hover:-translate-x-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>

            <!-- Title Block -->
            <div class="space-y-1">
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold tracking-wider uppercase">
                        Section
                    </span>
                    <span class="text-sm text-gray-400 font-medium">
                        {{ $section->schoolYear?->name ?? 'Current Year' }}
                    </span>
                </div>
                <h1 class="text-3xl lg:text-4xl font-black text-gray-900 tracking-tight">
                    {{ $section->year_level }} 
                    <span class="text-indigo-600 relative">
                        {{ $section->name }}
                        <svg class="absolute -bottom-2 left-0 w-full h-3 text-indigo-200 -z-10" viewBox="0 0 100 10" preserveAspectRatio="none">
                            <path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="8" fill="none" opacity="0.3"/>
                        </svg>
                    </span>
                </h1>
            </div>
        </div>

        <!-- Right Section: Stats -->
        <div class="flex items-center gap-6">
            <div class="text-right">
                <p class="text-3xl font-black text-gray-900">{{ count($section->students) }}</p>
                <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">Students</p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- ================= CUSTOM ANIMATIONS ================= -->
    <style>
    @keyframes fadeInUp {
      0% { opacity: 0; transform: translateY(20px); }
      100% { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideInLeft {
      0% { opacity: 0; transform: translateX(-20px); }
      100% { opacity: 1; transform: translateX(0); }
    }
    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
    }
    @keyframes shimmer {
      0% { background-position: -1000px 0; }
      100% { background-position: 1000px 0; }
    }
    .animate-fadeInUp {
      animation: fadeInUp 0.6s ease-out forwards;
    }
    .animate-slideInLeft {
      animation: slideInLeft 0.6s ease-out forwards;
    }
    .animate-float {
      animation: float 6s ease-in-out infinite;
    }
    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }
    .stagger-3 { animation-delay: 0.3s; }
    .stagger-4 { animation-delay: 0.4s; }
    .stagger-5 { animation-delay: 0.5s; }
    .stagger-6 { animation-delay: 0.6s; }
    </style>

    <!-- ================= STUDENT GRID ================= -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
        @foreach($section->students as $index => $student)
        @php $delayClass = 'stagger-' . (($index % 6) + 1); @endphp
        <div class="group bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-2 transition-all duration-500 animate-fadeInUp {{ $delayClass }}">
            
            <!-- Card Header with Gradient -->
            <div class="h-24 bg-gradient-to-br from-indigo-500 via-violet-500 to-purple-600 relative overflow-hidden">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
                <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-white/20 rounded-full blur-2xl"></div>
            </div>

            <!-- Card Content -->
            <div class="px-6 pb-6 relative">
                <!-- Avatar -->
                <div class="relative -mt-12 mb-4">
                    <div class="w-24 h-24 rounded-2xl p-1 bg-white shadow-lg inline-block">
                        <img src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/photo-placeholder.png') }}"
                             class="w-full h-full rounded-xl object-cover bg-gray-100"
                             alt="{{ $student->first_name }}'s photo">
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-8 h-8 bg-emerald-500 rounded-full border-4 border-white flex items-center justify-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <!-- Student Info -->
                <div class="space-y-3">
                    <div>
                        <h3 class="font-bold text-lg text-gray-900 leading-tight group-hover:text-indigo-600 transition-colors">
                            {{ $student->last_name }}, {{ $student->first_name }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $student->middle_name ?? '' }} {{ $student->suffix ?? '' }}
                        </p>
                    </div>

                    <!-- Meta Info -->
                    <div class="flex items-center gap-3 pt-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100 text-gray-600 text-xs font-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            ID: {{ $student->school_id ?? 'N/A' }}
                        </span>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <button onclick="openReportCard({{ $student->id }})"
                            class="w-full group/btn relative overflow-hidden bg-gray-900 text-white px-6 py-3.5 rounded-xl font-semibold text-sm hover:bg-indigo-600 transition-all duration-300 flex items-center justify-center gap-2 shadow-lg shadow-gray-900/20 hover:shadow-indigo-500/30">
                        <span class="relative z-10 flex items-center gap-2">
                            View Report Card
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform duration-300 group-hover/btn:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-violet-600 translate-y-full group-hover/btn:translate-y-0 transition-transform duration-300"></div>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Empty State (shown when no students) -->
    @if(count($section->students) === 0)
    <div class="text-center py-20 animate-fadeInUp">
        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">No students found</h3>
        <p class="text-gray-500">This section doesn't have any enrolled students yet.</p>
    </div>
    @endif

</main>

</div>


<!-- ================= REPORT CARD MODAL ================= -->
<div id="reportModal"
     class="fixed inset-0 hidden bg-black/50 z-50 flex items-center justify-center p-4 overflow-auto">

    <div class="bg-white w-full max-w-3xl rounded-xl shadow-lg p-6 relative">

        <!-- CLOSE BUTTON -->
        <button onclick="closeReportCard()"
                class="absolute top-3 right-3 text-xl text-gray-500 hover:text-red-600">
            ✕
        </button>

        <!-- ================= HEADER ================= -->
        <div class="border-b pb-3 mb-4">
            <div class="flex items-center justify-center gap-4">

                <div class="w-20">
                    <img src="{{ asset('images/logo1.png') }}" class="w-full">
                </div>

                <div class="text-center">
                    <p class="text-xs">Republic of the Philippines</p>
                    <p class="text-sm font-semibold">Department of Education</p>
                    <p class="text-xs">Division of Negros Oriental</p>

                    <h2 class="text-lg font-bold mt-1">
                        TUGAWE ELEMENTARY SCHOOL
                    </h2>

                    <p class="text-sm font-semibold">
                        STUDENT REPORT CARD
                    </p>
                </div>

                <div class="w-20">
                    <img src="{{ asset('images/logo.jpg') }}" class="w-full">
                </div>

            </div>
        </div>

        <!-- ================= STUDENT INFO ================= -->
        <div class="grid grid-cols-3 gap-3 text-sm mb-4">

            <div>
                <p class="font-semibold">Name:</p>
                <p id="modalStudentName" class="border-b pb-1"></p>
            </div>

            <div>
                <p class="font-semibold">Student ID:</p>
                <p id="modalStudentId" class="border-b pb-1"></p>
            </div>

            <div>
                <p class="font-semibold">Address:</p>
                <p id="modalStudentAddress" class="border-b pb-1"></p>
            </div>

        </div>

        <!-- ================= TABLE ================= -->
        <div class="overflow-auto max-h-[50vh] border rounded">

            <table class="min-w-full text-sm border">

                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-3 py-2 text-left">Learning Areas</th>
                        <th class="border px-2 py-2 text-center">1st</th>
                        <th class="border px-2 py-2 text-center">2nd</th>
                        <th class="border px-2 py-2 text-center">3rd</th>
                        <th class="border px-2 py-2 text-center">4th</th>
                        <th class="border px-2 py-2 text-center bg-indigo-100">Average</th>
                    </tr>
                </thead>

                <tbody id="report-body"></tbody>

                <tfoot class="bg-gray-100 font-semibold">
                    <tr>
                        <td class="border px-3 py-2">General Average</td>
                        <td class="border text-center qavg" data-q="1">—</td>
                        <td class="border text-center qavg" data-q="2">—</td>
                        <td class="border text-center qavg" data-q="3">—</td>
                        <td class="border text-center qavg" data-q="4">—</td>
                        <td class="border text-center bg-indigo-100" id="finalAverage">—</td>
                    </tr>
                </tfoot>

            </table>

        </div>

        <!-- SAVE BUTTON -->
        <div class="mt-4 text-right">
            <button onclick="saveModalGrades()"
                class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">
                💾 Save Grades
            </button>
        </div>

    </div>
</div>


<script>
function reportCard() {
    return {
        open: false,
        studentId: null,
        grades: {},
        studentName: '',
        subjects: @json($subjects),
        allSubjectsByGrade: @json($allSubjectsByGrade),
        finalQuarterTotals: {1:0,2:0,3:0,4:0},
        finalQuarterCounts: {1:0,2:0,3:0,4:0},
        finalAllSum: 0,
        finalAllCount: 0,

        openModal(id) {
            this.studentId = id;
            this.open = true;
            
            // get student info
            const student = @json($section->students->mapWithKeys(fn($s)=>[$s->id=>$s]))[id];
            this.studentName = `${student.first_name} ${student.last_name}`;
            
            // initialize grades
            this.grades = {};
            const subjectsByGrade = this.allSubjectsByGrade;
            Object.values(subjectsByGrade).forEach(subjects => {
                subjects.forEach(sub => {
                    if(sub.components){
                        this.grades[sub.id] = {};
                        JSON.parse(sub.components).forEach(comp => {
                            this.grades[sub.id][comp] = {1:'',2:'',3:'',4:''};
                        });
                    } else {
                        this.grades[sub.id] = {'': {1:'',2:'',3:'',4:''}};
                    }
                });
            });

            this.computeFinal();
        },

        closeModal() {
            this.open = false;
        },

        saveModalGrades() {
            fetch("{{ route('teacher.grades.modal.save') }}", {
                method:'POST',
                headers:{
                    'Content-Type':'application/json',
                    'X-CSRF-TOKEN':'{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    student_id: this.studentId,
                    grades: this.grades
                })
            })
            .then(r=>r.json())
            .then(()=> {
                alert('Grades saved successfully');
                this.open = false;
                location.reload();
            });
        },

        computeComponentAverage(subjectId, comp) {
            let compGrades = this.grades[subjectId]?.[comp] || {};
            let sum = 0, count = 0;
            Object.values(compGrades).forEach(v => {
                if(v !== null && v !== undefined && v !== '') { sum += parseFloat(v); count++; }
            });
            return count ? (sum / count).toFixed(2) : '-';
        },

        computeMAPEHAverage(subjectId, quarter) {
            let comps = this.grades[subjectId] || {};
            let sum=0, count=0;
            Object.values(comps).forEach(compGrades => {
                let val = parseFloat(compGrades[quarter]);
                if(!isNaN(val)) { sum += val; count++; }
            });
            return count ? (sum/count).toFixed(2) : '-';
        },

        computeMAPEHFinalAverage(subjectId) {
            let comps = this.grades[subjectId] || {};
            let sum=0, count=0;
            Object.values(comps).forEach(compGrades => {
                Object.values(compGrades).forEach(v=>{
                    if(v !== null && v !== undefined && v !== '') { sum+=parseFloat(v); count++; }
                });
            });
            return count ? (sum/count).toFixed(2) : '-';
        },

        computeSubjectAverage(subjectId) {
            let subject = this.grades[subjectId] || {};
            let sum=0, count=0;
            Object.values(subject).forEach(compGrades=>{
                Object.values(compGrades).forEach(v=>{
                    if(v !== null && v !== undefined && v !== '') { sum+=parseFloat(v); count++; }
                });
            });
            return count ? (sum/count).toFixed(2) : '-';
        },

        computeFinal() {
            this.finalQuarterTotals = {1:0,2:0,3:0,4:0};
            this.finalQuarterCounts = {1:0,2:0,3:0,4:0};
            this.finalAllSum = 0;
            this.finalAllCount = 0;

            Object.values(this.grades).forEach(subject=>{
                Object.values(subject).forEach(comp=>{
                    Object.entries(comp).forEach(([q,v])=>{
                        let val=parseFloat(v);
                        if(!isNaN(val)){
                            this.finalQuarterTotals[q]+=val;
                            this.finalQuarterCounts[q]++;
                            this.finalAllSum+=val;
                            this.finalAllCount++;
                        }
                    });
                });
            });
        },

        finalQuarterAverage(q) {
            return this.finalQuarterCounts[q] ? (this.finalQuarterTotals[q]/this.finalQuarterCounts[q]).toFixed(2) : '-';
        },

        finalAverage() {
            return this.finalAllCount ? (this.finalAllSum/this.finalAllCount).toFixed(2) : '-';
        }
    }
}
</script>


<!-- ================= JAVASCRIPT ================= -->

<script>

const currentYearLevel = @json($section->year_level);

const students = @json(
    $section->students->mapWithKeys(function($s){
        return [
            $s->id => [
                'name' => $s->last_name.', '.$s->first_name,
                'grades' => $s->grades
                    ->groupBy('subject_id')
                    ->map(function($g){
                        return $g->keyBy('quarter')->map->grade;
                    })
            ]
        ];
    })
);

const subjects = @json(
    $subjects->where('grade_level',$section->year_level)->map(function($s){
        return [
            'id'=>$s->id,
            'name'=>$s->name
        ];
    })
);

let activeStudentId = null;


/* ================= OPEN MODAL ================= */

function openReportCard(id){

    activeStudentId = id;

    const student = students[id];

    document.getElementById('modalStudentName').textContent = student.name;

    let body = '';

    subjects.forEach(sub => {

        body += `<tr class="subject-row">

            <td class="border px-3 py-2">${sub.name}</td>`;

        for(let q=1;q<=4;q++){

            const val = student.grades?.[sub.id]?.[q] ?? '';

            body += `<td class="border text-center">
                <input type="number"
                       class="grade-input w-16 text-center border rounded"
                       data-subject="${sub.id}"
                       data-quarter="${q}"
                       value="${val}">
            </td>`;
        }

        body += `<td class="border text-center bg-indigo-50 subject-final">—</td>
        </tr>`;
    });

    document.getElementById('report-body').innerHTML = body;

    calculateAll();

    const modal = document.getElementById('reportModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}


/* ================= CLOSE ================= */

function closeReportCard(){

    const modal = document.getElementById('reportModal');

    modal.classList.add('hidden');
    modal.classList.remove('flex');
}


/* ================= CALCULATE ================= */

function calculateAll(){

    let quarterTotals = {1:[],2:[],3:[],4:[]};
    let finalSubjects = [];

    document.querySelectorAll('.subject-row').forEach(row => {

        let grades = [];

        row.querySelectorAll('.grade-input').forEach(input => {

            const q = input.dataset.quarter;
            const v = parseFloat(input.value);

            if(!isNaN(v)){
                grades.push(v);
                quarterTotals[q].push(v);
            }

        });

        const avgCell = row.querySelector('.subject-final');

        if(grades.length){

            const avg = grades.reduce((a,b)=>a+b,0)/grades.length;

            avgCell.textContent = avg.toFixed(2);

            finalSubjects.push(avg);

        }else{

            avgCell.textContent = '—';

        }

    });

    let finalQuarters = [];

    for(let q=1;q<=4;q++){

        const avg = quarterTotals[q].length
            ? (quarterTotals[q].reduce((a,b)=>a+b,0)/quarterTotals[q].length).toFixed(2)
            : '—';

        document.querySelector(`.qavg[data-q="${q}"]`).textContent = avg;

        if(avg !== '—') finalQuarters.push(parseFloat(avg));

    }

    document.getElementById('finalAverage').textContent =
        finalQuarters.length
            ? (finalQuarters.reduce((a,b)=>a+b,0)/finalQuarters.length).toFixed(2)
            : '—';

}


/* AUTO RECALCULATE */

document.addEventListener('input', e=>{

    if(e.target.classList.contains('grade-input')){
        calculateAll();
    }

});


/* ================= SAVE ================= */

function saveModalGrades(){

    let grades = {};

    document.querySelectorAll('.grade-input').forEach(input=>{

        const subject = input.dataset.subject;
        const quarter = input.dataset.quarter;

        if(!grades[subject]) grades[subject] = {};

        grades[subject][quarter] = input.value;

    });

    fetch("{{ route('teacher.grades.modal.save') }}",{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body:JSON.stringify({
            student_id: activeStudentId,
            grades: grades
        })
    })
    .then(r=>r.json())
    .then(()=>{
        alert('Grades saved successfully');
        closeReportCard();
        location.reload();
    });

}

</script>

<!-- PROFILE MODAL -->
<div id="profileModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl p-6 relative overflow-y-auto max-h-[90vh]">

        <h2 class="text-xl font-bold mb-6">My Profile</h2>

        <form method="POST"
              action="{{ route('profile.update') }}"
              enctype="multipart/form-data"
              x-data="{ editMode: false }">

            @csrf
            @method('PATCH')

            @php
                $teacher = auth()->user()->teacher;
            @endphp

            <!-- PHOTO -->
            <div class="flex items-center gap-6 mb-6">
                <img src="{{ $teacher && $teacher->photo 
                                ? asset('storage/'.$teacher->photo) 
                                : asset('images/photo-placeholder.png') }}"
                     class="w-24 h-24 rounded-full object-cover shadow">

                <div x-show="editMode">
                    <input type="file" name="photo" class="block text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- FIRST NAME -->
                <div>
                    <label class="text-sm font-medium">First Name</label>
                    <input type="text" name="first_name"
                           value="{{ $teacher->first_name ?? '' }}"
                           :disabled="!editMode"
                           class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-50 disabled:bg-gray-100">
                </div>

                <!-- MIDDLE NAME -->
                <div>
                    <label class="text-sm font-medium">Middle Name</label>
                    <input type="text" name="middle_name"
                           value="{{ $teacher->middle_name ?? '' }}"
                           :disabled="!editMode"
                           class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-50 disabled:bg-gray-100">
                </div>

                <!-- LAST NAME -->
                <div>
                    <label class="text-sm font-medium">Last Name</label>
                    <input type="text" name="last_name"
                           value="{{ $teacher->last_name ?? '' }}"
                           :disabled="!editMode"
                           class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-50 disabled:bg-gray-100">
                </div>

                <!-- SUFFIX -->
                <div>
                    <label class="text-sm font-medium">Suffix</label>
                    <input type="text" name="suffix"
                           value="{{ $teacher->suffix ?? '' }}"
                           :disabled="!editMode"
                           class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-50 disabled:bg-gray-100">
                </div>

                <!-- BIRTHDAY -->
                <div>
                    <label class="text-sm font-medium">Birthday</label>
                    <input type="date" name="birthday"
                           value="{{ $teacher->birthday ?? '' }}"
                           :disabled="!editMode"
                           class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-50 disabled:bg-gray-100">
                </div>

                <!-- USERNAME (from users table)  -->
                <div>
                    <label class="text-sm font-medium">Username</label>
                    <input type="text" name="username"
                           value="{{ auth()->user()->username }}"
                           :disabled="!editMode"
                           class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-50 disabled:bg-gray-100">
                </div> 

                <!-- CONTACT -->
                <div>
                    <label class="text-sm font-medium">Contact Number</label>
                    <input type="text" name="contact_number"
                           value="{{ $teacher->contact_number ?? '' }}"
                           :disabled="!editMode"
                           class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-50 disabled:bg-gray-100">
                </div>

                <!-- EMAIL (NOT EDITABLE - from users table) -->
                <div>
                    <label class="text-sm font-medium">Email</label>
                    <input type="email"
                           value="{{ auth()->user()->email }}"
                           disabled
                           class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-200 cursor-not-allowed">
                </div>

                <!-- PASSWORD -->
                <div class="md:col-span-2" x-show="editMode">
                    <label class="text-sm font-medium">New Password</label>
                    <input type="password" name="password"
                           placeholder="Leave blank if not changing"
                           class="w-full border rounded-lg px-3 py-2 mt-1">
                </div>

            </div>

            <!-- BUTTONS -->
            <div class="flex justify-end gap-3 mt-8">

                <!-- EDIT BUTTON -->
                <button type="button"
                        x-show="!editMode"
                        @click="editMode = true"
                        class="bg-indigo-600 text-white px-5 py-2 rounded-lg">
                    Edit Profile
                </button>

                <!-- CANCEL BUTTON -->
                <button type="button"
                        x-show="editMode"
                        @click="editMode = false"
                        class="bg-gray-400 text-white px-5 py-2 rounded-lg">
                    Cancel
                </button>

                <!-- SAVE BUTTON -->
                <button type="submit"
                        x-show="editMode"
                        class="bg-green-600 text-white px-5 py-2 rounded-lg">
                    Save Changes
                </button>

            </div>
        </form>

        <!-- CLOSE -->
        <button onclick="closeProfileModal()"
                class="absolute top-3 right-4 text-xl">
            ✕
        </button>
    </div>
</div>

<script>
function closeProfileModal() {
    document.getElementById('profileModal').classList.add('hidden');
    document.getElementById('profileModal').classList.remove('flex');
}
</script>

<!-- ENROLL STUDENT MODAL -->
<div id="enrollStudentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 relative mx-auto my-auto">
        <h2 class="text-xl font-bold mb-4">Enroll Student</h2>

        <form method="POST" action="{{ route('teacher.students.enroll') }}">
            @csrf
<label class="block text-gray-700 font-medium mb-2">Select Student</label>
<select name="student_id" required class="w-full px-4 py-2 border rounded-lg mb-4">
    <option value="">-- Choose Student --</option>
  @foreach($section->students as $student)
        <option value="{{ $student->id }}">
            {{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name ? ' '.$student->middle_name[0].'.' : '' }} {{ $student->suffix ? ' '.$student->suffix : '' }} ({{ $student->school_id }})    
        </option>
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



<!-- ANNOUNCEMENT MODAL -->
<div id="announcementModal"
     class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl p-6 relative animate-fadeIn">

        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-indigo-600">📢 Create Announcement</h2>
            <button onclick="closeAnnouncementModal()"
                    class="text-gray-400 hover:text-red-500 text-xl">&times;</button>
        </div>

        <!-- Form to create new announcement -->
        <form action="{{ route('teacher.announcements.store') }}" method="POST" class="mb-4">
            @csrf

            <!-- Title -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" required
                       class="w-full mt-1 px-4 py-2 border rounded-xl focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>

            <!-- Message -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Message</label>
                <textarea name="message" rows="4" required
                          class="w-full mt-1 px-4 py-2 border rounded-xl focus:ring-2 focus:ring-indigo-400 focus:outline-none"></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-3">
                <button type="button"
                        onclick="closeAnnouncementModal()"
                        class="px-4 py-2 bg-gray-200 rounded-xl hover:bg-gray-300">
                    Cancel
                </button>

                <button type="submit"
                        class="px-5 py-2 bg-indigo-600 text-white rounded-xl shadow hover:bg-indigo-700 transition">
                    Post Announcement
                </button>
            </div>
        </form>

        <!-- List of announcements -->
        <ul class="space-y-4 mt-4">
            @foreach($announcements as $announcement)
            <li x-data="{ editing: false, title: '{{ addslashes($announcement->title) }}', content: '{{ addslashes($announcement->content) }}' }"
                class="bg-indigo-50 p-4 rounded-2xl shadow hover:shadow-lg transition">

                <!-- Display Mode -->
                <div x-show="!editing">
                    <h3 class="font-semibold text-indigo-900 text-lg mb-1" x-text="title"></h3>
                    <p class="text-gray-700 text-sm" x-text="content"></p>
                    <div class="flex justify-between items-center mt-2 text-xs text-gray-500">
                        <span>Posted by: {{ $announcement->user->name }}</span>
                        <span>{{ $announcement->created_at->format('M d, Y') }}</span>
                    </div>

                    <div class="flex gap-2 mt-2">
                        <button @click="editing = true"
                                class="text-indigo-600 hover:underline text-sm">Edit</button>

                        <form @submit.prevent="deleteAnnouncement({{ $announcement->id }}, $el)" class="inline">
                            @csrf
                            @method('DELETE')
                          <!--  <button type="submit" class="text-red-600 hover:underline text-sm">Delete</button> -->
                        </form>
                    </div>
                </div>

                <!-- Edit Mode -->
                <div x-show="editing" x-cloak class="space-y-2">
                    <input type="text" x-model="title" class="w-full px-3 py-2 rounded-xl border" />
                    <textarea x-model="content" class="w-full px-3 py-2 rounded-xl border"></textarea>

                    <div class="flex gap-2">
                        <button @click="
                            updateAnnouncement({{ $announcement->id }}, title, content);
                            editing = false;
                        "
                                class="bg-indigo-600 text-white px-3 py-1 rounded-xl hover:bg-indigo-700 text-sm">Save</button>

                        <button @click="editing = false"
                                class="bg-gray-300 px-3 py-1 rounded-xl text-sm">Cancel</button>
                    </div>
                </div>

            </li>
            @endforeach
        </ul>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function closeAnnouncementModal() {
    const modal = document.getElementById('announcementModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Inline Update
function updateAnnouncement(id, title, content) {
    axios.put(`/teacher/announcements/${id}`, {
        title: title,
        message: content
    })
    .then(() => {
        Swal.fire({
            icon: 'success',
            title: 'Updated!',
            text: 'Announcement updated successfully.',
            confirmButtonColor: '#6366f1'
        });
    })
    .catch(() => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to update announcement.',
            confirmButtonColor: '#f87171'
        });
    });
}

// Inline Delete
function deleteAnnouncement(id, formElement) {
    axios.delete(`/teacher/announcements/${id}`)
        .then(() => {
            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: 'Announcement deleted successfully.',
                confirmButtonColor: '#6366f1'
            });
            formElement.closest('li').remove();
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to delete announcement.',
                confirmButtonColor: '#f87171'
            });
        });
}
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
.animate-fadeIn {
    animation: fadeIn 0.2s ease-out;
}
</style>



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


</body>
</html>
