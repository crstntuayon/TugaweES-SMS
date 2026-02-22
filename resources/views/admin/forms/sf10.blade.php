<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SF10 — Learner Permanent Academic Record</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; background: #f7f7f7; }
        .container { width: 1000px; margin: auto; background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }

        .buttons { margin-bottom: 15px; display: flex; gap: 10px; }
        .btn { padding: 6px 12px; border: none; cursor: pointer; font-size: 12px; border-radius: 4px; }
        .btn-back { background: #6c757d; color: white; }
        .btn-print { background: #007bff; color: white; }
        .btn-download { background: #28a745; color: white; }

        .header { display: flex; align-items: center; justify-content: center; gap: 15px; margin-bottom: 20px; }
        .header img { width: 75px; }
        .header-text { text-align: center; line-height: 1.3; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background: #e2e8f0; font-weight: bold; }
        .subject { text-align: left; padding-left: 8px; }

        .year-title { margin-top: 25px; font-weight: bold; font-size: 14px; background: #cbd5e1; padding: 5px; }

        .student-info { display: flex; justify-content: space-between; margin-top: 10px; margin-bottom: 10px; }
        .student-info div { width: 48%; }
        .signature { margin-top: 50px; width: 45%; display: inline-block; text-align: center; }
        .general-average { margin-top: 20px; font-weight: bold; font-size: 14px; }
    </style>
</head>
<body>

<div class="container">

   <!-- Dropdown Hamburger -->
<div class="hamburger-container" style="position: relative; margin-bottom: 15px;">
    <button id="hamburgerBtn" class="hamburger-btn">
        ☰ Menu
    </button>

    <div id="hamburgerDropdown" class="hamburger-dropdown">
        <a href="{{ route('admin.students.index') }}">⬅ Back</a>
        <button onclick="window.print()">🖨 Print</button>
        <a href="{{ route('admin.sf10.download', $student->id) }}">⬇ Save PDF</a>
    </div>
</div>

<style>
    .hamburger-btn {
        padding:6px 12px; 
        font-size:12px; 
        border:none; 
        border-radius:4px; 
        cursor:pointer; 
        background:#007bff; 
        color:white;
    }

    .hamburger-dropdown {
        display:none; 
        position:absolute; 
        top:100%; 
        left:0; 
        background:white; 
        border:1px solid #ccc; 
        border-radius:4px; 
        min-width:150px; 
        box-shadow:0 2px 8px rgba(0,0,0,0.2); 
        z-index:100;
    }

    .hamburger-dropdown a, 
    .hamburger-dropdown button {
        display:block; 
        width:100%;
        text-align:left; 
        padding:8px 12px; 
        border:none; 
        background:none; 
        cursor:pointer; 
        color:#333; 
        text-decoration:none;
    }

    /* Hide the menu in print */
    @media print {
        .hamburger-container {
            display: none !important;
        }
    }
</style>

<script>
    const btn = document.getElementById('hamburgerBtn');
    const dropdown = document.getElementById('hamburgerDropdown');

    btn.addEventListener('click', () => {
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    });

    window.addEventListener('click', function(e){
        if (!btn.contains(e.target) && !dropdown.contains(e.target)){
            dropdown.style.display = 'none';
        }
    });
</script>


    <!-- Header -->
    <div class="header">
        <img src="{{ asset('images/logo1.png') }}" alt="DepEd Logo">
        <div class="header-text">
            <strong>Republic of the Philippines</strong><br>
            Department of Education<br>
            <strong>Learner Permanent Academic Record (SF10-ES)</strong><br><br>
            <strong>TUGAWE ELEMENTARY SCHOOL</strong>
        </div>
        <img src="{{ asset('images/logo.jpg') }}" alt="School Logo">
    </div>

    @php
        $quarters = [1,2,3,4];
        $studentSections = $student->sections->keyBy('year_level');
        $allSubjectsByGrade = \App\Models\Subject::orderByRaw(
            "FIELD(grade_level, 'Kindergarten','Grade 1','Grade 2','Grade 3','Grade 4','Grade 5','Grade 6')"
        )->get()->groupBy('grade_level');
        $mapehSubjects = ['Music','Arts','PE','Health'];

        $generalGrades = collect(); // For General Average across all year levels
    @endphp

    @foreach($allSubjectsByGrade as $grade => $subjects)
        @php
            $section = $studentSections[$grade] ?? null;
            $otherSubjects = $subjects->whereNotIn('name', $mapehSubjects);
            $yearGrades = $student->grades->where('year_level', $grade);

            $quarterTotals = [1=>0,2=>0,3=>0,4=>0];
            $quarterCounts = [1=>0,2=>0,3=>0,4=>0];
            $finalGrades = [];
        @endphp

        <div class="year-title">{{ $grade }}</div>
<!-- Student Info aligned -->
<div class="student-info flex justify-between gap-6">
    <div>
        <strong>Name:</strong> {{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name ?? '' }} {{ $student->suffix ?? '' }}<br>
        <strong>Student ID:</strong> {{ $student->school_id }}<br>
        <strong>Birthdate:</strong> {{ $student->birthday }}<br>
        <strong>Sex:</strong> {{ $student->sex }}
    </div>

    <div>
        <strong>Section:</strong> {{ $section?->name ?? 'N/A' }}<br>
        <strong>Adviser:</strong> {{ $section?->teacher->name ?? 'N/A' }}<br>
        <strong>School Year:</strong> {{ $activeSchoolYear->name ?? 'N/A' }}<br>

        @php
            // Get pivot for this student in this section
            $pivot = $student->sections()->where('sections.id', $section?->id)->first()?->pivot;
        @endphp

        <strong>Status:</strong> {{ ucfirst($pivot?->status ?? 'Active') }}
    </div>
</div>

        <!-- Grades Table -->
        <table>
            <thead>
                <tr>
                    <th rowspan="2">Subject</th>
                    <th colspan="4">Quarterly Ratings</th>
                    <th rowspan="2">Final Rating</th>
                    <th rowspan="2">Remarks</th>
                </tr>
                <tr>
                    @foreach($quarters as $q)
                        <th>Q{{ $q }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                {{-- Other Subjects --}}
                @foreach($otherSubjects as $subject)
                    @php
                        $subjectGrades = $student->grades->where('subject_id', $subject->id)->keyBy('quarter');
                        $final = $subjectGrades->avg('grade');
                        $finalGrades[] = $final ?? null;

                        foreach($quarters as $q){
                            $grade = $subjectGrades[$q]->grade ?? null;
                            if($grade !== null){ $quarterTotals[$q] += $grade; $quarterCounts[$q]++; }
                        }

                        $remarks = $final >= 75 ? 'Passed' : ($final ? 'Failed' : '-');
                        $color = $remarks === 'Passed' ? 'green' : ($remarks === 'Failed' ? 'red' : 'gray');

                        if($final) $generalGrades->push($final);
                    @endphp
                    <tr>
                        <td class="subject">{{ $subject->name }}</td>
                        @foreach($quarters as $q)
                            <td>{{ $subjectGrades[$q]->grade ?? '-' }}</td>
                        @endforeach
                        <td>{{ $final ? round($final,2) : '-' }}</td>
                        <td style="color: {{ $color }}; font-weight:bold;">{{ $remarks }}</td>
                    </tr>
                @endforeach

                {{-- MAPEH --}}
                @php
                    $mapehGradesData = $student->grades->whereIn('subject.name',$mapehSubjects)->where('year_level',$grade);
                    $mapehQuarterly = [];
                    $mapehFinal = null;
                    $mapehRemarks = '-';
                @endphp
                @if($mapehGradesData->count())
                    @foreach($quarters as $q)
                        @php
                            $grades = $mapehGradesData->where('quarter',$q)->pluck('grade');
                            $mapehQuarterly[$q] = $grades->count() ? round($grades->avg(),2) : '-';
                            if($grades->count()) { $quarterTotals[$q] += $grades->avg(); $quarterCounts[$q]++; }
                        @endphp
                    @endforeach
                    @php
                        $mapehFinal = $mapehGradesData->pluck('grade')->count() ? round($mapehGradesData->pluck('grade')->avg(),2) : null;
                        $mapehRemarks = $mapehFinal >= 75 ? 'Passed' : ($mapehFinal ? 'Failed' : '-');
                        if($mapehFinal) $finalGrades[] = $mapehFinal;
                        if($mapehFinal) $generalGrades->push($mapehFinal);
                    @endphp
                    <tr>
                        <td class="subject">MAPEH</td>
                        @foreach($quarters as $q)
                            <td>{{ $mapehQuarterly[$q] ?? '-' }}</td>
                        @endforeach
                        <td>{{ $mapehFinal ?? '-' }}</td>
                        <td style="color: {{ $mapehRemarks === 'Passed' ? 'green' : ($mapehRemarks === 'Failed' ? 'red' : 'gray') }}; font-weight:bold;">
                            {{ $mapehRemarks ?? '-' }}
                        </td>
                    </tr>
                @endif

                {{-- Quarterly Average & Final Rating --}}
                <tr style="font-weight:bold; background:#f0f0f0;">
                    <td>Quarterly Average</td>
                    @foreach($quarters as $q)
                        @php
                            $qAvg = $quarterCounts[$q] ? round($quarterTotals[$q]/$quarterCounts[$q],2) : '-';
                        @endphp
                        <td>{{ $qAvg }}</td>
                    @endforeach
                    @php
                        $numericFinals = array_filter($finalGrades, fn($val) => $val !== null);
                        $finalAvg = count($numericFinals) ? round(collect($numericFinals)->avg(),2) : '-';
                        $remarksFinal = $finalAvg !== '-' ? ($finalAvg >= 75 ? 'Passed' : 'Failed') : '-';
                    @endphp
                    <td>{{ $finalAvg }}</td>
                    <td style="color: {{ $remarksFinal === 'Passed' ? 'green' : ($remarksFinal === 'Failed' ? 'red' : 'gray') }}; font-weight:bold;">
                        {{ $remarksFinal }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- General Average -->
        <p class="general-average">
            <strong>General Average:</strong> 
            @php
                $numericFinals = array_filter($finalGrades, fn($val) => $val !== null);
            @endphp
            {{ count($numericFinals) ? round(collect($numericFinals)->avg(),2) : '---' }}
        </p>

        <!-- Signatures -->
        <div class="signature">
            ___________________________<br>
            Principal / School Head
        </div>
        <div class="signature" style="float:right;">
            ___________________________<br>
            Adviser
        </div>

    @endforeach

</div>

</body>
</html>
