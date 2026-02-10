<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grades | Teacher Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-emerald-100 via-sky-100 to-indigo-200 p-4">

<!-- ================= ENHANCED HEADER ================= -->

<header class="mb-6">
    <div class="bg-white/80 backdrop-blur rounded-2xl shadow-md p-5 border border-gray-200">

        <div class="flex flex-col gap-2">

            <!-- Title Row -->
            <div class="flex items-center gap-3 flex-wrap">

                <!-- Back Button (SVG) -->
                <a href="{{ route('teacher.dashboard') }}"
                   class="group inline-flex items-center justify-center
                          w-10 h-10 rounded-xl
                          bg-indigo-600 text-white
                          hover:bg-indigo-700 transition
                          shadow-md">

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

                <!-- Title -->
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800 flex items-center gap-2">
                    Grades
                    <span class="text-indigo-600">
                        – {{ $section->year_level }} {{ $section->name }}
                    </span>
                </h1>
            </div>

            <!-- Subtitle -->
            <p class="text-sm text-gray-600 flex items-center gap-2 pl-14">
                🏫 School Year:
                <span class="font-semibold text-gray-700">
                    {{ $section->school_year ?? 'N/A' }}
                </span>
            </p>

        </div>

    </div>
</header>


<!-- ================= STUDENT LIST ================= -->

<div class="overflow-auto rounded-xl border border-gray-200 shadow bg-white">
<table class="min-w-full text-sm">

<thead class="bg-gray-100 font-semibold">
<tr>
    <th class="border px-3 py-2">No.</th>
    <th class="border px-3 py-2 text-left">Student</th>
    <th class="border px-3 py-2 text-center">Action</th>
</tr>
</thead>

<tbody>
@foreach($section->students as $i => $student)
<tr class="hover:bg-gray-50">

<td class="border px-3 py-2">{{ $i + 1 }}</td>

 <!-- STUDENT -->
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-4">
                                    <img
                                        src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/photo-placeholder.png') }}"
                                        class="w-12 h-12 rounded-full object-cover shadow"
                                        alt="Photo">

                                    <div>
                                        <p class="font-semibold text-gray-800 leading-tight">
                                            {{ $student->last_name }},
                                            {{ $student->first_name }}
                                             {{ $student->middle_name ?? '' }}
                                            {{ $student->suffix ?? '' }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            S-ID: {{ $student->school_id }}
                                        </p>
                            
                                    </div>
                                </div>
                            </td>

<td class="border px-3 py-2 text-center">
    <button
        onclick="openReportCard({{ $student->id }})"
        class="bg-indigo-600 text-white px-4 py-1 rounded text-xs hover:bg-indigo-700">
        📄 View Report Card
    </button>
</td>

</tr>
@endforeach
</tbody>

</table>
</div>

<!-- ================= REPORT CARD MODAL ================= -->

<div id="reportModal"
     class="fixed inset-0 hidden bg-black/50 z-50 items-center justify-center">

<div class="bg-white w-full max-w-5xl rounded-xl shadow-lg p-6 relative">

<button onclick="closeReportCard()"
        class="absolute top-3 right-4 text-xl text-gray-500 hover:text-red-600">
    ✕
</button>

<h2 class="text-xl font-bold text-center">
    ELEMENTARY SCHOOL REPORT CARD
</h2>

<p class="text-center text-sm text-gray-600 mb-4">
    <span id="rc-student-name"></span> |
    {{ $section->year_level }} {{ $section->name }}
</p>

<!-- ================= REPORT TABLE ================= -->

<div class="overflow-auto">
<table class="min-w-full text-sm border">

<thead class="bg-gray-100">
<tr>
    <th class="border px-3 py-2 text-left">Learning Areas</th>
    <th class="border px-2 py-2">1st</th>
    <th class="border px-2 py-2">2nd</th>
    <th class="border px-2 py-2">3rd</th>
    <th class="border px-2 py-2">4th</th>
    <th class="border px-2 py-2 bg-indigo-100">Final</th>
</tr>
</thead>

<tbody id="report-body"></tbody>

<tfoot class="font-semibold bg-gray-50">
<tr>
    <td class="border px-3 py-2">Quarterly Average</td>
    <td class="border text-center" id="q1">—</td>
    <td class="border text-center" id="q2">—</td>
    <td class="border text-center" id="q3">—</td>
    <td class="border text-center" id="q4">—</td>
    <td class="border text-center bg-indigo-200" id="general">—</td>
</tr>
</tfoot>

</table>
</div>

<div class="mt-5 text-right">
    <button onclick="saveModalGrades()"
        class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
        💾 Save Grades
    </button>
</div>

</div>
</div>

<!-- ================= JAVASCRIPT ================= -->

<script>
const students = @json(
    $section->students->mapWithKeys(fn($s)=>[
        $s->id => [
            'name' => $s->last_name.', '.$s->first_name,
            'grades' => $s->grades
                ->groupBy('subject_id')
                ->map(fn($g)=>$g->keyBy('quarter')->map->grade)
        ]
    ])
);

const subjects = @json(
    $subjects->map(fn($s)=>['id'=>$s->id,'name'=>$s->name])
);

let activeStudentId = null;

/* ---------- OPEN MODAL ---------- */
function openReportCard(id){
    activeStudentId = id;
    const student = students[id];
    document.getElementById('rc-student-name').textContent = student.name;

    let body = '';
    subjects.forEach(sub => {
        body += `<tr>
            <td class="border px-3 py-2">${sub.name}</td>`;

        for(let q=1;q<=4;q++){
            const val = student.grades?.[sub.id]?.[q] ?? '';
            body += `
            <td class="border text-center">
                <input type="number" min="0" max="100" step="0.01"
                    class="grade-input w-16 text-center border rounded"
                    data-subject="${sub.id}"
                    data-quarter="${q}"
                    value="${val}">
            </td>`;
        }

        body += `<td class="border text-center bg-indigo-50 subject-final">—</td></tr>`;
    });

    document.getElementById('report-body').innerHTML = body;
    calculateAll();

    document.getElementById('reportModal').classList.remove('hidden');
    document.getElementById('reportModal').classList.add('flex');
}

/* ---------- CALCULATIONS ---------- */
function calculateAll(){
    let quarterTotals = {1:[],2:[],3:[],4:[]};

    document.querySelectorAll('#report-body tr').forEach(row=>{
        let subjectGrades = [];

        row.querySelectorAll('.grade-input').forEach(input=>{
            const q = input.dataset.quarter;
            const v = parseFloat(input.value);
            if(!isNaN(v)){
                subjectGrades.push(v);
                quarterTotals[q].push(v);
            }
        });

        const finalCell = row.querySelector('.subject-final');
        finalCell.textContent = subjectGrades.length
            ? (subjectGrades.reduce((a,b)=>a+b,0)/subjectGrades.length).toFixed(2)
            : '—';
    });

    let overall = [];
    for(let q=1;q<=4;q++){
        const avg = quarterTotals[q].length
            ? (quarterTotals[q].reduce((a,b)=>a+b,0)/quarterTotals[q].length).toFixed(2)
            : '—';
        document.getElementById('q'+q).textContent = avg;
        if(avg!=='—') overall.push(parseFloat(avg));
    }

    document.getElementById('general').textContent =
        overall.length
            ? (overall.reduce((a,b)=>a+b,0)/overall.length).toFixed(2)
            : '—';
}

document.addEventListener('input', e=>{
    if(e.target.classList.contains('grade-input')){
        calculateAll();
    }
});

/* ---------- SAVE ---------- */
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
        location.reload();
    });
}

function closeReportCard(){
    document.getElementById('reportModal').classList.add('hidden');
}
</script>

</body>
</html>
