<!DOCTYPE html>
<html>
<head>
    <title>SF9 - Report Card</title>
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; }
        }

        /* Signature styling */
        .signature { text-align: center; font-weight: bold; margin-top: 60px; }
        .signature-container { display: flex; justify-content: space-between; margin-top: 40px; }

        /* Table improvements */
        table th, table td { vertical-align: middle; }
    </style>
</head>
<body class="bg-gray-100 py-10">

<div class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow-xl relative">

    <!-- DROPDOWN MENU -->
    <div class="absolute top-4 left-4 no-print">
        <button id="menuButton" onclick="toggleMenu(event)" class="p-2 rounded-lg hover:bg-indigo-100">
            ☰
        </button>
        <div id="dropdown" class="hidden absolute mt-2 w-44 bg-white border rounded-xl shadow-xl overflow-hidden">
            <a href="{{ route('admin.students.index') }}" class="block px-4 py-2 hover:bg-gray-100">← Back</a>
            <button onclick="window.print()" class="block w-full text-left px-4 py-2 hover:bg-gray-100">🖨 Print</button>
            <a href="{{ route('admin.sf9.download', $student->id) }}" class="block px-4 py-2 hover:bg-gray-100">📄 Export PDF</a>
        </div>
    </div>

    <!-- HEADER -->
    <div class="flex items-center justify-center gap-4 mb-6">
        <img src="{{ asset('images/logo1.png') }}" class="w-20 h-20 object-contain">
        <div class="text-center">
            <h1 class="font-bold uppercase text-lg">Republic of the Philippines</h1>
            <h2 class="font-semibold text-sm">Department of Education</h2>
            <h3 class="font-bold mt-1 text-xl">STUDENT REPORT CARD (SF9)</h3>
        </div>
        <img src="{{ asset('images/logo.jpg') }}" class="w-20 h-20 object-contain">
    </div>

    <!-- STUDENT INFO -->
    <div class="grid grid-cols-2 gap-4 mb-6 text-sm border rounded-lg p-4">
        <p><strong>Name:</strong> {{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name }} {{ $student->suffix }}</p>
        <p><strong>Student ID:</strong> {{ $student->school_id }}</p>
        <p><strong>Grade Level:</strong> {{ $section->year_level ?? 'N/A' }}</p>
        <p><strong>Section:</strong> {{ $section->name ?? 'N/A' }}</p>
        <p><strong>Adviser:</strong> {{ $section->teacher->name ?? 'N/A' }}</p>
        <p><strong>School Year:</strong> {{ $activeSchoolYear->name }}</p>
    </div>

    <!-- GRADES -->
    <h3 class="font-bold mb-3">Scholastic Record</h3>
    <div class="overflow-x-auto">
        <table class="w-full border text-sm rounded-lg overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border p-2 text-left">Learning Area</th>
                    <th class="border p-2 text-center">Q1</th>
                    <th class="border p-2 text-center">Q2</th>
                    <th class="border p-2 text-center">Q3</th>
                    <th class="border p-2 text-center">Q4</th>
                    <th class="border p-2 text-center">Final</th>
                    <th class="border p-2 text-center">Remarks</th>
                </tr>
            </thead>
            <tbody>
            @php
                $total = 0;
                $count = 0;
                $quarterTotals = [1=>0,2=>0,3=>0,4=>0];
                $quarterCounts = [1=>0,2=>0,3=>0,4=>0];
            @endphp
            @foreach($subjects as $subject)
                @php
                    $q1 = $grades[$subject->id][1] ?? null;
                    $q2 = $grades[$subject->id][2] ?? null;
                    $q3 = $grades[$subject->id][3] ?? null;
                    $q4 = $grades[$subject->id][4] ?? null;

                    foreach([1=>$q1,2=>$q2,3=>$q3,4=>$q4] as $q => $g){
                        if($g !== null){ $quarterTotals[$q] += $g; $quarterCounts[$q]++; }
                    }

                    $final = collect([$q1,$q2,$q3,$q4])->filter()->avg();
                    $total += $final ?? 0;
                    $count += $final !== null ? 1 : 0;
                @endphp
                <tr class="hover:bg-gray-50">
                    <td class="border p-2">{{ $subject->name }}</td>
                    <td class="border p-2 text-center">{{ $q1 ?? '-' }}</td>
                    <td class="border p-2 text-center">{{ $q2 ?? '-' }}</td>
                    <td class="border p-2 text-center">{{ $q3 ?? '-' }}</td>
                    <td class="border p-2 text-center">{{ $q4 ?? '-' }}</td>
                    <td class="border p-2 text-center font-bold">{{ $final ? number_format($final,2) : '-' }}</td>
                    <td class="border p-2 text-center">
                        @if($final !== null)
                            <span class="{{ $final >= 75 ? 'text-green-600 font-bold' : 'text-red-600 font-bold' }}">
                                {{ $final >= 75 ? 'Passed' : 'Failed' }}
                            </span>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach

            <!-- Quarterly Averages -->
            <tr class="bg-gray-100 font-semibold">
                <td class="border px-2 py-2">Quarterly Average</td>
                @foreach([1,2,3,4] as $q)
                    <td class="border px-2 py-2 text-center">
                        {{ $quarterCounts[$q] ? number_format($quarterTotals[$q]/$quarterCounts[$q],2) : '-' }}
                    </td>
                @endforeach
                <td colspan="2" class="border px-2 py-2"></td>
            </tr>
            </tbody>
        </table>
    </div>

    @php $generalAverage = $count ? $total/$count : 0; @endphp
    <div class="mt-4 flex justify-between items-center flex-wrap gap-4">
        <div class="w-64 border rounded-lg p-4 text-sm">
            <p><strong>General Average:</strong>
                <span class="float-right font-bold">{{ number_format($generalAverage,2) }}</span>
            </p>
            <p class="mt-2"><strong>Final Remark:</strong>
                <span class="{{ $generalAverage >= 75 ? 'text-green-600 font-bold' : 'text-red-600 font-bold' }}">
                    {{ $generalAverage >= 75 ? 'PROMOTED' : 'RETAINED' }}
                </span>
            </p>
        </div>
    </div>

    <!-- Signatures -->
    <div class="signature-container">
        <div class="signature">
            ___________________________<br>
            Principal / School Head
        </div>
        <div class="signature">
            ___________________________<br>
            Adviser
        </div>
    </div>

</div>

<script>
    const dropdown = document.getElementById('dropdown');
    const menuButton = document.getElementById('menuButton');

    function toggleMenu(event){
        event.stopPropagation();
        dropdown.classList.toggle('hidden');
    }

    document.addEventListener('click', function(event){
        if(!dropdown.contains(event.target) && !menuButton.contains(event.target)){
            dropdown.classList.add('hidden');
        }
    });
</script>

</body>
</html>