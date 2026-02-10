<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-emerald-100 via-sky-100 to-indigo-200 min-h-screen p-6">

<!-- ================= ENHANCED HEADER ================= -->
<header class="mb-6">
    <div class="bg-white/80 backdrop-blur rounded-2xl shadow-md p-5 border border-gray-200">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <!-- Left: Back button + Title + School Year -->
            <div class="flex flex-col sm:flex-row sm:items-center gap-3">

                <!-- Back Button (SVG) -->
                <a href="{{ route('teacher.dashboard') }}"
                   class="group inline-flex items-center justify-center
                          w-10 h-10 rounded-xl
                          bg-indigo-600 text-white
                          hover:bg-indigo-700 transition
                          shadow-md flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="2"
                         stroke="currentColor"
                         class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M15 19l-7-7 7-7" />
                    </svg>
                </a>

                <!-- Title & School Year -->
                <div class="flex flex-col">
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800">
                        Attendance
                        <span class="text-indigo-600">– {{ $section->year_level }} {{ $section->name }}</span>
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">
                        🏫 School Year: <span class="font-semibold text-gray-700">{{ $section->school_year ?? 'N/A' }}</span>
                    </p>
                </div>

            </div>

        </div>
    </div>
</header>

<!-- ================= MONTH NAVIGATION ================= -->
<div class="flex justify-between items-center mb-4 gap-2 flex-wrap">
    <div class="flex items-center gap-2">
        <form method="GET" class="flex items-center gap-2">
            <input type="month" name="month" value="{{ sprintf('%04d-%02d',$year,$month) }}"
                   onchange="this.form.submit()"
                   class="px-3 py-2 border rounded-lg">
        </form>
        <form method="GET" class="flex items-center gap-1">
            <input type="hidden" name="month" value="{{ sprintf('%04d-%02d',$year,($month>1?$month-1:12)) }}">
            <input type="hidden" name="year" value="{{ ($month>1?$year:$year-1) }}">
            <button class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">&laquo; Prev</button>
        </form>
        <form method="GET" class="flex items-center gap-1">
            <input type="hidden" name="month" value="{{ sprintf('%04d-%02d',$year,($month<12?$month+1:1)) }}">
            <input type="hidden" name="year" value="{{ ($month<12?$year:$year+1) }}">
            <button class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">Next &raquo;</button>
        </form>
    </div>

    <a href="{{ route('teacher.export', [$section->id, 'month'=>$month, 'year'=>$year]) }}"
       class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
       📄 Export PDF
    </a>
</div>

@if(session('success'))
<div id="success-alert" class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded">
    {{ session('success') }}
</div>

<script>
    // Remove success message after 3 seconds
    setTimeout(() => {
        const alert = document.getElementById('success-alert');
        if(alert){
            alert.remove();
        }
    }, 3000);
</script>
@endif


<!-- ================= OPEN ATTENDANCE MODAL BUTTON ================= -->
<button type="button"
        onclick="openModal()"
        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 mb-4">
    📋 View/Edit Attendance
</button>

<!-- ================= ATTENDANCE MODAL ================= -->
<div id="attendanceModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-6xl rounded-xl shadow-lg p-6 relative overflow-auto max-h-[90vh]">

        <!-- Close Button -->
        <button onclick="closeModal()"
                class="absolute top-3 right-3 text-gray-500 hover:text-red-600 text-xl">✕</button>

        <!-- Title -->
        <h2 class="text-xl font-bold mb-4 text-center">
            School Form 2 (SF2) – Daily Attendance Report <br>
            <span class="text-indigo-600 text-lg">
                {{ $section->year_level }} – {{ $section->name }}
                | {{ \Carbon\Carbon::create()->month((int) $month)->format('F') }} {{ $year }}
            </span>
        </h2>

        <form method="POST" action="{{ route('teacher.attendance.store', $section->id) }}">
            @csrf

            @php
                // Generate school days (Mon-Fri)
                $schoolDays = [];
                for($d=1;$d<=$daysInMonth;$d++){
                    $dateObj = \Carbon\Carbon::create($year, $month, $d);
                    if(!$dateObj->isWeekend()){ // Skip Saturday & Sunday
                        $schoolDays[] = $dateObj->format('Y-m-d');
                    }
                }

                // Group students by gender and sort alphabetically
                $grouped = $students
                    ->sortBy('first_name')
                    ->sortBy('last_name')
                    ->groupBy('gender'); // Male/Female
            @endphp

            <table class="min-w-full text-sm border">
                <thead class="bg-gray-100 sticky top-0 z-10">
                    <tr>
                        <th class="border px-2 py-1">Student</th>
                        @foreach($schoolDays as $date)
                            <th class="border px-1 py-1 text-center">{{ \Carbon\Carbon::parse($date)->format('d') }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>

                    @foreach($grouped as $gender => $genderStudents)
                        <!-- Gender Header Row -->
                        <tr class="bg-gray-200 font-semibold text-gray-700">
                            <td class="border px-2 py-1" colspan="{{ count($schoolDays) + 1 }}">
                                {{ $gender }}
                            </td>
                        </tr>

                        @foreach($genderStudents as $student)
                            <tr class="hover:bg-gray-50">
                                <!-- Student Info -->
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-4">
                                        <img
                                            src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/photo-placeholder.png') }}"
                                            class="w-12 h-12 rounded-full object-cover shadow"
                                            alt="Photo">
                                        <div>
                                            <p class="font-semibold text-gray-800 leading-tight">
                                                {{ $student->last_name }}
                                                {{ $student->middle_name ?? '' }}
                                                {{ $student->first_name }}
                                                {{ $student->suffix ?? '' }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                S-ID: {{ $student->school_id }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Attendance Cells -->
                                @foreach($schoolDays as $date)
                                    @php
                                        $att = $student->attendances->firstWhere('date',$date);
                                        $status = $att?->status ?? 'none';
                                    @endphp
                                    <td class="border px-1 py-1 text-center">
                                        <select name="attendance[{{ $student->id }}][{{ $date }}]"
                                                class="px-1 py-1 text-xs rounded-lg
                                                @if($status=='present') bg-green-100 text-green-700
                                                @elseif($status=='late') bg-yellow-100 text-yellow-700
                                                @elseif($status=='absent') bg-red-100 text-red-700
                                                @else bg-gray-100 text-gray-700 @endif">
                                            <option value="none" @selected($status=='none')>
                                                <!-- None Icon -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                                </svg> None
                                            </option>
                                            <option value="present" @selected($status=='present')>
                                                <!-- Present Checkmark -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                </svg> Present
                                            </option>
                                            <option value="late" @selected($status=='late')>
                                                <!-- Late Clock -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 text-yellow-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <circle cx="12" cy="12" r="9"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                                                </svg> Late
                                            </option>
                                            <option value="absent" @selected($status=='absent')>
                                                <!-- Absent Cross -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 text-red-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg> Absent
                                            </option>
                                        </select>
                                    </td>
                                @endforeach

                            </tr>
                        @endforeach
                    @endforeach

                </tbody>
            </table>

            <div class="mt-4 flex justify-end gap-2">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">💾 Save</button>
                <button type="button" onclick="closeModal()" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
            </div>

        </form>
    </div>
</div>


<script>
function openModal(){ 
    document.getElementById('attendanceModal').classList.remove('hidden'); 
    document.getElementById('attendanceModal').classList.add('flex'); 
}
function closeModal(){ 
    document.getElementById('attendanceModal').classList.remove('flex'); 
    document.getElementById('attendanceModal').classList.add('hidden'); 
}
</script>

</body>
</html>
