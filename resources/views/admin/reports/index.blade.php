<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reports Dashboard | Student Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <style>
        @media print {
            body { background: white !important; }
            button, select, form { display: none !important; }
            .shadow-md, .shadow-lg, .shadow-xl { box-shadow: none !important; }
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-100 via-indigo-50 to-purple-100">

<div class="max-w-7xl mx-auto px-6 py-10 space-y-10">

    <!-- HEADER -->
    <div class="bg-white/70 backdrop-blur-xl border border-white/40 
                shadow-xl rounded-3xl p-6 flex flex-col md:flex-row 
                justify-between items-center gap-6">

        <div class="flex items-center gap-5">
            <a href="{{ route('admin.dashboard') }}"
               class="bg-white shadow-md hover:shadow-lg 
                      text-indigo-600 px-4 py-2 rounded-2xl transition">
                ← 
            </a>

            <img src="{{ asset('images/logo.jpg') }}"
                 class="h-16 w-16 rounded-2xl shadow-md ring-4 ring-indigo-100"
                 alt="School Logo">

            <div>
                <h1 class="text-3xl font-bold text-slate-800 tracking-tight">
                    Reports Dashboard
                </h1>
                <p class="text-slate-500 text-sm">
                    Academic Performance & Enrollment Overview
                </p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <form id="schoolYearForm" action="{{ route('admin.reports') }}" method="GET">
                <select name="school_year"
                        onchange="document.getElementById('schoolYearForm').submit()"
                        class="rounded-2xl border-slate-300 shadow-sm 
                               focus:ring-indigo-500 focus:border-indigo-500 text-sm px-4 py-2">
                    @foreach($schoolYears as $year)
                        <option value="{{ $year->id }}"
                            {{ request('school_year') == $year->id ? 'selected' : '' }}>
                            {{ $year->name }}
                        </option>
                    @endforeach
                </select>
            </form>

            <button onclick="window.print()"
                class="bg-indigo-600 hover:bg-indigo-700 
                       text-white text-sm px-5 py-2.5 rounded-2xl shadow-md transition">
                Print
            </button>

            <button onclick="exportPDF()"
                class="bg-emerald-600 hover:bg-emerald-700 
                       text-white text-sm px-5 py-2.5 rounded-2xl shadow-md transition">
                Export PDF
            </button>
        </div>
    </div>

    <!-- SUMMARY CARDS -->
    <div class="grid md:grid-cols-3 gap-8">
        @foreach($cards as $card)
            <div class="bg-white rounded-3xl p-7 
                        shadow-md hover:shadow-2xl 
                        hover:-translate-y-1 transition duration-300">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-slate-500 text-sm uppercase tracking-wide">
                            {{ $card['title'] }}
                        </p>
                        <h2 class="text-4xl font-bold mt-2 text-slate-800">
                            {{ $card['value'] }}
                        </h2>
                    </div>
                    <div class="text-4xl">
                        {{ $card['icon'] }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>


  <!-- SECTIONS & TEACHERS -->
<div>
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6 gap-2 md:gap-0">
        <h2 class="text-2xl font-bold text-slate-800">
            Sections & Advisers
        </h2>
        <p class="text-sm text-slate-500">
            Teachers handling each section
        </p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($studentsPerSection as $section)

            @php
                $teacher = $section->teacher ?? null;
                // Fix teacher photo URL
                $photoUrl = $teacher && $teacher->photo
                    ? asset('storage/teachers/' . $teacher->photo)
                    : asset('images/photo-placeholder.png');

                // Progress bar percentage
                $progress = min(($section->students_count / 50) * 100, 100);
            @endphp

            <div class="bg-white rounded-3xl shadow-md hover:shadow-2xl transition-transform duration-300 overflow-hidden hover:-translate-y-1">
                
                <!-- Top Gradient Accent -->
                <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500"></div>

                <div class="p-6 space-y-4">

                    <!-- Teacher Info -->
                    <div class="flex items-center gap-4">
                        <img src="{{ $photoUrl }}" 
                             class="h-16 w-16 rounded-2xl object-cover shadow-md" 
                             alt='Teacher'>

                        <div>
                            <p class="font-semibold text-slate-800 text-sm">
                                {{ $teacher 
                                    ? trim("{$teacher->first_name} {$teacher->middle_name} {$teacher->last_name} {$teacher->suffix}") 
                                    : 'No Teacher Assigned!' 
                                }}
                            </p>
                            <p class="text-sm text-slate-500">Section Adviser</p>
                        </div>
                    </div>

                    <!-- Section Info -->
                    <div class="border-t pt-4 space-y-2">
                        <p class="text-sm text-slate-500 uppercase tracking-wide">Section</p>
                        <h4 class="text-lg font-bold text-slate-700">{{ $section->year_level }} - {{ $section->name }}</h4>

                        <div class="flex items-center justify-between mt-4">
                            <span class="text-sm text-slate-500">Students</span>
                            <span class="text-xl font-bold text-emerald-600">{{ $section->students_count }}</span>
                        </div>

                        <!-- Progress bar -->
                        <div class="relative w-full h-3 bg-slate-200 rounded-full mt-2 overflow-hidden">
                            <div class="absolute h-3 rounded-full bg-gradient-to-r from-emerald-400 to-emerald-600 transition-all duration-700 ease-out"
                                 style="width: {{ $progress }}%">
                            </div>

                            <!-- Circle tip -->
                            <div class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-5 h-5 bg-white border-2 border-emerald-500 rounded-full shadow-md"
                                 style="left: {{ $progress }}%">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        @endforeach
    </div>
</div>


    <!-- CHARTS -->
    <div class="grid lg:grid-cols-2 gap-10">
        <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-xl transition">
            <h2 class="text-lg font-semibold text-slate-700 mb-6">
                Total Enrollees Distribution
            </h2>
            <canvas id="enrolleesPieChart"></canvas>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-xl transition">
            <h2 class="text-lg font-semibold text-slate-700 mb-6">
                Total Enrollees by Gender
            </h2>
            <canvas id="enrolleesGenderChart"></canvas>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-xl transition">
            <h2 class="text-lg font-semibold text-slate-700 mb-6">
                Students Per Section
            </h2>
            <canvas id="sectionChart"></canvas>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-md hover:shadow-xl transition">
            <h2 class="text-lg font-semibold text-slate-700 mb-6">
                Top 10 Students (Average Grade)
            </h2>
            <canvas id="topStudentsChart"></canvas>
        </div>
    </div>

    <!-- TABLES -->
    <div class="space-y-10">

      <!-- Enrollees Table -->
<div class="bg-white rounded-3xl shadow-md p-8 overflow-x-auto">
    <h2 class="text-xl font-semibold mb-6 text-slate-800">
        Total Enrollees
    </h2>

    <table class="w-full text-sm">
        <thead class="text-slate-500 text-xs uppercase tracking-wider border-b">
            <tr>
                <th class="text-left py-3">School Year</th>
                <th class="text-left py-3">Male</th>
                <th class="text-left py-3">Female</th>
                <th class="text-left py-3">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($enrolleesPerYear as $year)
                @php
                    // Determine if this is the active year
                    $isActive = $schoolYears->find($activeYearId)->name === $year['school_year'];
                @endphp

                <tr class="hover:bg-slate-50 transition {{ $isActive ? 'bg-indigo-50 font-semibold' : '' }}">
                    <td class="py-3">{{ $year['school_year'] }}</td>
                    <td class="py-3 text-blue-600 font-semibold">{{ $year['male'] }}</td>
                    <td class="py-3 text-pink-600 font-semibold">{{ $year['female'] }}</td>
                    <td class="py-3 text-indigo-600 font-bold">{{ $year['total'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

        <!-- Top Students Table -->
        <div class="bg-white rounded-3xl shadow-md p-8 overflow-x-auto">
            <h2 class="text-xl font-semibold mb-6 text-slate-800">
                Top 10 Students
            </h2>

            <table class="w-full text-sm">
                <thead class="text-slate-500 text-xs uppercase tracking-wider border-b">
                    <tr>
                        <th class="text-left py-3">Rank</th>
                        <th class="text-left py-3">Student Name</th>
                        <th class="text-left py-3">Average Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topStudents as $index => $student)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3 font-semibold">#{{ $index + 1 }}</td>
                            <td class="py-3">{{ $student->full_name }}</td>
                            <td class="py-3 font-bold text-purple-600">
                                {{ $student->average_grade }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</div>

<!-- EXPORT PDF -->
<script>
function exportPDF() {
    const element = document.querySelector('.max-w-7xl');
    html2pdf().from(element).save('reports-dashboard.pdf');
}
</script>

<!-- CHARTS -->
<script>
const chartOptions = {
    responsive: true,
    plugins: { legend: { position: 'top' } },
    scales: {
        y: {
            beginAtZero: true,
            grid: { color: "rgba(0,0,0,0.05)" }
        }
    }
};

new Chart(document.getElementById('enrolleesGenderChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($enrolleesPerYear->pluck('school_year')) !!},
        datasets: [
            { label: 'Male', data: {!! json_encode($enrolleesPerYear->pluck('male')) !!}, backgroundColor: 'rgba(59,130,246,0.7)' },
            { label: 'Female', data: {!! json_encode($enrolleesPerYear->pluck('female')) !!}, backgroundColor: 'rgba(236,72,153,0.7)' }
        ]
    },
    options: chartOptions
});

new Chart(document.getElementById('sectionChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($studentsPerSection->pluck('section_name')) !!},
        datasets: [
            { label: 'Students', data: {!! json_encode($studentsPerSection->pluck('students_count')) !!}, backgroundColor: 'rgba(16,185,129,0.7)' }
        ]
    },
    options: chartOptions
});

new Chart(document.getElementById('topStudentsChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($topStudents->pluck('full_name')) !!},
        datasets: [
            { label: 'Average Grade', data: {!! json_encode($topStudents->pluck('average_grade')) !!}, backgroundColor: 'rgba(139,92,246,0.7)' }
        ]
    },
    options: { ...chartOptions, indexAxis: 'y' }
});

new Chart(document.getElementById('enrolleesPieChart'), {
    type: 'pie',
    data: {
        labels: ['Male', 'Female'],
        datasets: [{
            data: [{{ $totalMale }}, {{ $totalFemale }}],
            backgroundColor: ['rgba(59,130,246,0.8)','rgba(236,72,153,0.8)']
        }]
    },
    options: { responsive: true }
});
</script>

</body>
</html>