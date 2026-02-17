<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SF10 — Learner Permanent Academic Record</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 900px; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; font-size: 12px; }
        h2, h3 { text-align: center; }
        .no-border td { border: none; }
        .signature { margin-top: 50px; width: 48%; display: inline-block; text-align: center; }
        .no-print { margin-top: 15px; }
    </style>
</head>
<body>

<div class="container">

    <div class="no-print">
        <button onclick="window.print()">🖨 Print SF10</button>
        <a href="{{ route('admin.sf10.download', $student->id) }}">
            <button>⬇ Download PDF</button>
        </a>
    </div>

    <h2>Republic of the Philippines</h2>
    <h3>Department of Education</h3>
    <h3>Learner Permanent Academic Record (SF10-ES)</h3>
    <hr>

    <!-- PERSONAL INFORMATION -->
    <table class="no-border">
        <tr>
            <td>Name:</td>
            <td><strong>{{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name }}</strong></td>
            <td>LRN:</td>
            <td><strong>{{ $student->lrn }}</strong></td>
        </tr>
        <tr>
            <td>Birthdate:</td>
            <td><strong>{{ $student->birthday }}</strong></td>
            <td>Sex:</td>
            <td><strong>{{ $student->sex }}</strong></td>
        </tr>
        <tr>
            <td>School:</td>
            <td><strong>{{ $student->school?->name ?? 'N/A' }}</strong></td>
            <td>Section:</td>
            <td><strong>{{ $student->section?->name ?? 'N/A' }}</strong></td>
        </tr>
        <tr>
            <td>School Year:</td>
            <td><strong>{{ $student->section?->schoolYear?->name ?? 'N/A' }}</strong></td>
            <td>Year Level:</td>
            <td><strong>{{ $student->section?->year_level ?? 'N/A' }}</strong></td>
        </tr>
    </table>

    <!-- ACADEMIC RECORD TABLE -->
    <table>
        <thead>
            <tr>
                <th rowspan="2">Learning Area</th>
                <th colspan="4">Quarterly Ratings</th>
                <th rowspan="2">Final Grade</th>
            </tr>
            <tr>
                <th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th>
            </tr>
        </thead>
        <tbody>
            @foreach($student->gradesGroupedByLearningArea() as $area => $grades)
            <tr>
                <td>{{ $area }}</td>
                <td>{{ $grades['q1'] ?? '' }}</td>
                <td>{{ $grades['q2'] ?? '' }}</td>
                <td>{{ $grades['q3'] ?? '' }}</td>
                <td>{{ $grades['q4'] ?? '' }}</td>
                <td>{{ $grades['final'] ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- FINAL REMARKS AND CERTIFICATION -->
    <p><strong>General Average:</strong> {{ $student->general_average ?? '---' }}</p>

    <div class="signature">
        ___________________________<br>
        Principal / School Head
    </div>

    <div class="signature" style="float: right;">
        ___________________________<br>
        Adviser / Teacher
    </div>

</div>

</body>
</html>
