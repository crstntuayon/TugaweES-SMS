<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SF9 - Report Card</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css'])

    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; }
        }
    </style>
</head>

<body class="bg-gray-100 py-10">

<div class="max-w-5xl mx-auto bg-white shadow-xl rounded-2xl p-10">

    <!-- ================= HEADER ================= -->
    <div class="text-center border-b pb-6 mb-6">
        <h1 class="text-2xl font-bold uppercase tracking-wide">
            Republic of the Philippines
        </h1>
        <h2 class="text-lg font-semibold mt-1">
            Department of Education
        </h2>
        <h3 class="text-lg font-bold mt-3">
            STUDENT REPORT CARD (SF9)
        </h3>
    </div>

    <!-- ================= SCHOOL INFO ================= -->
    <div class="grid grid-cols-2 gap-6 mb-6 text-sm">
        <div>
            <p><strong>School Name:</strong> {{ config('app.school_name', 'Your School Name') }}</p>
            <p><strong>School ID:</strong> {{ config('app.school_id', '000000') }}</p>
        </div>
        <div class="text-right">
            <p><strong>School Year:</strong> {{ $activeSchoolYear->name ?? 'N/A' }}</p>
            <p><strong>Status:</strong> {{ ucfirst($enrollment->status ?? 'Active') }}</p>
        </div>
    </div>

    <!-- ================= STUDENT INFO ================= -->
    <div class="border rounded-xl p-6 mb-8">
        <div class="grid grid-cols-2 gap-4 text-sm">

            <p><strong>Name:</strong>
                {{ $student->last_name }},
                {{ $student->first_name }}
                {{ $student->middle_name }}
                {{ $student->suffix }}
            </p>

            <p><strong>Student ID:</strong> {{ $student->school_id }}</p>

            <p><strong>Grade Level:</strong> {{ $section->year_level }}</p>

            <p><strong>Section:</strong> {{ $section->name }}</p>

            <p><strong>Adviser:</strong> {{ $section->teacher->name ?? 'N/A' }}</p>

            <p><strong>Sex:</strong> {{ $student->sex }}</p>

        </div>
    </div>

    <!-- ================= GRADES TABLE ================= -->
    <div class="mb-8">

        <h3 class="text-lg font-bold mb-4">Scholastic Record</h3>

        <table class="w-full border-collapse border text-sm">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2 text-left">Learning Area</th>
                    <th class="border p-2 text-center">Q1</th>
                    <th class="border p-2 text-center">Q2</th>
                    <th class="border p-2 text-center">Q3</th>
                    <th class="border p-2 text-center">Q4</th>
                    <th class="border p-2 text-center">Final Grade</th>
                    <th class="border p-2 text-center">Remarks</th>
                </tr>
            </thead>

            <tbody>
                @php $total = 0; $count = 0; @endphp

                @forelse($grades as $grade)
                    @php
                        $final = collect([
                            $grade->quarter1,
                            $grade->quarter2,
                            $grade->quarter3,
                            $grade->quarter4
                        ])->filter()->avg();

                        $total += $final;
                        $count++;
                    @endphp

                    <tr>
                        <td class="border p-2">{{ $grade->subject->name }}</td>
                        <td class="border p-2 text-center">{{ $grade->quarter1 }}</td>
                        <td class="border p-2 text-center">{{ $grade->quarter2 }}</td>
                        <td class="border p-2 text-center">{{ $grade->quarter3 }}</td>
                        <td class="border p-2 text-center">{{ $grade->quarter4 }}</td>
                        <td class="border p-2 text-center font-semibold">
                            {{ number_format($final, 2) }}
                        </td>
                        <td class="border p-2 text-center">
                            {{ $final >= 75 ? 'Passed' : 'Failed' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="border p-4 text-center text-gray-500">
                            No grades available.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ================= GENERAL AVERAGE ================= -->
    @php
        $generalAverage = $count > 0 ? $total / $count : 0;
    @endphp

    <div class="flex justify-end mb-8">
        <div class="w-72 border rounded-lg p-4 text-sm">
            <p><strong>General Average:</strong>
                <span class="float-right font-bold">
                    {{ number_format($generalAverage, 2) }}
                </span>
            </p>
            <p class="mt-2">
                <strong>Final Remark:</strong>
                <span class="float-right font-bold">
                    {{ $generalAverage >= 75 ? 'PROMOTED' : 'RETAINED' }}
                </span>
            </p>
        </div>
    </div>

    <!-- ================= SIGNATURES ================= -->
    <div class="grid grid-cols-2 gap-20 mt-16 text-sm">

        <div class="text-center">
            <div class="border-t pt-2">
                {{ $section->teacher->name ?? 'Adviser Name' }}
            </div>
            <p>Class Adviser</p>
        </div>

        <div class="text-center">
            <div class="border-t pt-2">
                School Head
            </div>
            <p>Principal</p>
        </div>

    </div>

    <!-- ================= PRINT BUTTON ================= -->
    <div class="text-center mt-10 no-print">
        <button onclick="window.print()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl shadow-lg">
            Print SF9
        </button>
    </div>

</div>

</body>
</html>