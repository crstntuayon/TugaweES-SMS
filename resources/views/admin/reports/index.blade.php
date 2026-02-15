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
            body {
                background: white !important;
            }
            button, select, form {
                display: none !important;
            }
            .shadow-md, .shadow-lg, .shadow-xl {
                box-shadow: none !important;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-100 p-6">

<div class="max-w-7xl mx-auto space-y-8">

    <!-- HEADER -->
    <div class="bg-white shadow-lg rounded-2xl p-6 flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.dashboard') }}"
               class="bg-indigo-100 hover:bg-indigo-200 text-indigo-600 p-2 rounded-xl transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>

            <img src="{{ asset('images/logo.jpg') }}"
                 class="h-14 w-14 rounded-full shadow-md ring-4 ring-indigo-100"
                 alt="School Logo">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">Reports Dashboard</h1>
                <p class="text-gray-500 text-sm">Academic Performance & Enrollment Overview</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2 md:gap-4 mt-4 md:mt-0">
            <form id="schoolYearForm" action="{{ route('admin.reports') }}" method="GET" class="flex items-center gap-2">
                <label for="school_year" class="text-sm font-medium text-gray-600">School Year:</label>
                <select name="school_year" id="school_year"
                        onchange="document.getElementById('schoolYearForm').submit()"
                        class="rounded-xl border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    @foreach($schoolYears as $year)
                        <option value="{{ $year->id }}"
                            {{ request('school_year') == $year->id ? 'selected' : ($activeYearId == $year->id ? 'selected' : '') }}>
                            {{ $year->name }}
                        </option>
                    @endforeach
                </select>
            </form>

            <button onclick="window.print()"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-4 py-2 rounded-xl shadow-md transition">
                🖨 Print
            </button>
            <button onclick="exportPDF()"
                    class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-xl shadow-md transition">
                📄 Export PDF
            </button>
        </div>
    </div>

    <!-- SUMMARY CARDS -->
    <div class="grid md:grid-cols-3 gap-6 mt-6">
        @foreach($cards as $card)
            <div class="{{ $card['bg'] }} rounded-2xl p-6 shadow-md hover:shadow-xl transition flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">{{ $card['title'] }}</p>
                    <h2 class="text-3xl font-bold {{ $card['text'] }}">{{ $card['value'] }}</h2>
                </div>
                <div class="text-3xl">{{ $card['icon'] }}</div>
            </div>
        @endforeach
    </div>

    <!-- SECTION POPULATION CARDS (Modern ID Style) -->
<div class="grid md:grid-cols-3 gap-6 mt-6">
    @foreach($studentsPerSection as $section)
        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition relative overflow-hidden">

            <!-- Colored top border -->
            <div class="h-2 w-full bg-gradient-to-r from-indigo-400 to-purple-500"></div>

            <div class="p-5 flex flex-col items-center">

                <!-- Teacher Profile Photo -->
                @php
                    $photoPath = $section->teacher->photo ?? null;
                    $photoUrl = $photoPath && file_exists(storage_path('app/public/' . $photoPath)) 
                                ? asset('storage/' . $photoPath) 
                                : asset('images/photo-placeholder.png');
                @endphp

                <div class="w-20 h-20">
                    <img src="{{ $photoUrl }}" 
                         alt="{{ $section->teacher->full_name ?? 'Teacher' }}" 
                         class="w-full h-full object-cover rounded-lg border-2 border-white shadow-md">
                </div>

                <!-- Section Info -->
                <p class="text-sm text-gray-400 uppercase font-medium mt-3">Section</p>
                <h3 class="text-lg font-semibold text-gray-800 mt-1">{{ $section->year_level }} - {{ $section->name }}</h3>

                <!-- Student Count -->
                <p class="text-2xl font-bold text-green-600 mt-4">{{ $section->students_count }}</p>
                <p class="text-xs text-gray-400 mt-1">Total Population</p>

                <!-- Mini Progress Bar -->
                @php
                    $progress = min($section->students_count / 50 * 100, 100);
                @endphp
                <div class="mt-4 relative w-full bg-gray-200 rounded-full h-2">
                    <div class="h-2 rounded-full bg-gradient-to-r from-green-400 to-green-600" 
                         style="width: {{ $progress }}%"></div>

                    <!-- Circle tip at the end of the progress -->
                    <div class="absolute top-1/2 -translate-y-1/2 right-0 w-4 h-4 bg-white border-2 border-green-600 rounded-full shadow-md"
                         style="transform: translateX({{ $progress }}%) translateY(-50%)"></div>
                </div>

            </div>
        </div>
    @endforeach
</div>


    <!-- CHARTS -->
    <div class="grid md:grid-cols-2 gap-8 mt-6">
        <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-lg transition">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Total Enrollees Distribution</h2>
            <canvas id="enrolleesPieChart" class="w-full h-64"></canvas>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-lg transition">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Total Enrollees by Gender</h2>
            <canvas id="enrolleesGenderChart" class="w-full h-64"></canvas>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-lg transition">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Students Per Section</h2>
            <canvas id="sectionChart" class="w-full h-64"></canvas>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-lg transition">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Top 10 Students (Average Grade)</h2>
            <canvas id="topStudentsChart" class="w-full h-64"></canvas>
        </div>
    </div>

    <!-- TABLES -->
    <div class="space-y-8 mt-6">
        <!-- Total Enrollees Table -->
        <div class="bg-white shadow-xl rounded-2xl p-6 overflow-x-auto">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Total Enrollees</h2>
            <table class="w-full text-sm border-separate border-spacing-y-2">
                <thead>
                   <tr class="text-gray-600 uppercase text-xs tracking-wider {{ $year['school_year'] == $schoolYears->find($activeYearId)->name ? 'bg-indigo-50 font-bold' : '' }}">

                        <th class="text-left py-2">School Year</th>
                        <th class="text-left py-2">Male</th>
                        <th class="text-left py-2">Female</th>
                        <th class="text-left py-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enrolleesPerYear as $year)
                        <tr class="text-gray-600 uppercase text-xs tracking-wider">
                            <td class="py-2 font-medium">{{ $year['school_year'] }}</td>
                            <td class="py-2 text-blue-600 font-bold">{{ $year['male'] }}</td>
                            <td class="py-2 text-pink-600 font-bold">{{ $year['female'] }}</td>
                            <td class="py-2 font-bold text-indigo-600">{{ $year['total'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        

        <!-- Top Students Table -->
        <div class="bg-white shadow-xl rounded-2xl p-6 overflow-x-auto">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Top 10 Students</h2>
            <table class="w-full text-sm border-separate border-spacing-y-2">
                <thead>
                    <tr class="bg-gray-50 hover:bg-indigo-50 transition rounded-xl">
                        <th class="text-left py-2">Rank</th>
                        <th class="text-left py-2">Student Name</th>
                        <th class="text-left py-2">Average Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topStudents as $index => $student)
                        <tr class="text-gray-600 uppercase text-xs tracking-wider">
                            <td class="py-2 font-semibold text-gray-600">#{{ $index + 1 }}</td>
                            <td class="py-2 font-medium flex items-center gap-2">
                                @if($index == 0) 🥇
                                @elseif($index == 1) 🥈
                                @elseif($index == 2) 🥉
                                @endif
                                {{ $student->full_name }}
                            </td>
                            <td class="py-2 font-bold text-purple-600">{{ $student->average_grade }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
function exportPDF() {
    const element = document.querySelector('.max-w-7xl');
    const opt = {
        margin: 0.3,
        filename: 'reports-dashboard.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, logging: true, scrollY: 0 },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
    };
    html2pdf().set(opt).from(element).save();
}
</script>

<!-- Chart.js Scripts (unchanged) -->
<script>
    const genderCtx = document.getElementById('enrolleesGenderChart').getContext('2d');
    new Chart(genderCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($enrolleesPerYear->pluck('school_year')) !!},
            datasets: [
                { label: 'Male', data: {!! json_encode($enrolleesPerYear->pluck('male')) !!}, backgroundColor: 'rgba(59, 130, 246, 0.7)' },
                { label: 'Female', data: {!! json_encode($enrolleesPerYear->pluck('female')) !!}, backgroundColor: 'rgba(236, 72, 153, 0.7)' }
            ]
        },
        options: { responsive: true, plugins: { legend: { position: 'top' } }, scales: { y: { beginAtZero: true, stepSize: 1 } } }
    });

    const sectionsCtx = document.getElementById('sectionChart').getContext('2d');
    new Chart(sectionsCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($studentsPerSection->pluck('section_name')) !!},
            datasets: [{ label: 'Students', data: {!! json_encode($studentsPerSection->pluck('students_count')) !!}, backgroundColor: 'rgba(16, 185, 129, 0.7)' }]
        },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });

    const topStudentsCtx = document.getElementById('topStudentsChart').getContext('2d');
    new Chart(topStudentsCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($topStudents->pluck('full_name')) !!},
            datasets: [{ label: 'Average Grade', data: {!! json_encode($topStudents->pluck('average_grade')) !!}, backgroundColor: 'rgba(139, 92, 246, 0.7)' }]
        },
        options: { indexAxis: 'y', responsive: true, plugins: { legend: { display: false } }, scales: { x: { beginAtZero: true, max: 100 } } }
    });

    const pieCtx = document.getElementById('enrolleesPieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: { labels: ['Male', 'Female'], datasets: [{ data: [{{ $totalMale }}, {{ $totalFemale }}], backgroundColor: ['rgba(59, 130, 246, 0.8)','rgba(236, 72, 153, 0.8)'] }] },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });
</script>

</body>
</html>
