<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grades | Teacher Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-emerald-100 via-sky-100 to-indigo-200 p-4">


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
                    {{ $section->schoolYear?->name ?? 'N/A' }}
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
    <button onclick="openReportCard({{ $student->id }})"
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

                <!-- LEFT LOGO -->
                <div class="w-20 flex-shrink-0">
                    <img src="{{ asset('images/logo1.png') }}"
                         alt="DepEd Logo"
                         class="w-full h-auto object-contain">
                </div>

                <!-- CENTER TEXT -->
                <div class="text-center">
                    <p class="text-xs">Republic of the Philippines</p>
                    <p class="text-sm font-semibold">Department of Education</p>
                    <p class="text-xs">Division of Negros Oriental</p>

                    <h2 class="text-lg font-bold mt-1 tracking-wide">
                        TUGAWE ELEMENTARY SCHOOL
                    </h2>

                    <p class="text-sm font-semibold mt-1">
                        STUDENT REPORT CARD
                    </p>
                </div>

                <!-- RIGHT LOGO -->
                <div class="w-20 flex-shrink-0">
                    <img src="{{ asset('images/logo.jpg') }}"
                         alt="School Logo"
                         class="w-full h-auto object-contain">
                </div>

            </div>
        </div>

        <!-- ================= STUDENT INFO ================= -->
        <div class="grid grid-cols-3 gap-3 text-sm text-gray-700 mb-4">

            <div>
                <p><span class="font-semibold">Name:</span></p>
                <p id="modalStudentName" class="border-b border-gray-400 pb-1"></p>
            </div>

            <div>
                <p><span class="font-semibold">Student ID:</span></p>
                <p id="modalStudentId" class="border-b border-gray-400 pb-1"></p>
            </div>

            <div>
                <p><span class="font-semibold">Address:</span></p>
                <p id="modalStudentAddress" class="border-b border-gray-400 pb-1"></p>
            </div>

        </div>

        <!-- ================= TABLE ================= -->
        <div class="overflow-auto max-h-[50vh] border border-gray-300 rounded">
            <table class="min-w-full text-sm border border-gray-400">

                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-400 px-3 py-2 text-left">
                            Learning Areas
                        </th>
                        <th class="border border-gray-400 px-2 py-2 text-center">1st</th>
                        <th class="border border-gray-400 px-2 py-2 text-center">2nd</th>
                        <th class="border border-gray-400 px-2 py-2 text-center">3rd</th>
                        <th class="border border-gray-400 px-2 py-2 text-center">4th</th>
                        <th class="border border-gray-400 px-2 py-2 text-center bg-indigo-100">
                            Average
                        </th>
                    </tr>
                </thead>

                <tbody id="report-body"></tbody>

            </table>
        </div>

        <!-- ================= SAVE BUTTON ================= -->
        <div class="mt-4 text-right">
            <button onclick="saveModalGrades()"
                class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700 shadow">
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
    $subjects->map(fn($s)=>[
        'id'=>$s->id,
        'name'=>$s->name,
        'grade_level'=>$s->grade_level
    ])
);

let activeStudentId = null;


/* ================= OPEN MODAL ================= */
function openReportCard(id){

    activeStudentId = id;
    const student = students[id];

    document.getElementById('modalStudentName').textContent = student.name;

    let body = '';

    // GROUP SUBJECTS BY YEAR LEVEL
    const grouped = {};

    subjects.forEach(sub => {
        if(!grouped[sub.grade_level]){
            grouped[sub.grade_level] = [];
        }
        grouped[sub.grade_level].push(sub);
    });

    // LOOP PER YEAR LEVEL
    for(const year in grouped){

        // YEAR HEADER
        body += `
            <tr class="bg-indigo-50 font-bold year-header" data-year="${year}">
                <td colspan="6" class="border px-3 py-2">
                    ${year}
                </td>
            </tr>
        `;

        grouped[year].forEach(sub => {

            body += `<tr class="subject-row" data-year="${year}">
                <td class="border px-3 py-2">${sub.name}</td>`;

            for(let q=1;q<=4;q++){
                const val = student.grades?.[sub.id]?.[q] ?? '';

                body += `
                    <td class="border text-center">
                        <input type="number"
                            class="grade-input w-16 text-center border rounded"
                            data-subject="${sub.id}"
                            data-quarter="${q}"
                            data-year="${year}"
                            value="${val}">
                    </td>`;
            }

            body += `
                <td class="border text-center bg-indigo-50 subject-final">—</td>
            </tr>`;
        });

        // YEAR LEVEL FOOTER (AVERAGE)
        body += `
            <tr class="bg-gray-100 font-semibold year-footer" data-year="${year}">
                <td class="border px-3 py-2">Year Level Average</td>
                <td class="border text-center year-q" data-year="${year}" data-quarter="1">—</td>
                <td class="border text-center year-q" data-year="${year}" data-quarter="2">—</td>
                <td class="border text-center year-q" data-year="${year}" data-quarter="3">—</td>
                <td class="border text-center year-q" data-year="${year}" data-quarter="4">—</td>
                <td class="border text-center bg-indigo-100 year-final" data-year="${year}">—</td>
            </tr>
        `;
    }

    document.getElementById('report-body').innerHTML = body;

    calculateAll();

    const modal = document.getElementById('reportModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}


/* ================= CLOSE MODAL ================= */
function closeReportCard(){
    const modal = document.getElementById('reportModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}


/* ================= CALCULATE PER YEAR ================= */
function calculateAll(){

    const years = [...document.querySelectorAll('.year-header')]
                    .map(row => row.dataset.year);

    years.forEach(year => {

        let quarterTotals = {1:[],2:[],3:[],4:[]};

        document.querySelectorAll(`.subject-row[data-year="${year}"]`)
            .forEach(row => {

                let subjectGrades = [];

                row.querySelectorAll('.grade-input').forEach(input => {

                    const q = input.dataset.quarter;
                    const v = parseFloat(input.value);

                    if(!isNaN(v)){
                        subjectGrades.push(v);
                        quarterTotals[q].push(v);
                    }
                });

                const finalCell = row.querySelector('.subject-final');

                finalCell.textContent =
                    subjectGrades.length
                        ? (subjectGrades.reduce((a,b)=>a+b,0)/subjectGrades.length).toFixed(2)
                        : '—';
            });

        // QUARTER AVERAGE
        let overall = [];

        for(let q=1;q<=4;q++){

            const avg = quarterTotals[q].length
                ? (quarterTotals[q].reduce((a,b)=>a+b,0)/quarterTotals[q].length).toFixed(2)
                : '—';

            document.querySelector(
                `.year-q[data-year="${year}"][data-quarter="${q}"]`
            ).textContent = avg;

            if(avg !== '—') overall.push(parseFloat(avg));
        }

        // FINAL AVERAGE
        document.querySelector(
            `.year-final[data-year="${year}"]`
        ).textContent =
            overall.length
                ? (overall.reduce((a,b)=>a+b,0)/overall.length).toFixed(2)
                : '—';
    });
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


</body>
</html>
