<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SF10-ES — Learner Permanent Academic Record</title>
    @vite(['resources/css/app.css'])
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Arial:wght@400;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 9pt;
            line-height: 1.3;
            background: #f3f4f6;
            padding: 20px;
        }
        
        @media print {
            @page {
                size: auto;
                margin: 0;
            }
            
            body { 
                background: white; 
                padding: 0;
                margin: 0;
            }
            
            .sf10-wrapper {
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            
            .sf10-container {
                box-shadow: none;
                border: 1.5pt solid black;
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
                padding: 10px !important;
                margin: 0 !important;
            }
            
            .no-print { 
                display: none !important; 
            }
            
            input, select, textarea {
                border: none !important;
                background: transparent !important;
                padding: 0 !important;
                appearance: none;
            }
            
            .page-break {
                page-break-after: always;
            }
        }

        .sf10-wrapper {
            width: 210mm;
            max-width: 100%;
            margin: 0 auto;
            background: white;
        }

        .sf10-container {
            border: 1.5pt solid black;
            background: white;
            padding: 12px;
            position: relative;
            margin-bottom: 20px;
        }
        
        /* Editable fields styling - only for text fields, NOT grades */
        .editable {
            border-bottom: 1px dotted #666;
            min-width: 60px;
            display: inline-block;
            padding: 0 4px;
            background: #fafafa;
        }
        
        .editable-input {
            border: 1px solid #ddd;
            padding: 2px 4px;
            font-size: 9pt;
            font-family: "Times New Roman", Times, serif;
            background: #fafafa;
            width: 100%;
        }
        
        .editable-input:focus {
            outline: 2px solid #3b82f6;
            background: white;
        }
        
        .editable-select {
            border: 1px solid #ddd;
            padding: 1px;
            font-size: 9pt;
            background: #fafafa;
            font-family: "Times New Roman", Times, serif;
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
            margin-bottom: 8px;
        }
        
        .official-header .govt-name {
            font-size: 11pt;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }
        
        .official-header .dept-name {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .official-header .form-title {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 4px;
        }
        
        .official-header .form-subtitle {
            font-size: 9pt;
            font-style: italic;
            margin-top: 2px;
        }

        .logo {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }

        /* Section headers */
        .section-header {
            background: #e5e7eb;
            font-weight: bold;
            font-size: 9pt;
            padding: 4px 6px;
            text-transform: uppercase;
            border: 1pt solid black;
            margin-top: 8px;
            margin-bottom: 0;
        }

        /* Info tables */
        .info-table td {
            font-size: 8.5pt;
            padding: 3px 6px;
        }
        
        .info-table .label {
            background: #f9fafb;
            font-weight: bold;
            width: 20%;
        }

        /* Grades table - DISPLAY ONLY */
        .grades-table th {
            background: #f3f4f6;
            font-size: 8pt;
            font-weight: bold;
            text-align: center;
        }
        
        .grades-table td {
            font-size: 8.5pt;
            text-align: center;
            height: 24px;
        }
        
        .grades-table .subject-col {
            text-align: left;
            padding-left: 6px;
            width: 35%;
        }

        .summary-row {
            background: #f9fafb;
            font-weight: bold;
        }

        /* General average box */
        .general-avg-box {
            border: 1.5pt solid black;
            margin: 8px 0;
            padding: 6px;
            text-align: center;
            font-weight: bold;
            font-size: 10pt;
            background: #f9fafb;
        }

        /* Remedial section */
        .remedial-section {
            border: 1pt solid black;
            margin-top: 8px;
            padding: 6px;
            font-size: 8pt;
        }
        
        .remedial-title {
            font-weight: bold;
            font-size: 8pt;
            margin-bottom: 4px;
        }

        /* Certification box */
        .certification-box {
            border: 1.5pt solid black;
            margin-top: 12px;
            padding: 10px;
            font-size: 9pt;
        }
        
        .certification-title {
            font-weight: bold;
            text-align: center;
            margin-bottom: 8px;
            text-decoration: underline;
            font-size: 10pt;
        }

        /* Signature section */
        .signature-section {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }
        
        .signature-box {
            width: 45%;
            text-align: center;
        }
        
        .signature-line {
            border-top: 1pt solid black;
            margin-top: 30px;
            padding-top: 4px;
            font-size: 9pt;
        }

        /* Floating toolbar */
        .toolbar {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 200px;
        }
        
        .btn {
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 10pt;
            font-weight: 600;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
            justify-content: center;
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
        
        .edit-mode-indicator {
            position: fixed;
            top: 20px;
            left: 20px;
            background: #f59e0b;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            display: none;
            z-index: 1000;
        }
        
        .edit-active .edit-mode-indicator {
            display: block;
        }
        
        .edit-active .editable {
            background: #fef3c7;
            border-bottom: 1px solid #f59e0b;
        }
        
        [contenteditable="true"] {
            background: #fef3c7 !important;
            outline: 2px solid #f59e0b;
            padding: 2px;
        }

        /* Compact spacing */
        .compact-section {
            margin-bottom: 6px;
        }

        /* Status colors for grades display */
        .status-passed { color: #059669; font-weight: bold; }
        .status-failed { color: #dc2626; font-weight: bold; }
        .status-pending { color: #6b7280; }

        /* Grades display styling - NOT EDITABLE */
        .grade-display {
            font-weight: bold;
        }
        .grade-display.passed {
            color: #059669;
        }
        .grade-display.failed {
            color: #dc2626;
        }

        /* Hamburger menu for mobile */
        .hamburger-menu {
            display: none;
        }

        @media screen and (max-width: 768px) {
            .toolbar {
                display: none;
            }
            
            .hamburger-menu {
                display: block;
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 1000;
            }
            
            .hamburger-btn {
                background: #2563eb;
                color: white;
                border: none;
                padding: 10px;
                border-radius: 8px;
                cursor: pointer;
                font-size: 14pt;
            }
            
            .dropdown-content {
                display: none;
                position: absolute;
                right: 0;
                background: white;
                min-width: 200px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.15);
                border-radius: 8px;
                overflow: hidden;
            }
            
            .dropdown-content.show {
                display: block;
            }
            
            .dropdown-content button, .dropdown-content a {
                display: block;
                width: 100%;
                padding: 12px;
                border: none;
                background: none;
                text-align: left;
                cursor: pointer;
                font-size: 10pt;
                color: #374151;
                text-decoration: none;
            }
            
            .dropdown-content button:hover, .dropdown-content a:hover {
                background: #f3f4f6;
            }
        }
    </style>
</head>
<body>

<!-- Edit Mode Indicator -->
<div class="edit-mode-indicator" id="editIndicator">
    ✏️ EDIT MODE - Click any text to edit
</div>

<!-- Floating Toolbar -->
<div class="toolbar no-print">
    <div style="font-weight: bold; color: #374151; margin-bottom: 5px; text-align: center;">SF10 Controls</div>
    
    <button onclick="toggleEditMode()" class="btn btn-secondary" id="editBtn">
        <span>✏️</span> Edit Mode
    </button>
    
    <button onclick="window.print()" class="btn btn-primary">
        <span>🖨️</span> Print / Save PDF
    </button>
    
    <button onclick="saveData()" class="btn btn-success">
        <span>💾</span> Save Changes
    </button>
    
    <button onclick="resetForm()" class="btn btn-secondary">
        <span>↩️</span> Reset
    </button>
    
    <a href="{{ route('admin.students.index') }}" class="btn btn-secondary" style="text-decoration: none;">
        <span>←</span> Back
    </a>
    
    <div style="font-size: 8pt; color: #6b7280; text-align: center; margin-top: 5px;">
        Auto-saves to browser
    </div>
</div>

<!-- Mobile Hamburger Menu -->
<div class="hamburger-menu no-print">
    <button class="hamburger-btn" onclick="toggleMobileMenu()">☰</button>
    <div id="mobileDropdown" class="dropdown-content">
        <button onclick="toggleEditMode()">✏️ Edit Mode</button>
        <button onclick="window.print()">🖨️ Print</button>
        <button onclick="saveData()">💾 Save</button>
        <button onclick="resetForm()">↩️ Reset</button>
        <a href="{{ route('admin.students.index') }}">← Back</a>
    </div>
</div>

@php
    $quarters = [1, 2, 3, 4];
    $studentSections = $student->sections->keyBy('year_level');
    
    // Get all subjects ordered by grade level
    $allSubjectsByGrade = \App\Models\Subject::orderByRaw(
        "FIELD(grade_level, 'Kindergarten','Grade 1','Grade 2','Grade 3','Grade 4','Grade 5','Grade 6')"
    )->get()->groupBy('grade_level');
    
    $mapehSubjects = ['Music', 'Arts', 'PE', 'Health'];
    $generalGrades = collect();
    
    // Pre-load all grades for this student with subjects
    $allStudentGrades = $student->grades()->with('subject')->get();
@endphp

@foreach($allSubjectsByGrade as $grade => $subjects)
    @php
        $section = $studentSections[$grade] ?? null;
        $otherSubjects = $subjects->whereNotIn('name', $mapehSubjects);
        
        // Filter grades for this year level by checking the subject's grade_level
        $yearGrades = $allStudentGrades->filter(function($gradeItem) use ($grade) {
            return $gradeItem->subject && $gradeItem->subject->grade_level === $grade;
        });
        
        $quarterTotals = [1=>0, 2=>0, 3=>0, 4=>0];
        $quarterCounts = [1=>0, 2=>0, 3=>0, 4=>0];
        $finalGrades = [];
        $pivot = $student->sections()->where('sections.id', $section?->id)->first()?->pivot;
    @endphp

    <div class="sf10-wrapper" data-grade="{{ $grade }}">
        <div class="sf10-container">
            
            <!-- HEADER WITH DUAL SCHOOL LOGOS LEFT, DEPED LOGO RIGHT -->
            <div class="official-header">
                <table style="border: none; width: 100%; margin-bottom: 5px;">
                    <tr style="border: none;">
                        <!-- LEFT SIDE: Dual School Logos -->
                        <td style="border: none; width: 25%; text-align: right; vertical-align: middle; padding-right: 8px;">
                            <div style="display: inline-flex; align-items: center; gap: 5px;">
                                <img src="{{ asset('images/logo1.png') }}" 
                                     onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2275%22 height=%2275%22><rect fill=%22%23006633%22 width=%2275%22 height=%2275%22 rx=%2237.5%22/><text fill=%22white%22 x=%2237.5%22 y=%2242%22 text-anchor=%22middle%22 font-size=%2210%22 font-weight=%22bold%22>LOGO1</text></svg>'"
                                     class="logo" alt="School Logo 1" style="width: 75px; height: 75px;">
                                <img src="{{ asset('images/logo.png') }}" 
                                     onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2275%22 height=%2275%22><rect fill=%22%23008000%22 width=%2275%22 height=%2275%22 rx=%2237.5%22/><text fill=%22white%22 x=%2237.5%22 y=%2242%22 text-anchor=%22middle%22 font-size=%2210%22 font-weight=%22bold%22>LOGO2</text></svg>'"
                                     class="logo" alt="School Logo 2" style="width: 75px; height: 75px;">
                            </div>
                        </td>
                        
                        <!-- CENTER: Text -->
                        <td style="border: none; width: 50%; text-align: center; vertical-align: middle;">
                            <p>Republic of the Philippines</p>
                            <p><strong>Department of Education</strong></p>
                            <div class="form-title">Learner's Permanent Academic Record</div>
                            <div class="form-subtitle">School Form 10-ES (SF10-ES) - Formerly Form 137</div>
                        </td>
                        
                        <!-- RIGHT SIDE: DepEd Logo -->
                        <td style="border: none; width: 25%; text-align: left; vertical-align: middle; padding-left: 8px;">
                            <div style="display: inline-flex; align-items: center; gap: 5px;">
                                <img src="{{ asset('images/DepEd.jpg') }}" 
                                     onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2285%22 height=%2285%22><circle fill=%22%23003366%22 cx=%2242.5%22 cy=%2242.5%22 r=%2242.5%22/><text fill=%22white%22 x=%2242.5%22 y=%2248%22 text-anchor=%22middle%22 font-size=%2212%22 font-weight=%22bold%22>DepEd</text></svg>'"
                                     class="logo" alt="DepEd Logo" style="width: 85px; height: 85px;">
                                <img src="{{ asset('images/Bagong Pilipinas.jpg') }}" 
                                     onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2260%22 height=%2260%22><circle fill=%22%23003366%22 cx=%2230%22 cy=%2230%22 r=%2230%22/><text fill=%22white%22 x=%2230%22 y=%2235%22 text-anchor=%22middle%22 font-size=%2210%22 font-weight=%22bold%22>BP</text></svg>'"
                                     class="logo" alt="Bagong Pilipinas" style="width: 60px; height: 60px;">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- LEARNER'S PERSONAL INFORMATION -->
            <div class="section-header">Learner's Personal Information</div>
            <table class="info-table">
                <tr>
                    <td class="label">LAST NAME:</td>
                    <td>
                        <span class="editable uppercase" data-field="last_name_{{ $grade }}">{{ $student->last_name }}</span>
                    </td>
                    <td class="label">FIRST NAME:</td>
                    <td>
                        <span class="editable" data-field="first_name_{{ $grade }}">{{ $student->first_name }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">NAME EXTN. (Jr,I,II):</td>
                    <td>
                        <span class="editable" data-field="suffix_{{ $grade }}">{{ $student->suffix ?? 'N/A' }}</span>
                    </td>
                    <td class="label">MIDDLE NAME:</td>
                    <td>
                        <span class="editable" data-field="middle_name_{{ $grade }}">{{ $student->middle_name ?? 'N/A' }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">Student Identification Number (SIN):</td>
                    <td class="font-bold">
                        <span class="editable" data-field="lrn">{{ $student->lrn ?? $student->school_id }}</span>
                    </td>
                    <td class="label">Birthdate (mm/dd/yyyy):</td>
                    <td>
                        <input type="date" class="editable-input" data-field="birthdate_{{ $grade }}" 
                               value="{{ $student->birthday ? date('Y-m-d', strtotime($student->birthday)) : '' }}"
                               style="width: 130px; display: inline-block;">
                    </td>
                </tr>
                <tr>
                    <td class="label">Sex:</td>
                   <td style="width: 30%;">
    <strong>Sex:</strong> 
    @if($student->sex == 'M')
        Male
    @elseif($student->sex == 'F')
        Female
    @else
        {{ $student->sex }}
    @endif
</td>
                    <td class="label">Date of Admission:</td>
                    <td>
                        <input type="date" class="editable-input" data-field="admission_date_{{ $grade }}" 
                               value="{{ $student->created_at ? date('Y-m-d', strtotime($student->created_at)) : '' }}"
                               style="width: 130px; display: inline-block;">
                    </td>
                </tr>
            </table>

            <!-- ELIGIBILITY -->
            <div class="section-header">Eligibility for Elementary School Enrollment</div>
            <table class="info-table">
                <tr>
                    <td class="label" style="width: 30%;">Credential Presented for Grade 1:</td>
                    <td style="width: 70%;">
                        <label style="margin-right: 15px;"><input type="checkbox" data-field="credential_kinder_{{ $grade }}"> Kinder Progress Report</label>
                        <label style="margin-right: 15px;"><input type="checkbox" data-field="credential_eccd_{{ $grade }}"> ECCD Checklist</label>
                        <label><input type="checkbox" data-field="credential_cert_{{ $grade }}"> Kindergarten Certificate</label>
                    </td>
                </tr>
                <tr>
                    <td class="label">Other Credential Presented:</td>
                    <td>
                        <input type="text" class="editable-input" data-field="other_credential_{{ $grade }}" 
                               value="{{ $student->other_credential ?? '' }}" style="border: none; background: transparent; width: 100%;">
                    </td>
                </tr>
            </table>

            <!-- SCHOLASTIC RECORD -->
            <div class="section-header">Scholastic Record - {{ $grade }}</div>
            <table class="info-table">
                <tr>
                    <td class="label">School:</td>
                    <td>
                        <span class="editable" data-field="school_name_{{ $grade }}">TUGAWE ELEMENTARY SCHOOL</span>
                    </td>
                    <td class="label">School ID:</td>
                    <td>
                        <span class="editable" data-field="school_id_{{ $grade }}">{{ $section?->school_id ?? '120231' }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">District:</td>
                    <td>
                        <span class="editable" data-field="district_{{ $grade }}">{{ $section?->district ?? 'Dauin District' }}</span>
                    </td>
                    <td class="label">Division:</td>
                    <td>
                        <span class="editable" data-field="division_{{ $grade }}">{{ $section?->division ?? 'Division of Negros Oriental' }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">Region:</td>
                    <td>
                        <span class="editable" data-field="region_{{ $grade }}">{{ $section?->region ?? 'NIR - Negros Island Region' }}</span>
                    </td>
                    <td class="label">Classified as Grade:</td>
                    <td class="font-bold">{{ $grade }}</td>
                </tr>
                <tr>
                    <td class="label">Section:</td>
                    <td>
                        <span class="editable" data-field="section_{{ $grade }}">{{ $section?->name ?? 'N/A' }}</span>
                    </td>
                    <td class="label">School Year:</td>
                    <td>
                        <span class="editable" data-field="school_year_{{ $grade }}">{{ $activeSchoolYear->name ?? 'N/A' }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">Name of Adviser/Teacher:</td>
                    <td>
                        <span class="editable" data-field="adviser_{{ $grade }}">{{ $section?->teacher->name ?? 'N/A' }}</span>
                    </td>
                    <td class="label">Status:</td>
                    <td>
                        <select class="editable-select" data-field="status_{{ $grade }}" style="width: 100%;">
                            <option value="Active" {{ ($pivot?->status ?? 'Active') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Promoted" {{ ($pivot?->status ?? '') == 'Promoted' ? 'selected' : '' }}>Promoted</option>
                            <option value="Retained" {{ ($pivot?->status ?? '') == 'Retained' ? 'selected' : '' }}>Retained</option>
                            <option value="Dropped" {{ ($pivot?->status ?? '') == 'Dropped' ? 'selected' : '' }}>Dropped</option>
                        </select>
                    </td>
                </tr>
            </table>

            <!-- GRADES TABLE - DISPLAY ONLY (NO INPUTS) -->
            <table class="grades-table" style="margin-top: 6px;">
                <thead>
                    <tr>
                        <th rowspan="2" class="subject-col" style="width: 35%;">LEARNING AREAS</th>
                        <th colspan="4" style="width: 32%;">QUARTERLY RATING</th>
                        <th rowspan="2" style="width: 12%;">FINAL RATING</th>
                        <th rowspan="2" style="width: 21%;">REMARKS</th>
                    </tr>
                    <tr>
                        @foreach($quarters as $q)
                            <th style="width: 8%;">Q{{ $q }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    {{-- Core Subjects --}}
                    @foreach($otherSubjects as $subject)
                        @php
                            // Get grades for this specific subject from pre-loaded grades
                            $subjectGrades = $yearGrades->where('subject_id', $subject->id)->keyBy('quarter');
                            $final = $subjectGrades->avg('grade');
                            $finalGrades[] = $final ?? null;

                            foreach($quarters as $q){
                                $qGrade = $subjectGrades[$q]->grade ?? null;
                                if($qGrade !== null){ 
                                    $quarterTotals[$q] += $qGrade; 
                                    $quarterCounts[$q]++; 
                                }
                            }

                            $remarks = $final >= 75 ? 'Passed' : ($final ? 'Failed' : '-');
                            $statusClass = $remarks === 'Passed' ? 'status-passed' : ($remarks === 'Failed' ? 'status-failed' : 'status-pending');
                            if($final) $generalGrades->push($final);
                        @endphp
                        <tr>
                            <td class="subject-col">{{ strtoupper($subject->name) }}</td>
                            @foreach($quarters as $q)
                                @php 
                                    $qGrade = $subjectGrades[$q]->grade ?? null;
                                    $gradeClass = '';
                                    if ($qGrade !== null) {
                                        $gradeClass = $qGrade >= 75 ? 'passed' : 'failed';
                                    }
                                @endphp
                                <td>
                                    @if($qGrade !== null)
                                        <span class="grade-display {{ $gradeClass }}">{{ round($qGrade) }}</span>
                                    @else
                                        <span style="color: #9ca3af;"></span>
                                    @endif
                                </td>
                            @endforeach
                            <td>
                                @if($final !== null)
                                    <span class="grade-display {{ $final >= 75 ? 'passed' : 'failed' }}">{{ round($final) }}</span>
                                @else
                                    <span style="color: #9ca3af;"></span>
                                @endif
                            </td>
                            <td class="{{ $statusClass }}">{{ $remarks }}</td>
                        </tr>
                    @endforeach

                    {{-- MAPEH Components --}}
                    @php
                        // Get MAPEH grades for this year level by subject name
                        $mapehGradesData = $yearGrades->filter(function($gradeItem) use ($mapehSubjects) {
                            return in_array($gradeItem->subject->name ?? '', $mapehSubjects);
                        });
                        
                        $mapehQuarterly = [];
                        $mapehFinal = null;
                        $mapehRemarks = '-';
                    @endphp
                    
                    @if($mapehGradesData->count() > 0)
                        @foreach($quarters as $q)
                            @php
                                $grades = $mapehGradesData->where('quarter', $q)->pluck('grade');
                                $mapehQuarterly[$q] = $grades->count() ? round($grades->avg(), 2) : null;
                                if($grades->count()) { 
                                    $quarterTotals[$q] += $grades->avg(); 
                                    $quarterCounts[$q]++; 
                                }
                            @endphp
                        @endforeach
                        
                        @php
                            $mapehFinal = $mapehGradesData->pluck('grade')->count() ? round($mapehGradesData->pluck('grade')->avg(), 2) : null;
                            $mapehRemarks = $mapehFinal >= 75 ? 'Passed' : ($mapehFinal ? 'Failed' : '-');
                            if($mapehFinal) {
                                $finalGrades[] = $mapehFinal;
                                $generalGrades->push($mapehFinal);
                            }
                        @endphp

                        {{-- MAPEH Components (Display Only) --}}
                        @foreach($mapehSubjects as $mapehSub)
                            @php
                                $mGrades = $yearGrades->filter(function($gradeItem) use ($mapehSub) {
                                    return ($gradeItem->subject->name ?? '') === $mapehSub;
                                })->keyBy('quarter');
                                $mFinal = $mGrades->avg('grade');
                            @endphp
                            <tr style="font-size: 8pt; font-style: italic;">
                                <td class="subject-col" style="padding-left: 20px;">{{ $mapehSub }}</td>
                                @foreach($quarters as $q)
                                    @php 
                                        $mGrade = $mGrades[$q]->grade ?? null;
                                        $mClass = '';
                                        if ($mGrade !== null) {
                                            $mClass = $mGrade >= 75 ? 'passed' : 'failed';
                                        }
                                    @endphp
                                    <td>
                                        @if($mGrade !== null)
                                            <span class="grade-display {{ $mClass }}">{{ round($mGrade) }}</span>
                                        @else
                                            <span style="color: #9ca3af;"></span>
                                        @endif
                                    </td>
                                @endforeach
                                <td>
                                    @if($mFinal !== null)
                                        <span class="grade-display {{ $mFinal >= 75 ? 'passed' : 'failed' }}">{{ round($mFinal) }}</span>
                                    @else
                                        <span style="color: #9ca3af;"></span>
                                    @endif
                                </td>
                                <td></td>
                            </tr>
                        @endforeach

                        {{-- MAPEH Total Row --}}
                        <tr style="font-weight: bold;">
                            <td class="subject-col">MAPEH</td>
                            @foreach($quarters as $q)
                                @php
                                    $mqGrade = $mapehQuarterly[$q] ?? null;
                                    $mqClass = '';
                                    if ($mqGrade !== null) {
                                        $mqClass = $mqGrade >= 75 ? 'passed' : 'failed';
                                    }
                                @endphp
                                <td>
                                    @if($mqGrade !== null)
                                        <span class="grade-display {{ $mqClass }}">{{ round($mqGrade) }}</span>
                                    @else
                                        <span style="color: #9ca3af;"></span>
                                    @endif
                                </td>
                            @endforeach
                            <td>
                                @if($mapehFinal !== null)
                                    <span class="grade-display {{ $mapehFinal >= 75 ? 'passed' : 'failed' }}">{{ round($mapehFinal) }}</span>
                                @else
                                    <span style="color: #9ca3af;"></span>
                                @endif
                            </td>
                            <td class="{{ $mapehRemarks === 'Passed' ? 'status-passed' : ($mapehRemarks === 'Failed' ? 'status-failed' : '') }}">
                                {{ $mapehRemarks }}
                            </td>
                        </tr>
                    @endif

                    {{-- Quarterly Average Row --}}
                    <tr class="summary-row">
                        <td class="subject-col" style="font-style: italic;">Quarterly Average</td>
                        @foreach($quarters as $q)
                            @php 
                                $qAvg = $quarterCounts[$q] > 0 ? round($quarterTotals[$q]/$quarterCounts[$q]) : null;
                                $qAvgClass = '';
                                if ($qAvg !== null) {
                                    $qAvgClass = $qAvg >= 75 ? 'passed' : 'failed';
                                }
                            @endphp
                            <td>
                                @if($qAvg !== null)
                                    <span class="grade-display {{ $qAvgClass }}">{{ $qAvg }}</span>
                                @else
                                    <span style="color: #9ca3af;"></span>
                                @endif
                            </td>
                        @endforeach
                        @php
                            $numericFinals = array_filter($finalGrades, fn($val) => $val !== null);
                            $finalAvg = count($numericFinals) ? round(collect($numericFinals)->avg()) : null;
                            $remarksFinal = $finalAvg !== null ? ($finalAvg >= 75 ? 'Passed' : 'Failed') : '-';
                        @endphp
                        <td>
                            @if($finalAvg !== null)
                                <span class="grade-display {{ $finalAvg >= 75 ? 'passed' : 'failed' }}">{{ $finalAvg }}</span>
                            @else
                                <span style="color: #9ca3af;"></span>
                            @endif
                        </td>
                        <td class="{{ $remarksFinal === 'Passed' ? 'status-passed' : ($remarksFinal === 'Failed' ? 'status-failed' : '') }}">
                            {{ $remarksFinal }}
                        </td>
                    </tr>
                </tbody>
            </table>

            {{-- General Average --}}
            @php
                $numericFinals = array_filter($finalGrades, fn($val) => $val !== null);
                $genAvg = count($numericFinals) ? round(collect($numericFinals)->avg()) : null;
            @endphp
            @if($genAvg)
                <div class="general-avg-box">
                    GENERAL AVERAGE: <span id="generalAverage_{{ $grade }}">{{ $genAvg }}</span>
                    <span style="margin-left: 20px;" class="{{ $genAvg >= 75 ? 'status-passed' : 'status-failed' }}" id="promotionStatus_{{ $grade }}">
                        ({{ $genAvg >= 75 ? 'PROMOTED' : 'RETAINED' }})
                    </span>
                </div>
            @endif

            {{-- Remedial Classes --}}
            <div class="remedial-section">
                <div class="remedial-title">REMEDIAL CLASSES (Conducted if the learner has failed in not more than two learning areas)</div>
                <table class="grades-table" style="margin-top: 4px;">
                    <thead>
                        <tr style="background: #f3f4f6;">
                            <th style="width: 30%;">Learning Areas</th>
                            <th style="width: 17%;">Final Rating</th>
                            <th style="width: 17%;">Remedial Class Mark</th>
                            <th style="width: 18%;">Recomputed Final Grade</th>
                            <th style="width: 18%;">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i <= 2; $i++)
                            <tr>
                                <td><input type="text" class="editable-input" data-field="remedial_subject_{{ $grade }}_{{ $i }}" style="width: 100%; border: none; background: transparent;"></td>
                                <td><input type="number" class="editable-input" data-field="remedial_final_{{ $grade }}_{{ $i }}" style="width: 100%; text-align: center; border: none; background: transparent;"></td>
                                <td><input type="number" class="editable-input" data-field="remedial_mark_{{ $grade }}_{{ $i }}" style="width: 100%; text-align: center; border: none; background: transparent;"></td>
                                <td><input type="number" class="editable-input" data-field="remedial_recomputed_{{ $grade }}_{{ $i }}" style="width: 100%; text-align: center; border: none; background: transparent;"></td>
                                <td><input type="text" class="editable-input" data-field="remedial_remarks_{{ $grade }}_{{ $i }}" style="width: 100%; text-align: center; border: none; background: transparent;"></td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
                <div style="margin-top: 5px; font-size: 8pt;">
                    <strong>Conducted from:</strong> 
                    <input type="date" class="editable-input" data-field="remedial_from_{{ $grade }}" style="width: 120px; display: inline-block;">
                    <strong>to</strong> 
                    <input type="date" class="editable-input" data-field="remedial_to_{{ $grade }}" style="width: 120px; display: inline-block;">
                    <strong style="margin-left: 20px;">Signature of Teacher:</strong> 
                    <input type="text" class="editable-input" data-field="remedial_teacher_sig_{{ $grade }}" style="width: 150px; display: inline-block; border: none; border-bottom: 1px solid black;">
                </div>
            </div>

            {{-- Signatures --}}
            <div class="signature-section">
                <div class="signature-box">
                    <input type="text" class="editable-input" data-field="adviser_sig_{{ $grade }}" 
                           value="{{ $section?->teacher->name ?? '' }}"
                           style="text-align: center; border: none; border-bottom: 1pt solid black; width: 80%; font-weight: bold;">
                    <div class="signature-line">
                        <strong>Class Adviser</strong><br>
                        <span style="font-size: 7.5pt;">(Signature over Printed Name)</span>
                    </div>
                </div>
                <div class="signature-box">
                    <input type="text" class="editable-input" data-field="principal_sig_{{ $grade }}" 
                           style="text-align: center; border: none; border-bottom: 1pt solid black; width: 80%; font-weight: bold;">
                    <div class="signature-line">
                        <strong>Principal/School Head</strong><br>
                        <span style="font-size: 7.5pt;">(Signature over Printed Name)</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @if(!$loop->last)
        <div class="page-break"></div>
    @endif

@endforeach

{{-- Final Certification (Only on last page) --}}
<div class="sf10-wrapper">
    <div class="sf10-container">
        <div class="certification-box">
            <div class="certification-title">CERTIFICATION</div>
            <p style="text-align: justify; line-height: 1.5; margin-bottom: 10px;">
                I CERTIFY that this is a true record of 
                <strong>
                    <span class="editable" data-field="cert_first_name">{{ $student->first_name }}</span> 
                    <span class="editable" data-field="cert_middle_name">{{ $student->middle_name ?? '' }}</span> 
                    <span class="editable" data-field="cert_last_name">{{ $student->last_name }}</span>
                </strong>, 
                with LRN <strong><span class="editable" data-field="cert_lrn">{{ $student->school_id }}</span></strong> 
                and that he/she is eligible for admission to Grade 
                <input type="text" class="editable-input" data-field="admission_grade" style="width: 60px; text-align: center; display: inline-block;">.
            </p>
            
            <table class="info-table" style="margin-top: 10px;">
                <tr>
                    <td class="label" style="width: 15%;">School:</td>
                    <td style="width: 35%;">
                        <span class="editable" data-field="cert_school">TUGAWE ELEMENTARY SCHOOL</span>
                    </td>
                    <td class="label" style="width: 15%;">School ID:</td>
                    <td style="width: 35%;">
                        <input type="text" class="editable-input" data-field="cert_school_id" style="width: 100%; border: none; background: transparent;">
                    </td>
                </tr>
                <tr>
                    <td class="label">Division:</td>
                    <td>
                        <input type="text" class="editable-input" data-field="cert_division" style="width: 100%; border: none; background: transparent;">
                    </td>
                    <td class="label">Last School Year Attended:</td>
                    <td>
                        <span class="editable" data-field="cert_last_sy">{{ $activeSchoolYear->name ?? '' }}</span>
                    </td>
                </tr>
            </table>
            
            <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: flex-end;">
                <div style="width: 60%;">
                    <input type="text" class="editable-input" data-field="cert_principal" 
                           style="text-align: center; border: none; border-bottom: 1pt solid black; width: 80%; display: block; font-weight: bold;">
                    <div style="text-align: center; width: 80%; margin-top: 4px; font-size: 9pt;">
                        <strong>Signature of Principal/School Head over Printed Name</strong>
                    </div>
                </div>
                <div style="width: 35%; text-align: right;">
                    <strong>Date:</strong> 
                    <input type="date" class="editable-input" data-field="cert_date" style="width: 130px; display: inline-block;"><br>
                    <span style="font-size: 8pt; margin-right: 30px;">(mm/dd/yyyy)</span><br><br>
                    <div style="border: 1pt solid black; padding: 15px; display: inline-block; margin-top: 5px; min-width: 100px; text-align: center; color: #6b7280;">
                        School Seal
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let isEditMode = false;
    let autoSaveTimer;

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        loadSavedData();
        setupAutoSave();
    });

    function toggleEditMode() {
        isEditMode = !isEditMode;
        document.body.classList.toggle('edit-active');
        const btn = document.getElementById('editBtn');
        
        if (isEditMode) {
            btn.innerHTML = '<span>✅</span> Done Editing';
            btn.classList.remove('btn-secondary');
            btn.classList.add('btn-success');
            makeFieldsEditable(true);
        } else {
            btn.innerHTML = '<span>✏️</span> Edit Mode';
            btn.classList.remove('btn-success');
            btn.classList.add('btn-secondary');
            makeFieldsEditable(false);
            saveData();
        }
    }

    function makeFieldsEditable(editable) {
        // Only make .editable spans contenteditable (not grades)
        document.querySelectorAll('.editable').forEach(el => {
            el.contentEditable = editable;
            el.style.cursor = editable ? 'text' : 'default';
        });
    }

    function toggleMobileMenu() {
        document.getElementById('mobileDropdown').classList.toggle('show');
    }

    // Close mobile menu when clicking outside
    window.onclick = function(event) {
        if (!event.target.matches('.hamburger-btn')) {
            const dropdown = document.getElementById('mobileDropdown');
            if (dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            }
        }
    }

    function setupAutoSave() {
        document.querySelectorAll('input, select').forEach(el => {
            el.addEventListener('change', triggerAutoSave);
        });
    }

    function triggerAutoSave() {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(saveData, 1000);
    }

    function saveData() {
        const data = {
            student_id: {{ $student->id }},
            fields: {},
            timestamp: new Date().toISOString()
        };

        // Save all editable spans
        document.querySelectorAll('.editable').forEach(el => {
            if (el.dataset.field) {
                data.fields[el.dataset.field] = el.textContent.trim();
            }
        });

        // Save all inputs and selects
        document.querySelectorAll('.editable-input, .editable-select').forEach(el => {
            if (el.dataset.field) {
                data.fields[el.dataset.field] = el.value;
            }
        });

        // Save checkboxes
        document.querySelectorAll('input[type="checkbox"]').forEach(el => {
            if (el.dataset.field) {
                data.fields[el.dataset.field] = el.checked;
            }
        });

        localStorage.setItem('sf10_draft_{{ $student->id }}', JSON.stringify(data));
        showNotification('Changes saved automatically');
        return data;
    }

    function loadSavedData() {
        const saved = localStorage.getItem('sf10_draft_{{ $student->id }}');
        if (!saved) return;
        
        try {
            const data = JSON.parse(saved);
            
            // Restore fields
            Object.entries(data.fields || {}).forEach(([key, value]) => {
                const el = document.querySelector(`[data-field="${key}"]`);
                if (el) {
                    if (el.tagName === 'INPUT') {
                        if (el.type === 'checkbox') {
                            el.checked = value;
                        } else {
                            el.value = value;
                        }
                    } else if (el.tagName === 'SELECT') {
                        el.value = value;
                    } else {
                        el.textContent = value;
                    }
                }
            });

        } catch (e) {
            console.error('Error loading saved data:', e);
        }
    }

    function resetForm() {
        if (confirm('Reset all changes? This will clear all entered data.')) {
            localStorage.removeItem('sf10_draft_{{ $student->id }}');
            location.reload();
        }
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
            saveData();
            showNotification('Saved!');
        }
    });
</script>

</body>
</html>