<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DepEd SF3 - Books Issued and Returned | {{ $student->last_name ?? 'Student' }}</title>
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
            .sf3-container { 
                box-shadow: none !important; 
                border: 1px solid #000;
                border-radius: 0 !important;
            }
            .books-table th { 
                background: #1e3a8a !important; 
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .status-badge {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .editable-input { 
                border: none !important; 
                background: transparent !important; 
                text-align: center;
            }
            .sf3-header {
                background: #f8fafc !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
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
        
        .header-date svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
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
        
        .student-info-bar {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .student-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--primary-gradient);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.1rem;
            box-shadow: var(--shadow);
            border: 3px solid white;
            position: relative;
        }
        
        .student-avatar::after {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            border: 2px solid var(--primary-light);
            opacity: 0.3;
        }
        
        .student-details h3 {
            font-size: 1.125rem;
            font-weight: 700;
            margin: 0;
            color: var(--text);
            letter-spacing: -0.025em;
        }
        
        .student-details p {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin: 0.15rem 0 0 0;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        
        .student-meta-badge {
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
        
        .student-meta-badge svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }
        
        /* Report Type Selector */
        .report-type-selector {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: #f8fafc;
            padding: 0.5rem;
            border-radius: 12px;
            border: 1px solid var(--border);
        }
        
        .report-type-selector label {
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .report-type-selector label svg {
            width: 18px;
            height: 18px;
            stroke: var(--primary);
            stroke-width: 2;
            fill: none;
        }
        
        .report-type-selector select {
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
        
        .report-type-selector select:hover {
            border-color: var(--primary-light);
        }
        
        .report-type-selector select:focus {
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
        
        .fab-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.3) 0%, transparent 50%);
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .fab-button:hover {
            transform: translateY(-4px) scale(1.08);
            box-shadow: 0 20px 30px -5px rgba(0,0,0,0.2);
        }
        
        .fab-button:hover::before {
            opacity: 1;
        }
        
        .fab-button:active {
            transform: translateY(-2px) scale(0.96);
        }
        
        .fab-button svg {
            width: 26px;
            height: 26px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
            transition: transform 0.3s;
            position: relative;
            z-index: 1;
        }
        
        .fab-button:hover svg {
            transform: scale(1.15) rotate(-5deg);
        }
        
        /* Back Button */
        .fab-back {
            background: white;
            color: var(--text);
            border: 2px solid var(--border);
        }
        
        .fab-back:hover {
            background: #f8fafc;
            color: var(--primary);
            border-color: var(--primary-light);
        }
        
        /* Print Button */
        .fab-print {
            background: var(--primary-gradient);
            color: white;
            animation: pulse 2s infinite;
        }
        
        .fab-print:hover {
            background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);
            animation: none;
        }
        
        /* Export Button */
        .fab-export {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            color: white;
        }
        
        .fab-export:hover {
            background: linear-gradient(135deg, var(--success-light) 0%, var(--success) 100%);
        }
        
        /* Tooltip */
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
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(12px);
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(255,255,255,0.1);
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
            max-width: 1400px;
            margin: 2.5rem auto;
            padding: 0 2rem;
            padding-bottom: 8rem;
        }
        
        /* SF3 Container */
        .sf3-container {
            background: var(--card);
            border-radius: 16px;
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            border: 1px solid var(--border);
        }
        
        /* Official DepEd Header */
        .sf3-header {
            padding: 2.5rem;
            border-bottom: 3px double var(--primary);
            background: linear-gradient(135deg, #f8fafc 0%, #f0f9ff 100%);
            position: relative;
        }
        
        .sf3-header::after {
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
            font-size: 1.75rem;
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
        .school-info {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
            margin-top: 1rem;
        }
        
        .school-info .info-field {
            text-align: left;
        }
        
        .school-info .info-field label {
            text-align: left;
            padding-left: 0.25rem;
        }
        
        .school-info .info-field .value {
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            border-bottom: 3px solid var(--primary);
            border-radius: 0;
            background: transparent;
            box-shadow: none;
            padding-left: 0.25rem;
        }
        
        /* Report Period Bar */
        .period-bar {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            padding: 1.5rem 2.5rem;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border-bottom: 1px solid #bfdbfe;
            position: relative;
        }
        
        .period-bar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, var(--primary-light) 50%, transparent 100%);
            opacity: 0.3;
        }
        
        .period-box {
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
        
        .period-box:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .period-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--primary-gradient);
            color: white;
            box-shadow: var(--shadow);
            flex-shrink: 0;
        }
        
        .period-icon svg {
            width: 24px;
            height: 24px;
            stroke: white;
            stroke-width: 2;
            fill: none;
        }
        
        .period-details h4 {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.25rem;
            letter-spacing: -0.025em;
        }
        
        .period-details p {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 500;
        }
        
        /* Stats Bar */
        .stats-bar {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
            padding: 1.5rem 2.5rem;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-bottom: 1px solid #bbf7d0;
        }
        
        .stat-box {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: white;
            padding: 1.25rem;
            border-radius: 12px;
            box-shadow: var(--shadow);
            border: 1px solid #bbf7d0;
            transition: all 0.3s;
        }
        
        .stat-box:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
            border-color: var(--success-light);
        }
        
        .stat-icon {
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
        
        .stat-icon svg {
            width: 28px;
            height: 28px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }
        
        .stat-icon.issued { 
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); 
            color: var(--primary); 
        }
        .stat-icon.returned { 
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); 
            color: var(--success); 
        }
        .stat-icon.pending { 
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); 
            color: var(--warning); 
        }
        .stat-icon.lost { 
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); 
            color: var(--danger); 
        }
        
        .stat-details h4 {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text);
            line-height: 1;
            margin-bottom: 0.25rem;
            letter-spacing: -0.05em;
        }
        
        .stat-details p {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 600;
        }
        
        /* Books Table */
        .table-wrapper {
            overflow-x: auto;
            padding: 2rem;
            background: white;
        }
        
        .books-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.875rem;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
        }
        
        .books-table th {
            background: var(--primary-gradient);
            color: white;
            padding: 1rem 0.75rem;
            text-align: center;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-right: 1px solid rgba(255,255,255,0.15);
        }
        
        .books-table th:last-child {
            border-right: none;
        }
        
        .books-table td {
            padding: 1rem 0.75rem;
            text-align: center;
            border-bottom: 1px solid var(--border);
            border-right: 1px solid var(--border);
            transition: background-color 0.15s;
        }
        
        .books-table td:last-child {
            border-right: none;
        }
        
        .books-table tr:last-child td {
            border-bottom: none;
        }
        
        .books-table tbody tr {
            background: white;
        }
        
        .books-table tbody tr:nth-child(even) {
            background: #f8fafc;
        }
        
        .books-table tbody tr:hover {
            background: #eff6ff;
        }
        
        /* Row Number */
        .row-number {
            font-weight: 800;
            color: var(--primary);
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            font-size: 0.9rem;
            border-radius: 8px;
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-sm);
        }
        
        /* Status Badges */
        .status-badge {
            font-weight: 700;
            font-size: 0.75rem;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid transparent;
        }
        
        .status-badge svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            stroke-width: 2.5;
            fill: none;
        }
        
        .status-issued { 
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); 
            color: var(--primary);
            border-color: #93c5fd;
        }
        .status-returned { 
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); 
            color: var(--success);
            border-color: #6ee7b7;
        }
        .status-damaged { 
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); 
            color: var(--warning);
            border-color: #fcd34d;
        }
        .status-lost { 
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); 
            color: var(--danger);
            border-color: #fca5a5;
        }
        .status-pending { 
            background: #f1f5f9; 
            color: var(--text-muted);
            border-color: #cbd5e1;
        }
        
        /* Date Cells */
        .date-cell {
            font-family: 'SF Mono', Monaco, monospace;
            font-size: 0.8rem;
            color: var(--text-secondary);
            font-weight: 600;
        }
        
        /* Subject Badge */
        .subject-badge {
            display: inline-flex;
            padding: 0.375rem 0.875rem;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
            color: #4338ca;
            margin-bottom: 0.5rem;
            box-shadow: var(--shadow-sm);
        }
        
        /* Book Title */
        .book-title {
            text-align: left !important;
            font-weight: 600;
            min-width: 280px;
            color: var(--text);
        }
        
        .book-title-text {
            font-size: 0.95rem;
            line-height: 1.4;
            color: var(--text);
        }
        
        .book-reference {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-family: 'SF Mono', Monaco, monospace;
            background: #f1f5f9;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            display: inline-block;
            margin-top: 0.25rem;
        }
        
        /* Condition Indicators */
        .condition-indicator {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .condition-indicator svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            stroke-width: 2.5;
            fill: none;
        }
        
        .condition-good { color: var(--success); }
        .condition-fair { color: var(--warning); }
        .condition-poor { color: var(--danger); }
        
        /* Remarks */
        .remarks-cell {
            font-size: 0.8rem;
            max-width: 220px;
            text-align: left !important;
            line-height: 1.5;
        }
        
        .action-code {
            display: inline-flex;
            padding: 0.25rem 0.625rem;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 800;
            margin-right: 0.35rem;
            margin-bottom: 0.25rem;
            box-shadow: var(--shadow-sm);
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }
        
        .code-fm { background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #92400e; }
        .code-tdo { background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); color: #3730a3; }
        .code-neg { background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); color: #991b1b; }
        .code-lltr { background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #065f46; }
        .code-tltr { background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); color: #1e40af; }
        .code-ptl { background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%); color: #9d174d; }
        .code-dmg { background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); color: #991b1b; }
        
        /* Totals Row */
        .totals-row {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%) !important;
            font-weight: 800;
            font-size: 0.95rem;
        }
        
        .totals-row td {
            border-top: 3px solid var(--primary) !important;
            padding: 1.25rem 0.75rem !important;
            color: var(--text);
        }
        
        /* Legend */
        .legend-bar {
            display: flex;
            align-items: center;
            gap: 2rem;
            padding: 1.25rem 2.5rem;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-top: 1px solid var(--border);
            font-size: 0.9rem;
            flex-wrap: wrap;
        }
        
        .legend-title {
            font-weight: 700;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 0.8rem;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            font-weight: 600;
            color: var(--text-secondary);
        }
        
        .legend-symbol {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.85rem;
            box-shadow: var(--shadow-sm);
        }
        
        /* Codes Section */
        .codes-section {
            padding: 2rem 2.5rem;
            background: linear-gradient(135deg, #fafafa 0%, #f4f4f5 100%);
            border-top: 1px solid var(--border);
        }
        
        .codes-title {
            font-size: 1rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 1.25rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .codes-title::before {
            content: '';
            width: 4px;
            height: 24px;
            background: var(--primary-gradient);
            border-radius: 2px;
        }
        
        .codes-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
        }
        
        .code-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            font-size: 0.85rem;
            background: white;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            transition: all 0.2s;
        }
        
        .code-item:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
            border-color: var(--primary-light);
        }
        
        .code-label {
            font-weight: 800;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            min-width: 48px;
            text-align: center;
            flex-shrink: 0;
            font-size: 0.75rem;
        }
        
        .code-desc {
            color: var(--text-secondary);
            line-height: 1.5;
            font-weight: 500;
        }
        
        .code-desc strong {
            color: var(--text);
            display: block;
            margin-bottom: 0.15rem;
            font-weight: 700;
        }
        
        /* Signatures */
        .signatures {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
            padding: 3rem;
            max-width: 900px;
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
        
        .signature-title {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 600;
        }
        
        .signature-date {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
            font-weight: 500;
        }
        
        /* Footer */
        .sf3-footer {
            padding: 1.25rem;
            text-align: center;
            font-size: 0.8rem;
            color: var(--text-muted);
            border-top: 2px solid var(--border);
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            font-weight: 500;
        }
        
        .sf3-footer strong {
            color: var(--primary);
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 5rem;
            color: var(--text-muted);
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 16px;
            margin: 2rem;
        }
        
        .empty-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            opacity: 0.3;
        }
        
        .empty-icon svg {
            width: 100%;
            height: 100%;
            stroke: var(--text-muted);
            stroke-width: 1.5;
            fill: none;
        }
        
        .empty-state h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0.5rem;
        }
        
        .empty-state p {
            font-size: 1rem;
            color: var(--text-muted);
            max-width: 400px;
            margin: 0 auto;
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
        
        .toast svg {
            width: 20px;
            height: 20px;
            stroke: var(--success);
            stroke-width: 2.5;
            fill: none;
        }
        
        /* Debug Panel - Remove in production */
        .debug-panel {
            background: #fef3c7;
            border: 2px solid #f59e0b;
            padding: 1rem;
            margin: 1rem;
            border-radius: 8px;
            font-family: monospace;
            font-size: 0.85rem;
        }
        .debug-panel h4 {
            margin-bottom: 0.5rem;
            color: #92400e;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .school-info, .stats-bar, .codes-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .header-grid, .school-info, .stats-bar, .period-bar, .signatures, .codes-grid {
                grid-template-columns: 1fr;
            }
            .control-content {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>

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
        
        // Report period dates
        if (isset($activeSchoolYear) && $activeSchoolYear) {
            $bosyDate = $activeSchoolYear->start_date ? $activeSchoolYear->start_date->format('F d, Y') : 'June 01, 2024';
            $eosyDate = $activeSchoolYear->end_date ? $activeSchoolYear->end_date->format('F d, Y') : 'March 31, 2025';
            $schoolYearName = $activeSchoolYear->name ?? 'N/A';
        } else {
            $bosyDate = 'June 01, 2024';
            $eosyDate = 'March 31, 2025';
            $schoolYearName = 'N/A';
        }
        
        // School info - Use the explicitly passed variables or fallback to safe access
        $schoolName = $school?->name ?? 'Tugawe Elementary School';
        $schoolId = $school?->school_id ?? '120231';
        
        // Use the explicitly passed variables from controller
        // These are now guaranteed to have values (either real data or 'N/A')
    @endphp

    <!-- App Header -->
    <header class="app-header no-print">
        <div class="header-content">
            <div class="brand">
                <div class="logo-icon">
                    <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </div>
                <div class="brand-text">
                    <h1>DepEd SF3 - Books Issued and Returned</h1>
                    <p>School Form 3 (SF3) - Individual Book Inventory Record</p>
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
            <div class="student-info-bar">
                <div class="student-avatar">
                    {{ strtoupper(substr($student->first_name, 0, 1) . substr($student->last_name, 0, 1)) }}
                </div>
                <div class="student-details">
                    <h3>{{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name ? substr($student->middle_name, 0, 1) . '.' : '' }}</h3>
                    <p>
                        <span class="student-meta-badge">
                            <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                            LRN: {{ $student->lrn ?? 'N/A' }}
                        </span>
                        <span class="student-meta-badge">
    <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
    Grade {{ $section?->year_level ?? 'N/A' }}
</span>
<span class="student-meta-badge">
    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
    {{ $section?->name ?? 'N/A' }}
</span>
                    </p>
                </div>
            </div>
            
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div class="report-type-selector">
                    <label>
                        <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                        Report:
                    </label>
                    <form method="GET" style="display: flex; gap: 0.5rem;">
                        <select name="report_type" onchange="this.form.submit()">
                            <option value="bosy" {{ (request('report_type', 'bosy') == 'bosy') ? 'selected' : '' }}>Beginning of School Year (BoSY)</option>
                            <option value="eosy" {{ (request('report_type') == 'eosy') ? 'selected' : '' }}>End of School Year (EoSY)</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Action Buttons -->
    <div class="fab-container no-print">
        <a href="{{ route('teacher.dashboard') }}" class="fab-button fab-back" title="Back to Dashboard">
            <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span class="fab-tooltip">Back to Dashboard</span>
        </a>
        
        <button class="fab-button fab-print" onclick="window.print()" title="Print SF3">
            <svg viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            <span class="fab-tooltip">Print Report</span>
        </button>
    </div>

    <!-- Main Content -->
    <div class="container">
        
        <div class="sf3-container">
            
            <!-- SF3 Official Header -->
            <div class="sf3-header">
                <div class="header-grid">
                    <!-- Left: Logo + School Year -->
                    <div class="header-left-side">
                        <div class="header-logo-left">
                            <img src="{{ asset('images/logo1.png') }}" alt="DepEd Logo" class="header-logo-img" onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\'header-logo-placeholder\'>DepEd<br>Logo</div>';">
                        </div>
                        <div class="info-field">
                            <label>School Year</label>
                            <div class="value">{{ $schoolYearName }}</div>
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
                        <div class="info-field">
                            <label>School ID</label>
                            <div class="value">{{ $schoolId }}</div>
                        </div>
                    </div>
                </div>
                
             <!-- Replace lines 689-696 in your template -->
<div class="school-info">
    <div class="info-field">
        <label>Name of School</label>
        <div class="value">{{ $schoolName }}</div>
    </div>
    <div class="info-field">
        <label>Grade Level</label>
        <div class="value" id="displayGradeLevel">
            {{ $section?->year_level ?? $student->grade_level ?? 'N/A' }}
        </div>
    </div>
    <div class="info-field">
        <label>Section</label>
        <div class="value" id="displaySection">
            {{ $section?->name ?? $student->section_name ?? 'N/A' }}
        </div>
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
                    <div class="period-icon">
                        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    </div>
                    <div class="period-details">
                        <h4>{{ $reportType == 'bosy' ? $bosyDate : $eosyDate }}</h4>
                        <p>{{ $reportType == 'bosy' ? 'Date of Book Issuance (BoSY)' : 'Date of Book Return (EoSY)' }}</p>
                    </div>
                </div>
                <div class="period-box">
                    <div class="period-icon">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </div>
                    <div class="period-details">
                        <h4>{{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }} {{ $student->suffix }}</h4>
                        <p>LRN: {{ $student->lrn ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="stats-bar">
                <div class="stat-box">
                    <div class="stat-icon issued">
                        <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    </div>
                    <div class="stat-details">
                        <h4>{{ $totalBooksIssued }}</h4>
                        <p>Total Books Issued</p>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon returned">
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </div>
                    <div class="stat-details">
                        <h4>{{ $totalBooksReturned }}</h4>
                        <p>Books Returned</p>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon pending">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <div class="stat-details">
                        <h4>{{ $totalBooksPending }}</h4>
                        <p>Pending Return</p>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon lost">
                        <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    </div>
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
                                <th style="width: 60px;">#</th>
                                <th style="min-width: 280px;">Title of Book & Subject Area</th>
                                <th>Book Code</th>
                                <th>Date Issued</th>
                                <th>Date Returned</th>
                                <th>Status</th>
                                <th>Condition</th>
                                <th style="min-width: 220px;">Remarks / Action Taken</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($studentBooks as $index => $book)
                                <tr>
                                    <td>
                                        <span class="row-number">{{ $index + 1 }}</span>
                                    </td>
                                    <td class="book-title">
                                        <span class="subject-badge">{{ $book->subject_area ?? 'General' }}</span>
                                        <div class="book-title-text">{{ $book->title ?? 'Untitled Book' }}</div>
                                    </td>
                                    <td>
                                        <span class="book-reference">{{ $book->reference_code ?? $book->book_code ?? '-' }}</span>
                                    </td>
                                    <td class="date-cell">{{ $book->date_issued ? date('m/d/Y', strtotime($book->date_issued)) : '-' }}</td>
                                    <td class="date-cell">
                                        @if($book->status == 'lost')
                                            <span class="status-badge status-lost">
                                                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                                LOST
                                            </span>
                                        @elseif($book->status == 'returned' && $book->date_returned)
                                            {{ date('m/d/Y', strtotime($book->date_returned)) }}
                                        @else
                                            <span class="status-badge status-pending">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($book->status == 'issued')
                                            <span class="status-badge status-issued">
                                                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="3"></circle></svg>
                                                ISSUED
                                            </span>
                                        @elseif($book->status == 'returned')
                                            <span class="status-badge status-returned">
                                                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                RETURNED
                                            </span>
                                        @elseif($book->status == 'lost')
                                            <span class="status-badge status-lost">
                                                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                                LOST
                                            </span>
                                        @else
                                            <span class="status-badge status-pending">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($book->condition == 'good' || $book->condition == 'new')
                                            <span class="condition-indicator condition-good">
                                                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                Good
                                            </span>
                                        @elseif($book->condition == 'fair')
                                            <span class="condition-indicator condition-fair">
                                                <svg viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                                Fair
                                            </span>
                                        @elseif($book->condition == 'damaged' || $book->condition == 'poor')
                                            <span class="condition-indicator condition-poor">
                                                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                Damaged
                                            </span>
                                        @else
                                            <span class="condition-indicator">-</span>
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
                                            <span class="action-code code-dmg">DMG</span> {{ $book->damage_details ?? 'Damaged' }}
                                        @else
                                            {{ $book->remarks ?? '-' }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            
                            <!-- TOTAL ROW -->
                            <tr class="totals-row">
                                <td colspan="2" style="text-align: right; padding-right: 1.5rem;">TOTAL →</td>
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
                        <div class="empty-icon">
                            <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                        </div>
                        <h3>No Books Recorded</h3>
                        <p>This student has no book issuance records yet. Books will appear here once they are assigned.</p>
                    </div>
                @endif
            </div>

            <!-- Legend -->
            <div class="legend-bar">
                <span class="legend-title">Status Legend:</span>
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
                        <span class="code-desc"><strong>Force Majeure</strong> - Natural disasters, calamities, fortuitous events</span>
                    </div>
                    <div class="code-item">
                        <span class="action-code code-tdo">TDO</span>
                        <span class="code-desc"><strong>Transferred/Dropout</strong> - Student moved to another school or dropped out</span>
                    </div>
                    <div class="code-item">
                        <span class="action-code code-neg">NEG</span>
                        <span class="code-desc"><strong>Negligence</strong> - Carelessness, misuse, or failure to exercise due care</span>
                    </div>
                    <div class="code-item">
                        <span class="action-code code-lltr">LLTR</span>
                        <span class="code-desc"><strong>Letter from Learner</strong> - Signed explanation from parent/guardian (for FM cases)</span>
                    </div>
                    <div class="code-item">
                        <span class="action-code code-tltr">TLTR</span>
                        <span class="code-desc"><strong>Teacher Letter</strong> - Report submitted to School Head (for TDO cases)</span>
                    </div>
                    <div class="code-item">
                        <span class="action-code code-ptl">PTL</span>
                        <span class="code-desc"><strong>Paid by Learner</strong> - Replacement cost paid (for NEG cases)</span>
                    </div>
                </div>
            </div>

            <!-- Signatures with Editable Names and Dates -->
<div class="signatures">
    <div class="signature-box">
        <div class="signature-line"></div>
        <input type="text" 
               class="editable-input" 
               value="{{ $section && $section->teacher ? ($section->teacher->full_name ?? $section->teacher->name ?? 'Class Adviser Name') : 'Class Adviser Name' }}" 
               placeholder="Enter Teacher Name"
               id="teacherName">
        <div class="signature-title">Class Adviser (Signature over Printed Name)</div>
        <input type="text" 
               class="editable-input editable-date" 
               value="{{ $reportType == 'bosy' ? $bosyDate : $eosyDate }}" 
               placeholder="Enter Date"
               id="teacherDate"
               style="font-size: 0.85rem; max-width: 200px; margin-top: 0.5rem;">
    </div>
    <div class="signature-box">
        <div class="signature-line"></div>
        <input type="text" 
               class="editable-input" 
               value="{{ $school ? ($school->principal_name ?? $school->head_name ?? 'School Principal') : 'School Principal' }}" 
               placeholder="Enter Principal Name"
               id="principalName">
        <div class="signature-title">School Head (Signature over Printed Name)</div>
        <input type="text" 
               class="editable-input editable-date" 
               value="{{ $reportType == 'bosy' ? $bosyDate : $eosyDate }}" 
               placeholder="Enter Date"
               id="principalDate"
               style="font-size: 0.85rem; max-width: 200px; margin-top: 0.5rem;">
    </div>
</div>

<!-- Footer -->
<div class="sf3-footer">
    <strong>School Form 3 (SF3)</strong> - Page 1 of 1 | 
    Generated on {{ now()->format('F d, Y h:i A') }} | 
    {{ $reportType == 'bosy' ? 'Beginning of School Year' : 'End of School Year' }} Report | 
    Student: <strong>{{ $student->last_name }}, {{ $student->first_name }}</strong>
</div>

    <!-- Toast Notification -->
    <div id="toast" class="toast no-print">
        <span>✓</span>
        <span id="toastMessage">Changes saved successfully!</span>
    </div>

  <script>
    // Set current date
    document.getElementById('currentDate').textContent = new Date().toLocaleDateString('en-US', {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
    });
    
    // Auto-save signature names and dates to localStorage with toast notification
    function showToast(message) {
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toastMessage');
        toastMessage.textContent = message;
        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }
    
    // Handle all editable inputs (names and dates)
    document.querySelectorAll('.editable-input').forEach(input => {
        // Load saved value
        const key = 'sf3_' + input.id;
        const saved = localStorage.getItem(key);
        if (saved && input.value === input.defaultValue) {
            input.value = saved;
        }
        
        // Save on change
        input.addEventListener('change', function() {
            const key = 'sf3_' + this.id;
            localStorage.setItem(key, this.value);
            showToast('Saved successfully!');
        });
        
        // Save on blur (when leaving the field)
        input.addEventListener('blur', function() {
            const key = 'sf3_' + this.id;
            localStorage.setItem(key, this.value);
        });
    });
    
    // Print preparation
    window.addEventListener('beforeprint', function() {
        document.body.classList.add('printing');
    });
    
    window.addEventListener('afterprint', function() {
        document.body.classList.remove('printing');
    });
</script>
</body>
</html>