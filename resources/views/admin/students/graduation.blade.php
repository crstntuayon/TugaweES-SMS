<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Graduation Students | Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .progress-bg { background: #E5E7EB; border-radius: 9999px; height: 0.5rem; }
        .progress-bar { height: 0.5rem; border-radius: 9999px; transition: width 0.5s; }
    </style>
</head>
<body class="bg-indigo-50 p-6 min-h-screen">

<div class="max-w-7xl mx-auto space-y-6">

    <!-- Header -->
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
                <h1 class="text-2xl font-bold text-slate-800">Graduation Records</h1>
                <p class="text-gray-500 text-sm">View students eligible or graduated</p>
            </div>
        </div>

        <!-- Filter + Search -->
        <div class="flex flex-wrap items-center gap-2 md:gap-4 mt-4 md:mt-0">
            <form method="GET" class="flex gap-2 items-center w-full md:w-auto">
                <select name="status" class="rounded-xl border-gray-300 px-3 py-2" id="statusFilter">
                    <option value="">All Students</option>
                    <option value="active" {{ request('status')=='active' ? 'selected' : '' }}>Active</option>
                    <option value="candidate" {{ request('status')=='candidate' ? 'selected' : '' }}>Candidate</option>
                    <option value="graduated" {{ request('status')=='graduated' ? 'selected' : '' }}>Graduated</option>
                </select>

                <div class="relative w-full md:w-64">
                    <input type="text"
                           id="studentSearch"
                           placeholder="Search students..."
                           class="w-full px-4 py-2 rounded-xl border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400"
                           autocomplete="off">
                </div>

                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl shadow-md transition">
                    Filter
                </button>
            </form>
        </div>
    </div>

    <!-- Students Table -->
    <div class="bg-white rounded-3xl shadow-md overflow-x-auto">
        <table class="min-w-full text-sm divide-y divide-gray-200">
            <thead class="bg-indigo-50">
            <tr>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Student</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-600">Graduation Status</th>
            </tr>
            </thead>
            <tbody id="studentsTableBody" class="bg-white divide-y divide-gray-200">
            @forelse($studentsByStatus as $status => $students)
                <!-- Status Header -->
                <tr class="bg-indigo-100">
                    <td colspan="2" class="px-6 py-2 font-bold text-indigo-700 text-lg">
                        Status: {{ ucfirst($status) }}
                    </td>
                </tr>

                @foreach($students as $student)
                    <tr class="hover:bg-indigo-50 transition">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-4">
                                <img src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/photo-placeholder.png') }}"
                                     class="w-12 h-12 rounded-full object-cover shadow" alt="Photo">
                                <div>
                                    <p class="font-semibold text-gray-800 leading-tight">
                                        {{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name }} {{ $student->suffix }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">S-ID: {{ $student->school_id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-3">
                            <div class="space-y-1">
                                <div class="progress-bg">
                                    <div class="progress-bar"
                                         style="width: {{ $student->graduation_status=='graduated' ? 100 : ($student->graduation_status=='candidate' ? 75 : 50) }}%;
                                                background: {{ $student->graduation_status=='graduated' ? '#22c55e' : ($student->graduation_status=='candidate' ? '#facc15' : '#64748b') }};">
                                    </div>
                                </div>
                                <span class="text-sm font-semibold {{ $student->graduation_status=='graduated' ? 'text-green-600' : ($student->graduation_status=='candidate' ? 'text-yellow-600' : 'text-gray-600') }}">
                                    {{ ucfirst($student->graduation_status) }}
                                </span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="5" class="text-center py-6 text-gray-400">No students found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('studentSearch');
    const tableBody = document.getElementById('studentsTableBody');
    const statusFilter = document.getElementById('statusFilter');

    let timeout = null;

    function renderTable(students) {
        tableBody.innerHTML = '';
        if (!students.length) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center py-6 text-gray-400">No students found.</td>
                </tr>`;
            return;
        }

        const grouped = students.reduce((acc, student) => {
            const key = student.graduation_status || 'active';
            if (!acc[key]) acc[key] = [];
            acc[key].push(student);
            return acc;
        }, {});

        Object.keys(grouped).forEach(status => {
            if (statusFilter.value && status !== statusFilter.value) return;

            tableBody.innerHTML += `
                <tr class="bg-indigo-100">
                    <td colspan="2" class="px-6 py-2 font-bold text-indigo-700 text-lg">
                        Status: ${status.charAt(0).toUpperCase() + status.slice(1)}
                    </td>
                </tr>
            `;

            grouped[status].forEach(student => {
                const width = student.graduation_status === 'graduated' ? 100 :
                              student.graduation_status === 'candidate' ? 75 : 50;
                const color = student.graduation_status === 'graduated' ? '#22c55e' :
                              student.graduation_status === 'candidate' ? '#facc15' : '#64748b';
                const textColor = student.graduation_status === 'graduated' ? 'text-green-600' :
                                  student.graduation_status === 'candidate' ? 'text-yellow-600' : 'text-gray-600';

                tableBody.innerHTML += `
                    <tr class="hover:bg-indigo-50 transition">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-4">
                                <img src="${student.photo ? `/storage/${student.photo}` : '/images/photo-placeholder.png'}"
                                     class="w-12 h-12 rounded-full object-cover shadow" alt="Photo">
                                <div>
                                    <p class="font-semibold text-gray-800 leading-tight">
                                        ${student.last_name}, ${student.first_name} ${student.middle_name || ''} ${student.suffix || ''}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">S-ID: ${student.school_id}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-3">
                            <div class="space-y-1">
                                <div class="progress-bg">
                                    <div class="progress-bar" style="width: ${width}%; background: ${color};"></div>
                                </div>
                                <span class="text-sm font-semibold ${textColor}">
                                    ${student.graduation_status.charAt(0).toUpperCase() + student.graduation_status.slice(1)}
                                </span>
                            </div>
                        </td>
                    </tr>
                `;
            });
        });
    }

    function fetchStudents() {
        const query = searchInput.value.trim();
        fetch(`/admin/students/search?q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(students => renderTable(students));
    }

    searchInput.addEventListener('input', () => {
        clearTimeout(timeout);
        timeout = setTimeout(fetchStudents, 300);
    });

    statusFilter.addEventListener('change', fetchStudents);
});
</script>

</body>
</html>