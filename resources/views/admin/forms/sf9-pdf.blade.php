<!DOCTYPE html>
<html>
<head>
    <title>SF9 - Report Card</title>
    

    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 800px; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 6px; text-align: center; }
        .no-print { margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="container">

    <div class="no-print">
      

        <a href="{{ route('admin.sf9.download', $student->id) }}">
            <button>⬇ Download PDF</button>
        </a>
    </div>

    <h2 style="text-align:center;">School Form 9 (SF9)</h2>
    <h3 style="text-align:center;">Report Card</h3>

    <p><strong>Student Name:</strong>
        {{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}
    </p>

    <p><strong>School ID:</strong> {{ $student->school_id }}</p>
    <p><strong>Section:</strong> {{ $student->section->name ?? 'N/A' }}</p>
    <p><strong>Year Level:</strong> {{ $student->section->year_level ?? 'N/A' }}</p>

    <table>
        <thead>
            <tr>
                <th>Subject</th>
                <th>1st Quarter</th>
                <th>2nd Quarter</th>
                <th>3rd Quarter</th>
                <th>4th Quarter</th>
                <th>Final Grade</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Mathematics</td>
                <td>90</td>
                <td>91</td>
                <td>89</td>
                <td>92</td>
                <td>91</td>
            </tr>
            <tr>
                <td>English</td>
                <td>88</td>
                <td>90</td>
                <td>87</td>
                <td>89</td>
                <td>89</td>
            </tr>
        </tbody>
    </table>

    <br><br>

    <p><strong>General Average:</strong> 90</p>

</div>

</body>
</html>
