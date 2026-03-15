<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DepEd SF5 - Report on Promotion and Level of Proficiency | {{ $school?->name ?? 'School' }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --primary: #1e3a8a;
            --primary-light: #3b82f6;
            --primary-dark: #1e40af;
            --primary-gradient: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            --success: #059669;
            --success-light: #10b981;
            --warning: #d97706;
            --warning-light: #f59e0b;
            --danger: #dc2626;
            --danger-light: #ef4444;
            --info: #0891b2;
            --bg: #f1f5f9;
            --card: #ffffff;
            --text: #0f172a;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        /* Print Styles */
        @media print {
            body { 
                background: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .no-print { display: none !important; }
            .fab-container { display: none !important; }
            .sf5-container { 
                box-shadow: none !important; 
                border: 1px solid #000;
                border-radius: 0 !important;
            }
            .sf5-header { 
                background: #f8fafc !important; 
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .data-table th { 
                background: #1e3a8a !important; 
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .data-table th.section-header {
                background: #f8fafc !important;
                color: #1e3a8a !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .editable-input { 
                border: none !important; 
                background: transparent !important; 
                text-align: center;
            }
            .stats-bar, .summary-cards, .section-selector { display: none !important; }
        }
        
        /* App Header */
        .app-header {
            background: var(--primary-gradient);
            color: white;
            padding: 1.25rem 2rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }
        
        .app-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.4;
        }
        
        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 1;
        }
        
        .brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .logo-icon {
            width: 52px;
            height: 52px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        }
        
        .logo-icon svg {
            width: 28px;
            height: 28px;
            stroke: white;
            stroke-width: 2;
            fill: none;
        }
        
        .brand-text h1 {
            font-size: 1.35rem;
            font-weight: 800;
            letter-spacing: -0.025em;
            margin-bottom: 0.15rem;
        }
        
        .brand-text p {
            font-size: 0.875rem;
            opacity: 0.85;
            font-weight: 500;
        }
        
        .header-date {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            background: rgba(255,255,255,0.1);
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        /* Control Bar */
        .control-bar {
            background: var(--card);
            border-bottom: 1px solid var(--border);
            padding: 1.25rem 2rem;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: var(--shadow-sm);
        }
        
        .control-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }
        
        .school-info-bar {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .school-avatar {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: var(--primary-gradient);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.1rem;
            box-shadow: var(--shadow);
            border: 3px solid white;
        }
        
        .school-details h3 {
            font-size: 1.125rem;
            font-weight: 700;
            margin: 0;
            color: var(--text);
            letter-spacing: -0.025em;
        }
        
        .school-details p {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin: 0.15rem 0 0 0;
            font-weight: 500;
        }
        
        .school-meta-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: #dbeafe;
            color: var(--primary);
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        /* Section Selector */
        .section-selector {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: #f8fafc;
            padding: 0.5rem;
            border-radius: 12px;
            border: 1px solid var(--border);
        }
        
        .section-selector label {
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .section-selector select {
            padding: 0.625rem 1rem;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 0.9rem;
            background: white;
            font-weight: 500;
            color: var(--text);
            cursor: pointer;
            transition: all 0.2s;
            min-width: 220px;
        }
        
        .section-selector select:hover {
            border-color: var(--primary-light);
        }
        
        .section-selector select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        /* Floating Action Buttons */
        .fab-container {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            display: flex;
            flex-direction: column;
            gap: 0.875rem;
            z-index: 1000;
            align-items: flex-end;
        }
        
        .fab-button {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-xl);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }
        
        .fab-button:hover {
            transform: translateY(-4px) scale(1.08);
        }
        
        .fab-button svg {
            width: 26px;
            height: 26px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }
        
        .fab-back {
            background: white;
            color: var(--text);
            border: 2px solid var(--border);
        }
        
        .fab-print {
            background: var(--primary-gradient);
            color: white;
            animation: pulse 2s infinite;
        }
        
        .fab-export {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            color: white;
        }
        
        .fab-tooltip {
            position: absolute;
            right: 75px;
            background: rgba(15, 23, 42, 0.95);
            color: white;
            padding: 0.625rem 1rem;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transform: translateX(15px);
            transition: all 0.3s;
        }
        
        .fab-button:hover .fab-tooltip {
            opacity: 1;
            visibility: visible;
            transform: translateX(0);
        }
        
        @keyframes pulse {
            0%, 100% { box-shadow: 0 10px 15px -3px rgba(30, 58, 138, 0.3); }
            50% { box-shadow: 0 10px 25px -5px rgba(30, 58, 138, 0.5), 0 0 0 10px rgba(30, 58, 138, 0.05); }
        }
        
        /* Main Container */
        .container {
            max-width: 1600px;
            margin: 2.5rem auto;
            padding: 0 2rem;
            padding-bottom: 8rem;
        }
        
        .sf5-container {
            background: var(--card);
            border-radius: 16px;
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            border: 1px solid var(--border);
        }
        
        /* Official DepEd Header */
        .sf5-header {
            padding: 2.5rem;
            border-bottom: 3px double var(--primary);
            background: linear-gradient(135deg, #f8fafc 0%, #f0f9ff 100%);
            position: relative;
        }
        
        .sf5-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-light) 50%, var(--primary) 100%);
            opacity: 0.2;
        }
        
        .header-grid {
            display: grid;
            grid-template-columns: 1fr 2.5fr 1fr;
            gap: 2.5rem;
            margin-bottom: 2rem;
            align-items: center;
        }
        
        .header-left-side, .header-right-side {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
        }
        
        .header-logo-left, .header-logo-right {
            width: 85px;
            height: 85px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow);
            padding: 8px;
        }
        
        .header-logo-img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        
        .header-logo-placeholder {
            width: 85px;
            height: 85px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            text-align: center;
            color: var(--text-muted);
            border: 2px dashed var(--border);
            border-radius: 12px;
            font-weight: 600;
        }
        
        .header-center {
            text-align: center;
        }
        
        .header-center h2 {
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 0.35rem;
            color: var(--text-secondary);
            font-weight: 700;
        }
        
        .header-center h1 {
            font-size: 1.4rem;
            font-weight: 800;
            color: white;
            background: var(--primary-gradient);
            display: inline-block;
            padding: 0.75rem 2.5rem;
            border-radius: 8px;
            margin: 0.75rem 0;
            box-shadow: var(--shadow-lg);
            letter-spacing: -0.025em;
        }
        
        .header-center p {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-style: italic;
            font-weight: 500;
        }
        
        .info-field {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            text-align: center;
            min-width: 120px;
        }
        
        .info-field label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--text-muted);
            letter-spacing: 0.05em;
        }
        
        .info-field .value {
            padding: 0.625rem;
            background: white;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text);
            min-height: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-sm);
        }
        
        /* School Info Grid */
        .school-info-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
            margin-top: 1rem;
        }
        
        .school-info-grid .info-field {
            text-align: left;
        }
        
        .school-info-grid .info-field label {
            text-align: left;
            padding-left: 0.25rem;
        }
        
        .school-info-grid .info-field .value {
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            border-bottom: 3px solid var(--primary);
            border-radius: 0;
            background: transparent;
            box-shadow: none;
            padding-left: 0.25rem;
        }
        
        /* Year Level Badge */
        .year-level-badge {
            background: var(--primary-gradient);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            font-size: 1.2rem;
            font-weight: 800;
            display: inline-block;
            text-align: center;
        }
        
        /* Summary Cards */
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
            padding: 1.5rem 2.5rem;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border-bottom: 1px solid #bfdbfe;
        }
        
        .summary-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: white;
            padding: 1.25rem;
            border-radius: 12px;
            box-shadow: var(--shadow);
            border: 1px solid #bfdbfe;
            transition: transform 0.2s;
        }
        
        .summary-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .summary-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
            box-shadow: var(--shadow);
        }
        
        .summary-icon svg {
            width: 28px;
            height: 28px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }
        
        .summary-icon.promoted { 
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); 
            color: var(--primary); 
        }
        .summary-icon.irregular { 
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); 
            color: var(--warning); 
        }
        .summary-icon.retained { 
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); 
            color: var(--danger); 
        }
        .summary-icon.deferred { 
            background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); 
            color: #4338ca; 
        }
        
        .summary-details h4 {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text);
            line-height: 1;
            margin-bottom: 0.25rem;
            letter-spacing: -0.05em;
        }
        
        .summary-details p {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 600;
        }
        
        /* Data Table */
        .table-wrapper {
            overflow-x: auto;
            padding: 2rem;
            background: white;
        }
        
        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.75rem;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
        }
        
        .data-table th {
            background: var(--primary-gradient);
            color: white;
            padding: 0.75rem 0.4rem;
            text-align: center;
            font-weight: 700;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            border-right: 1px solid rgba(255,255,255,0.15);
            white-space: nowrap;
        }
        
        .data-table th:last-child {
            border-right: none;
        }
        
        /* Section Header - Light background with dark text */
        .data-table th.section-header {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: var(--text);
            border-right: 1px solid var(--border);
            border-bottom: 2px solid var(--primary);
            font-weight: 800;
            font-size: 0.65rem;
        }
        
        .data-table td {
            padding: 0.625rem 0.4rem;
            text-align: center;
            border-bottom: 1px solid var(--border);
            border-right: 1px solid var(--border);
            transition: background-color 0.15s;
            font-weight: 600;
        }
        
        .data-table td:last-child {
            border-right: none;
        }
        
        .data-table tr:last-child td {
            border-bottom: none;
        }
        
        .data-table tbody tr {
            background: white;
        }
        
        .data-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }
        
        .data-table tbody tr:hover {
            background: #eff6ff;
        }
        
        /* Student Name Column */
        .student-name {
            text-align: left !important;
            padding-left: 1rem !important;
            font-weight: 700;
            color: var(--text);
            min-width: 200px;
        }
        
        /* LRN Column */
        .lrn-column {
            font-family: 'Courier New', monospace;
            font-weight: 700;
            color: var(--primary);
            min-width: 120px;
        }
        
        /* Grade Columns */
        .grade-cell {
            font-weight: 700;
            min-width: 45px;
        }
        
        .grade-cell.high {
            color: var(--success);
        }
        
        .grade-cell.average {
            color: var(--warning);
        }
        
        .grade-cell.low {
            color: var(--danger);
        }
        
        .grade-cell.empty {
            color: var(--text-muted);
            font-weight: 400;
        }
        
        /* General Average */
        .gen-ave {
            font-weight: 800;
            font-size: 0.9rem;
            background: #f1f5f9;
        }
        
        /* Action Column */
        .action-promoted {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: var(--success);
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.7rem;
        }
        
        .action-irregular {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: var(--warning);
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.7rem;
        }
        
        .action-retained {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: var(--danger);
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.7rem;
        }
        
        .action-deferred {
            background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
            color: #4338ca;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.7rem;
        }
        
        /* Incomplete Grades */
        .incomplete {
            color: var(--danger);
            font-weight: 800;
        }
        
        /* Totals Row */
        .totals-row {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%) !important;
            font-weight: 800;
            font-size: 0.85rem;
        }
        
        .totals-row td {
            border-top: 3px solid var(--primary) !important;
            padding: 1rem 0.5rem !important;
            color: var(--text);
        }
        
        /* Legend */
        .legend {
            display: flex;
            gap: 1.5rem;
            padding: 1rem 2.5rem;
            background: white;
            border-bottom: 1px solid var(--border);
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 4px;
        }
        
        /* Signatures */
        .signatures {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 3rem;
            padding: 3rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .signature-box {
            text-align: center;
            position: relative;
        }
        
        .signature-line {
            border-bottom: 2px solid var(--text);
            height: 60px;
            margin-bottom: 1rem;
            position: relative;
            background: linear-gradient(to bottom, transparent 95%, rgba(30, 58, 138, 0.1) 100%);
        }
        
        .editable-input {
            border: 2px solid var(--border);
            padding: 0.625rem 1rem;
            font-family: inherit;
            font-size: 1rem;
            text-align: center;
            width: 100%;
            max-width: 280px;
            background: white;
            border-radius: 10px;
            margin-bottom: 0.75rem;
            font-weight: 600;
            color: var(--text);
            transition: all 0.2s;
            box-shadow: var(--shadow-sm);
        }
        
        .editable-input:focus {
            border-color: var(--primary);
            outline: none;
            background: #f8fafc;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        
        .editable-date {
            font-size: 0.85rem;
            max-width: 200px;
            margin-top: 0.5rem;
        }
        
        .signature-title {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 600;
        }
        
        /* Footer */
        .sf5-footer {
            padding: 1.25rem;
            text-align: center;
            font-size: 0.8rem;
            color: var(--text-muted);
            border-top: 2px solid var(--border);
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            font-weight: 500;
        }
        
        /* Guidelines */
        .guidelines {
            padding: 2rem 2.5rem;
            background: linear-gradient(135deg, #fafafa 0%, #f4f4f5 100%);
            border-top: 1px solid var(--border);
        }
        
        .guidelines-title {
            font-size: 1rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .guidelines-title::before {
            content: '';
            width: 4px;
            height: 24px;
            background: var(--primary-gradient);
            border-radius: 2px;
        }
        
        .guidelines-list {
            font-size: 0.85rem;
            color: var(--text-secondary);
            line-height: 1.8;
            padding-left: 1.5rem;
        }
        
        .guidelines-list li {
            margin-bottom: 0.5rem;
        }
        
        /* Toast */
        .toast {
            position: fixed;
            top: 2rem;
            right: 2rem;
            background: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: var(--shadow-xl);
            border-left: 4px solid var(--success);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
            z-index: 9999;
            transform: translateX(150%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .toast.show {
            transform: translateX(0);
        }
        
        /* Responsive */
        @media (max-width: 1400px) {
            .data-table {
                font-size: 0.7rem;
            }
            .data-table th, .data-table td {
                padding: 0.5rem 0.3rem;
            }
        }
        
        @media (max-width: 1024px) {
            .school-info-grid, .summary-cards {
                grid-template-columns: repeat(2, 1fr);
            }
            .header-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            .signatures {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
        }
        
        @media (max-width: 768px) {
            .school-info-grid, .summary-cards {
                grid-template-columns: 1fr;
            }
            .control-content {
                flex-direction: column;
                align-items: flex-start;
            }
            .data-table {
                font-size: 0.65rem;
            }
            .data-table th, .data-table td {
                padding: 0.4rem 0.2rem;
            }
        }
    </style>
</head>
<body>

    @php
        // Ensure variables have default values if not set
        $schoolName = $school?->name ?? 'School Name';
        $schoolId = $school?->school_id ?? '000000';
        $region = $school?->region ?? 'Region';
        $division = $school?->division ?? 'Division';
        $district = $school?->district ?? 'District';
        
        // School year from database
        $schoolYearName = $activeSchoolYear?->name ?? date('Y') . '-' . (date('Y') + 1);
        
        // Ensure subjects is always a collection
        if (!isset($subjects) || $subjects === null) {
            $subjects = collect([]);
        }
        
        // Count subjects for colspan - use safe method
        $subjectCount = is_countable($subjects) ? count($subjects) : 0;
        
        // Ensure students is always a collection
        if (!isset($students) || $students === null) {
            $students = collect([]);
        }
        
        // Ensure totals is always an array
        if (!isset($totals) || $totals === null) {
            $totals = [
                'promoted' => 0,
                'irregular' => 0,
                'retained' => 0,
                'deferred' => 0,
                'average_gen_ave' => 0,
            ];
        }
        
        // Current year level
        $displayYearLevel = $currentYearLevel ?? $currentSection->year_level ?? 'Unknown';
    @endphp

    <!-- App Header -->
    <header class="app-header no-print">
        <div class="header-content">
            <div class="brand">
                <div class="logo-icon">
                    <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                </div>
                <div class="brand-text">
                    <h1>DepEd SF5 - Report on Promotion and Level of Proficiency</h1>
                    <p>School Form 5 (SF5) - End of School Year Report</p>
                </div>
            </div>
            <div class="header-date">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                <span id="currentDate">{{ now()->format('F d, Y') }}</span>
            </div>
        </div>
    </header>

    <!-- Control Bar -->
    <div class="control-bar no-print">
        <div class="control-content">
            <div class="school-info-bar">
                <div class="school-avatar">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                </div>
                <div class="school-details">
                    <h3>{{ $schoolName }}</h3>
                    <p>
                        <span class="school-meta-badge">School ID: {{ $schoolId }}</span>
                        <span class="school-meta-badge">{{ $region }}</span>
                        <span class="school-meta-badge">SY: {{ $schoolYearName }}</span>
                    </p>
                </div>
            </div>
            
            <!-- Section Selector - Shows ALL sections -->
            <div class="section-selector">
                <label>
                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    Select Section:
                </label>
<select onchange="window.location.href=this.value">
    @foreach($sections as $section)
        <option value="{{ route('teacher.school-forms.sf5', ['section_id' => $section->id]) }}"
            {{ $currentSection->id == $section->id ? 'selected' : '' }}>
            {{ $section->year_level }} - {{ $section->name }}
        </option>
    @endforeach
</select>
            </div>
        </div>
    </div>

    <!-- Floating Action Buttons -->
    <div class="fab-container no-print">
        <a href="{{ route('teacher.dashboard') }}" class="fab-button fab-back">
            <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span class="fab-tooltip">Back to Dashboard</span>
        </a>

        <button class="fab-button fab-print" onclick="window.print()">
            <svg viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            <span class="fab-tooltip">Print SF5</span>
        </button>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="sf5-container">
            
            <!-- SF5 Official Header -->
            <div class="sf5-header">
                <div class="header-grid">
                    <!-- Left: Logo + Region -->
                    <div class="header-left-side">
                        <div class="header-logo-left">
                            <img src="{{ asset('images/logo1.png') }}" alt="DepEd Logo" class="header-logo-img" onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\'header-logo-placeholder\'>DepEd<br>Logo</div>';">
                        </div>
                        <div class="info-field">
                            <label>Region</label>
                            <div class="value">{{ $region }}</div>
                        </div>
                    </div>
                    
                    <!-- Center: Republic/DepEd text -->
                    <div class="header-center">
                        <h2>Republic of the Philippines</h2>
                        <h2>Department of Education</h2>
                        <h1>Report on Promotion and Level of Proficiency & Achievement</h1>
                        <p>(End of School Year Report for K to 6)</p>
                    </div>
                    
                    <!-- Right: Logo + School ID -->
                    <div class="header-right-side">
                        <div class="header-logo-right">
                            <img src="{{ asset('images/logo.png') }}" alt="School Seal" class="header-logo-img" onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\'header-logo-placeholder\'>School<br>Seal</div>';">
                        </div>
                        <div class="info-field">
                            <label>School ID</label>
                            <div class="value">{{ $schoolId }}</div>
                        </div>
                    </div>
                </div>
                
                <!-- School Info Grid -->
                <div class="school-info-grid">
                    <div class="info-field">
                        <label>Division</label>
                        <div class="value">{{ $division }}</div>
                    </div>
                    <div class="info-field">
                        <label>District</label>
                        <div class="value">{{ $district }}</div>
                    </div>
                    <div class="info-field">
                        <label>School Name</label>
                        <div class="value">{{ $schoolName }}</div>
                    </div>
                    <div class="info-field">
                        <label>School Year</label>
                        <div class="value">{{ $schoolYearName }}</div>
                    </div>
                </div>
                
                <!-- Current Section Info with Year Level -->
                <div class="school-info-grid" style="margin-top: 1.5rem; padding-top: 1rem; border-top: 2px solid var(--border);">
                    <div class="info-field">
                        <label>Current Year Level</label>
                        <div class="year-level-badge">
                            {{ $displayYearLevel }}
                        </div>
                    </div>
                    <div class="info-field">
                        <label>Section</label>
                        <div class="value">{{ $currentSection->name }}</div>
                    </div>
    <div class="info-field">
    <label>Adviser</label>
    <div class="value">{{ $teacherFullName }}</div>
</div>
                    <div class="info-field">
                        <label>Total Students</label>
                        <div class="value">{{ count($students) }}</div>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="summary-cards no-print">
                <div class="summary-card">
                    <div class="summary-icon promoted">
                        <svg viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                    </div>
                    <div class="summary-details">
                        <h4>{{ $totals['promoted'] ?? 0 }}</h4>
                        <p>Promoted</p>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon irregular">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    </div>
                    <div class="summary-details">
                        <h4>{{ $totals['irregular'] ?? 0 }}</h4>
                        <p>Irregular</p>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon retained">
                        <svg viewBox="0 0 24 24"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path></svg>
                    </div>
                    <div class="summary-details">
                        <h4>{{ $totals['retained'] ?? 0 }}</h4>
                        <p>Retained</p>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon deferred">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <div class="summary-details">
                        <h4>{{ $totals['deferred'] ?? 0 }}</h4>
                        <p>Deferred</p>
                    </div>
                </div>
            </div>

            <!-- Legend -->
            <div class="legend no-print">
                <div class="legend-item">
                    <div class="legend-color" style="background: var(--success);"></div>
                    <span>Promoted (75-100)</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: var(--warning);"></div>
                    <span>Irregular (75-100 with deficiencies)</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: var(--danger);"></div>
                    <span>Retained (Below 75)</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #4338ca;"></div>
                    <span>Deferred (Incomplete requirements)</span>
                </div>
            </div>

            <!-- Main Data Table -->
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th rowspan="2" style="width: 50px;">No.</th>
                            <th rowspan="2" style="width: 120px;">LRN</th>
                            <th rowspan="2" style="width: 200px;">Learner's Name<br>(Last Name, First Name, Middle Name)</th>
                            <th colspan="{{ is_countable($subjects) ? count($subjects) : 0 }}" class="section-header">
                                {{ $displayYearLevel }} SUBJECTS
                            </th>
                            <th rowspan="2" style="width: 60px;">Gen.<br>Ave.</th>
                            <th rowspan="2" style="width: 100px;">Action<br>Taken</th>
                            <th rowspan="2" style="width: 150px;">Incomplete<br>Subjects</th>
                        </tr>
                        <tr>
                            <!-- Dynamic Subject Headers for Current Year Level Only -->
                            @foreach($subjects as $subject)
                                <th class="section-header" style="width: 50px;" title="{{ $subject->name }}">
                                    {{ $subject->code ?? strtoupper(substr($subject->name, 0, 4)) }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    
                    <tbody>
                        @forelse($students as $index => $student)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="lrn-column">{{ $student->lrn ?? 'N/A' }}</td>
                            <td class="student-name">
                                {{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name }}
                                <br><small style="color: var(--text-muted); font-size: 0.75rem;">{{ $student->current_year_level ?? $displayYearLevel }}</small>
                            </td>
                            
                            <!-- Dynamic Subject Grades for Current Year Level -->
                            @foreach($subjects as $subject)
                                @php
                                    $subjectKey = strtolower(str_replace(' ', '_', $subject->name));
                                    $grade = $student->grades_array[$subjectKey] ?? null;
                                    $gradeClass = $grade === null ? 'empty' : ($grade >= 90 ? 'high' : ($grade >= 75 ? 'average' : 'low'));
                                @endphp
                                <td class="grade-cell {{ $gradeClass }}">
                                    {{ $grade !== null ? round($grade) : '-' }}
                                </td>
                            @endforeach
                            
                            <!-- General Average -->
                            <td class="gen-ave {{ $student->general_average >= 75 ? 'grade-cell high' : 'grade-cell low' }}">
                                {{ $student->general_average > 0 ? round($student->general_average) : '-' }}
                            </td>
                            
                            <!-- Action Taken -->
                            <td class="action-{{ strtolower($student->action_taken) }}">
                                {{ $student->action_taken }}
                            </td>
                            
                            <!-- Incomplete Subjects -->
                            <td class="incomplete">
                                {{ $student->incomplete_subjects ?: '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ (is_countable($subjects) ? count($subjects) : 0) + 6 }}" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                                <svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" stroke-width="2" fill="none" style="margin-bottom: 1rem;">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                                <br>No student records found for {{ $displayYearLevel }}.
                                <br>Please ensure students are enrolled and grades are encoded.
                            </td>
                        </tr>
                        @endforelse
                        
                        <!-- TOTAL ROW -->
                        @if(!empty($students) && count($students) > 0)
                        <tr class="totals-row">
                            <td colspan="3" style="text-align: right; padding-right: 1.5rem;">TOTAL →</td>
                            <td colspan="{{ $subjectCount }}"></td>
                            <td>{{ $totals['average_gen_ave'] > 0 ? round($totals['average_gen_ave']) : '-' }}</td>
                            <td colspan="2"></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Guidelines -->
            <div class="guidelines no-print">
                <div class="guidelines-title">Guidelines</div>
                <ol class="guidelines-list">
                    <li>This form shall be accomplished by the class adviser at the end of the school year.</li>
                    <li><strong>Rating:</strong> Enter the final rating of the learner in each subject area.</li>
                    <li><strong>General Average:</strong> The average of all subject areas. Minimum passing grade is 75.</li>
                    <li><strong>Action Taken:</strong>
                        <ul style="margin-left: 1.5rem; margin-top: 0.5rem;">
                            <li><strong>Promoted:</strong> General Average of 75 and above with no failing grades.</li>
                            <li><strong>Irregular:</strong> General Average of 75 and above but with failing grades in some subjects (for SHS).</li>
                            <li><strong>Retained:</strong> General Average below 75 or with failing grades in 3 or more subjects.</li>
                            <li><strong>Deferred:</strong> Incomplete requirements or unresolved disciplinary cases.</li>
                        </ul>
                    </li>
                    <li>Submit this form to the principal/office-in-charge for consolidation into SF6.</li>
                </ol>
            </div>

            <!-- Signatures -->
            <div class="signatures">
               <div class="signature-box">
    <div class="signature-line"></div>
    <input type="text" 
           class="editable-input" 
           value="{{ $teacherFullName }}" 
           placeholder="Enter Name"
           id="preparedBy">
    <div class="signature-title">Prepared by:<br>(Class Adviser)</div>
    <input type="text" 
           class="editable-input editable-date" 
           value="{{ now()->format('F d, Y') }}" 
           placeholder="Enter Date"
           id="preparedDate">
</div>
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <input type="text" 
                           class="editable-input" 
                           value="{{ $school?->principal_name ?? 'School Principal' }}" 
                           placeholder="Enter Name"
                           id="certifiedBy">
                    <div class="signature-title">Certified Correct:<br>(School Principal)</div>
                    <input type="text" 
                           class="editable-input editable-date" 
                           value="{{ now()->format('F d, Y') }}" 
                           placeholder="Enter Date"
                           id="certifiedDate">
                </div>
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <input type="text" 
                           class="editable-input" 
                           value="{{ $school?->division_rep ?? 'Division Representative' }}" 
                           placeholder="Enter Name"
                           id="reviewedBy">
                    <div class="signature-title">Reviewed by:<br>(Division Representative)</div>
                    <input type="text" 
                           class="editable-input editable-date" 
                           value="{{ now()->format('F d, Y') }}" 
                           placeholder="Enter Date"
                           id="reviewedDate">
                </div>
            </div>

            <!-- Footer -->
            <div class="sf5-footer">
                <strong>School Form 5 (SF5)</strong> - Page 1 of 1 | 
                {{ $displayYearLevel }} - Section {{ $currentSection->name }} |
                School Year <strong>{{ $schoolYearName }}</strong> | 
                Generated on {{ now()->format('F d, Y h:i A') }}
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="toast no-print">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="var(--success)" stroke-width="3" fill="none"><polyline points="20 6 9 17 4 12"></polyline></svg>
        <span id="toastMessage">Changes saved successfully!</span>
    </div>

    <script>
        // Set current date
        document.getElementById('currentDate').textContent = new Date().toLocaleDateString('en-US', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
        });
        
        // Toast notification
        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            toastMessage.textContent = message;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }
        
        // Auto-save all editable inputs
        document.querySelectorAll('.editable-input').forEach(input => {
            const key = 'sf5_' + input.id + '_' + {{ $currentSection->id }};
            const saved = localStorage.getItem(key);
            if (saved) {
                input.value = saved;
            }
            
            input.addEventListener('change', function() {
                localStorage.setItem(key, this.value);
                showToast('Saved successfully!');
            });
            
            input.addEventListener('blur', function() {
                localStorage.setItem(key, this.value);
            });
        });
        
        // Print preparation
        window.addEventListener('beforeprint', () => document.body.classList.add('printing'));
        window.addEventListener('afterprint', () => document.body.classList.remove('printing'));
    </script>
</body>
</html>