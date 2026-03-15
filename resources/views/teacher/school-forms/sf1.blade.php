<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SF1 - School Register (Landscape)</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
     <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --primary-light: #e0e7ff;
            --secondary: #ec4899;
            --accent: #8b5cf6;
            --success: #10b981;
            --info: #0ea5e9;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #0f172a;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            font-size: 9pt;
            line-height: 1.2;
            background: var(--gray-50);
            color: var(--gray-800);
        }

        /* Modern Top Navigation */
        .top-nav {
            background: white;
            border-bottom: 1px solid var(--gray-200);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.125rem;
        }

        .nav-title-group h1 {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--gray-800);
            margin: 0;
        }

        .nav-title-group p {
            font-size: 0.75rem;
            color: var(--gray-500);
            margin: 0;
        }

        .nav-divider {
            width: 1px;
            height: 32px;
            background: var(--gray-200);
        }

        .nav-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .nav-info-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8125rem;
            color: var(--gray-600);
        }

        .nav-info-item i {
            color: var(--primary);
            font-size: 0.75rem;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Modern Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.1);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.3);
        }

        .btn-secondary {
            background: var(--gray-100);
            color: var(--gray-700);
            border: 1px solid var(--gray-200);
        }

        .btn-secondary:hover {
            background: var(--gray-200);
            border-color: var(--gray-300);
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-success:hover {
            background: #059669;
            box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.3);
        }

        .btn-warning {
            background: var(--warning);
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
            box-shadow: 0 10px 20px -5px rgba(245, 158, 11, 0.3);
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
            box-shadow: 0 10px 20px -5px rgba(239, 68, 68, 0.3);
        }

        .btn-ghost {
            background: transparent;
            color: var(--gray-600);
        }

        .btn-ghost:hover {
            background: var(--gray-100);
            color: var(--gray-800);
        }

        .btn-icon {
            padding: 10px;
            aspect-ratio: 1;
        }

        /* Mobile Menu */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            color: var(--gray-600);
            font-size: 1.25rem;
        }

        .mobile-menu-btn:hover {
            background: var(--gray-100);
        }

        .mobile-actions {
            display: none;
            position: absolute;
            top: 100%;
            right: 20px;
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            padding: 8px;
            min-width: 200px;
            flex-direction: column;
            gap: 4px;
            z-index: 1001;
        }

        .mobile-actions.show {
            display: flex;
        }

        .mobile-actions .btn {
            width: 100%;
            justify-content: flex-start;
            padding: 12px 16px;
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: var(--gray-100);
            border: 1px solid var(--gray-200);
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--gray-600);
        }

        .status-badge.editing {
            background: #fef3c7;
            border-color: #fcd34d;
            color: #92400e;
        }

        .status-badge.editing::before {
            content: '';
            width: 6px;
            height: 6px;
            background: var(--warning);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .status-badge.saving {
            background: #dbeafe;
            border-color: #60a5fa;
            color: #1e40af;
        }

        .status-badge.saved {
            background: #d1fae5;
            border-color: #34d399;
            color: #059669;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Main Content */
        .main-wrapper {
            max-width: 1400px;
            margin: 0 auto;
            padding: 24px;
        }

        /* Document Container */
        .document-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .document-header {
            background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
            padding: 16px 24px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .document-title {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--gray-700);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .document-actions {
            display: flex;
            gap: 8px;
        }

        .sf1-wrapper {
            padding: 24px;
            background: white;
        }

        .sf1-container {
            border: 1.5pt solid black;
            background: white;
            padding: 10px;
            min-height: 210mm;
            position: relative;
        }

        /* Print Styles - FIXED */
        @media print {
            @page {
                size: landscape;
                margin: 5mm;
            }
            
            body { 
                background: white; 
                padding: 0;
                margin: 0;
                font-size: 8pt;
            }
            
            /* Only hide navigation elements, NOT the document card */
            .top-nav,
            .document-header,
            .floating-actions,
            .modal-overlay,
            .toast-container {
                display: none !important;
            }
            
            /* Show the document card and its contents */
            .document-card {
                display: block !important;
                box-shadow: none !important;
                border: none !important;
                border-radius: 0 !important;
                margin: 0 !important;
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
                min-height: auto !important;
                padding: 8mm !important;
                margin: 0 !important;
                transform: none !important; /* Remove zoom transform */
            }

            .edit-indicator,
            .edit-hint {
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

            /* Ensure table prints properly */
            .students-table {
                font-size: 7pt !important;
            }

            .students-table th,
            .students-table td {
                padding: 2px 3px !important;
            }

            /* Force background colors to print */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }

        /* Floating Action Button for Mobile */
        .floating-actions {
            position: fixed;
            bottom: 24px;
            right: 24px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            z-index: 999;
        }

        .fab {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .fab:hover {
            transform: scale(1.1) translateY(-2px);
            box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.3);
        }

        .fab-primary { background: var(--primary); }
        .fab-success { background: var(--success); }
        .fab-warning { background: var(--warning); }

        /* Reset Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            padding: 32px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            transform: scale(0.9) translateY(20px);
            transition: all 0.3s ease;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .modal-overlay.show .modal-content {
            transform: scale(1) translateY(0);
        }

        .modal-icon {
            width: 64px;
            height: 64px;
            background: #fee2e2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 1.75rem;
            color: var(--danger);
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 8px;
        }

        .modal-text {
            color: var(--gray-600);
            font-size: 0.9375rem;
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
        }

        .modal-actions .btn {
            flex: 1;
            justify-content: center;
        }

        /* Toast Notification */
        .toast-container {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 3000;
            display: flex;
            flex-direction: column;
            gap: 8px;
            pointer-events: none;
        }

        .toast {
            background: var(--gray-800);
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.2);
            animation: slideUp 0.3s ease;
            pointer-events: auto;
        }

        .toast.success { background: var(--success); }
        .toast.error { background: var(--danger); }
        .toast.warning { background: var(--warning); }
        .toast.info { background: var(--info); }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Original SF1 Styles (Preserved) */
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
            border-left: 3px solid var(--primary);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .edit-mode .editable-field {
            background: #fef3c7;
            border-bottom: 1px dashed var(--warning);
            cursor: text;
            padding: 1px 3px;
            min-height: 16px;
            display: inline-block;
        }

        .edit-mode .editable-field[contenteditable="true"]:focus {
            outline: 2px solid var(--warning);
            background: white;
        }

        .edit-indicator {
            display: none;
            font-size: 7pt;
            color: var(--warning);
            font-weight: normal;
            margin-left: 10px;
        }

        .edit-mode .edit-indicator {
            display: inline;
        }

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
            border-left: 3px solid var(--primary);
        }

        .female-section {
            border-left: 3px solid var(--secondary);
        }

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

        .default-value {
            color: #6b7280;
            font-style: italic;
        }

        .edit-mode .default-value {
            color: var(--warning);
            font-style: normal;
        }

        .summary-box {
            background: #f9fafb;
            border: 1pt solid black;
            padding: 6px;
            margin-top: 6px;
            font-size: 9pt;
        }

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

        .document-footer {
            margin-top: 8px;
            padding-top: 4px;
            border-top: 1pt solid #d1d5db;
            font-size: 7pt;
            color: #6b7280;
            display: flex;
            justify-content: space-between;
        }

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

        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

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

        .row-number {
            text-align: center;
            font-weight: 600;
            color: #4b5563;
        }

        .readonly-notice {
            font-size: 7pt;
            color: #6b7280;
            font-weight: normal;
            font-style: italic;
        }

        .edit-mode .readonly-notice {
            color: var(--danger);
            font-weight: bold;
        }

        .count-summary {
            background: #f3f4f6;
            font-weight: bold;
            font-size: 7.5pt;
            text-align: right;
            padding-right: 10px;
        }

        /* Auto-save indicator */
        .autosave-indicator {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.75rem;
            color: var(--gray-500);
            margin-left: 10px;
        }

        .autosave-indicator.saving {
            color: var(--info);
        }

        .autosave-indicator.saved {
            color: var(--success);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .desktop-actions {
                display: none;
            }

            .mobile-menu-btn {
                display: block;
            }

            .nav-divider,
            .nav-info {
                display: none;
            }
        }

        @media (max-width: 640px) {
            .nav-container {
                padding: 12px 16px;
            }

            .nav-title-group h1 {
                font-size: 1rem;
            }

            .sf1-wrapper {
                padding: 16px;
            }

            .floating-actions {
                bottom: 16px;
                right: 16px;
            }
        }
    </style>
</head>
<body>

    <!-- Modern Top Navigation -->
    <nav class="top-nav">
        <div class="nav-container">
            <div class="nav-left">
                <div class="nav-brand">
                    <div class="nav-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="nav-title-group">
                        <h1>SF1 - School Register</h1>
                        <p>DepEd Official Form</p>
                    </div>
                </div>
                
                <div class="nav-divider"></div>
                
                <div class="nav-info">
                    <div class="nav-info-item">
                        <i class="fas fa-graduation-cap"></i>
                        <span>{{ $section->year_level ?? 'Grade Level' }} - {{ $section->name ?? 'Section' }}</span>
                    </div>
                    <div class="nav-info-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>SY {{ $activeSchoolYear->name ?? '2025-2026' }}</span>
                    </div>
                </div>
            </div>

            <div class="nav-right">
                <div class="status-badge" id="statusBadge">
                    <i class="fas fa-eye"></i>
                    <span>View Mode</span>
                </div>

                <div class="desktop-actions">
                    <button onclick="toggleEditMode()" class="btn btn-warning" id="editBtn">
                        <i class="fas fa-pen"></i>
                        <span>Edit</span>
                    </button>
                    
                    <button onclick="confirmReset()" class="btn btn-danger">
                        <i class="fas fa-rotate-left"></i>
                        <span>Reset</span>
                    </button>
                   
                    
                </div>

                <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                    <i class="fas fa-ellipsis-v"></i>
                </button>

                <div class="mobile-actions" id="mobileActions">
                    <button onclick="toggleEditMode(); toggleMobileMenu();" class="btn btn-warning" id="mobileEditBtn">
                        <i class="fas fa-pen"></i>
                        <span>Edit</span>
                    </button>
                    <button onclick="confirmReset(); toggleMobileMenu();" class="btn btn-danger">
                        <i class="fas fa-rotate-left"></i>
                        <span>Reset</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-wrapper">
        <div class="document-card">
            <div class="document-header">
                <div class="document-title">
                    <i class="fas fa-file-alt" style="color: var(--primary);"></i>
                    School Form 1 Preview
                </div>
                <div class="document-actions">
                    <button onclick="zoomOut()" class="btn btn-ghost btn-icon" title="Zoom Out">
                        <i class="fas fa-minus"></i>
                    </button>
                    <span id="zoomLevel" style="font-size: 0.875rem; color: var(--gray-600); min-width: 50px; text-align: center;">100%</span>
                    <button onclick="zoomIn()" class="btn btn-ghost btn-icon" title="Zoom In">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>

            <div class="sf1-wrapper" id="sf1Wrapper">
                <div class="sf1-container" id="sf1Container">
                    
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
                                    <span class="editable-field" data-field="school_id" data-original="{{ $school->school_id ?? '120231' }}">{{ $school->school_id ?? '120231' }}</span>
                                </td>
                                <td style="width: 12%; font-weight: bold; background: #f9fafb;">Region</td>
                                <td style="width: 20%;">
                                    <span class="editable-field" data-field="region" data-original="{{ $school->region ?? 'NIR - Negros Island Region' }}">{{ $school->region ?? 'NIR - Negros Island Region' }}</span>
                                </td>
                                <td style="width: 12%; font-weight: bold; background: #f9fafb;">Division</td>
                                <td style="width: 29%;">
                                    <span class="editable-field" data-field="division" data-original="{{ $school->division ?? 'Division of Negros Oriental' }}">{{ $school->division ?? 'Division of Negros Oriental' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; background: #f9fafb;">School Name</td>
                                <td colspan="3">
                                    <span class="editable-field font-bold" data-field="school_name" data-original="{{ $school->name ?? 'Tugawe Elementary School' }}">{{ $school->name ?? 'Tugawe Elementary School' }}</span>
                                </td>
                                <td style="font-weight: bold; background: #f9fafb;">District</td>
                                <td>
                                    <span class="editable-field" data-field="district" data-original="{{ $school->district ?? 'Dauin District' }}">{{ $school->district ?? 'Dauin District' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold; background: #f9fafb;">School Year</td>
                                <td>
                                    <span class="editable-field font-bold" data-field="school_year" data-original="{{ $activeSchoolYear->name ?? 'N/A' }}">{{ $activeSchoolYear->name ?? 'N/A' }}</span>
                                </td>
                                <td style="font-weight: bold; background: #f9fafb;">Grade Level</td>
                                <td>
                                    <span class="editable-field font-bold" data-field="grade_level" data-original="{{ $section->year_level ?? 'N/A' }}">{{ $section->year_level ?? 'N/A' }}</span>
                                </td>
                                <td style="font-weight: bold; background: #f9fafb;">Section</td>
                                <td>
                                    <span class="editable-field font-bold" data-field="section" data-original="{{ $section->name ?? 'N/A' }}">{{ $section->name ?? 'N/A' }}</span>
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
                                    <span class="editable-field font-bold uppercase" data-field="adviser_name" data-original="{{ $adviser ?? auth()->user()->full_name ?? '____________________' }}">{{ $adviser ?? auth()->user()->full_name ?? '____________________' }}</span>
                                </td>
                                <td style="width: 15%; font-weight: bold; background: #f9fafb;">Date Generated</td>
                                <td style="width: 20%;">
                                    <span class="editable-field" data-field="date_generated" data-original="{{ now()->format('F d, Y') }}">{{ now()->format('F d, Y') }}</span>
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
                                    <th class="col-address">House No./Street</th>
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
                                    
                                    // Default address values
                                    $defaultStreet = 'Purok 1';
                                    $defaultBarangay = 'Tugawe';
                                    $defaultMunicipality = 'Dauin';
                                    $defaultProvince = 'Negros Oriental';
                                @endphp
                                
                                {{-- MALE STUDENTS SECTION --}}
                                @if($maleStudents->count() > 0)
                                    <tr class="gender-header">
                                        <td colspan="12" style="background: #dbeafe; color: #1e40af; border-left: 3px solid var(--primary);">
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
                                            
                                            // Address defaults
                                            $street = $student->house_no_street ?? 'N/A';
                                            $barangay = $student->barangay ?? 'Tugawe';
                                            $municipality = $student->municipality ?? 'Dauin';
                                            $province = $student->province ?? 'Negros Oriental';
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
                                            <td class="data-text editable-field default-value" data-field="mother_tongue_{{ $student->id }}" data-original="{{ $motherTongue }}">{{ $motherTongue }}</td>
                                            <td class="data-text editable-field default-value" data-field="ethnic_group_{{ $student->id }}" data-original="{{ $ethnicGroup }}">{{ $ethnicGroup }}</td>
                                            <td class="data-text editable-field default-value" data-field="religion_{{ $student->id }}" data-original="{{ $religion }}">{{ $religion }}</td>
                                            <td class="data-text editable-field default-value" data-field="street_{{ $student->id }}" data-original="{{ $street }}">{{ $street }}</td>
                                            <td class="data-text editable-field default-value" data-field="barangay_{{ $student->id }}" data-original="{{ $barangay }}">{{ $barangay }}</td>
                                            <td class="data-text editable-field default-value" data-field="municipality_{{ $student->id }}" data-original="{{ $municipality }}">{{ $municipality }}</td>
                                            <td class="data-text editable-field default-value" data-field="province_{{ $student->id }}" data-original="{{ $province }}">{{ $province }}</td>
                                        </tr>
                                    @endforeach
                                    
                                    <tr>
                                        <td colspan="12" class="count-summary" style="background: #eff6ff;">
                                            Male Subtotal: {{ $maleStudents->count() }} students
                                        </td>
                                    </tr>
                                @endif
                                
                                {{-- FEMALE STUDENTS SECTION --}}
                                @if($femaleStudents->count() > 0)
                                    <tr class="gender-header">
                                        <td colspan="12" style="background: #fce7f3; color: #be185d; border-left: 3px solid var(--secondary);">
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
                                            
                                            // Address defaults
                                            $street = $student->house_no_street ?? $defaultStreet;
                                            $barangay = $student->barangay ?? $defaultBarangay;
                                            $municipality = $student->municipality ?? $defaultMunicipality;
                                            $province = $student->province ?? $defaultProvince;
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
                                            <td class="data-text editable-field default-value" data-field="mother_tongue_{{ $student->id }}" data-original="{{ $motherTongue }}">{{ $motherTongue }}</td>
                                            <td class="data-text editable-field default-value" data-field="ethnic_group_{{ $student->id }}" data-original="{{ $ethnicGroup }}">{{ $ethnicGroup }}</td>
                                            <td class="data-text editable-field default-value" data-field="religion_{{ $student->id }}" data-original="{{ $religion }}">{{ $religion }}</td>
                                            <td class="data-text editable-field default-value" data-field="street_{{ $student->id }}" data-original="{{ $street }}">{{ $street }}</td>
                                            <td class="data-text editable-field default-value" data-field="barangay_{{ $student->id }}" data-original="{{ $barangay }}">{{ $barangay }}</td>
                                            <td class="data-text editable-field default-value" data-field="municipality_{{ $student->id }}" data-original="{{ $municipality }}">{{ $municipality }}</td>
                                            <td class="data-text editable-field default-value" data-field="province_{{ $student->id }}" data-original="{{ $province }}">{{ $province }}</td>
                                        </tr>
                                    @endforeach
                                    
                                    <tr>
                                        <td colspan="12" class="count-summary" style="background: #fdf2f8;">
                                            Female Subtotal: {{ $femaleStudents->count() }} students
                                        </td>
                                    </tr>
                                @endif
                                
                                {{-- NO STUDENTS MESSAGE --}}
                                @if(($maleStudents->count() + $femaleStudents->count()) == 0)
                                    <tr>
                                        <td colspan="12" style="text-align: center; padding: 20px; color: #6b7280; font-style: italic;">
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
                                    </tr>
                                    @endfor
                                @endif
                                
                                {{-- GRAND TOTAL ROW --}}
                                @if(($maleStudents->count() + $femaleStudents->count()) > 0)
                                    <tr style="background: #f3f4f6; font-weight: bold; border-top: 2pt solid black;">
                                        <td colspan="12" class="count-summary" style="text-align: center; font-size: 8pt; padding: 5px;">
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
                                    <span class="editable-field uppercase font-bold" data-field="adviser_signature" data-original="{{ $adviser ?? auth()->user()->full_name ?? '' }}" style="font-size: 9pt;">{{ $adviser ?? auth()->user()->full_name ?? '' }}</span>
                                </div>
                                <div style="font-size: 7pt; margin-top: 3px;">Class Adviser (Signature over Printed Name)</div>
                                <div style="margin-top: 8px; font-size: 8pt;">
                                    Date: <span class="editable-field" data-field="adviser_date" style="border-bottom: 1pt solid black; display: inline-block; min-width: 100px; text-align: center;">&nbsp;</span>
                                </div>
                            </div>
                            
                            <div style="text-align: center;">
                                <div class="signature-line">
                                    <span class="editable-field uppercase font-bold" data-field="principal_signature" data-original="{{ $school->principal ?? '' }}" style="font-size: 9pt;">{{ $school->principal ?? '' }}</span>
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
        </div>
    </main>

   <!-- Floating Action Button Container -->
<div class="fab-container">
    <a href="{{ route('teacher.school-forms.sf1.select-section') }}" class="fab-button fab-back" title="Back to Dashboard">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        <span class="fab-tooltip">Back to Dashboard</span>
    </a>
    
    <button onclick="window.print()" class="fab-button fab-print" title="Print SF1">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 6 2 18 2 18 9"></polyline>
            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
            <rect x="6" y="14" width="12" height="8"></rect>
        </svg>
        <span class="fab-tooltip">Print SF1</span>
    </button>
</div>

<style>
    /* CSS Variables (add to your existing :root) */
    :root {
        --primary: #1e3a8a;
        --primary-dark: #1e40af;
        --primary-light: #3b82f6;
        --text: #0f172a;
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

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .fab-container {
            bottom: 1.5rem;
            right: 1.5rem;
            gap: 0.75rem;
        }
        
        .fab-button {
            width: 48px;
            height: 48px;
        }
        
        .fab-button svg {
            width: 20px;
            height: 20px;
        }
        
        .fab-tooltip {
            display: none; /* Hide tooltips on mobile */
        }
    }

    /* Print styles - hide FAB when printing */
    @media print {
        .fab-container {
            display: none !important;
        }
    }
</style>

    <!-- Reset Confirmation Modal -->
    <div class="modal-overlay" id="resetModal">
        <div class="modal-content">
            <div class="modal-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="modal-title">Reset All Changes?</div>
            <div class="modal-text">
                This will restore all fields to their original values. This action cannot be undone.
            </div>
            <div class="modal-actions">
                <button onclick="closeResetModal()" class="btn btn-secondary">
                    Cancel
                </button>
                <button onclick="executeReset()" class="btn btn-danger">
                    <i class="fas fa-rotate-left"></i>
                    Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <script>
        let isEditMode = false;
        let currentZoom = 100;

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadSavedEdits();
            updateEnrollmentSummary();
            setupKeyboardShortcuts();
        });

        // Toggle Mobile Menu
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileActions');
            menu.classList.toggle('show');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('mobileActions');
            const btn = document.querySelector('.mobile-menu-btn');
            if (!menu.contains(e.target) && !btn.contains(e.target)) {
                menu.classList.remove('show');
            }
        });

        // Edit Mode Toggle
        function toggleEditMode() {
            isEditMode = !isEditMode;
            const wrapper = document.getElementById('sf1Wrapper');
            const statusBadge = document.getElementById('statusBadge');
            const editBtn = document.getElementById('editBtn');
            const mobileEditBtn = document.getElementById('mobileEditBtn');
            
            if (isEditMode) {
                wrapper.classList.add('edit-mode');
                statusBadge.classList.add('editing');
                statusBadge.innerHTML = '<i class="fas fa-pen"></i><span>Editing</span>';
                
                if (editBtn) {
                    editBtn.classList.remove('btn-warning');
                    editBtn.classList.add('btn-success');
                    editBtn.innerHTML = '<i class="fas fa-check"></i><span>Done</span>';
                }
                
                if (mobileEditBtn) {
                    mobileEditBtn.classList.remove('btn-warning');
                    mobileEditBtn.classList.add('btn-success');
                    mobileEditBtn.innerHTML = '<i class="fas fa-check"></i><span>Done</span>';
                }
                
                makeEditableFields(true);
                showToast('Edit mode enabled. Click any field to edit.', 'warning');
            } else {
                wrapper.classList.remove('edit-mode');
                statusBadge.classList.remove('editing');
                statusBadge.innerHTML = '<i class="fas fa-eye"></i><span>View Mode</span>';
                
                if (editBtn) {
                    editBtn.classList.remove('btn-success');
                    editBtn.classList.add('btn-warning');
                    editBtn.innerHTML = '<i class="fas fa-pen"></i><span>Edit</span>';
                }
                
                if (mobileEditBtn) {
                    mobileEditBtn.classList.remove('btn-success');
                    mobileEditBtn.classList.add('btn-warning');
                    mobileEditBtn.innerHTML = '<i class="fas fa-pen"></i><span>Edit</span>';
                }
                
                makeEditableFields(false);
                saveEdits();
                showToast('Changes saved successfully', 'success');
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

        // Reset Functionality
        function confirmReset() {
            if (isEditMode) {
                toggleEditMode(); // Exit edit mode first
            }
            document.getElementById('resetModal').classList.add('show');
        }

        function closeResetModal() {
            document.getElementById('resetModal').classList.remove('show');
        }

        function executeReset() {
            const sectionId = '{{ $section->id ?? "default" }}';
            
            // Clear localStorage
            localStorage.removeItem('sf1_edits_' + sectionId);
            
            // Reset all fields to original values
            document.querySelectorAll('.editable-field').forEach(el => {
                const originalValue = el.getAttribute('data-original');
                if (originalValue !== null) {
                    el.textContent = originalValue;
                    el.classList.add('default-value');
                }
            });
            
            closeResetModal();
            updateEnrollmentSummary();
            showToast('All fields reset to original values', 'success');
        }

        // Close modal on overlay click
        document.getElementById('resetModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeResetModal();
            }
        });

        // Zoom Functions
        function zoomIn() {
            if (currentZoom < 150) {
                currentZoom += 10;
                applyZoom();
            }
        }

        function zoomOut() {
            if (currentZoom > 70) {
                currentZoom -= 10;
                applyZoom();
            }
        }

        function applyZoom() {
            const container = document.getElementById('sf1Container');
            container.style.transform = `scale(${currentZoom / 100})`;
            container.style.transformOrigin = 'top center';
            document.getElementById('zoomLevel').textContent = currentZoom + '%';
        }

        // Save/Load Edits
        function saveEdits() {
            const edits = {};
            document.querySelectorAll('.editable-field').forEach(el => {
                if (el.dataset.field) {
                    const value = el.textContent.trim();
                    const original = el.getAttribute('data-original');
                    if (value !== original) {
                        edits[el.dataset.field] = value;
                        el.classList.remove('default-value');
                    } else {
                        el.classList.add('default-value');
                    }
                }
            });
            
            const sectionId = '{{ $section->id ?? "default" }}';
            localStorage.setItem('sf1_edits_' + sectionId, JSON.stringify(edits));
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
                        if (el && value) {
                            el.textContent = value;
                            el.classList.remove('default-value');
                        }
                    });
                } catch (e) {
                    console.error('Error loading saved edits:', e);
                }
            }
        }

        function updateEnrollmentSummary() {
            const maleRows = document.querySelectorAll('.male-section').length;
            const femaleRows = document.querySelectorAll('.female-section').length;
            const total = maleRows + femaleRows;
            
            const maleDisplay = document.getElementById('maleCountDisplay');
            const femaleDisplay = document.getElementById('femaleCountDisplay');
            const totalDisplay = document.getElementById('totalCountDisplay');
            
            if (maleDisplay) maleDisplay.textContent = maleRows;
            if (femaleDisplay) femaleDisplay.textContent = femaleRows;
            if (totalDisplay) totalDisplay.textContent = total;
        }

        // Export to Excel
        function exportToExcel() {
            const students = [];
            document.querySelectorAll('#studentTable tbody tr[data-student-id]').forEach(row => {
                const cells = row.querySelectorAll('td');
                if (cells.length > 1 && cells[1].textContent.trim() !== '') {
                    students.push({
                        no: cells[0].textContent.trim(),
                        lrn: cells[1].textContent.trim(),
                        name: cells[2].textContent.trim(),
                        birthday: cells[3].textContent.trim(),
                        age: cells[4].textContent.trim(),
                        mother_tongue: cells[5].textContent.trim(),
                        ethnic_group: cells[6].textContent.trim(),
                        religion: cells[7].textContent.trim(),
                        address: cells[8].textContent.trim(),
                        barangay: cells[9].textContent.trim(),
                        municipality: cells[10].textContent.trim(),
                        province: cells[11].textContent.trim()
                    });
                }
            });

            if (students.length === 0) {
                showToast('No student data to export', 'error');
                return;
            }

            const schoolName = document.querySelector('[data-field="school_name"]')?.textContent?.trim() || '{{ $school->name ?? "Tugawe Elementary School" }}';
            const schoolYear = document.querySelector('[data-field="school_year"]')?.textContent?.trim() || '{{ $activeSchoolYear->name ?? "2025-2026" }}';
            const gradeLevel = document.querySelector('[data-field="grade_level"]')?.textContent?.trim() || '{{ $section->year_level ?? "" }}';
            const sectionName = document.querySelector('[data-field="section"]')?.textContent?.trim() || '{{ $section->name ?? "" }}';

            let csv = 'SCHOOL FORM 1 (SF1) - SCHOOL REGISTER\n';
            csv += `School: ${schoolName}\n`;
            csv += `School Year: ${schoolYear}\n`;
            csv += `Grade/Section: ${gradeLevel} - ${sectionName}\n`;
            csv += `Generated: ${new Date().toLocaleString()}\n\n`;
            
            csv += 'No.,LRN,Learner Name,Birthday,Age,Mother Tongue,Ethnic Group,Religion,House No/Street,Barangay,Municipality,Province\n';
            
            students.forEach(s => {
                const escapeCsv = (str) => `"${(str || '').replace(/"/g, '""')}"`;
                csv += `${s.no},${escapeCsv(s.lrn)},${escapeCsv(s.name)},${escapeCsv(s.birthday)},${s.age},${escapeCsv(s.mother_tongue)},${escapeCsv(s.ethnic_group)},${escapeCsv(s.religion)},${escapeCsv(s.address)},${escapeCsv(s.barangay)},${escapeCsv(s.municipality)},${escapeCsv(s.province)}\n`;
            });

            const maleCount = document.querySelectorAll('.male-section').length;
            const femaleCount = document.querySelectorAll('.female-section').length;
            csv += `\nSUMMARY\n`;
            csv += `Male,${maleCount}\n`;
            csv += `Female,${femaleCount}\n`;
            csv += `Total,${maleCount + femaleCount}\n`;

            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            
            const safeSection = (sectionName || 'Section').replace(/[^a-z0-9]/gi, '_');
            const safeYear = (schoolYear || '2025-2026').replace(/[^a-z0-9]/gi, '_');
            
            link.setAttribute('href', url);
            link.setAttribute('download', `SF1_${safeSection}_${safeYear}.csv`);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            showToast('Excel file downloaded successfully', 'success');
        }

        // Toast Notification System
        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            
            const icon = type === 'success' ? 'check-circle' : 
                        type === 'error' ? 'times-circle' : 
                        type === 'warning' ? 'exclamation-circle' : 'info-circle';
            
            toast.innerHTML = `<i class="fas fa-${icon}"></i><span>${message}</span>`;
            container.appendChild(toast);
            
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-20px)';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Keyboard Shortcuts
        function setupKeyboardShortcuts() {
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + P = Print
                if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                    e.preventDefault();
                    window.print();
                }
                
                // Ctrl/Cmd + E = Toggle Edit
                if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
                    e.preventDefault();
                    toggleEditMode();
                }
                
                // Ctrl/Cmd + S = Save (exit edit mode)
                if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                    e.preventDefault();
                    if (isEditMode) {
                        toggleEditMode();
                    }
                }
                
                // Escape = Close modals or exit edit mode
                if (e.key === 'Escape') {
                    if (document.getElementById('resetModal').classList.contains('show')) {
                        closeResetModal();
                    } else if (isEditMode) {
                        toggleEditMode();
                    }
                }
            });
        }
    </script>

</body>
</html>