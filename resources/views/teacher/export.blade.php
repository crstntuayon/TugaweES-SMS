<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SF2 Attendance</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 20px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
        }

        h2, h4 {
            text-align: center;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th, td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .student {
            text-align: left;
            padding-left: 5px;
            white-space: nowrap;
        }

        .totals th,
        .totals td {
            font-weight: bold;
            background-color: #fafafa;
        }

        .legend {
            margin-top: 8px;
            font-size: 9px;
        }

        .footer {
            margin-top: 18px;
            font-size: 9px;
        }
    </style>
</head>
<body>

    <h2>School Form 2 (SF2) – Daily Attendance Report</h2>
    <h4>
        {{ $section->year_level }} – {{ $section->name }}
        | {{ \Carbon\Carbon::create()->month((int) $month)->format('F') }} {{ $year }}

    </h4>

    <table>
        <thead>
            <tr>
                <th width="18%">Learner Name</th>

                @for($d = 1; $d <= $daysInMonth; $d++)
                    <th width="2%">{{ $d }}</th>
                @endfor

                <th width="4%">P</th>
                <th width="4%">A</th>
                <th width="4%">L</th>
            </tr>
        </thead>

        <tbody>
            @foreach($students as $student)
                @php
                    $present = $absent = $late = 0;
                @endphp

                <tr>
                    <td class="student">
                        {{ $student->last_name }},
                        {{ $student->first_name }}
                        {{ $student->middle_name ?? '' }}
                        {{ $student->suffix ?? '' }}
                    </td>

                    @for($d = 1; $d <= $daysInMonth; $d++)
                      @php
    $date = sprintf('%04d-%02d-%02d', $year, $month, $d);

    $status = $student->attendances
        ->firstWhere('date', $date)
        ?->status;

    switch ($status) {
        case 'present':
            $present++;
            $mark = 'P';
            break;

        case 'absent':
            $absent++;
            $mark = 'A';
            break;

        case 'late':
            $late++;
            $mark = 'L';
            break;

        default:
            $mark = '';
    }
@endphp

                        <td>{{ is_array($mark) ? $mark[1] : $mark }}</td>
                    @endfor

                    <td>{{ $present }}</td>
                    <td>{{ $absent }}</td>
                    <td>{{ $late }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="legend">
        <strong>Legend:</strong>
        P – Present &nbsp;&nbsp;
        A – Absent &nbsp;&nbsp;
        L – Late
    </div>

    <div class="footer">
        <p>
            Class Adviser: ___________________________
            &nbsp;&nbsp;&nbsp;
            Signature: ___________________________
            &nbsp;&nbsp;&nbsp;
            Date: ____________
        </p>
    </div>

</body>
</html>
