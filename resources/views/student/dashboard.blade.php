<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard | SMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#4f46e5">
</head>
<body class="min-h-screen bg-gray-50 p-4 md:p-6 font-sans">

<!-- =================== HEADER =================== -->
<header class="sticky top-0 z-50 bg-white/50 backdrop-blur-md shadow-md rounded-2xl mb-10">
    <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/logo.jpg') }}" class="h-16 w-16 rounded-full shadow-sm ring-2 ring-gray-300" alt="School Logo">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Student Dashboard</h1>
                <p class="text-sm text-gray-500">Tugawe Elementary School | Dauin District</p>
            </div>
        </div>

        <!-- Account Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center gap-2 bg-white/60 hover:bg-gray-100 px-4 py-2 rounded-xl shadow-sm text-sm font-medium text-gray-700 transition">
                <span class="hidden md:block">Account</span>
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="open" @click.away="open = false" x-transition
                 class="absolute right-0 mt-3 w-64 bg-white/80 backdrop-blur-md rounded-2xl shadow-lg border border-gray-100 overflow-hidden z-50">
                <div class="px-4 py-3 border-b bg-gray-50/70">
                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name ?? 'User' }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                </div>
               
                
                <a href="#" onclick="openProfileModal()" 
   class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
   👤 My Profile
</a>

                <div class="border-t"></div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
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

@if(!$section)
    <div class="bg-white/50 rounded-3xl shadow-md p-8 text-center text-gray-600 text-lg font-medium backdrop-blur-sm">
        You are not assigned to any section yet.
    </div>
@else

    <!-- =================== STUDENT INFO =================== -->
    <div class="bg-white/60 rounded-3xl shadow-sm border border-gray-200 p-6 flex flex-col md:flex-row md:items-center gap-6 backdrop-blur-sm">
        <img src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/photo-placeholder.png') }}" 
             class="w-28 h-28 rounded-full object-cover border shadow-sm ring-2 ring-gray-300" alt="Profile Photo">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $student->first_name }} {{ $student->middle_name ?? '' }} {{ $student->last_name }} {{ $student->suffix ?? '' }}</h1>
            <p class="text-gray-600 mt-1">Student ID: <span class="font-medium">{{ $student->school_id }}</span></p>
            <p class="text-gray-600 mt-1">Section: <span class="font-medium">{{ $section->year_level }} - {{ $section->name }}</span></p>
        </div>
    </div>

    <!-- =================== ACTION BUTTONS =================== -->
    <div class="flex flex-wrap gap-4 mt-6">
<!-- Grades Button -->
<div x-data="{ openGrades: false }">
    <button @click="openGrades = true" 
        class="bg-indigo-600 text-white px-6 py-2 rounded-xl shadow-sm hover:bg-indigo-700 transition transform hover:scale-105">
        📄 View Report Card
    </button>

    <!-- Grades Modal -->
    <div x-show="openGrades" x-cloak 
         class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl shadow-md max-w-6xl w-full p-6 relative overflow-auto max-h-[90vh]">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-800 border-b pb-2">
                    📄 Report Card
                    <span class="text-sm text-gray-500 font-normal ml-2">
                        Section: {{ $section->year_level }} - {{ $section->name }}
                    </span>
                    <span class="text-gray-500 text-base font-normal">
                        - Active SY: {{ $activeSchoolYear->name ?? 'N/A' }}
                    </span>
                </h2>
                <button @click="openGrades = false" class="text-xl font-bold hover:text-red-500">✕</button>
            </div>

            @php
                $quarters = [1,2,3,4];

                $allSubjectsByGrade = \App\Models\Subject::orderByRaw(
                    "FIELD(grade_level, 'Kindergarten','Grade 1','Grade 2','Grade 3','Grade 4','Grade 5','Grade 6')"
                )->get()->groupBy('grade_level');

                $currentYear = $section->year_level;
                if($allSubjectsByGrade->has($currentYear)){
                    $currentSubjects = $allSubjectsByGrade->pull($currentYear);
                    $allSubjectsByGrade = collect([$currentYear => $currentSubjects])->merge($allSubjectsByGrade);
                }

                $finalQuarterTotals = [1 => 0, 2 => 0, 3 => 0, 4 => 0];
                $finalQuarterCounts = [1 => 0, 2 => 0, 3 => 0, 4 => 0];
                $finalAllSum = 0;
                $finalAllCount = 0;
            @endphp

            @foreach($allSubjectsByGrade as $grade => $subjects)
                <h3 class="text-lg font-bold text-indigo-800 mt-6 mb-2">{{ $grade }}</h3>

                <table class="min-w-full border text-sm rounded-lg overflow-hidden shadow-sm mb-6">
                    <thead class="bg-indigo-50 text-gray-700 sticky top-0 z-10">
                        <tr>
                            <th class="border px-3 py-2 text-left">Subject</th>
                            @foreach($quarters as $q)
                                <th class="border px-3 py-2 text-center">Q{{ $q }}</th>
                            @endforeach
                            <th class="border px-3 py-2 text-center">Average</th>
                            <th class="border px-3 py-2 text-center">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $quarterTotals = [1 => 0, 2 => 0, 3 => 0, 4 => 0];
                            $quarterCounts = [1 => 0, 2 => 0, 3 => 0, 4 => 0];
                            $gradeSum = 0;
                            $gradeCount = 0;
                        @endphp

                        @foreach($subjects as $subject)
                            @if($subject->components)
                                @php
                                    $components = json_decode($subject->components);
                                @endphp
                                <tr class="bg-gray-100 font-semibold">
                                    <td class="border px-4 py-2 text-gray-800">{{ $subject->name }}</td>
                                    @foreach($quarters as $q)
                                        <td class="border px-4 py-2 text-center">-</td>
                                    @endforeach
                                    <td class="border px-4 py-2 text-center">-</td>
                                    <td class="border px-4 py-2 text-center">-</td>
                                </tr>

                                @foreach($components as $comp)
                                    @php
                                        $grades = $student->grades
                                            ->where('subject_id', $subject->id)
                                            ->where('component', $comp)
                                            ->keyBy('quarter');

                                        $qValues = [];
                                        $compSum = 0;
                                        $compCount = 0;

                                        foreach($quarters as $q){
                                            $grade = $grades[$q]->grade ?? '-';
                                            $qValues[$q] = $grade;

                                            if($grade !== '-') {
                                                $quarterTotals[$q] += $grade;
                                                $quarterCounts[$q]++;
                                                $finalQuarterTotals[$q] += $grade;
                                                $finalQuarterCounts[$q]++;
                                                $compSum += $grade;
                                                $compCount++;
                                                $finalAllSum += $grade;
                                                $finalAllCount++;
                                            }
                                        }
                                        $average = $compCount ? round($compSum/$compCount,2) : '-';
                                        $remarks = $average !== '-' ? ($average >= 75 ? 'Passed' : 'Failed') : '-';
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="border px-8 py-2 text-gray-700 font-medium">{{ $comp }}</td>
                                        @foreach($quarters as $q)
                                            <td class="border px-4 py-2 text-center text-gray-600">{{ $qValues[$q] }}</td>
                                        @endforeach
                                        <td class="border px-4 py-2 text-center font-semibold text-gray-800">{{ $average }}</td>
                                        <td class="border px-4 py-2 text-center text-gray-700 font-medium">{{ $remarks }}</td>
                                    </tr>
                                @endforeach
                            @else
                                @php
                                    $grades = $student->grades
                                        ->where('subject_id', $subject->id)
                                        ->keyBy('quarter');

                                    $qValues = [];
                                    foreach($quarters as $q){
                                        $grade = $grades[$q]->grade ?? '-';
                                        $qValues[$q] = $grade;

                                        if($grade !== '-') {
                                            $quarterTotals[$q] += $grade;
                                            $quarterCounts[$q]++;
                                            $finalQuarterTotals[$q] += $grade;
                                            $finalQuarterCounts[$q]++;
                                            $gradeSum += $grade;
                                            $gradeCount++;
                                            $finalAllSum += $grade;
                                            $finalAllCount++;
                                        }
                                    }
                                    $average = $gradeCount ? round($gradeSum/$gradeCount,2) : '-';
                                    $remarks = $average !== '-' ? ($average >= 75 ? 'Passed' : 'Failed') : '-';
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-4 py-2 font-medium text-gray-700">{{ $subject->name }}</td>
                                    @foreach($quarters as $q)
                                        <td class="border px-4 py-2 text-center text-gray-600">{{ $qValues[$q] }}</td>
                                    @endforeach
                                    <td class="border px-4 py-2 text-center font-semibold text-gray-800">{{ $average }}</td>
                                    <td class="border px-4 py-2 text-center text-gray-700 font-medium">{{ $remarks }}</td>
                                </tr>
                            @endif
                        @endforeach

                        <!-- Quarterly Average Row -->
                        <tr class="bg-gray-100/50 font-semibold text-gray-800">
                            <td class="border px-4 py-2 text-left">Quarterly Average</td>
                            @foreach($quarters as $q)
                                @php
                                    $qAvg = $quarterCounts[$q] ? round($quarterTotals[$q]/$quarterCounts[$q],2) : '-';
                                @endphp
                                <td class="border px-4 py-2 text-center">{{ $qAvg }}</td>
                            @endforeach
                            <td class="border px-4 py-2 text-center"></td>
                            <td class="border px-4 py-2 text-center"></td>
                        </tr>

                        <!-- Final Average Row -->
                        <tr class="bg-indigo-50/50 font-semibold text-gray-800">
                            <td class="border px-4 py-2 text-left">Final Average</td>
                            @foreach($quarters as $q)
                                <td class="border px-4 py-2 text-center"></td>
                            @endforeach
                            @php
                                $finalAverage = $gradeCount ? round($gradeSum/$gradeCount,2) : '-';
                                $finalRemarks = $finalAverage !== '-' ? ($finalAverage >= 75 ? 'Passed' : 'Failed') : '-';
                            @endphp
                            <td class="border px-4 py-2 text-center font-semibold text-gray-800">{{ $finalAverage }}</td>
                            <td class="border px-4 py-2 text-center text-gray-700 font-medium">{{ $finalRemarks }}</td>
                        </tr>

                    </tbody>
                </table>
            @endforeach

        </div>
    </div>
</div>



        <!-- Attendance Button -->
        <div x-data="{ openAttendance: false, month: '{{ now()->format('F Y') }}', view: 'table' }">
            <button @click="openAttendance = true" class="bg-yellow-500/70 text-white px-6 py-2 rounded-xl shadow-sm hover:bg-yellow-600/70 transition transform hover:scale-105">
                📝 View Attendance
            </button>

            <!-- Attendance Modal -->
            <div x-show="openAttendance" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
                <div class="bg-white/60 rounded-3xl shadow-sm max-w-6xl w-full p-6 relative overflow-auto max-h-[90vh] backdrop-blur-sm">

                    <div class="flex justify-between items-center border-b pb-3 mb-4">
                        <h2 class="text-2xl font-bold text-gray-800">📝 Attendance Record</h2>
                        <button @click="openAttendance = false" class="text-xl font-bold hover:text-red-500">✕</button>
                    </div>

                    @php
                        $months = $student->attendances->groupBy(function ($a) {
                            return \Carbon\Carbon::parse($a->date)->format('F Y');
                        });
                    @endphp

                    <!-- Month Selector -->
                    <div class="mb-4 flex items-center gap-3">
                        <span class="font-semibold text-gray-700">Select Month:</span>
                        <select x-model="month" class="border px-3 py-1 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                            @foreach ($months as $m => $records)
                                <option value="{{ $m }}">{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Legend -->
                    <div class="mb-4 flex gap-6 text-sm font-semibold">
                        <span class="text-green-600">P – Present</span>
                        <span class="text-yellow-600">L – Late</span>
                        <span class="text-red-600">A – Absent</span>
                    </div>

                    <!-- Table View -->
                    <div x-show="view === 'table'" class="overflow-x-auto">
                        <table class="w-full border-collapse text-sm shadow-sm rounded-xl overflow-hidden">
                            <thead class="bg-yellow-100/70 text-gray-800 sticky top-0 z-10">
                                <tr>
                                    <th class="border px-4 py-2 text-left w-44">Date</th>
                                    <th class="border px-4 py-2 text-center w-24">Day</th>
                                    <th class="border px-4 py-2 text-center w-28">Attendance</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white/70">
                                <template x-for="record in {{ json_encode($months) }}[month]" :key="record.id">
                                    <tr class="transition hover:bg-gray-50/50"
                                        :class="['Sat','Sun'].includes(new Date(record.date).toLocaleDateString('en-US',{ weekday:'short' })) ? 'bg-gray-100/50 text-gray-500' : ''">

                                        <td class="border px-4 py-2 text-left font-medium"
                                            x-text="new Date(record.date).toLocaleDateString('en-US', { month:'long', day:'numeric', year:'numeric' })"></td>

                                        <td class="border px-4 py-2 text-center font-medium"
                                            x-text="new Date(record.date).toLocaleDateString('en-US',{ weekday:'short' })"></td>

                                        <td class="border px-4 py-2 text-center font-bold text-lg"
                                            :class="record.status === 'present' ? 'text-green-600' :
                                                    record.status === 'late' ? 'text-yellow-600' :
                                                    record.status === 'absent' ? 'text-red-600' :
                                                    'text-gray-400'"
                                            x-text="record.status === 'present' ? 'P' :
                                                    record.status === 'late' ? 'L' :
                                                    record.status === 'absent' ? 'A' : ''">
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <!-- Attendance Summary -->
                    <div class="mt-6 border-t pt-4">
                        <template x-for="(records, m) in {{ json_encode($months) }}" :key="m">
                            <div x-show="month === m" class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center font-semibold">

                                <div class="bg-gray-100/50 rounded-xl p-3 shadow-sm">
                                    Total Days
                                    <div class="text-2xl mt-1" x-text="records.length"></div>
                                </div>

                                <div class="bg-green-100/50 rounded-xl p-3 shadow-sm">
                                    Present (P)
                                    <div class="text-2xl mt-1" x-text="records.filter(r => r.status === 'present').length"></div>
                                </div>

                                <div class="bg-yellow-100/50 rounded-xl p-3 shadow-sm">
                                    Late (L)
                                    <div class="text-2xl mt-1" x-text="records.filter(r => r.status === 'late').length"></div>
                                </div>

                                <div class="bg-red-100/50 rounded-xl p-3 shadow-sm">
                                    Absent (A)
                                    <div class="text-2xl mt-1" x-text="records.filter(r => r.status === 'absent').length"></div>
                                </div>

                                <div class="bg-indigo-100/50 rounded-xl p-3 shadow-sm col-span-2 md:col-span-4">
                                    Attendance Percentage
                                    <div class="text-3xl font-bold mt-1"
                                        :class="((records.filter(r => r.status === 'present' || r.status === 'late').length / records.length) * 100) >= 90 ? 'text-green-700' :
                                                ((records.filter(r => r.status === 'present' || r.status === 'late').length / records.length) * 100) >= 75 ? 'text-yellow-700' :
                                                'text-red-700'"
                                        x-text="records.length ? Math.round((records.filter(r => r.status === 'present' || r.status === 'late').length / records.length) * 100)+'%' : '0%'">
                                    </div>
                                </div>

                            </div>
                        </template>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endif



</main>

<!-- =================== STUDENT PROFILE MODAL =================== -->
<div id="profileModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl p-6 relative overflow-y-auto max-h-[90vh]"
         x-data="{ editMode: false }">

        <h2 class="text-xl font-bold mb-6">My Profile</h2>

        <form method="POST"
              action="{{ route('student.profile.update') }}"
              enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <!-- PHOTO -->
            <div class="flex items-center gap-6 mb-6">
                <img src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/photo-placeholder.png') }}"
                     class="w-24 h-24 rounded-full object-cover shadow">

                <div x-show="editMode">
                    <input type="file" name="photo" class="block text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="text-sm font-medium">First Name</label>
                    <input type="text" name="first_name"
                           value="{{ $student->first_name }}"
                           :disabled="!editMode"
                           class="w-full border rounded-lg px-3 py-2 mt-1 disabled:bg-gray-100">
                </div>

                <div>
                    <label class="text-sm font-medium">Middle Name</label>
                    <input type="text" name="middle_name"
                           value="{{ $student->middle_name }}"
                           :disabled="!editMode"
                           class="w-full border rounded-lg px-3 py-2 mt-1 disabled:bg-gray-100">
                </div>

                <div>
                    <label class="text-sm font-medium">Last Name</label>
                    <input type="text" name="last_name"
                           value="{{ $student->last_name }}"
                           :disabled="!editMode"
                           class="w-full border rounded-lg px-3 py-2 mt-1 disabled:bg-gray-100">
                </div>

                <div>
                    <label class="text-sm font-medium">Suffix</label>
                    <input type="text" name="suffix"
                           value="{{ $student->suffix }}"
                           :disabled="!editMode"
                           class="w-full border rounded-lg px-3 py-2 mt-1 disabled:bg-gray-100">
                </div>

                <div>
                    <label class="text-sm font-medium">Birthday</label>
                    <input type="date" name="birthday"
                           value="{{ $student->birthday }}"
                           :disabled="!editMode"
                           class="w-full border rounded-lg px-3 py-2 mt-1 disabled:bg-gray-100">
                </div>

                <div>
                    <label class="text-sm font-medium">Contact Number</label>
                    <input type="text" name="contact_number"
                           value="{{ $student->contact_number }}"
                           :disabled="!editMode"
                           class="w-full border rounded-lg px-3 py-2 mt-1 disabled:bg-gray-100">
                </div>

                <!-- USERNAME (FROM USERS TABLE) -->
                <div>
                    <label class="text-sm font-medium">Username</label>
                    <input type="text" name="username"
                           value="{{ auth()->user()->username }}"
                           :disabled="!editMode"
                           class="w-full border rounded-lg px-3 py-2 mt-1 disabled:bg-gray-100">
                </div>

                <!-- EMAIL (NOT EDITABLE) -->
                <div>
                    <label class="text-sm font-medium">Email</label>
                    <input type="email"
                           value="{{ auth()->user()->email }}"
                           disabled
                           class="w-full border rounded-lg px-3 py-2 mt-1 bg-gray-200">
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

                <button type="button"
                        x-show="!editMode"
                        @click="editMode = true"
                        class="bg-indigo-600 text-white px-5 py-2 rounded-lg">
                    Edit Profile
                </button>

                <button type="button"
                        x-show="editMode"
                        @click="editMode = false"
                        class="bg-gray-400 text-white px-5 py-2 rounded-lg">
                    Cancel
                </button>

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
function openProfileModal() {
    document.getElementById('profileModal').classList.remove('hidden');
    document.getElementById('profileModal').classList.add('flex');
}

function closeProfileModal() {
    document.getElementById('profileModal').classList.remove('flex');
    document.getElementById('profileModal').classList.add('hidden');
}
</script>


<script src="//unpkg.com/alpinejs" defer></script>
<script>
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/service-worker.js');
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
