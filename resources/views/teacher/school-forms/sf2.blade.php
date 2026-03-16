<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DepEd SF2 - Daily Attendance Report | {{ $section->name ?? 'Section' }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --primary: #1e3a8a;
            --primary-light: #3b82f6;
            --primary-dark: #1e40af;
            --success: #059669;
            --warning: #d97706;
            --danger: #dc2626;
            --info: #0891b2;
            --bg: #f8fafc;
            --card: #ffffff;
            --text: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
            min-height: 100vh;
        }
        
        @media print {
            body { background: white; }
            .no-print { display: none !important; }
            .fab-container { display: none !important; }
            .form-container { box-shadow: none; border: 1px solid #000; }
            .attendance-table th { background: #1e3a8a !important; -webkit-print-color-adjust: exact; }
            .status-present { background: #d1fae5 !important; }
            .status-absent { background: #fee2e2 !important; }
            .status-late { background: #fef3c7 !important; }
            .status-excused { background: #dbeafe !important; }
            .editable-input { border: none; background: transparent; text-align: center; }
        }
        
        /* Header */
        .app-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        }
        
        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .logo-icon {
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.15);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .brand-text h1 {
            font-size: 1.25rem;
            font-weight: 700;
        }
        
        .brand-text p {
            font-size: 0.875rem;
            opacity: 0.9;
        }
        
        /* Control Bar - Removed buttons from here */
        .control-bar {
            background: var(--card);
            border-bottom: 1px solid var(--border);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        
        .control-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .month-selector {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .month-selector input[type="month"] {
            padding: 0.5rem 1rem;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
        }
        
        /* Floating Action Button Container */
        .fab-container {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            z-index: 1000;
            align-items: flex-end;
        }
        
        .fab-button {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15), 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }
        
        .fab-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, transparent 50%);
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .fab-button:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2), 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        
        .fab-button:hover::before {
            opacity: 1;
        }
        
        .fab-button:active {
            transform: translateY(-2px) scale(0.98);
        }
        
        .fab-button svg {
            width: 24px;
            height: 24px;
            stroke-width: 2.5;
            transition: transform 0.3s;
        }
        
        .fab-button:hover svg {
            transform: scale(1.1);
        }
        
        /* Back Button - White with subtle shadow */
        .fab-back {
            background: white;
            color: var(--text);
        }
        
        .fab-back:hover {
            background: #f8fafc;
            color: var(--primary);
        }
        
        /* Print Button - Primary color */
        .fab-print {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }
        
        .fab-print:hover {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 100%);
        }
        
        /* Tooltip for FAB buttons */
        .fab-tooltip {
            position: absolute;
            right: 70px;
            background: rgba(30, 41, 59, 0.9);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transform: translateX(10px);
            transition: all 0.3s;
            backdrop-filter: blur(8px);
        }
        
        .fab-button:hover .fab-tooltip {
            opacity: 1;
            visibility: visible;
            transform: translateX(0);
        }
        
        /* Pulse animation for print button */
        @keyframes pulse {
            0%, 100% { box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3); }
            50% { box-shadow: 0 4px 20px rgba(30, 58, 138, 0.5), 0 0 0 8px rgba(30, 58, 138, 0.1); }
        }
        
        .fab-print {
            animation: pulse 2s infinite;
        }
        
        .fab-print:hover {
            animation: none;
        }
        
        /* Main Container */
        .container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 2rem;
            padding-bottom: 6rem; /* Space for floating buttons */
        }
        
        /* SF2 Form Container */
        .sf2-container {
            background: var(--card);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        /* Official DepEd Header - Retained original structure with logos added beside Republic/DepEd */
        .sf2-header {
            padding: 2rem;
            border-bottom: 3px double var(--primary);
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }
        
        /* Updated header grid with logos beside Republic/DepEd text */
        .header-grid {
            display: grid;
            grid-template-columns: 1fr 2fr 1fr;
            gap: 2rem;
            margin-bottom: 1.5rem;
            align-items: center;
        }
        
        /* Left side with logo and School ID */
        .header-left-side {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }
        
        .header-logo-left {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .header-logo-img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            /* No background - transparent */
            background: transparent;
        }
        
        .header-logo-placeholder {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.6rem;
            text-align: center;
            color: #666;
            border: 1px solid #ddd;
        }
        
        /* Center text */
        .header-center {
            text-align: center;
        }
        
        .header-center h2 {
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
        }
        
        .header-center h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            background: var(--primary);
            color: white;
            display: inline-block;
            padding: 0.5rem 2rem;
            border-radius: 4px;
            margin: 0.5rem 0;
        }
        
        .header-center p {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-style: italic;
        }
        
        /* Right side with logo and School Year */
        .header-right-side {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }
        
        .header-logo-right {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .info-field {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            text-align: right;
        }
        
        .info-field label {
            font-size: 0.625rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--text-muted);
        }
        
        .info-field .value {
            padding: 0.5rem;
            border-bottom: 1px solid var(--border);
            font-size: 0.875rem;
            font-weight: 500;
            min-height: 2rem;
        }
        
        /* School info - RETAINED ORIGINAL 4-COLUMN LAYOUT */
        .school-info {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }
        
        /* Stats Summary */
        .stats-bar {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            padding: 1rem 2rem;
            background: #f0f9ff;
            border-bottom: 1px solid #bae6fd;
        }
        
        .stat-box {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }
        
        .stat-icon.present { background: #d1fae5; color: var(--success); }
        .stat-icon.absent { background: #fee2e2; color: var(--danger); }
        .stat-icon.late { background: #fef3c7; color: var(--warning); }
        .stat-icon.rate { background: #dbeafe; color: var(--primary); }
        
        .stat-details h4 {
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .stat-details p {
            font-size: 0.75rem;
            color: var(--text-muted);
        }
        
        /* Attendance Table */
        .table-wrapper {
            overflow-x: auto;
            padding: 1rem;
        }
        
        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.75rem;
            min-width: 1200px;
        }
        
        .attendance-table th {
            background: var(--primary);
            color: white;
            padding: 0.75rem 0.5rem;
            text-align: center;
            font-weight: 600;
            border-right: 1px solid rgba(255,255,255,0.1);
        }
        
        .attendance-table th:first-child {
            border-radius: 8px 0 0 0;
        }
        
        .attendance-table th:last-child {
            border-radius: 0 8px 0 0;
            border-right: none;
        }
        
        .attendance-table td {
            padding: 0.5rem;
            text-align: center;
            border: 1px solid var(--border);
        }
        
        .attendance-table tr:nth-child(even) {
            background: #fafafa;
        }
        
        .attendance-table tr:hover {
            background: #f1f5f9;
        }
        
        /* Student Info Cell */
        .student-info {
            text-align: left !important;
            min-width: 200px;
        }
        
        .student-name {
            font-weight: 600;
            font-size: 0.875rem;
        }
        
        .student-lrn {
            font-size: 0.625rem;
            color: var(--text-muted);
            font-family: monospace;
        }
        
        .row-num {
            font-weight: 700;
            color: var(--primary);
            background: #eff6ff;
            width: 40px;
        }
        
        /* Status Cells */
        .status-cell {
            width: 32px;
            height: 32px;
            font-weight: 700;
            font-size: 0.875rem;
        }
        
        .status-present { background: #d1fae5; color: var(--success); }
        .status-absent { background: #fee2e2; color: var(--danger); }
        .status-late { background: #fef3c7; color: var(--warning); }
        .status-excused { background: #dbeafe; color: var(--info); }
        .status-empty { background: white; color: #cbd5e1; }
        
        /* Day Headers */
        .day-header {
            min-width: 32px;
        }
        
        .day-header .day-num {
            font-size: 0.875rem;
            font-weight: 700;
        }
        
        .day-header .day-name {
            font-size: 0.625rem;
            opacity: 0.8;
        }
        
        /* Weekend columns */
        .weekend {
            background: #f1f5f9 !important;
        }
        
        /* Totals */
        .total-cell {
            font-weight: 700;
            min-width: 50px;
        }
        
        .total-absent { color: var(--danger); background: #fef2f2; }
        .total-late { color: var(--warning); background: #fffbeb; }
        
        /* Gender Divider */
        .gender-header {
            background: #e2e8f0 !important;
            color: var(--text) !important;
            font-weight: 700;
            text-align: left !important;
            padding-left: 1rem !important;
            text-transform: uppercase;
            font-size: 0.875rem;
        }
        
        /* Summary Section */
        .summary-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            padding: 2rem;
            background: #f8fafc;
            border-top: 2px solid var(--border);
        }
        
        .summary-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .summary-title {
            background: var(--primary);
            color: white;
            padding: 0.75rem;
            font-weight: 600;
            text-align: center;
            font-size: 0.875rem;
        }
        
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.75rem;
        }
        
        .summary-table th,
        .summary-table td {
            padding: 0.625rem;
            text-align: center;
            border-bottom: 1px solid var(--border);
        }
        
        .summary-table th {
            background: #f1f5f9;
            font-weight: 600;
        }
        
        .summary-table td:first-child {
            text-align: left;
        }
        
        .alert-row {
            background: #fef3c7;
            font-weight: 600;
        }
        
        /* Legend */
        .legend-bar {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 1rem 2rem;
            background: white;
            border-top: 1px solid var(--border);
            font-size: 0.875rem;
        }
        
        .legend-title {
            font-weight: 600;
            color: var(--text-muted);
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .legend-symbol {
            width: 24px;
            height: 24px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.75rem;
        }
        
        /* Signatures - Editable */
        .signatures {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            padding: 2rem;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .signature-box {
            text-align: center;
        }
        
        .signature-line {
            border-bottom: 1px solid var(--text);
            height: 50px;
            margin-bottom: 0.5rem;
        }
        
        .signature-name {
            font-weight: 600;
        }
        
        .signature-title {
            font-size: 0.75rem;
            color: var(--text-muted);
        }
        
        /* Editable input for signatures */
        .editable-input {
            border: 1px solid #ccc;
            padding: 4px 8px;
            font-family: inherit;
            font-size: 0.9rem;
            text-align: center;
            width: 100%;
            max-width: 250px;
            background: #fff;
            border-radius: 4px;
            margin-bottom: 0.5rem;
        }
        
        .editable-input:focus {
            border-color: var(--primary);
            outline: none;
            background: #f0f8ff;
        }
        
        @media print {
            .editable-input {
                border: none;
                background: transparent;
            }
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem;
            color: var(--text-muted);
        }
        
        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header class="app-header no-print">
        <div class="header-content">
            <div class="brand">
                <div class="logo-icon">📚</div>
                <div class="brand-text">
                    <h1>DepEd SF2 - Daily Attendance Report</h1>
                    <p>School Form 2 (SF2) - Daily Attendance Report of Learners</p>
                </div>
            </div>
            <div>
                <span id="currentDate"></span>
            </div>
        </div>
    </header>

    <!-- Control Bar - Buttons removed, only month selector remains -->
<!-- Control Bar -->
<div class="control-bar no-print">
    <div class="control-content">
        
        <!-- Section Selector - Navigate to URL -->
        <div class="section-selector">
            <label>🏫 Section:</label>
            <select onchange="changeSection(this.value)" 
                    style="padding: 0.5rem 1rem; border: 2px solid var(--border); border-radius: 8px; font-size: 0.95rem; min-width: 220px;">
                @foreach($teacherSections as $sec)
                    <option value="{{ $sec->id }}" {{ $selectedSection->id == $sec->id ? 'selected' : '' }}>
                        Grade {{ $sec->year_level }} - {{ $sec->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Month Selector - Keep current section in URL -->
        <form method="GET" style="display: flex; gap: 0.5rem;">
            <label>📅 Report Period:</label>
            <input type="month" name="month" value="{{ sprintf('%04d-%02d', $year, $month) }}" 
                   onchange="this.form.submit()"
                   style="padding: 0.5rem 1rem; border: 2px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
            <!-- Hidden section_id for form submission -->
            <input type="hidden" name="section_id" value="{{ $selectedSection->id }}">
        </form>
        
    </div>
</div>

<script>
function changeSection(sectionId) {
    // Navigate to the section-specific URL (like SF1 does)
    const baseUrl = '{{ url("/teacher/school-forms/sf2/section") }}';
    window.location.href = baseUrl + '/' + sectionId;
}
</script>



    <!-- Floating Action Buttons -->
    <div class="fab-container no-print">
        <a href="{{ route('teacher.dashboard')}}" class="fab-button fab-back" title="Back to Dashboard">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            <span class="fab-tooltip">Back to Dashboard</span>
        </a>
        <button class="fab-button fab-print" onclick="window.print()" title="Print SF2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                <rect x="6" y="14" width="12" height="8"></rect>
            </svg>
            <span class="fab-tooltip">Print Report</span>
        </button>
    </div>

    <!-- Main Content -->
    <div class="container">
        
        @php
            // Calculate all school days for the month
            $startOfMonth = \Carbon\Carbon::create($year, $month)->startOfMonth();
            $endOfMonth = \Carbon\Carbon::create($year, $month)->endOfMonth();
            $schoolDays = [];
            $weekendDays = [];
            
            for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
                $dayNum = $date->format('j');
                $dayName = $date->format('D');
                
                if ($date->isWeekend()) {
                    $weekendDays[] = $dayNum;
                } else {
                    $schoolDays[] = [
                        'num' => $dayNum,
                        'name' => $dayName,
                        'date' => $date->format('Y-m-d')
                    ];
                }
            }
            
            // Group students by gender
            $maleStudents = $students->where('sex', 'Male')->sortBy('last_name');
            $femaleStudents = $students->where('sex', 'Female')->sortBy('last_name');
            
            // Calculate statistics
            $totalStudents = $students->count();
            $totalMale = $maleStudents->count();
            $totalFemale = $femaleStudents->count();
            
            // Calculate daily totals and student stats
            $dailyTotals = [];
            $studentStats = [];
            $studentsWith5ConsecutiveAbsences = 0;
            
            foreach ($students as $student) {
                $absentCount = 0;
                $lateCount = 0;
                $consecutiveAbsences = 0;
                $maxConsecutive = 0;
                $lastWasAbsent = false;
                
                foreach ($schoolDays as $day) {
                    $att = $student->attendances->firstWhere('date', $day['date']);
                    $status = $att?->status ?? null;
                    
                    if ($status === 'absent') {
                        $absentCount++;
                        $consecutiveAbsences++;
                        $maxConsecutive = max($maxConsecutive, $consecutiveAbsences);
                    } elseif ($status === 'late') {
                        $lateCount++;
                        $consecutiveAbsences = 0;
                    } else {
                        $consecutiveAbsences = 0;
                    }
                }
                
                $studentStats[$student->id] = [
                    'absent' => $absentCount,
                    'late' => $lateCount,
                    'consecutive' => $maxConsecutive
                ];
                
                if ($maxConsecutive >= 5) {
                    $studentsWith5ConsecutiveAbsences++;
                }
            }
            
            // Calculate daily present totals
            foreach ($schoolDays as $day) {
                $present = 0;
                foreach ($students as $student) {
                    $att = $student->attendances->firstWhere('date', $day['date']);
                    if ($att && in_array($att->status, ['present', 'late'])) {
                        $present++;
                    }
                }
                $dailyTotals[$day['num']] = $present;
            }
            
            // Summary calculations
            $enrollmentAsOfFirstFriday = $totalStudents;
            $registeredLearners = $totalStudents;
            $percentageEnrolment = 100;
            $averageDailyAttendance = count($schoolDays) > 0 ? round(array_sum($dailyTotals) / count($schoolDays), 1) : 0;
            $percentageAttendance = $totalStudents > 0 ? round(($averageDailyAttendance / $totalStudents) * 100, 2) : 0;
            
            // Dropouts and transfers
            $dropoutsMale = $students->where('sex', 'Male')->where('status', 'dropped_out')->count();
            $dropoutsFemale = $students->where('sex', 'Female')->where('status', 'dropped_out')->count();
            $transferredOutMale = $students->where('sex', 'Male')->where('status', 'transferred_out')->count();
            $transferredOutFemale = $students->where('sex', 'Female')->where('status', 'transferred_out')->count();
            $transferredInMale = $students->where('sex', 'Male')->where('status', 'transferred_in')->count();
            $transferredInFemale = $students->where('sex', 'Female')->where('status', 'transferred_in')->count();
        @endphp

        <div class="sf2-container">
            
            <!-- SF2 Official Header - RETAINED School ID position, added logos beside Republic/DepEd -->
            <div class="sf2-header">
                <div class="header-grid">
                    <!-- Left: Logo + School ID -->
                    <div class="header-left-side">
                        <div class="header-logo-left">
                            <img src="{{ asset('images/logo1.png') }}" alt="DepEd Logo" class="header-logo-img" onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\'header-logo-placeholder\'>DepEd<br>Logo</div>';">
                        </div>
                    <div class="info-field" style="text-align: center;">
                            <label>School Year</label>
                            <div class="value">{{ $activeSchoolYear->name ?? '2024-2025' }}</div>
                        </div>
                    </div>
                    
                    <!-- Center: Republic/DepEd text (NO LOGO beside Daily Attendance) -->
                    <div class="header-center">
                        <h2>Republic of the Philippines</h2>
                        <h2>Department of Education</h2>
                        <h1>Daily Attendance Report of Learners</h1>
                        <p>(This replaces Form 1, Form 2 & STS Form 4 - Absenteeism and Dropout Profile)</p>
                    </div>
                    
                    <!-- Right: Logo + School Year -->
                    <div class="header-right-side">
                        <div class="header-logo-right">
                            <img src="{{ asset('images/logo.png') }}" alt="School Seal" class="header-logo-img" onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\'header-logo-placeholder\'>School<br>Seal</div>';">
                        </div>
                         <div class="info-field" style="text-align: center;">
                            <label>School ID</label>
                            <div class="value">{{ $school->school_id ?? '120231' }}</div>
                        </div>
                    </div>
                </div>
                
                <!-- School info - RETAINED ORIGINAL 4-COLUMN LAYOUT with School ID at top left -->
                <div class="school-info">
                    <div class="info-field">
                        <label>Name of School</label>
                        <div class="value">{{ $school->name ?? 'Tugawe Elementary School' }}</div>
                    </div>
                    <div class="info-field">
                        <label>Grade Level</label>
                        <div class="value">{{ $section->year_level }}</div>
                    </div>
                    <div class="info-field">
                        <label>Section</label>
                        <div class="value">{{ $section->name }}</div>
                    </div>
                    <div class="info-field">
                        <label>Month</label>
                        <div class="value">{{ \Carbon\Carbon::create($year, $month)->format('F Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="stats-bar">
                <div class="stat-box">
                    <div class="stat-icon present">✓</div>
                    <div class="stat-details">
                        <h4>{{ $totalStudents }}</h4>
                        <p>Total Enrolled Students</p>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon absent">A</div>
                    <div class="stat-details">
                        <h4>{{ count($schoolDays) }}</h4>
                        <p>School Days This Month</p>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon late">L</div>
                    <div class="stat-details">
                        <h4>{{ $averageDailyAttendance }}</h4>
                        <p>Average Daily Attendance</p>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon rate">%</div>
                    <div class="stat-details">
                        <h4>{{ $percentageAttendance }}%</h4>
                        <p>Monthly Attendance Rate</p>
                    </div>
                </div>
            </div>

            <!-- Attendance Table -->
            <div class="table-wrapper">
                <table class="attendance-table">
                    <thead>
                        <tr>
                            <th rowspan="2">#</th>
                            <th rowspan="2" style="min-width: 80px;">LRN</th>
                            <th rowspan="2" style="min-width: 200px;">Learner's Name<br><small>(Last Name, First Name, Middle Name)</small></th>
                            
                            @foreach(range(1, 31) as $day)
                                @php
                                    $isWeekend = in_array($day, $weekendDays);
                                    $dayInfo = collect($schoolDays)->firstWhere('num', $day);
                                @endphp
                                <th class="day-header {{ $isWeekend ? 'weekend' : '' }}" style="min-width: 32px;">
                                    @if($dayInfo)
                                        <div class="day-num">{{ $day }}</div>
                                        <div class="day-name">{{ $dayInfo['name'] }}</div>
                                    @else
                                        <div class="day-num">{{ $day }}</div>
                                    @endif
                                </th>
                            @endforeach
                            
                            <th rowspan="2" class="total-cell">Total<br>Absent</th>
                            <th rowspan="2" class="total-cell">Total<br>Late</th>
                            <th rowspan="2" style="min-width: 150px;">Remarks</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <!-- MALE STUDENTS -->
                        <tr>
                            <td colspan="36" class="gender-header">
                                MALE | Total: {{ $totalMale }} students
                            </td>
                        </tr>
                        
                        @foreach($maleStudents as $index => $student)
                            <tr>
                                <td class="row-num">{{ $index + 1 }}</td>
                                <td style="font-family: monospace; font-size: 0.7rem;">{{ $student->lrn ?? '-' }}</td>
                                <td class="student-info">
                                    <div class="student-name">
                                        {{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name ? substr($student->middle_name, 0, 1) . '.' : '' }}
                                    </div>
                                </td>
                                
                                @foreach(range(1, 31) as $day)
                                    @php
                                        $isWeekend = in_array($day, $weekendDays);
                                        $dayInfo = collect($schoolDays)->firstWhere('num', $day);
                                        $cellClass = 'status-empty';
                                        $symbol = '';
                                        
                                        if ($dayInfo && !$isWeekend) {
                                            $att = $student->attendances->firstWhere('date', $dayInfo['date']);
                                            if ($att) {
                                                switch($att->status) {
                                                    case 'present':
                                                        $cellClass = 'status-present';
                                                        $symbol = '✓';
                                                        break;
                                                    case 'absent':
                                                        $cellClass = 'status-absent';
                                                        $symbol = 'A';
                                                        break;
                                                    case 'late':
                                                        $cellClass = 'status-late';
                                                        $symbol = 'L';
                                                        break;
                                                    case 'excused':
                                                        $cellClass = 'status-excused';
                                                        $symbol = 'E';
                                                        break;
                                                }
                                            }
                                        } elseif ($isWeekend) {
                                            $cellClass = 'weekend';
                                            $symbol = '';
                                        }
                                    @endphp
                                    <td class="status-cell {{ $cellClass }}">
                                        {{ $symbol }}
                                    </td>
                                @endforeach
                                
                                @php
                                    $stats = $studentStats[$student->id] ?? ['absent' => 0, 'late' => 0];
                                    $remarks = '';
                                    if ($student->status === 'dropped_out') $remarks = 'Dropped Out';
                                    elseif ($student->status === 'transferred_out') $remarks = 'Transferred Out';
                                    elseif ($student->status === 'transferred_in') $remarks = 'Transferred In';
                                    elseif ($stats['consecutive'] >= 5) $remarks = '5+ Consecutive Absences';
                                @endphp
                                
                                <td class="total-cell total-absent">{{ $stats['absent'] > 0 ? $stats['absent'] : '' }}</td>
                                <td class="total-cell total-late">{{ $stats['late'] > 0 ? $stats['late'] : '' }}</td>
                                <td style="font-size: 0.7rem;">{{ $remarks }}</td>
                            </tr>
                        @endforeach
                        
                        <!-- MALE TOTAL ROW -->
                        <tr style="background: #f1f5f9; font-weight: 700;">
                            <td colspan="3" style="text-align: right; padding-right: 1rem;">MALE TOTAL PER DAY →</td>
                            @foreach(range(1, 31) as $day)
                                @php
                                    $dayInfo = collect($schoolDays)->firstWhere('num', $day);
                                    $malePresent = 0;
                                    if ($dayInfo) {
                                        foreach($maleStudents as $student) {
                                            $att = $student->attendances->firstWhere('date', $dayInfo['date']);
                                            if ($att && in_array($att->status, ['present', 'late'])) {
                                                $malePresent++;
                                            }
                                        }
                                    }
                                @endphp
                                <td>{{ $dayInfo ? $malePresent : '' }}</td>
                            @endforeach
                            <td colspan="3"></td>
                        </tr>

                        <!-- FEMALE STUDENTS -->
                        <tr>
                            <td colspan="36" class="gender-header">
                                FEMALE | Total: {{ $totalFemale }} students
                            </td>
                        </tr>
                        
                        @foreach($femaleStudents as $index => $student)
                            <tr>
                                <td class="row-num">{{ $index + 1 }}</td>
                                <td style="font-family: monospace; font-size: 0.7rem;">{{ $student->lrn ?? '-' }}</td>
                                <td class="student-info">
                                    <div class="student-name">
                                        {{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name ? substr($student->middle_name, 0, 1) . '.' : '' }}
                                    </div>
                                </td>
                                
                                @foreach(range(1, 31) as $day)
                                    @php
                                        $isWeekend = in_array($day, $weekendDays);
                                        $dayInfo = collect($schoolDays)->firstWhere('num', $day);
                                        $cellClass = 'status-empty';
                                        $symbol = '';
                                        
                                        if ($dayInfo && !$isWeekend) {
                                            $att = $student->attendances->firstWhere('date', $dayInfo['date']);
                                            if ($att) {
                                                switch($att->status) {
                                                    case 'present':
                                                        $cellClass = 'status-present';
                                                        $symbol = '✓';
                                                        break;
                                                    case 'absent':
                                                        $cellClass = 'status-absent';
                                                        $symbol = 'A';
                                                        break;
                                                    case 'late':
                                                        $cellClass = 'status-late';
                                                        $symbol = 'L';
                                                        break;
                                                    case 'excused':
                                                        $cellClass = 'status-excused';
                                                        $symbol = 'E';
                                                        break;
                                                }
                                            }
                                        } elseif ($isWeekend) {
                                            $cellClass = 'weekend';
                                        }
                                    @endphp
                                    <td class="status-cell {{ $cellClass }}">
                                        {{ $symbol }}
                                    </td>
                                @endforeach
                                
                                @php
                                    $stats = $studentStats[$student->id] ?? ['absent' => 0, 'late' => 0];
                                    $remarks = '';
                                    if ($student->status === 'dropped_out') $remarks = 'Dropped Out';
                                    elseif ($student->status === 'transferred_out') $remarks = 'Transferred Out';
                                    elseif ($student->status === 'transferred_in') $remarks = 'Transferred In';
                                    elseif ($stats['consecutive'] >= 5) $remarks = '5+ Consecutive Absences';
                                @endphp
                                
                                <td class="total-cell total-absent">{{ $stats['absent'] > 0 ? $stats['absent'] : '' }}</td>
                                <td class="total-cell total-late">{{ $stats['late'] > 0 ? $stats['late'] : '' }}</td>
                                <td style="font-size: 0.7rem;">{{ $remarks }}</td>
                            </tr>
                        @endforeach
                        
                        <!-- FEMALE TOTAL ROW -->
                        <tr style="background: #f1f5f9; font-weight: 700;">
                            <td colspan="3" style="text-align: right; padding-right: 1rem;">FEMALE TOTAL PER DAY →</td>
                            @foreach(range(1, 31) as $day)
                                @php
                                    $dayInfo = collect($schoolDays)->firstWhere('num', $day);
                                    $femalePresent = 0;
                                    if ($dayInfo) {
                                        foreach($femaleStudents as $student) {
                                            $att = $student->attendances->firstWhere('date', $dayInfo['date']);
                                            if ($att && in_array($att->status, ['present', 'late'])) {
                                                $femalePresent++;
                                            }
                                        }
                                    }
                                @endphp
                                <td>{{ $dayInfo ? $femalePresent : '' }}</td>
                            @endforeach
                            <td colspan="3"></td>
                        </tr>

                        <!-- COMBINED TOTAL -->
                        <tr style="background: #e2e8f0; font-weight: 700; font-size: 0.875rem;">
                            <td colspan="3" style="text-align: right; padding-right: 1rem;">COMBINED TOTAL PER DAY →</td>
                            @foreach(range(1, 31) as $day)
                                <td>{{ isset($dailyTotals[$day]) ? $dailyTotals[$day] : '' }}</td>
                            @endforeach
                            <td colspan="3" style="text-align: center;">
                                TOTAL: {{ $totalStudents }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Legend -->
            <div class="legend-bar">
                <span class="legend-title">Legend:</span>
                <div class="legend-item">
                    <span class="legend-symbol status-present">✓</span>
                    <span>Present</span>
                </div>
                <div class="legend-item">
                    <span class="legend-symbol status-absent">A</span>
                    <span>Absent</span>
                </div>
                <div class="legend-item">
                    <span class="legend-symbol status-late">L</span>
                    <span>Late</span>
                </div>
                <div class="legend-item">
                    <span class="legend-symbol status-excused">E</span>
                    <span>Excused</span>
                </div>
                <div class="legend-item">
                    <span class="legend-symbol" style="background: #f1f5f9; color: #94a3b8;">-</span>
                    <span>No Record / Weekend</span>
                </div>
            </div>

            <!-- Summary Section -->
            <div class="summary-section">
                <!-- Summary Table 1 -->
                <div class="summary-card">
                    <div class="summary-title">SUMMARY FOR THE MONTH</div>
                    <table class="summary-table">
                        <tr>
                            <th style="text-align: left;">Description</th>
                            <th>M</th>
                            <th>F</th>
                            <th>Total</th>
                        </tr>
                        <tr>
                            <td>1. Enrolment as of 1st Friday of June</td>
                            <td>{{ $enrollmentAsOfFirstFriday }}</td>
                            <td>{{ $totalFemale }}</td>
                            <td>{{ $enrollmentAsOfFirstFriday }}</td>
                        </tr>
                        <tr>
                            <td>2. Late Enrolment during the month</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>3. Registered Learner as of end of the month</td>
                            <td>{{ $totalMale }}</td>
                            <td>{{ $totalFemale }}</td>
                            <td>{{ $registeredLearners }}</td>
                        </tr>
                        <tr>
                            <td>4. Percentage of Enrolment</td>
                            <td colspan="3">{{ $percentageEnrolment }}%</td>
                        </tr>
                        <tr>
                            <td>5. Average Daily Attendance</td>
                            <td colspan="3">{{ $averageDailyAttendance }}</td>
                        </tr>
                        <tr>
                            <td>6. Percentage of Attendance for the month</td>
                            <td colspan="3">{{ $percentageAttendance }}%</td>
                        </tr>
                        <tr class="alert-row">
                            <td colspan="4">
                                7. Number of students with 5+ consecutive absences: 
                                <strong style="font-size: 1.125rem;">{{ $studentsWith5ConsecutiveAbsences }}</strong>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Summary Table 2 -->
                <div class="summary-card">
                    <div class="summary-title">TRANSFERRED / DROPPED OUT</div>
                    <table class="summary-table">
                        <tr>
                            <th style="text-align: left;">Status</th>
                            <th>M</th>
                            <th>F</th>
                            <th>Total</th>
                        </tr>
                        <tr>
                            <td>8. Drop Out</td>
                            <td>{{ $dropoutsMale }}</td>
                            <td>{{ $dropoutsFemale }}</td>
                            <td>{{ $dropoutsMale + $dropoutsFemale }}</td>
                        </tr>
                        <tr>
                            <td>9. Transferred Out</td>
                            <td>{{ $transferredOutMale }}</td>
                            <td>{{ $transferredOutFemale }}</td>
                            <td>{{ $transferredOutMale + $transferredOutFemale }}</td>
                        </tr>
                        <tr>
                            <td>10. Transferred In</td>
                            <td>{{ $transferredInMale }}</td>
                            <td>{{ $transferredInFemale }}</td>
                            <td>{{ $transferredInMale + $transferredInFemale }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Signatures with Editable Names -->
            <div class="signatures">
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <input type="text" 
                           class="editable-input" 
                           value="{{ $section->teacher->full_name ?? $section->teacher->name ?? 'Teacher Name' }}" 
                           placeholder="Enter Teacher Name">
                    <div class="signature-title">Teacher / Adviser (Signature over Printed Name)</div>
                </div>
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <input type="text" 
                           class="editable-input" 
                           value="{{ $school->principal_name ?? $school->head_name ?? 'School Principal' }}" 
                           placeholder="Enter Principal Name">
                    <div class="signature-title">School Head (Signature over Printed Name)</div>
                </div>
            </div>

            <!-- Footer -->
            <div style="padding: 1rem; text-align: center; font-size: 0.75rem; color: var(--text-muted); border-top: 1px solid var(--border);">
                School Form 2 (SF2) - Page 1 of 1 | Generated on {{ now()->format('F d, Y h:i A') }} | System Version 2.0
            </div>
        </div>
    </div>

    <script>
        // Set current date
        document.getElementById('currentDate').textContent = new Date().toLocaleDateString('en-US', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
        });
        
        // Auto-save signature names to localStorage
        document.querySelectorAll('.editable-input').forEach(input => {
            input.addEventListener('change', function() {
                const key = 'sf2_signature_' + this.placeholder.replace(/\s+/g, '_').toLowerCase();
                localStorage.setItem(key, this.value);
            });
            
            const key = 'sf2_signature_' + input.placeholder.replace(/\s+/g, '_').toLowerCase();
            const saved = localStorage.getItem(key);
            if (saved && input.value === input.defaultValue) {
                input.value = saved;
            }
        });
    </script>
</body>
</html>