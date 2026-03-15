<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DepEd SF3 - Books Issued and Returned | {{ $student->last_name ?? 'Student' }}</title>
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
            .sf3-container { box-shadow: none; border: 1px solid #000; }
            .books-table th { background: #1e3a8a !important; -webkit-print-color-adjust: exact; }
            .status-issued { background: #dbeafe !important; }
            .status-returned { background: #d1fae5 !important; }
            .status-damaged { background: #fef3c7 !important; }
            .status-lost { background: #fee2e2 !important; }
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
        
        /* Control Bar */
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
        
        .student-info-bar {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .student-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
        }
        
        .student-details h3 {
            font-size: 1rem;
            font-weight: 600;
            margin: 0;
        }
        
        .student-details p {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin: 0;
        }
        
        /* Report Type Selector */
        .report-type-selector {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .report-type-selector select {
            padding: 0.5rem 1rem;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
            background: white;
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
        
        /* Export Button - Success color */
        .fab-export {
            background: linear-gradient(135deg, var(--success) 0%, #047857 100%);
            color: white;
        }
        
        .fab-export:hover {
            background: linear-gradient(135deg, #34d399 0%, var(--success) 100%);
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
            padding-bottom: 6rem;
        }
        
        /* SF3 Form Container */
        .sf3-container {
            background: var(--card);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        /* Official DepEd Header - Same as SF2 */
        .sf3-header {
            padding: 2rem;
            border-bottom: 3px double var(--primary);
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }
        
        .header-grid {
            display: grid;
            grid-template-columns: 1fr 2fr 1fr;
            gap: 2rem;
            margin-bottom: 1.5rem;
            align-items: center;
        }
        
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
        
        /* School info - 4 Column Layout */
        .school-info {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }
        
        /* Report Period Bar */
        .period-bar {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            padding: 1rem 2rem;
            background: #f0f9ff;
            border-bottom: 1px solid #bae6fd;
        }
        
        .period-box {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .period-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            background: #dbeafe;
            color: var(--primary);
        }
        
        .period-details h4 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary);
        }
        
        .period-details p {
            font-size: 0.75rem;
            color: var(--text-muted);
        }
        
        /* Stats Summary */
        .stats-bar {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            padding: 1rem 2rem;
            background: #f0fdf4;
            border-bottom: 1px solid #bbf7d0;
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
        
        .stat-icon.issued { background: #dbeafe; color: var(--primary); }
        .stat-icon.returned { background: #d1fae5; color: var(--success); }
        .stat-icon.pending { background: #fef3c7; color: var(--warning); }
        .stat-icon.lost { background: #fee2e2; color: var(--danger); }
        
        .stat-details h4 {
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .stat-details p {
            font-size: 0.75rem;
            color: var(--text-muted);
        }
        
        /* Books Table */
        .table-wrapper {
            overflow-x: auto;
            padding: 1rem;
        }
        
        .books-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.75rem;
        }
        
        .books-table th {
            background: var(--primary);
            color: white;
            padding: 0.75rem 0.5rem;
            text-align: center;
            font-weight: 600;
            border-right: 1px solid rgba(255,255,255,0.1);
        }
        
        .books-table th:first-child {
            border-radius: 8px 0 0 0;
        }
        
        .books-table th:last-child {
            border-radius: 0 8px 0 0;
            border-right: none;
        }
        
        .books-table td {
            padding: 0.5rem;
            text-align: center;
            border: 1px solid var(--border);
        }
        
        .books-table tr:nth-child(even) {
            background: #fafafa;
        }
        
        .books-table tr:hover {
            background: #f1f5f9;
        }
        
        /* Book Status Cells */
        .book-status {
            font-weight: 700;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            display: inline-block;
        }
        
        .status-issued { background: #dbeafe; color: var(--primary); }
        .status-returned { background: #d1fae5; color: var(--success); }
        .status-damaged { background: #fef3c7; color: var(--warning); }
        .status-lost { background: #fee2e2; color: var(--danger); }
        .status-pending { background: #f1f5f9; color: var(--text-muted); }
        
        /* Date Cells */
        .date-cell {
            font-family: monospace;
            font-size: 0.7rem;
            color: var(--text-muted);
        }
        
        /* Subject Area Badge */
        .subject-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.625rem;
            font-weight: 600;
            text-transform: uppercase;
            background: #e0e7ff;
            color: #3730a3;
        }
        
        /* Book Title Cell */
        .book-title {
            text-align: left !important;
            font-weight: 500;
            min-width: 250px;
        }
        
        .book-reference {
            font-size: 0.625rem;
            color: var(--text-muted);
            font-family: monospace;
        }
        
        /* Remarks/Action Taken */
        .remarks-cell {
            font-size: 0.7rem;
            max-width: 200px;
        }
        
        .action-code {
            display: inline-block;
            padding: 0.125rem 0.375rem;
            border-radius: 3px;
            font-size: 0.625rem;
            font-weight: 700;
            margin-right: 0.25rem;
        }
        
        .code-fm { background: #fef3c7; color: #92400e; } /* Force Majeure */
        .code-tdo { background: #e0e7ff; color: #3730a3; } /* Transferred/Dropout */
        .code-neg { background: #fee2e2; color: #991b1b; } /* Negligence */
        .code-lltr { background: #d1fae5; color: #065f46; } /* Letter from Learner */
        .code-tltr { background: #dbeafe; color: #1e40af; } /* Teacher Letter */
        .code-ptl { background: #fce7f3; color: #9d174d; } /* Paid by Learner */
        
        /* Totals Row */
        .totals-row {
            background: #f8fafc;
            font-weight: 700;
        }
        
        .totals-row td {
            border-top: 2px solid var(--primary);
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
            flex-wrap: wrap;
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
        
        /* Codes Reference */
        .codes-section {
            padding: 1.5rem 2rem;
            background: #fafafa;
            border-top: 1px solid var(--border);
        }
        
        .codes-title {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1rem;
            text-transform: uppercase;
        }
        
        .codes-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }
        
        .code-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
        }
        
        .code-label {
            font-weight: 700;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            min-width: 40px;
            text-align: center;
        }
        
        .code-desc {
            color: var(--text-muted);
        }
        
        /* Signatures */
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
        
        /* Book Condition Indicators */
        .condition-good { color: var(--success); }
        .condition-fair { color: var(--warning); }
        .condition-poor { color: var(--danger); }
    </style>
</head>
<body>

    <!-- Header -->
    <header class="app-header no-print">
        <div class="header-content">
            <div class="brand">
                <div class="logo-icon">📖</div>
                <div class="brand-text">
                    <h1>DepEd SF3 - Books Issued and Returned</h1>
                    <p>School Form 3 (SF3) - Individual Book Inventory Record</p>
                </div>
            </div>
            <div>
                <span id="currentDate"></span>
            </div>
        </div>
    </header>

    <!-- Control Bar -->
    <div class="control-bar no-print">
        <div class="control-content">
            <div class="student-info-bar">
                <div class="student-avatar">
                    {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                </div>
                <div class="student-details">
                    <h3>{{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name ? substr($student->middle_name, 0, 1) . '.' : '' }}</h3>
                    <p>LRN: {{ $student->lrn ?? 'N/A' }} | Grade {{ $student->section->year_level ?? '-' }} - {{ $student->section->name ?? '-' }}</p>
                </div>
            </div>
            
            <div class="report-type-selector">
                <label>📚 Report Type:</label>
                <form method="GET" style="display: flex; gap: 0.5rem;">
                    <select name="report_type" onchange="this.form.submit()">
                        <option value="bosy" {{ (request('report_type', 'bosy') == 'bosy') ? 'selected' : '' }}>Beginning of School Year (BoSY)</option>
                        <option value="eosy" {{ (request('report_type') == 'eosy') ? 'selected' : '' }}>End of School Year (EoSY)</option>
                    </select>
                </form>
            </div>
        </div>
    </div>

    <!-- Floating Action Buttons -->
    <div class="fab-container no-print">
        <a href="{{ route('teacher.dashboard', $student->section_id) }}" class="fab-button fab-back" title="Back to Dashboard">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            <span class="fab-tooltip">Back to Dashboard</span>
        </a>
        <a href="{{ route('sf3.export', $student) }}" class="fab-button fab-export" title="Download PDF">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
            <span class="fab-tooltip">Download PDF</span>
        </a>
        <button class="fab-button fab-print" onclick="window.print()" title="Print SF3">
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
            $reportType = request('report_type', 'bosy');
            
            // Get student's books
            $studentBooks = $student->books ?? collect([]);
            $bookCount = $studentBooks->count();
            
            // Calculate statistics
            $totalBooksIssued = $studentBooks->count();
            $totalBooksReturned = $studentBooks->where('status', 'returned')->count();
            $totalBooksPending = $studentBooks->where('status', 'issued')->count();
            $totalBooksLost = $studentBooks->where('status', 'lost')->count();
            $totalBooksDamaged = $studentBooks->where('condition', 'damaged')->where('status', 'returned')->count();
            
            // Get unique subject areas
            $subjectAreas = $studentBooks->pluck('subject_area')->filter()->unique()->sort();
            
            // Report period dates
            $bosyDate = isset($activeSchoolYear) && $activeSchoolYear ? $activeSchoolYear->start_date->format('F d, Y') : 'June 01, 2024';
            $eosyDate = isset($activeSchoolYear) && $activeSchoolYear ? $activeSchoolYear->end_date->format('F d, Y') : 'March 31, 2025';
            
            // School info
            $school = $student->section->school ?? null;
        @endphp

        <div class="sf3-container">
            
            <!-- SF3 Official Header -->
            <div class="sf3-header">
                <div class="header-grid">
                    <!-- Left: Logo + School Year -->
                    <div class="header-left-side">
                        <div class="header-logo-left">
                            <img src="{{ asset('images/logo1.png') }}" alt="DepEd Logo" class="header-logo-img" onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\'header-logo-placeholder\'>DepEd<br>Logo</div>';">
                        </div>
                        <div class="info-field" style="text-align: center;">
                            <label>School Year</label>
                            <div class="value">{{ isset($activeSchoolYear) && $activeSchoolYear ? $activeSchoolYear->name : '2024-2025' }}</div>
                        </div>
                    </div>
                    
                    <!-- Center: Republic/DepEd text -->
                    <div class="header-center">
                        <h2>Republic of the Philippines</h2>
                        <h2>Department of Education</h2>
                        <h1>Books Issued and Returned</h1>
                        <p>(Individual Student Book Inventory Record)</p>
                    </div>
                    
                    <!-- Right: Logo + School ID -->
                    <div class="header-right-side">
                        <div class="header-logo-right">
                            <img src="{{ asset('images/logo.png') }}" alt="School Seal" class="header-logo-img" onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\'header-logo-placeholder\'>School<br>Seal</div>';">
                        </div>
                        <div class="info-field" style="text-align: center;">
                            <label>School ID</label>
                            <div class="value">{{ isset($school) && $school ? $school->school_id : '120231' }}</div>
                        </div>
                    </div>
                </div>
                
                <!-- School info - 4 Column Layout -->
                <div class="school-info">
                    <div class="info-field">
                        <label>Name of School</label>
                        <div class="value">{{ isset($school) && $school ? $school->name : 'Tugawe Elementary School' }}</div>
                    </div>
                    <div class="info-field">
                        <label>Grade Level</label>
                        <div class="value">{{ $student->section->year_level ?? '-' }}</div>
                    </div>
                    <div class="info-field">
                        <label>Section</label>
                        <div class="value">{{ $student->section->name ?? '-' }}</div>
                    </div>
                    <div class="info-field">
                        <label>Report Period</label>
                        <div class="value">{{ $reportType == 'bosy' ? 'Beginning of School Year' : 'End of School Year' }}</div>
                    </div>
                </div>
            </div>

            <!-- Report Period Bar -->
            <div class="period-bar">
                <div class="period-box">
                    <div class="period-icon">📅</div>
                    <div class="period-details">
                        <h4>{{ $reportType == 'bosy' ? $bosyDate : $eosyDate }}</h4>
                        <p>{{ $reportType == 'bosy' ? 'Date of Book Issuance (BoSY)' : 'Date of Book Return (EoSY)' }}</p>
                    </div>
                </div>
                <div class="period-box">
                    <div class="period-icon">👤</div>
                    <div class="period-details">
                        <h4>{{ $student->last_name }}, {{ $student->first_name }}</h4>
                        <p>LRN: {{ $student->lrn ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="stats-bar">
                <div class="stat-box">
                    <div class="stat-icon issued">📚</div>
                    <div class="stat-details">
                        <h4>{{ $totalBooksIssued }}</h4>
                        <p>Total Books Issued</p>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon returned">✓</div>
                    <div class="stat-details">
                        <h4>{{ $totalBooksReturned }}</h4>
                        <p>Books Returned</p>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon pending">⏳</div>
                    <div class="stat-details">
                        <h4>{{ $totalBooksPending }}</h4>
                        <p>Pending Return</p>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon lost">⚠</div>
                    <div class="stat-details">
                        <h4>{{ $totalBooksLost + $totalBooksDamaged }}</h4>
                        <p>Lost/Damaged</p>
                    </div>
                </div>
            </div>

            <!-- Books Table -->
            <div class="table-wrapper">
                @if($bookCount > 0)
                    <table class="books-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th style="min-width: 250px;">Title of Book & Subject Area</th>
                                <th>Book Code</th>
                                <th>Date Issued</th>
                                <th>Date Returned</th>
                                <th>Status</th>
                                <th>Condition</th>
                                <th style="min-width: 200px;">Remarks / Action Taken</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($studentBooks as $index => $book)
                                <tr>
                                    <td class="row-num">{{ $index + 1 }}</td>
                                    <td class="book-title">
                                        <span class="subject-badge">{{ $book->subject_area ?? 'General' }}</span>
                                        <div style="margin-top: 0.25rem;">{{ $book->title ?? 'Untitled Book' }}</div>
                                    </td>
                                    <td class="book-reference">{{ $book->reference_code ?? $book->book_code ?? '-' }}</td>
                                    <td class="date-cell">{{ $book->date_issued ? date('m/d/Y', strtotime($book->date_issued)) : '-' }}</td>
                                    <td class="date-cell">
                                        @if($book->status == 'lost')
                                            <span class="book-status status-lost">LOST</span>
                                        @elseif($book->status == 'returned' && $book->date_returned)
                                            {{ date('m/d/Y', strtotime($book->date_returned)) }}
                                        @else
                                            <span class="book-status status-pending">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($book->status == 'issued')
                                            <span class="book-status status-issued">ISSUED</span>
                                        @elseif($book->status == 'returned')
                                            <span class="book-status status-returned">RETURNED</span>
                                        @elseif($book->status == 'lost')
                                            <span class="book-status status-lost">LOST</span>
                                        @else
                                            <span class="book-status status-pending">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($book->condition == 'good' || $book->condition == 'new')
                                            <span class="condition-good">✓ Good</span>
                                        @elseif($book->condition == 'fair')
                                            <span class="condition-fair">~ Fair</span>
                                        @elseif($book->condition == 'damaged' || $book->condition == 'poor')
                                            <span class="condition-poor">✗ Damaged</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="remarks-cell">
                                        @if($book->status == 'lost')
                                            @if($book->loss_code == 'FM')
                                                <span class="action-code code-fm">FM</span> Force Majeure
                                            @elseif($book->loss_code == 'TDO')
                                                <span class="action-code code-tdo">TDO</span> Transferred/Dropout
                                            @elseif($book->loss_code == 'NEG')
                                                <span class="action-code code-neg">NEG</span> Negligence
                                            @endif
                                            @if($book->action_taken == 'LLTR')
                                                <br><span class="action-code code-lltr">LLTR</span> Letter from Learner
                                            @elseif($book->action_taken == 'TLTR')
                                                <br><span class="action-code code-tltr">TLTR</span> Teacher Report
                                            @elseif($book->action_taken == 'PTL')
                                                <br><span class="action-code code-ptl">PTL</span> Paid
                                            @endif
                                        @elseif($book->condition == 'damaged' || $book->condition == 'poor')
                                            <span class="action-code code-neg">DMG</span> {{ $book->damage_details ?? 'Damaged' }}
                                        @else
                                            {{ $book->remarks ?? '-' }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            
                            <!-- TOTAL ROW -->
                            <tr class="totals-row" style="background: #e2e8f0; font-size: 0.875rem;">
                                <td colspan="2" style="text-align: right; padding-right: 1rem;">TOTAL →</td>
                                <td>{{ $totalBooksIssued }} books</td>
                                <td>-</td>
                                <td>{{ $totalBooksReturned }} returned</td>
                                <td>{{ $totalBooksPending }} pending</td>
                                <td>{{ $totalBooksLost + $totalBooksDamaged }} lost/damaged</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">📚</div>
                        <h3>No Books Recorded</h3>
                        <p>This student has no book issuance records yet.</p>
                    </div>
                @endif
            </div>

            <!-- Legend -->
            <div class="legend-bar">
                <span class="legend-title">Status:</span>
                <div class="legend-item">
                    <span class="legend-symbol status-issued">I</span>
                    <span>Issued</span>
                </div>
                <div class="legend-item">
                    <span class="legend-symbol status-returned">R</span>
                    <span>Returned</span>
                </div>
                <div class="legend-item">
                    <span class="legend-symbol status-lost">L</span>
                    <span>Lost</span>
                </div>
                <div class="legend-item">
                    <span class="legend-symbol status-damaged">D</span>
                    <span>Damaged</span>
                </div>
            </div>

            <!-- Codes Reference Section -->
            <div class="codes-section">
                <div class="codes-title">Reference Codes for Lost/Unreturned Books</div>
                <div class="codes-grid">
                    <div class="code-item">
                        <span class="action-code code-fm">FM</span>
                        <span class="code-desc"><strong>Force Majeure</strong> - Natural disasters, calamities</span>
                    </div>
                    <div class="code-item">
                        <span class="action-code code-tdo">TDO</span>
                        <span class="code-desc"><strong>Transferred/Dropout</strong> - Student moved out</span>
                    </div>
                    <div class="code-item">
                        <span class="action-code code-neg">NEG</span>
                        <span class="code-desc"><strong>Negligence</strong> - Carelessness, misuse</span>
                    </div>
                    <div class="code-item">
                        <span class="action-code code-lltr">LLTR</span>
                        <span class="code-desc"><strong>Letter from Learner</strong> - Signed by parent/guardian (for FM)</span>
                    </div>
                    <div class="code-item">
                        <span class="action-code code-tltr">TLTR</span>
                        <span class="code-desc"><strong>Teacher Letter</strong> - Report to School Head (for TDO)</span>
                    </div>
                    <div class="code-item">
                        <span class="action-code code-ptl">PTL</span>
                        <span class="code-desc"><strong>Paid by Learner</strong> - Replacement cost paid (for NEG)</span>
                    </div>
                </div>
            </div>

            <!-- Signatures with Editable Names -->
            <div class="signatures">
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <input type="text" 
                           class="editable-input" 
                           value="{{ $student->section->teacher->full_name ?? $student->section->teacher->name ?? 'Teacher Name' }}" 
                           placeholder="Enter Teacher Name">
                    <div class="signature-title">Class Adviser (Signature over Printed Name)</div>
                    <div style="font-size: 0.625rem; color: var(--text-muted); margin-top: 0.25rem;">
                        Date: {{ $reportType == 'bosy' ? $bosyDate : $eosyDate }}
                    </div>
                </div>
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <input type="text" 
                           class="editable-input" 
                           value="{{ isset($school) && $school ? ($school->principal_name ?? $school->head_name) : 'School Principal' }}" 
                           placeholder="Enter Principal Name">
                    <div class="signature-title">School Head (Signature over Printed Name)</div>
                    <div style="font-size: 0.625rem; color: var(--text-muted); margin-top: 0.25rem;">
                        Date: {{ $reportType == 'bosy' ? $bosyDate : $eosyDate }}
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div style="padding: 1rem; text-align: center; font-size: 0.75rem; color: var(--text-muted); border-top: 1px solid var(--border);">
                School Form 3 (SF3) - Page 1 of 1 | Generated on {{ now()->format('F d, Y h:i A') }} | 
                {{ $reportType == 'bosy' ? 'Beginning of School Year' : 'End of School Year' }} Report | 
                Student: {{ $student->last_name }}, {{ $student->first_name }}
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
                const key = 'sf3_signature_' + this.placeholder.replace(/\s+/g, '_').toLowerCase();
                localStorage.setItem(key, this.value);
            });
            
            const key = 'sf3_signature_' + input.placeholder.replace(/\s+/g, '_').toLowerCase();
            const saved = localStorage.getItem(key);
            if (saved && input.value === input.defaultValue) {
                input.value = saved;
            }
        });
    </script>
</body>
</html>