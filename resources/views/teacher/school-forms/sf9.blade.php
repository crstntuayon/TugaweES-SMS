<!DOCTYPE html>
<html>
<head>
    <title>SF9 - Learner's Progress Report Card</title>
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
            font-family: Arial, sans-serif;
            font-size: 9pt;
            line-height: 1.2;
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
            
            .sf9-wrapper {
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            
            .sf9-container {
                box-shadow: none;
                border: 1.5pt solid black;
                width: 100% !important;
                max-width: 100% !important;
                height: 100vh !important;
                max-height: 100vh !important;
                padding: 10px !important;
                margin: 0 !important;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
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
            
            .print-fit {
                flex: 1;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }
        }

        .sf9-wrapper {
            width: 210mm;
            max-width: 100%;
            margin: 0 auto;
            background: white;
        }

        .sf9-container {
            border: 1.5pt solid black;
            background: white;
            padding: 12px;
            position: relative;
            min-height: 297mm;
        }
        
        /* Editable fields styling */
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
            font-family: Arial, sans-serif;
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
        
        .header-text {
            font-size: 12pt;
            font-weight: bold;
        }
        
        .logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }
        
        /* Compact spacing for single page */
        .compact-section {
            margin-bottom: 6px;
        }
        
        .grades-table td, .grades-table th {
            padding: 2px 3px;
            font-size: 8.5pt;
        }
        
        .values-table td, .values-table th {
            padding: 2px 3px;
            font-size: 7.5pt;
        }
        
        .attendance-table td, .attendance-table th {
            padding: 2px;
            font-size: 7.5pt;
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

        /* Header specific styles */
        .official-header {
            text-align: center;
            margin-bottom: 8px;
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

        /* Age auto-calculation indicator */
        .auto-calculated {
            background: #d1fae5 !important;
            border-bottom: 1px solid #059669 !important;
            font-weight: bold;
        }

        /* Flex layout for print fitting */
        .content-flex {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        /* Paper size indicator */
        .paper-info {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: white;
            padding: 10px 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            font-size: 9pt;
            z-index: 1000;
            max-width: 250px;
        }

        .paper-info .detected-size {
            font-weight: bold;
            color: #059669;
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
    <div style="font-weight: bold; color: #374151; margin-bottom: 5px; text-align: center;">SF9 Controls</div>
    
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
    
    <a href="{{ route('teacher.dashboard') }}" class="btn btn-secondary" style="text-decoration: none;">
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
        <a href="{{ route('teacher.dashboard') }}">← Back</a>
    </div>
</div>


<!-- Paper Info -->
<div class="paper-info no-print">
    <div>Detected Paper: <span class="detected-size" id="detectedPaper">A4</span></div>
    <div style="font-size: 7pt; color: #666; margin-top: 4px;">
        Layout auto-adjusts to fit any paper size
    </div>
</div>

<div class="sf9-wrapper">
    <div class="sf9-container" id="sf9Form">
        
        <div class="print-fit">
            <div class="content-flex">
                <!-- HEADER WITH DUAL SCHOOL LOGOS LEFT, DEPED LOGO RIGHT -->
<div class="official-header">
    <table style="border: none; width: 100%; margin-bottom: 5px;">
        <tr style="border: none;">
            <!-- LEFT SIDE: Dual School Logos -->
            <td style="border: none; width: 25%; text-align: right; vertical-align: middle; padding-right: 8px;">
                <div style="display: inline-flex; align-items: center; gap: 5px;">
                    <img src="{{ asset('images/logo1.png') }}" 
                         onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2275%22 height=%2275%22><rect fill=%22%23006633%22 width=%2275%22 height=%2275%22 rx=%2237.5%22/><text fill=%22white%22 x=%2237.5%22 y=%2242%22 text-anchor=%22middle%22 font-size=%2210%22 font-weight=%22bold%22>LOGO1</text></svg>'"
                         class="logo" alt="School Logo 1" style="display: inline-block; width: 75px; height: 75px;">
                    <img src="{{ asset('images/logo.png') }}" 
                         onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2275%22 height=%2275%22><rect fill=%22%23008000%22 width=%2275%22 height=%2275%22 rx=%2237.5%22/><text fill=%22white%22 x=%2237.5%22 y=%2242%22 text-anchor=%22middle%22 font-size=%2210%22 font-weight=%22bold%22>LOGO2</text></svg>'"
                         class="logo" alt="School Logo 2" style="display: inline-block; width: 75px; height: 75px;">
                </div>
            </td>
            
            <!-- CENTER: Text -->
            <td style="border: none; width: 50%; text-align: center; vertical-align: middle;">
                <p>Republic of the Philippines</p>
                <p><strong>Department of Education</strong></p>
                <div class="form-title">Learner's Progress Report Card</div>
                <div class="form-number">School Form 9 (SF9)</div>
            </td>
            
            <!-- RIGHT SIDE: DepEd Logo -->
            <td style="border: none; width: 25%; text-align: left; vertical-align: middle; padding-left: 8px;">
                 <div style="display: inline-flex; align-items: center; gap: 5px;">
                <img src="{{ asset('images/DepEd.jpg') }}" 
                     onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2285%22 height=%2285%22><circle fill=%22%23003366%22 cx=%2242.5%22 cy=%2242.5%22 r=%2242.5%22/><text fill=%22white%22 x=%2242.5%22 y=%2248%22 text-anchor=%22middle%22 font-size=%2212%22 font-weight=%22bold%22>DepEd</text></svg>'"
                     class="logo" alt="DepEd Logo" style="display: inline-block; width: 85px; height: 85px;">
                      <img src="{{ asset('images/Bagong Pilipinas.jpg') }}" 
                     onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2285%22 height=%2285%22><circle fill=%22%23003366%22 cx=%2242.5%22 cy=%2242.5%22 r=%2242.5%22/><text fill=%22white%22 x=%2242.5%22 y=%2248%22 text-anchor=%22middle%22 font-size=%2212%22 font-weight=%22bold%22>DepEd</text></svg>'"
                     class="logo" alt="DepEd Logo" style="display: inline-block; width: 60px; height: 60px;">
            </div>
                    </td>
        </tr>
    </table>
</div>

<style>
/* Header Styles */
.official-header {
    text-align: center;
    margin-bottom: 6px;
    padding: 5px 0;
}

.official-header .govt-name {
    font-size: 11pt;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 600;
    line-height: 1.1;
}

.official-header .dept-name {
    font-size: 13pt;
    font-weight: bold;
    text-transform: uppercase;
    margin-top: 1px;
    line-height: 1.1;
}

.official-header .form-title {
    font-size: 15pt;
    font-weight: bold;
    text-transform: uppercase;
    margin-top: 3px;
    line-height: 1.1;
}

.official-header .form-number {
    font-size: 10pt;
    margin-top: 1px;
    line-height: 1.1;
}

/* Logo sizing */
.logo {
    object-fit: contain;
    display: inline-block;
}

/* Print optimizations */
@media print {
    .official-header {
        margin-bottom: 4px;
    }
    
    .logo {
        max-width: 80px !important;
        max-height: 80px !important;
    }
}
</style>
                <!-- SCHOOL INFO -->
                <div class="compact-section">
                    <table style="font-size: 8.5pt;">
                        <tr>
                            <td style="width: 50%;">
                                <strong>Region:</strong> 
                                <span class="editable" data-field="region">{{ $schoolInfo->region ?? 'NIR - Negros Island Region' }}</span>
                            </td>
                            <td style="width: 50%;">
                                <strong>Schools Division:</strong> 
                                <span class="editable" data-field="division">{{ $schoolInfo->division ?? 'Division of Negros Oriental' }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>District:</strong> 
                                <span class="editable" data-field="district">{{ $schoolInfo->district ?? 'Dauin District' }}</span>
                            </td>
                            <td>
                                <strong>School Name:</strong> 
                                <span class="editable" data-field="school_name">{{ $schoolInfo->name ?? config('app.school_name', 'Tugawe Elementary School') }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>School Year:</strong> 
                                <span class="editable" data-field="school_year">{{ $activeSchoolYear->name ?? '2024-2025' }}</span>
                            </td>
                            <td>
                                <strong>Grade Level:</strong> 
                                <span class="editable" data-field="grade_level">{{ $section->year_level ?? 'Kindergarten' }}</span> &nbsp;&nbsp;
                                <strong>Section:</strong> 
                                <span class="editable" data-field="section">{{ $section->name ?? '-' }}</span>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- LEARNER INFO -->
                <div class="compact-section">
                    <table style="font-size: 8.5pt;">
                        <tr>
                            <td style="width: 40%;">
                                <strong>Name:</strong> 
                                <span class="editable uppercase" data-field="student_name">
                                    {{ strtoupper($student->last_name . ', ' . $student->first_name . ' ' . $student->middle_name) }}
                                </span>
                                <span class="editable" data-field="suffix">{{ $student->suffix }}</span>
                            </td>
    
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
                            <td style="width: 30%;">
                                <strong>LRN:</strong> 
                                <span class="editable" data-field="lrn">{{ $student->lrn ?? $student->school_id }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Age:</strong> 
                                <span class="editable auto-calculated" id="calculatedAge" data-field="age" style="width: 40px; font-weight: bold; color: #059669;">
                                    {{ $student->age ?? '' }}
                                </span>
                                <span style="font-size: 7pt; color: #666;"></span>
                            </td>
                            <td colspan="2">
                                <strong>Date of Birth:</strong> 
                                <input type="date" id="birthdateInput" class="editable-input" data-field="birthdate" 
                                       value="{{ $student->birthday ? date('Y-m-d', strtotime($student->birthday)) : '' }}"
                                       style="width: 130px; display: inline-block;" 
                                       onchange="calculateAgeFromBirthdate()">
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- PART I: ACADEMIC PROGRESS - DISPLAY ONLY -->
<div class="compact-section">
    <div style="font-size: 9pt; font-weight: bold; margin-bottom: 4px; text-transform: uppercase; background: #e5e7eb; padding: 3px;">
        Report on Learning Progress and Achievement
    </div>
    
    <table class="grades-table" style="font-size: 8.5pt;">
        <thead>
            <tr style="background: #f3f4f6;">
                <th style="width: 32%; text-align: left; padding-left: 6px;">Learning Areas</th>
                <th style="width: 8%;">Q1</th>
                <th style="width: 8%;">Q2</th>
                <th style="width: 8%;">Q3</th>
                <th style="width: 8%;">Q4</th>
                <th style="width: 10%;">Final Rating</th>
                <th style="width: 16%;">Remarks</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalFinal = 0;
                $subjectCount = 0;
                $quarterTotals = [1 => 0, 2 => 0, 3 => 0, 4 => 0];
                $quarterCounts = [1 => 0, 2 => 0, 3 => 0, 4 => 0];
            @endphp

            @foreach($subjects as $subject)
                @php
                    $q1 = $grades[$subject->id][1] ?? null;
                    $q2 = $grades[$subject->id][2] ?? null;
                    $q3 = $grades[$subject->id][3] ?? null;
                    $q4 = $grades[$subject->id][4] ?? null;
                    
                    foreach([1 => $q1, 2 => $q2, 3 => $q3, 4 => $q4] as $q => $val) {
                        if($val !== null) {
                            $quarterTotals[$q] += $val;
                            $quarterCounts[$q]++;
                        }
                    }
                    
                    $final = collect([$q1, $q2, $q3, $q4])->filter()->avg();
                    if($final !== null) {
                        $totalFinal += $final;
                        $subjectCount++;
                    }
                @endphp
                <tr>
                    <td style="text-align: left; padding-left: 6px;">{{ $subject->name }}</td>
                    <td style="text-align: center; font-weight: {{ $q1 ? 'bold' : 'normal' }}; color: {{ $q1 ? ($q1 >= 75 ? '#059669' : '#dc2626') : '#9ca3af' }};">
                        {{ $q1 ?? '' }}
                    </td>
                    <td style="text-align: center; font-weight: {{ $q2 ? 'bold' : 'normal' }}; color: {{ $q2 ? ($q2 >= 75 ? '#059669' : '#dc2626') : '#9ca3af' }};">
                        {{ $q2 ?? '' }}
                    </td>
                    <td style="text-align: center; font-weight: {{ $q3 ? 'bold' : 'normal' }}; color: {{ $q3 ? ($q3 >= 75 ? '#059669' : '#dc2626') : '#9ca3af' }};">
                        {{ $q3 ?? '' }}
                    </td>
                    <td style="text-align: center; font-weight: {{ $q4 ? 'bold' : 'normal' }}; color: {{ $q4 ? ($q4 >= 75 ? '#059669' : '#dc2626') : '#9ca3af' }};">
                        {{ $q4 ?? '' }}
                    </td>
                    <td style="text-align: center; font-weight: bold; font-size: 9pt; color: {{ $final ? ($final >= 75 ? '#059669' : '#dc2626') : '#9ca3af' }};">
                        {{ $final ? round($final) : '' }}
                    </td>
                    <td style="text-align: center; font-weight: {{ $final ? 'bold' : 'normal' }}; color: {{ $final ? ($final >= 75 ? '#059669' : '#dc2626') : '#9ca3af' }};">
                        @if($final !== null)
                            {{ $final >= 75 ? 'Passed' : 'Failed' }}
                        @else
                            
                        @endif
                    </td>
                </tr>
            @endforeach

            @if($subjectCount > 0)
                <!-- Quarterly Average Row -->
                <tr style="background: #f9fafb; font-weight: bold;">
                    <td style="text-align: left; padding-left: 6px; font-style: italic;">Quarterly Average</td>
                    @foreach([1, 2, 3, 4] as $q)
                        @php $qAvg = $quarterCounts[$q] > 0 ? round($quarterTotals[$q]/$quarterCounts[$q]) : null; @endphp
                        <td style="text-align: center; color: {{ $qAvg ? ($qAvg >= 75 ? '#059669' : '#dc2626') : '#9ca3af' }};">
                            {{ $qAvg ?? '-' }}
                        </td>
                    @endforeach
                    <td colspan="2"></td>
                </tr>

                @php $generalAverage = $totalFinal / $subjectCount; @endphp
                <tr style="background: #f3f4f6; font-weight: bold; border-top: 2pt solid black;">
                    <td colspan="5" style="text-align: right; padding-right: 10px;">General Average</td>
                    <td style="text-align: center; font-size: 10pt; color: {{ $generalAverage >= 75 ? '#059669' : '#dc2626' }};">
                        {{ round($generalAverage) }}
                    </td>
                    <td style="text-align: center; font-weight: bold; color: {{ $generalAverage >= 75 ? '#059669' : '#dc2626' }};">
                        {{ $generalAverage >= 75 ? 'PASSED' : 'FAILED' }}
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Grading Scale -->
    <table style="font-size: 7.5pt; margin-top: 4px;">
        <tr style="background: #f9fafb;">
            <td style="width: 20%; text-align: center; font-weight: bold;">Descriptors</td>
            <td style="width: 15%; text-align: center; font-weight: bold;">Grading Scale</td>
            <td style="width: 15%; text-align: center; font-weight: bold;">Remarks</td>
            <td style="width: 20%; text-align: center; font-weight: bold;">Descriptors</td>
            <td style="width: 15%; text-align: center; font-weight: bold;">Grading Scale</td>
            <td style="width: 15%; text-align: center; font-weight: bold;">Remarks</td>
        </tr>
        <tr>
            <td style="text-align: center;">Outstanding</td>
            <td style="text-align: center;">90-100</td>
            <td style="text-align: center;" rowspan="2">Passed</td>
            <td style="text-align: center;">Fairly Satisfactory</td>
            <td style="text-align: center;">75-79</td>
            <td style="text-align: center;" rowspan="2">Passed</td>
        </tr>
        <tr>
            <td style="text-align: center;">Very Satisfactory</td>
            <td style="text-align: center;">85-89</td>
            <td style="text-align: center; color: #dc2626;">Did Not Meet Expectations</td>
            <td style="text-align: center; color: #dc2626;">Below 75</td>
        </tr>
        <tr>
            <td style="text-align: center;">Satisfactory</td>
            <td style="text-align: center;">80-84</td>
            <td style="text-align: center;">Passed</td>
            <td colspan="3"></td>
        </tr>
    </table>
</div>
                <!-- PART II: CORE VALUES -->
                <div class="compact-section">
                    <div style="font-size: 9pt; font-weight: bold; margin-bottom: 4px; text-transform: uppercase; background: #e5e7eb; padding: 3px;">
                        Report on Learner's Observed Values
                    </div>
                    
                    <table class="values-table">
                        <thead>
                            <tr style="background: #f3f4f6;">
                                <th style="width: 12%;">Core Values</th>
                                <th style="width: 48%;">Behavior Statements</th>
                                <th style="width: 10%;">Q1</th>
                                <th style="width: 10%;">Q2</th>
                                <th style="width: 10%;">Q3</th>
                                <th style="width: 10%;">Q4</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $coreValues = [
                                ['Maka-Diyos', 'Expresses one\'s spiritual beliefs while respecting the spiritual beliefs of others', 2],
                                ['', 'Shows adherence to ethical principles by upholding truth', 0],
                                ['Makatao', 'Is sensitive to individual, social, and cultural differences', 2],
                                ['', 'Demonstrates contributions toward solidarity', 0],
                                ['Makakalikasan', 'Cares for the environment and utilizes resources wisely, judiciously, and economically', 1],
                                ['Makabansa', 'Demonstrates pride in being a Filipino; exercises the rights and responsibilities of a Filipino citizen', 2],
                                ['', 'Demonstrates appropriate behavior in carrying out activities in the school, community, and country', 0],
                            ];
                            @endphp
                            
                            @foreach($coreValues as $value)
                            <tr>
                                @if($value[2] > 0)
                                <td rowspan="{{ $value[2] }}" style="font-weight: bold; vertical-align: top;">{{ $value[0] }}</td>
                                @endif
                                <td>{{ $value[1] }}</td>
                                @for($q = 1; $q <= 4; $q++)
                                <td>
                                    <select class="editable-select values-select" style="width: 100%; font-size: 7pt;">
                                        <option value=""></option>
                                        <option value="AO">AO</option>
                                        <option value="SO">SO</option>
                                        <option value="RO">RO</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </td>
                                @endfor
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div style="font-size: 7.5pt; margin-top: 3px; text-align: center;">
                        <strong>Marking:</strong> 
                        <span style="margin-left: 10px;">AO = Always Observed (95-100)</span>
                        <span style="margin-left: 10px;">SO = Sometimes Observed (85-94)</span>
                        <span style="margin-left: 10px;">RO = Rarely Observed (75-84)</span>
                        <span style="margin-left: 10px;">NO = Not Observed (Below 75)</span>
                    </div>
                </div>

                <!-- PART III: ATTENDANCE -->
                <div class="compact-section">
                    <div style="font-size: 9pt; font-weight: bold; margin-bottom: 4px; text-transform: uppercase; background: #e5e7eb; padding: 3px;">
                        Attendance Record
                    </div>
                    
                    @php
                    $months = ['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'Total'];
                    @endphp
                    
                    <table class="attendance-table">
                        <tr style="background: #f9fafb;">
                            <td style="width: 16%; font-weight: bold;">No. of School Days</td>
                            @foreach($months as $month)
                            <td style="width: 7%; text-align: center;">{{ $month }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">No. of Days Present</td>
                            @foreach($months as $i => $month)
                            <td>
                                <input type="number" class="editable-input attendance-input" 
                                       data-month="{{ $i }}" data-type="present"
                                       style="width: 100%; text-align: center; font-size: 7.5pt;" 
                                       value="{{ $attendance[$i]['present'] ?? '' }}">
                            </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">No. of Times Absent</td>
                            @foreach($months as $i => $month)
                            <td>
                                <input type="number" class="editable-input attendance-input" 
                                       data-month="{{ $i }}" data-type="absent"
                                       style="width: 100%; text-align: center; font-size: 7.5pt;" 
                                       value="{{ $attendance[$i]['absent'] ?? '' }}">
                            </td>
                            @endforeach
                        </tr>
                    </table>
                </div>

                <!-- PARENT'S SIGNATURE -->
                <div class="compact-section">
                    <div style="font-size: 9pt; font-weight: bold; margin-bottom: 4px; text-transform: uppercase; background: #e5e7eb; padding: 3px;">
                        Parent/Guardian's Signature
                    </div>
                    <table style="font-size: 8.5pt;">
                        <tr>
                            <td style="width: 20%; font-weight: bold;">1st Quarter:</td>
                            <td style="border-bottom: 1px solid black; width: 80%;">
                                <input type="text" class="editable-input" data-field="sig_q1" style="border: none; background: transparent;">
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">2nd Quarter:</td>
                            <td style="border-bottom: 1px solid black;">
                                <input type="text" class="editable-input" data-field="sig_q2" style="border: none; background: transparent;">
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">3rd Quarter:</td>
                            <td style="border-bottom: 1px solid black;">
                                <input type="text" class="editable-input" data-field="sig_q3" style="border: none; background: transparent;">
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">4th Quarter:</td>
                            <td style="border-bottom: 1px solid black;">
                                <input type="text" class="editable-input" data-field="sig_q4" style="border: none; background: transparent;">
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- CERTIFICATION -->
                <div style="border: 1pt solid black; padding: 6px; margin-bottom: 6px; font-size: 8.5pt;">
                    <p style="text-align: justify; margin-bottom: 8px;">
                        I certify that this is a true record of <strong class="editable" data-field="cert_name">{{ $student->first_name }} {{ $student->last_name }}</strong>, 
                        a pupil of this school. He/She is eligible for admission to Grade <input type="text" class="editable-input" data-field="admission_grade" style="width: 40px; text-align: center;">.
                    </p>
                    
                    <table style="border: none; margin-top: 10px;">
                        <tr style="border: none;">
                            <td style="border: none; width: 50%; text-align: center;">
                                <div style="border-top: 1pt solid black; width: 80%; margin: 0 auto; padding-top: 4px;">
                                    <input type="text" class="editable-input" data-field="adviser_name" 
                                           value="{{ $section->teacher->name ?? '' }}" 
                                           style="text-align: center; border: none; background: transparent; font-weight: bold; width: 100%;">
                                </div>
                                <div style="font-size: 7.5pt;">Class Adviser</div>
                            </td>
                            <td style="border: none; width: 50%; text-align: center;">
                                <div style="border-top: 1pt solid black; width: 80%; margin: 0 auto; padding-top: 4px;">
                                    <input type="text" class="editable-input" data-field="principal_name" 
                                           value="{{ $schoolInfo->principal ?? '' }}" 
                                           style="text-align: center; border: none; background: transparent; font-weight: bold; width: 100%;">
                                </div>
                                <div style="font-size: 7.5pt;">School Principal</div>
                            </td>
                        </tr>
                    </table>
                    
                    <div style="text-align: right; margin-top: 8px; font-size: 8.5pt;">
                        Date: <input type="date" class="editable-input" data-field="cert_date" style="width: 120px;">
                    </div>
                </div>

                <!-- CANCELLATION OF ELIGIBILITY -->
                <div style="border: 1pt solid black; padding: 4px; background: #f9fafb; font-size: 7.5pt;">
                    <div style="font-weight: bold; margin-bottom: 3px;">Cancellation of Eligibility to Transfer</div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Admitted in: <input type="text" class="editable-input" data-field="transfer_school" style="width: 150px;"></span>
                        <span>Date: <input type="date" class="editable-input" data-field="transfer_date" style="width: 100px;"></span>
                    </div>
                    <div style="text-align: right; margin-top: 4px;">
                        <div style="display: inline-block; text-align: center; width: 150px;">
                            <div style="border-top: 1pt solid black; padding-top: 2px;">Principal</div>
                        </div>
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
        setupAutoCalculation();
        setupAutoSave();
        detectPaperSize();
        calculateAgeFromBirthdate(); // Calculate age on load
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
        document.querySelectorAll('.editable').forEach(el => {
            el.contentEditable = editable;
            el.style.cursor = editable ? 'text' : 'default';
        });
    }

    // Auto-calculate age from birthdate
    function calculateAgeFromBirthdate() {
        const birthdateInput = document.getElementById('birthdateInput');
        const ageDisplay = document.getElementById('calculatedAge');
        
        if (!birthdateInput.value) {
            ageDisplay.textContent = '';
            return;
        }
        
        const birthDate = new Date(birthdateInput.value);
        const today = new Date();
        
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        
        // Adjust age if birthday hasn't occurred this year
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        
        // Ensure age is not negative
        if (age < 0) age = 0;
        
        ageDisplay.textContent = age;
        
        // Visual feedback
        ageDisplay.style.background = '#d1fae5';
        ageDisplay.style.color = '#059669';
        
        triggerAutoSave();
    }

    // Detect paper size for display
    function detectPaperSize() {
        const height = window.innerHeight;
        const width = window.innerWidth;
        const detectedEl = document.getElementById('detectedPaper');
        
        // Rough detection based on aspect ratio and size
        const aspectRatio = width / height;
        
        if (aspectRatio > 0.7 && aspectRatio < 0.8) {
            if (height > 1100) {
                detectedEl.textContent = 'A4 / Letter';
            } else {
                detectedEl.textContent = 'Letter (8.5"x11")';
            }
        } else if (aspectRatio > 0.6 && aspectRatio < 0.7) {
            detectedEl.textContent = 'Long/Folio (8.5"x13")';
        } else if (aspectRatio >= 0.8) {
            detectedEl.textContent = 'A4 (210×297mm)';
        } else {
            detectedEl.textContent = 'Auto-detect';
        }
    }

    function setupAutoCalculation() {
        document.querySelectorAll('.grade-input').forEach(input => {
            input.addEventListener('input', function() {
                calculateRow(this.closest('tr'));
                calculateGeneralAverage();
                triggerAutoSave();
            });
        });

        document.querySelectorAll('.attendance-input').forEach(input => {
            input.addEventListener('input', function() {
                calculateAttendanceTotals();
                triggerAutoSave();
            });
        });
    }

    function calculateRow(row) {
        const inputs = row.querySelectorAll('.grade-input');
        let sum = 0;
        let count = 0;
        
        inputs.forEach(input => {
            const val = parseFloat(input.value);
            if (!isNaN(val)) {
                sum += val;
                count++;
            }
        });
        
        const finalCell = row.querySelector('.final-grade');
        const remarksCell = row.querySelector('.remarks');
        
        if (count > 0) {
            const final = Math.round(sum / count);
            finalCell.textContent = final;
            remarksCell.textContent = final >= 75 ? 'Passed' : 'Failed';
            remarksCell.style.color = final >= 75 ? '#059669' : '#dc2626';
        } else {
            finalCell.textContent = '';
            remarksCell.textContent = '';
        }
    }

    function calculateGeneralAverage() {
        const rows = document.querySelectorAll('#gradesBody tr[data-subject-id]');
        let total = 0;
        let count = 0;
        
        rows.forEach(row => {
            const finalText = row.querySelector('.final-grade').textContent;
            const final = parseFloat(finalText);
            if (!isNaN(final)) {
                total += final;
                count++;
            }
        });
        
        const genAvg = count > 0 ? Math.round(total / count) : '';
        const genAvgCell = document.getElementById('generalAverage');
        const finalRemarkCell = document.getElementById('finalRemark');
        
        genAvgCell.textContent = genAvg;
        if (genAvg !== '') {
            finalRemarkCell.textContent = genAvg >= 75 ? 'Passed' : 'Failed';
            finalRemarkCell.style.color = genAvg >= 75 ? '#059669' : '#dc2626';
        } else {
            finalRemarkCell.textContent = '';
        }
    }

    function calculateAttendanceTotals() {
        ['present', 'absent'].forEach(type => {
            const inputs = document.querySelectorAll(`.attendance-input[data-type="${type}"]`);
            let total = 0;
            inputs.forEach((input, idx) => {
                if (idx < 11) { // Exclude total column
                    const val = parseInt(input.value) || 0;
                    total += val;
                }
            });
            const row = inputs[0]?.closest('tr');
            if (row) {
                const totalCell = row.cells[row.cells.length - 1];
                if (totalCell) totalCell.textContent = total || '';
            }
        });
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
            grades: {},
            attendance: {},
            values: {},
            timestamp: new Date().toISOString()
        };

        document.querySelectorAll('.editable').forEach(el => {
            data.fields[el.dataset.field] = el.textContent.trim();
        });

        document.querySelectorAll('.editable-input:not(.grade-input):not(.attendance-input)').forEach(el => {
            if (el.dataset.field) {
                data.fields[el.dataset.field] = el.value;
            }
        });

        document.querySelectorAll('#gradesBody tr[data-subject-id]').forEach(row => {
            const subjectId = row.dataset.subjectId;
            data.grades[subjectId] = {};
            row.querySelectorAll('.grade-input').forEach(input => {
                data.grades[subjectId][input.dataset.quarter] = input.value;
            });
        });

        document.querySelectorAll('.attendance-input').forEach(input => {
            if (!data.attendance[input.dataset.month]) {
                data.attendance[input.dataset.month] = {};
            }
            data.attendance[input.dataset.month][input.dataset.type] = input.value;
        });

        document.querySelectorAll('.values-select').forEach((select, index) => {
            data.values[index] = select.value;
        });

        localStorage.setItem('sf9_draft_{{ $student->id }}', JSON.stringify(data));
        showNotification('Changes saved automatically');
        return data;
    }

    function loadSavedData() {
        const saved = localStorage.getItem('sf9_draft_{{ $student->id }}');
        if (!saved) {
            // If no saved data, still calculate age from existing birthdate
            calculateAgeFromBirthdate();
            return;
        }
        
        try {
            const data = JSON.parse(saved);
            
            Object.entries(data.fields || {}).forEach(([key, value]) => {
                const el = document.querySelector(`[data-field="${key}"]`);
                if (el) {
                    if (el.tagName === 'INPUT' || el.tagName === 'SELECT') {
                        el.value = value;
                    } else {
                        el.textContent = value;
                    }
                }
            });

            // Restore birthdate and recalculate age
            const birthdateInput = document.getElementById('birthdateInput');
            if (data.fields.birthdate) {
                birthdateInput.value = data.fields.birthdate;
            }
            calculateAgeFromBirthdate();

            Object.entries(data.grades || {}).forEach(([subjectId, quarters]) => {
                const row = document.querySelector(`tr[data-subject-id="${subjectId}"]`);
                if (row) {
                    Object.entries(quarters).forEach(([q, val]) => {
                        const input = row.querySelector(`.grade-input[data-quarter="${q}"]`);
                        if (input) input.value = val;
                    });
                    calculateRow(row);
                }
            });
            calculateGeneralAverage();

            Object.entries(data.attendance || {}).forEach(([month, types]) => {
                Object.entries(types).forEach(([type, val]) => {
                    const input = document.querySelector(`.attendance-input[data-month="${month}"][data-type="${type}"]`);
                    if (input) input.value = val;
                });
            });
            calculateAttendanceTotals();

            Object.entries(data.values || {}).forEach(([index, val]) => {
                const selects = document.querySelectorAll('.values-select');
                if (selects[index]) selects[index].value = val;
            });

        } catch (e) {
            console.error('Error loading saved data:', e);
            calculateAgeFromBirthdate();
        }
    }

    function resetForm() {
        if (confirm('Reset all changes? This will clear all entered data.')) {
            localStorage.removeItem('sf9_draft_{{ $student->id }}');
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

    // Handle window resize for paper detection
    window.addEventListener('resize', detectPaperSize);

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