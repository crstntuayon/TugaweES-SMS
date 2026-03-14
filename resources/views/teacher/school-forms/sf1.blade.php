<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SF1 - School Register (Landscape)</title>
    @vite(['resources/css/app.css'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Arial:wght@400;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 9pt;
            line-height: 1.2;
            background: #f3f4f6;
        }
        
        @media print {
            @page {
                size: landscape;
                margin: 0;
            }
            
            body { 
                background: white; 
                padding: 0;
                margin: 0;
            }
            
            .sf1-wrapper {
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            
            .sf1-container {
                box-shadow: none;
                border: 1.5pt solid black;
                width: 100% !important;
                max-width: 100% !important;
                height: 100vh !important;
                padding: 8mm !important;
                margin: 0 !important;
            }
            
            .no-print { 
                display: none !important; 
            }
            
            .top-controls {
                display: none !important;
            }

            .edit-indicator {
                display: none !important;
            }

            .editable-field {
                background: transparent !important;
                border: none !important;
                padding: 0 !important;
            }

            .gender-header {
                background: #e5e7eb !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .auto-calculated {
                background: transparent !important;
            }
        }

        /* Top Controls Bar */
        .top-controls {
            background: white;
            padding: 12px 20px;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            margin-bottom: 20px;
        }

        .controls-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .controls-right {
            display: flex;
            gap: 10px;
        }

        .page-title {
            font-size: 14pt;
            font-weight: bold;
            color: #1f2937;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 9pt;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }
        
        .btn-primary {
            background: #2563eb;
            color: white;
        }
        
        .btn-primary:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }
        
        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
        }
        
        .btn-secondary:hover {
            background: #e5e7eb;
        }
        
        .btn-success {
            background: #059669;
            color: white;
        }
        
        .btn-success:hover {
            background: #047857;
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .sf1-wrapper {
            width: 297mm;
            max-width: 100%;
            margin: 0 auto 20px;
            background: white;
            padding: 0 20px;
        }

        .sf1-container {
            border: 1.5pt solid black;
            background: white;
            padding: 10px;
            min-height: 210mm;
            position: relative;
        }
        
        table { 
            border-collapse: collapse; 
            width: 100%;
        }
        
        td, th { 
            border: 1pt solid black; 
            padding: 3px 4px;
            vertical-align: middle;
        }
        
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }
        
        /* Header specific styles */
        .official-header {
            text-align: center;
            margin-bottom: 6px;
        }
        
        .official-header .govt-name {
            font-size: 10pt;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .official-header .dept-name {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 2px;
        }
        
        .official-header .form-title {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 4px;
        }
        
        .official-header .form-number {
            font-size: 9pt;
            margin-top: 2px;
        }
        
        .logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }

        /* Compact sections for landscape */
        .compact-section {
            margin-bottom: 6px;
            position: relative;
        }
        
        .section-title {
            font-size: 8pt;
            font-weight: bold;
            margin-bottom: 3px;
            text-transform: uppercase;
            background: #e5e7eb;
            padding: 3px 6px;
            border-left: 3px solid #2563eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Edit mode styles */
        .edit-mode .editable-field {
            background: #fef3c7;
            border-bottom: 1px dashed #f59e0b;
            cursor: text;
            padding: 1px 3px;
            min-height: 16px;
            display: inline-block;
        }

        .edit-mode .editable-field[contenteditable="true"]:focus {
            outline: 2px solid #f59e0b;
            background: white;
        }

        .edit-indicator {
            display: none;
            font-size: 7pt;
            color: #f59e0b;
            font-weight: normal;
            margin-left: 10px;
        }

        .edit-mode .edit-indicator {
            display: inline;
        }

        /* Students table - READ ONLY */
        .students-table {
            font-size: 7.5pt;
        }
        
        .students-table th {
            background: #f3f4f6;
            font-weight: bold;
            font-size: 7pt;
            padding: 4px 2px;
            text-align: center;
            vertical-align: middle;
        }
        
        .students-table td {
            padding: 3px 4px;
            vertical-align: middle;
            background: white !important;
        }
        
        .students-table tr:nth-child(even) {
            background: #fafafa;
        }

        .students-table tr:hover {
            background: #f3f4f6;
        }

        /* Gender separator rows */
        .gender-header {
            background: #e5e7eb !important;
            font-weight: bold;
            font-size: 8pt;
            text-align: center;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .gender-header td {
            background: #e5e7eb !important;
            border-top: 2pt solid #000 !important;
            border-bottom: 2pt solid #000 !important;
        }

        .male-section {
            border-left: 3px solid #2563eb;
        }

        .female-section {
            border-left: 3px solid #db2777;
        }

        /* Data display styling */
        .data-field {
            display: inline-block;
            min-height: 14px;
        }

        .data-number {
            text-align: center;
            font-weight: 500;
        }

        .data-text {
            text-align: left;
        }

        /* Auto-calculated fields */
        .auto-calculated {
            background: #d1fae5;
            color: #059669;
            font-weight: bold;
            padding: 1px 4px;
            border-radius: 3px;
        }

        .edit-mode .auto-calculated {
            background: #d1fae5 !important;
            border-bottom: 1px dashed #059669;
        }

        /* Default value styling */
        .default-value {
            color: #6b7280;
            font-style: italic;
        }

        .edit-mode .default-value {
            color: #f59e0b;
            font-style: normal;
        }

        /* Summary section */
        .summary-box {
            background: #f9fafb;
            border: 1pt solid black;
            padding: 6px;
            margin-top: 6px;
            font-size: 9pt;
        }

        /* Certification section */
        .certification-box {
            border: 1pt solid black;
            padding: 8px;
            margin-top: 8px;
            font-size: 8pt;
        }

        .signature-line {
            border-top: 1pt solid black;
            width: 200px;
            margin: 0 auto;
            padding-top: 3px;
            text-align: center;
            min-height: 20px;
        }

        /* Footer */
        .document-footer {
            margin-top: 8px;
            padding-top: 4px;
            border-top: 1pt solid #d1d5db;
            font-size: 7pt;
            color: #6b7280;
            display: flex;
            justify-content: space-between;
        }

        /* Status badges */
        .badge {
            display: inline-block;
            padding: 1px 4px;
            border-radius: 3px;
            font-size: 7pt;
            font-weight: bold;
        }

        .badge-male {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-female {
            background: #fce7f3;
            color: #be185d;
        }

        /* Print info display */
        .print-info {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: white;
            padding: 10px 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            font-size: 9pt;
            z-index: 1000;
            max-width: 200px;
        }

        /* Two column layout for certification */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* Column widths for landscape optimization */
        .col-no { width: 2%; }
        .col-lrn { width: 9%; }
        .col-name { width: 16%; }
        .col-grade { width: 5%; }
        .col-section { width: 6%; }
        .col-birth { width: 7%; }
        .col-age { width: 4%; }
        .col-tongue { width: 7%; }
        .col-ip { width: 7%; }
        .col-religion { width: 7%; }
        .col-address { width: 10%; }
        .col-brgy { width: 7%; }
        .col-city { width: 7%; }
        .col-province { width: 7%; }

        /* Row number styling */
        .row-number {
            text-align: center;
            font-weight: 600;
            color: #4b5563;
        }

        /* Non-editable notice for student table */
        .readonly-notice {
            font-size: 7pt;
            color: #6b7280;
            font-weight: normal;
            font-style: italic;
        }

        .edit-mode .readonly-notice {
            color: #dc2626;
            font-weight: bold;
        }

        /* Student count summary in table */
        .count-summary {
            background: #f3f4f6;
            font-weight: bold;
            font-size: 7.5pt;
            text-align: right;
            padding-right: 10px;
        }
    </style>
</head>
<body>

<!-- Top Controls Bar -->
<div class="top-controls no-print">
    <div class="controls-left">
        <div class="page-title">SF1 - School Register</div>
        <span style="color: #6b7280; font-size: 9pt;">|</span>
        <span style="color: #6b7280; font-size: 9pt;">{{ $section->year_level ?? 'Grade Level' }} - {{ $section->name ?? 'Section' }}</span>
        <span style="color: #6b7280; font-size: 9pt;">|</span>
        <span style="color: #6b7280; font-size: 9pt;">SY {{ $activeSchoolYear->name ?? '2025-2026' }}</span>
    </div>
    
    <div class="controls-right">
        <button onclick="toggleEditMode()" class="btn btn-warning" id="editBtn">
            <span>✏️</span> <span id="editBtnText">Edit</span>
        </button>
        
        <button onclick="window.print()" class="btn btn-primary">
            <span>🖨️</span> Print
        </button>
        
        <button onclick="exportToExcel()" class="btn btn-success">
            <span>📊</span> Export
        </button>
        
        <a href="{{ route('teacher.dashboard') }}" class="btn btn-secondary">
            <span>←</span> Back
        </a>
    </div>
</div>

<!-- Print Info -->
<div class="print-info no-print">
    <div style="font-weight: bold; color: #374151; margin-bottom: 4px;">Print Settings</div>
    <div style="font-size: 8pt; color: #6b7280;">
        Orientation: <span style="color: #059669; font-weight: bold;">Landscape</span><br>
        Paper: A4 or Letter<br>
        <span id="editStatus">View Mode</span>
    </div>
</div>

<div class="sf1-wrapper" id="sf1Wrapper">
    <div class="sf1-container">
        
        <!-- HEADER WITH DUAL SCHOOL LOGOS LEFT, DEPED LOGO RIGHT -->
        <div class="official-header">
            <table style="border: none; width: 100%; margin-bottom: 4px;">
                <tr style="border: none;">
                    <!-- LEFT SIDE: Dual School Logos -->
                    <td style="border: none; width: 20%; text-align: right; vertical-align: middle; padding-right: 8px;">
                        <div style="display: inline-flex; align-items: center; gap: 5px;">
                            <img src="{{ asset('images/logo1.png') }}" 
                                 onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2260%22 height=%2260%22><rect fill=%22%23006633%22 width=%2260%22 height=%2260%22 rx=%2230%22/><text fill=%22white%22 x=%2230%22 y=%2235%22 text-anchor=%22middle%22 font-size=%2210%22 font-weight=%22bold%22>LOGO1</text></svg>'"
                                 class="logo" alt="School Logo 1" style="display: inline-block; width: 60px; height: 60px;">
                            <img src="{{ asset('images/logo.png') }}" 
                                 onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2260%22 height=%2260%22><rect fill=%22%23008000%22 width=%2260%22 height=%2260%22 rx=%2230%22/><text fill=%22white%22 x=%2230%22 y=%2235%22 text-anchor=%22middle%22 font-size=%2210%22 font-weight=%22bold%22>LOGO2</text></svg>'"
                                 class="logo" alt="School Logo 2" style="display: inline-block; width: 60px; height: 60px;">
                        </div>
                    </td>
                    
                    <!-- CENTER: Text -->
                    <td style="border: none; width: 60%; text-align: center; vertical-align: middle;">
                        <p class="govt-name">Republic of the Philippines</p>
                        <p class="dept-name">Department of Education</p>
                        <div class="form-title">School Form 1 (SF1)</div>
                        <div class="form-number">School Register</div>
                        <div style="font-size: 7pt; color: #666; margin-top: 2px;">(This replaces Form 1, Master List of Students)</div>
                    </td>
                    
                    <!-- RIGHT SIDE: DepEd Logo -->
                    <td style="border: none; width: 20%; text-align: left; vertical-align: middle; padding-left: 8px;">
                        <div style="display: inline-flex; align-items: center; gap: 5px;">
                            <img src="{{ asset('images/DepEd.jpg') }}" 
                                 onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2265%22 height=%2265%22><circle fill=%22%23003366%22 cx=%2232.5%22 cy=%2232.5%22 r=%2232.5%22/><text fill=%22white%22 x=%2232.5%22 y=%2238%22 text-anchor=%22middle%22 font-size=%2212%22 font-weight=%22bold%22>DepEd</text></svg>'"
                                 class="logo" alt="DepEd Logo" style="display: inline-block; width: 65px; height: 65px;">
                            <img src="{{ asset('images/Bagong Pilipinas.jpg') }}" 
                                 onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2250%22 height=%2250%22><circle fill=%22%23003366%22 cx=%2225%22 cy=%2225%22 r=%2225%22/><text fill=%22white%22 x=%2225%22 y=%2230%22 text-anchor=%22middle%22 font-size=%229%22 font-weight=%22bold%22>BP</text></svg>'"
                                 class="logo" alt="Bagong Pilipinas Logo" style="display: inline-block; width: 50px; height: 50px;">
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- SCHOOL INFORMATION - EDITABLE -->
        <div class="compact-section">
            <div class="section-title">
                <span>School Information</span>
                <span class="edit-indicator">✏️ Click fields to edit</span>
            </div>
            <table style="font-size: 8pt;">
                <tr>
                    <td style="width: 12%; font-weight: bold; background: #f9fafb;">School ID</td>
                    <td style="width: 15%;">
                        <span class="editable-field" data-field="school_id">{{ $school->school_id ?? '__________' }}</span>
                    </td>
                    <td style="width: 12%; font-weight: bold; background: #f9fafb;">Region</td>
                    <td style="width: 20%;">
                        <span class="editable-field" data-field="region">{{ $school->region ?? 'NIR - Negros Island Region' }}</span>
                    </td>
                    <td style="width: 12%; font-weight: bold; background: #f9fafb;">Division</td>
                    <td style="width: 29%;">
                        <span class="editable-field" data-field="division">{{ $school->division ?? 'Division of Negros Oriental' }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f9fafb;">School Name</td>
                    <td colspan="3">
                        <span class="editable-field font-bold" data-field="school_name">{{ $school->name ?? 'Tugawe Elementary School' }}</span>
                    </td>
                    <td style="font-weight: bold; background: #f9fafb;">District</td>
                    <td>
                        <span class="editable-field" data-field="district">{{ $school->district ?? 'Dauin District' }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background: #f9fafb;">School Year</td>
                    <td>
                        <span class="editable-field font-bold" data-field="school_year">{{ $activeSchoolYear->name ?? '2025-2026' }}</span>
                    </td>
                    <td style="font-weight: bold; background: #f9fafb;">Grade Level</td>
                    <td>
                        <span class="editable-field font-bold" data-field="grade_level">{{ $section->year_level ?? '__________' }}</span>
                    </td>
                    <td style="font-weight: bold; background: #f9fafb;">Section</td>
                    <td>
                        <span class="editable-field font-bold" data-field="section">{{ $section->name ?? '__________' }}</span>
                    </td>
                </tr>
            </table>
        </div>

        <!-- ADVISER INFORMATION - EDITABLE -->
        <div class="compact-section">
            <div class="section-title">
                <span>Adviser Information</span>
                <span class="edit-indicator">✏️ Click fields to edit</span>
            </div>
            <table style="font-size: 8pt;">
                <tr>
                    <td style="width: 15%; font-weight: bold; background: #f9fafb;">Name of Adviser</td>
                    <td style="width: 50%;">
                        <span class="editable-field font-bold uppercase" data-field="adviser_name">{{ $adviser ?? auth()->user()->full_name ?? '____________________' }}</span>
                    </td>
                    <td style="width: 15%; font-weight: bold; background: #f9fafb;">Date Generated</td>
                    <td style="width: 20%;">
                        <span class="editable-field" data-field="date_generated">{{ now()->format('F d, Y') }}</span>
                    </td>
                </tr>
            </table>
        </div>

        <!-- STUDENT REGISTER TABLE - FULL LIST BY GENDER -->
        <div class="compact-section">
            <div class="section-title">
                <span>Student Register</span>
                <span class="readonly-notice">🔒 Male ({{ $maleStudents->count() ?? 0 }}) | Female ({{ $femaleStudents->count() ?? 0 }}) | Total ({{ ($maleStudents->count() ?? 0) + ($femaleStudents->count() ?? 0) }})</span>
            </div>
            
            <table class="students-table" id="studentTable">
                <thead>
                    <tr>
                        <th class="col-no">No.</th>
                        <th class="col-lrn">LRN</th>
                        <th class="col-name">Learner's Name</th>
                    
                        <th class="col-birth">Birthday<br>(mm/dd/yyyy)</th>
                        <th class="col-age">Age</th>
                        <th class="col-tongue">Mother<br>Tongue</th>
                        <th class="col-ip">Ethnic<br>Group</th>
                        <th class="col-religion">Religion</th>
                        <th class="col-address">Address</th>
                        <th class="col-brgy">Barangay</th>
                        <th class="col-city">Municipality</th>
                        <th class="col-province">Province</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $counter = 1;
                        $maleCount = 0;
                        $femaleCount = 0;
                        
                        // Sort students by gender and alphabetically by last name
                        $maleStudents = ($students ?? collect())->where('sex', 'Male')->sortBy('last_name');
                        $femaleStudents = ($students ?? collect())->where('sex', 'Female')->sortBy('last_name');
                        
                        // Calculate age as of first Friday of June
                        $currentYear = date('Y');
                        $juneFirstFriday = new DateTime("first friday of June $currentYear");
                        $referenceDate = $juneFirstFriday->format('Y-m-d');
                    @endphp
                    
                    {{-- MALE STUDENTS SECTION --}}
                    @if($maleStudents->count() > 0)
                        <tr class="gender-header">
                            <td colspan="14" style="background: #dbeafe; color: #1e40af; border-left: 3px solid #2563eb;">
                                MALE STUDENTS ({{ $maleStudents->count() }})
                            </td>
                        </tr>
                        
                        @foreach($maleStudents as $student)
                            @php 
                                $maleCount++;
                                
                                // Calculate age as of first Friday of June
                                $birthDate = $student->birthday ? new DateTime($student->birthday) : null;
                                $age = '';
                                if ($birthDate) {
                                    $refDate = new DateTime($referenceDate);
                                    $interval = $refDate->diff($birthDate);
                                    $age = $interval->y;
                                }
                                
                                // Default values
                                $motherTongue = $student->mother_tongue ?? 'Bisaya';
                                $ethnicGroup = $student->ip_ethnic_group ?? 'Negrense';
                                $religion = $student->religion ?? 'Roman Catholic';
                            @endphp
                            <tr data-student-id="{{ $student->id }}" class="male-section">
                                <td class="row-number">{{ $counter++ }}</td>
                                <td class="data-text" style="font-family: monospace; font-size: 7.5pt;">{{ $student->lrn ?? '' }}</td>
                                <td class="data-text uppercase" style="font-weight: 500;">
                                    {{ strtoupper($student->last_name . ', ' . $student->first_name . ' ' . ($student->middle_name ? substr($student->middle_name, 0, 1) . '.' : '')) }}
                                    {{ $student->suffix ? ' ' . $student->suffix : '' }}
                                </td>
                               
                                <td class="text-center">
                                    {{ $student->birthday ? date('m/d/Y', strtotime($student->birthday)) : '' }}
                                </td>
                                <td class="text-center auto-calculated" style="font-weight: 600;">
                                    {{ $age }}
                                </td>
                                <td class="data-text editable-field default-value" data-field="mother_tongue_{{ $student->id }}">{{ $motherTongue }}</td>
                                <td class="data-text editable-field default-value" data-field="ethnic_group_{{ $student->id }}">{{ $ethnicGroup }}</td>
                                <td class="data-text editable-field default-value" data-field="religion_{{ $student->id }}">{{ $religion }}</td>
                                <td class="data-text">{{ $student->house_no_street ?? '' }}</td>
                                <td class="data-text">{{ $student->barangay ?? '' }}</td>
                                <td class="data-text">{{ $student->municipality ?? '' }}</td>
                                <td class="data-text">{{ $student->province ?? '' }}</td>
                            </tr>
                        @endforeach
                        
                        <tr>
                            <td colspan="14" class="count-summary" style="background: #eff6ff;">
                                Male Subtotal: {{ $maleStudents->count() }} students
                            </td>
                        </tr>
                    @endif
                    
                    {{-- FEMALE STUDENTS SECTION --}}
                    @if($femaleStudents->count() > 0)
                        <tr class="gender-header">
                            <td colspan="14" style="background: #fce7f3; color: #be185d; border-left: 3px solid #db2777;">
                                FEMALE STUDENTS ({{ $femaleStudents->count() }})
                            </td>
                        </tr>
                        
                        @foreach($femaleStudents as $student)
                            @php 
                                $femaleCount++;
                                
                                // Calculate age as of first Friday of June
                                $birthDate = $student->birthday ? new DateTime($student->birthday) : null;
                                $age = '';
                                if ($birthDate) {
                                    $refDate = new DateTime($referenceDate);
                                    $interval = $refDate->diff($birthDate);
                                    $age = $interval->y;
                                }
                                
                                // Default values
                                $motherTongue = $student->mother_tongue ?? 'Bisaya';
                                $ethnicGroup = $student->ip_ethnic_group ?? 'Negrense';
                                $religion = $student->religion ?? 'Roman Catholic';
                            @endphp
                            <tr data-student-id="{{ $student->id }}" class="female-section">
                                <td class="row-number">{{ $counter++ }}</td>
                                <td class="data-text" style="font-family: monospace; font-size: 7.5pt;">{{ $student->lrn ?? '' }}</td>
                                <td class="data-text uppercase" style="font-weight: 500;">
                                    {{ strtoupper($student->last_name . ', ' . $student->first_name . ' ' . ($student->middle_name ? substr($student->middle_name, 0, 1) . '.' : '')) }}
                                    {{ $student->suffix ? ' ' . $student->suffix : '' }}
                                </td>
                               
                                <td class="text-center">
                                    {{ $student->birthday ? date('m/d/Y', strtotime($student->birthday)) : '' }}
                                </td>
                                <td class="text-center auto-calculated" style="font-weight: 600;">
                                    {{ $age }}
                                </td>
                                <td class="data-text editable-field default-value" data-field="mother_tongue_{{ $student->id }}">{{ $motherTongue }}</td>
                                <td class="data-text editable-field default-value" data-field="ethnic_group_{{ $student->id }}">{{ $ethnicGroup }}</td>
                                <td class="data-text editable-field default-value" data-field="religion_{{ $student->id }}">{{ $religion }}</td>
                                <td class="data-text">{{ $student->house_no_street ?? '' }}</td>
                                <td class="data-text">{{ $student->barangay ?? '' }}</td>
                                <td class="data-text">{{ $student->municipality ?? '' }}</td>
                                <td class="data-text">{{ $student->province ?? '' }}</td>
                            </tr>
                        @endforeach
                        
                        <tr>
                            <td colspan="14" class="count-summary" style="background: #fdf2f8;">
                                Female Subtotal: {{ $femaleStudents->count() }} students
                            </td>
                        </tr>
                    @endif
                    
                    {{-- NO STUDENTS MESSAGE --}}
                    @if(($maleStudents->count() + $femaleStudents->count()) == 0)
                        <tr>
                            <td colspan="14" style="text-align: center; padding: 20px; color: #6b7280; font-style: italic;">
                                No students enrolled in this section.
                            </td>
                        </tr>
                        
                        @for($i = 1; $i <= 20; $i++)
                        <tr style="height: 18px;">
                            <td class="row-number">{{ $i }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endfor
                    @endif
                    
                    {{-- GRAND TOTAL ROW --}}
                    @if(($maleStudents->count() + $femaleStudents->count()) > 0)
                        <tr style="background: #f3f4f6; font-weight: bold; border-top: 2pt solid black;">
                            <td colspan="14" class="count-summary" style="text-align: center; font-size: 8pt; padding: 5px;">
                                TOTAL ENROLLMENT: {{ $maleStudents->count() }} Male + {{ $femaleStudents->count() }} Female = {{ $maleStudents->count() + $femaleStudents->count() }} Students
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- ENROLLMENT SUMMARY - AUTO CALCULATED -->
        <div class="summary-box">
            <div class="section-title" style="margin-bottom: 5px;">
                <span>Enrollment Summary</span>
                <span class="edit-indicator">✏️ Click numbers to edit if needed</span>
            </div>
            <table style="border: none; width: auto;">
                <tr style="border: none;">
                    <td style="border: none; font-weight: bold; padding-right: 20px;">MALE:</td>
                    <td style="border: none; border-bottom: 1pt solid black; width: 50px; text-align: center; font-weight: bold; color: #1e40af;">
                        <span class="editable-field auto-calculated" data-field="male_count" id="maleCountDisplay">{{ $maleCount }}</span>
                    </td>
                    <td style="border: none; width: 30px;"></td>
                    <td style="border: none; font-weight: bold; padding-right: 20px;">FEMALE:</td>
                    <td style="border: none; border-bottom: 1pt solid black; width: 50px; text-align: center; font-weight: bold; color: #be185d;">
                        <span class="editable-field auto-calculated" data-field="female_count" id="femaleCountDisplay">{{ $femaleCount }}</span>
                    </td>
                    <td style="border: none; width: 30px;"></td>
                    <td style="border: none; font-weight: bold; padding-right: 20px;">TOTAL:</td>
                    <td style="border: none; border-bottom: 1pt solid black; width: 50px; text-align: center; font-weight: bold; color: #059669;">
                        <span class="editable-field auto-calculated" data-field="total_count" id="totalCountDisplay">{{ $maleCount + $femaleCount }}</span>
                    </td>
                </tr>
            </table>
        </div>

        <!-- CERTIFICATION - EDITABLE -->
        <div class="certification-box">
            <div class="section-title" style="background: transparent; border-left: none; padding: 0; margin-bottom: 8px;">
                <span style="font-size: 8pt; font-weight: bold; text-transform: uppercase;">Certification</span>
                <span class="edit-indicator">✏️ Click fields to edit</span>
            </div>
            <p style="text-align: justify; margin-bottom: 10px; line-height: 1.3; font-size: 7.5pt;">
                I hereby certify that the information provided in this School Form 1 (SF1) is true, accurate, and complete. 
                I understand that any false statement or misrepresentation may result in administrative and/or criminal liability 
                pursuant to DepEd policies and existing laws.
            </p>
            
            <div class="two-col" style="margin-top: 15px;">
                <div style="text-align: center;">
                    <div class="signature-line">
                        <span class="editable-field uppercase font-bold" data-field="adviser_signature" style="font-size: 9pt;">{{ $adviser ?? auth()->user()->full_name ?? '' }}</span>
                    </div>
                    <div style="font-size: 7pt; margin-top: 3px;">Class Adviser (Signature over Printed Name)</div>
                    <div style="margin-top: 8px; font-size: 8pt;">
                        Date: <span class="editable-field" data-field="adviser_date" style="border-bottom: 1pt solid black; display: inline-block; min-width: 100px; text-align: center;">&nbsp;</span>
                    </div>
                </div>
                
                <div style="text-align: center;">
                    <div class="signature-line">
                        <span class="editable-field uppercase font-bold" data-field="principal_signature" style="font-size: 9pt;">{{ $school->principal ?? '' }}</span>
                    </div>
                    <div style="font-size: 7pt; margin-top: 3px;">School Head (Signature over Printed Name)</div>
                    <div style="margin-top: 8px; font-size: 8pt;">
                        Date: <span class="editable-field" data-field="principal_date" style="border-bottom: 1pt solid black; display: inline-block; min-width: 100px; text-align: center;">&nbsp;</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- DOCUMENT FOOTER -->
        <div class="document-footer">
            <span>School Form 1 (SF1) v2018.01</span>
            <span>Reference: DO 4, s. 2014 | DO 58, s. 2017</span>
            <span>Generated: {{ now()->format('M d, Y h:i A') }}</span>
        </div>

    </div>
</div>

<script>
    let isEditMode = false;

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        loadSavedEdits();
        updateEnrollmentSummary();
    });

    function toggleEditMode() {
        isEditMode = !isEditMode;
        const wrapper = document.getElementById('sf1Wrapper');
        const btn = document.getElementById('editBtn');
        const btnText = document.getElementById('editBtnText');
        const editStatus = document.getElementById('editStatus');
        
        if (isEditMode) {
            wrapper.classList.add('edit-mode');
            btn.classList.remove('btn-warning');
            btn.classList.add('btn-success');
            btnText.textContent = 'Done';
            editStatus.textContent = 'Edit Mode';
            editStatus.style.color = '#f59e0b';
            makeEditableFields(true);
        } else {
            wrapper.classList.remove('edit-mode');
            btn.classList.remove('btn-success');
            btn.classList.add('btn-warning');
            btnText.textContent = 'Edit';
            editStatus.textContent = 'View Mode';
            editStatus.style.color = '#059669';
            makeEditableFields(false);
            saveEdits();
            showNotification('Changes saved');
        }
    }

    function makeEditableFields(editable) {
        document.querySelectorAll('.editable-field').forEach(el => {
            el.contentEditable = editable;
            if (editable) {
                el.style.cursor = 'text';
                el.title = 'Click to edit';
            } else {
                el.style.cursor = 'default';
                el.title = '';
            }
        });
    }

    function updateEnrollmentSummary() {
        // Count actual student rows in the table
        const maleRows = document.querySelectorAll('.male-section').length;
        const femaleRows = document.querySelectorAll('.female-section').length;
        const total = maleRows + femaleRows;
        
        // Update the summary display
        const maleDisplay = document.getElementById('maleCountDisplay');
        const femaleDisplay = document.getElementById('femaleCountDisplay');
        const totalDisplay = document.getElementById('totalCountDisplay');
        
        if (maleDisplay) maleDisplay.textContent = maleRows;
        if (femaleDisplay) femaleDisplay.textContent = femaleRows;
        if (totalDisplay) totalDisplay.textContent = total;
    }

    function saveEdits() {
        const edits = {};
        document.querySelectorAll('.editable-field').forEach(el => {
            if (el.dataset.field) {
                edits[el.dataset.field] = el.textContent.trim();
            }
        });
        
        const sectionId = '{{ $section->id ?? "default" }}';
        localStorage.setItem('sf1_edits_' + sectionId, JSON.stringify(edits));
        
        // Recalculate summary after edits
        updateEnrollmentSummary();
    }

    function loadSavedEdits() {
        const sectionId = '{{ $section->id ?? "default" }}';
        const saved = localStorage.getItem('sf1_edits_' + sectionId);
        
        if (saved) {
            try {
                const edits = JSON.parse(saved);
                Object.entries(edits).forEach(([field, value]) => {
                    const el = document.querySelector(`[data-field="${field}"]`);
                    if (el && value && value !== '' && value !== '__________') {
                        el.textContent = value;
                        // Remove default-value styling if edited
                        el.classList.remove('default-value');
                    }
                });
            } catch (e) {
                console.error('Error loading saved edits:', e);
            }
        }
    }

    function exportToExcel() {
        const students = [];
        document.querySelectorAll('#studentTable tbody tr[data-student-id]').forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length > 1 && cells[1].textContent.trim() !== '') {
                students.push({
                    no: cells[0].textContent.trim(),
                    lrn: cells[1].textContent.trim(),
                    name: cells[2].textContent.trim(),
                    grade: cells[3].textContent.trim(),
                    section: cells[4].textContent.trim(),
                    birthday: cells[5].textContent.trim(),
                    age: cells[6].textContent.trim(),
                    mother_tongue: cells[7].textContent.trim(),
                    ethnic_group: cells[8].textContent.trim(),
                    religion: cells[9].textContent.trim(),
                    address: cells[10].textContent.trim(),
                    barangay: cells[11].textContent.trim(),
                    municipality: cells[12].textContent.trim(),
                    province: cells[13].textContent.trim()
                });
            }
        });

        let csv = 'SCHOOL FORM 1 (SF1) - SCHOOL REGISTER\n';
        csv += 'School: {{ $school->name ?? "Tugawe Elementary School" }}\n';
        csv += 'School Year: {{ $activeSchoolYear->name ?? "2025-2026" }}\n';
        csv += 'Grade/Section: {{ $section->year_level ?? "" }} - {{ $section->name ?? "" }}\n\n';
        
        csv += 'No.,LRN,Learner Name,Grade,Section,Birthday,Age,Mother Tongue,Ethnic Group,Religion,Address,Barangay,Municipality,Province\n';
        
        students.forEach(s => {
            csv += `${s.no},"${s.lrn}","${s.name}","${s.grade}","${s.section}","${s.birthday}",${s.age},"${s.mother_tongue}","${s.ethnic_group}","${s.religion}","${s.address}","${s.barangay}","${s.municipality}","${s.province}"\n`;
        });

        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', `SF1_{{ $section->name ?? 'Section' }}_{{ $activeSchoolYear->name ?? '2025-2026' }}.csv`);
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        showNotification('Excel file downloaded');
    }

    function showNotification(msg) {
        const notif = document.createElement('div');
        notif.textContent = msg;
        notif.style.cssText = `
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #059669;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 9pt;
            z-index: 10000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        `;
        document.body.appendChild(notif);
        setTimeout(() => notif.remove(), 2000);
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'p') {
            e.preventDefault();
            window.print();
        }
        if (e.ctrlKey && e.key === 'e') {
            e.preventDefault();
            toggleEditMode();
        }
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            if (isEditMode) {
                toggleEditMode();
            }
        }
    });
</script>

</body>
</html>