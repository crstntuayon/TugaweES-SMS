<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DepEd SF8 - Learner's Basic Health and Nutrition Report | {{ $school?->name ?? 'School' }}</title>
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
            .sf8-container { 
                box-shadow: none !important; 
                border: 1px solid #000;
                border-radius: 0 !important;
            }
            .sf8-header { 
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
            .school-year-selector, .stats-bar, .summary-cards { display: none !important; }
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
        
        /* School Year Selector */
        .school-year-selector {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: #f8fafc;
            padding: 0.5rem;
            border-radius: 12px;
            border: 1px solid var(--border);
        }
        
        .school-year-selector label {
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .school-year-selector select {
            padding: 0.625rem 1rem;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 0.9rem;
            background: white;
            font-weight: 500;
            color: var(--text);
            cursor: pointer;
            transition: all 0.2s;
            min-width: 180px;
        }
        
        .school-year-selector select:hover {
            border-color: var(--primary-light);
        }
        
        .school-year-selector select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        /* Section Filter */
        .section-filter {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: #f8fafc;
            padding: 0.5rem;
            border-radius: 12px;
            border: 1px solid var(--border);
        }
        
        .section-filter label {
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .section-filter select {
            padding: 0.625rem 1rem;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 0.9rem;
            background: white;
            font-weight: 500;
            color: var(--text);
            cursor: pointer;
            transition: all 0.2s;
            min-width: 200px;
        }
        
        .section-filter select:hover {
            border-color: var(--primary-light);
        }
        
        .section-filter select:focus {
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
        
        .sf8-container {
            background: var(--card);
            border-radius: 16px;
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            border: 1px solid var(--border);
        }
        
        /* Official DepEd Header */
        .sf8-header {
            padding: 2.5rem;
            border-bottom: 3px double var(--primary);
            background: linear-gradient(135deg, #f8fafc 0%, #f0f9ff 100%);
            position: relative;
        }
        
        .sf8-header::after {
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
            font-size: 1.3rem;
            font-weight: 800;
            color: white;
            background: var(--primary-gradient);
            display: inline-block;
            padding: 0.75rem 2.5rem;
            border-radius: 8px;
            margin: 0.75rem 0;
            box-shadow: var(--shadow-lg);
            letter-spacing: -0.025em;
            line-height: 1.3;
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
        
        .summary-icon.total { 
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); 
            color: var(--primary); 
        }
        .summary-icon.normal { 
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); 
            color: var(--success); 
        }
        .summary-icon.malnourished { 
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); 
            color: var(--warning); 
        }
        .summary-icon.obese { 
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); 
            color: var(--danger); 
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
        
        /* Gender Header Row */
        .gender-header {
            font-weight: 800;
            color: var(--primary);
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%) !important;
            font-size: 0.9rem;
            text-align: left !important;
            padding-left: 1rem !important;
        }
        
        /* Nutritional Status Colors */
        .status-severely-wasted { color: #7f1d1d; font-weight: 700; background: #fee2e2; }
        .status-wasted { color: #dc2626; font-weight: 700; background: #fecaca; }
        .status-normal { color: #059669; font-weight: 700; background: #d1fae5; }
        .status-overweight { color: #d97706; font-weight: 700; background: #fef3c7; }
        .status-obese { color: #991b1b; font-weight: 700; background: #fca5a5; }
        
        /* HFA Colors */
        .hfa-severely-stunted { color: #7f1d1d; font-weight: 700; background: #fee2e2; }
        .hfa-stunted { color: #dc2626; font-weight: 700; background: #fecaca; }
        .hfa-normal { color: #059669; font-weight: 700; background: #d1fae5; }
        .hfa-tall { color: #0891b2; font-weight: 700; background: #cffafe; }
        
        /* Summary Tables */
        .summary-section {
            padding: 2rem;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-top: 1px solid var(--border);
        }
        
        .summary-title {
            font-size: 1rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .summary-title::before {
            content: '';
            width: 4px;
            height: 24px;
            background: var(--primary-gradient);
            border-radius: 2px;
        }
        
        .summary-tables-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }
        
        .summary-table-container {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
        }
        
        .summary-table-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 1rem;
            text-align: center;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--border);
        }
        
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }
        
        .summary-table th {
            background: var(--primary-gradient);
            color: white;
            padding: 0.75rem;
            text-align: center;
            font-weight: 700;
            font-size: 0.75rem;
        }
        
        .summary-table td {
            padding: 0.75rem;
            text-align: center;
            border-bottom: 1px solid var(--border);
            font-weight: 600;
        }
        
        .summary-table tr:nth-child(even) {
            background: #f8fafc;
        }
        
        .summary-table .total-row {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%) !important;
            font-weight: 800;
            font-size: 0.9rem;
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
        .sf8-footer {
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
            .school-info-grid, .summary-cards, .summary-tables-grid {
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
            .school-info-grid, .summary-cards, .summary-tables-grid {
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
        
        // School year from selected school year object
        $schoolYearName = $selectedSchoolYear?->name ?? date('Y') . '-' . (date('Y') + 1);
        
        // Selected section info
        $selectedSectionName = $selectedSection?->name ?? 'All Sections';
        $selectedGradeLevel = $selectedSection?->year_level ?? 'All Grades';
        
        // Ensure healthData is always an array
        if (!isset($healthData) || $healthData === null) {
            $healthData = [];
        }
        
        // Ensure summaries is always an array
        if (!isset($summaries) || $summaries === null) {
            $summaries = [
                'nutritional' => [
                    'severely_wasted' => ['male' => 0, 'female' => 0, 'total' => 0],
                    'wasted' => ['male' => 0, 'female' => 0, 'total' => 0],
                    'normal' => ['male' => 0, 'female' => 0, 'total' => 0],
                    'overweight' => ['male' => 0, 'female' => 0, 'total' => 0],
                    'obese' => ['male' => 0, 'female' => 0, 'total' => 0],
                ],
                'hfa' => [
                    'severely_stunted' => ['male' => 0, 'female' => 0, 'total' => 0],
                    'stunted' => ['male' => 0, 'female' => 0, 'total' => 0],
                    'normal' => ['male' => 0, 'female' => 0, 'total' => 0],
                    'tall' => ['male' => 0, 'female' => 0, 'total' => 0],
                ],
                'totals' => [
                    'total_students' => 0,
                    'total_male' => 0,
                    'total_female' => 0,
                    'normal_nutrition' => 0,
                    'malnourished' => 0,
                    'obese_count' => 0,
                ]
            ];
        }
    @endphp

    <!-- App Header -->
    <header class="app-header no-print">
        <div class="header-content">
            <div class="brand">
                <div class="logo-icon">
                    <svg viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                </div>
                <div class="brand-text">
                    <h1>DepEd SF8 - Learner's Basic Health and Nutrition Report</h1>
                    <p>School Form 8 (SF8) - Health and Nutritional Assessment</p>
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
            
            <div style="display: flex; gap: 1rem;">
                <!-- School Year Selector -->
                <div class="school-year-selector">
                    <label>
                        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        School Year:
                    </label>
                    <form method="GET" action="{{ route('teacher.school-forms.sf8') }}" style="display: flex; gap: 0.5rem;" id="filterForm">
                        <select name="school_year_id" onchange="document.getElementById('filterForm').submit()">
                            @foreach($schoolYears as $schoolYear)
                                <option value="{{ $schoolYear->id }}" {{ $selectedSchoolYearId == $schoolYear->id ? 'selected' : '' }}>
                                    {{ $schoolYear->name }}
                                </option>
                            @endforeach
                        </select>
                </div>
                
                <!-- Section Filter -->
                <div class="section-filter">
                    <label>
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        Section:
                    </label>
                        <select name="section_id" onchange="document.getElementById('filterForm').submit()">
                            <option value="">All Sections</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}" {{ $selectedSectionId == $section->id ? 'selected' : '' }}>
                                    Grade {{ $section->year_level }} - {{ $section->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
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
            <span class="fab-tooltip">Print SF8</span>
        </button>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="sf8-container">
            
            <!-- SF8 Official Header -->
            <div class="sf8-header">
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
                        <h1>Learner's Basic Health and Nutrition Report</h1>
                        <p>(This replaces Form 1 - Health and Nutrition Profile)</p>
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
                        <label>Grade Level & Section</label>
                        <div class="value">Grade {{ $selectedGradeLevel }} - {{ $selectedSectionName }}</div>
                    </div>
                    <div class="info-field">
                        <label>School Year</label>
                        <div class="value">{{ $schoolYearName }}</div>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="summary-cards no-print">
                <div class="summary-card">
                    <div class="summary-icon total">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </div>
                    <div class="summary-details">
                        <h4>{{ $summaries['totals']['total_students'] ?? 0 }}</h4>
                        <p>Total Students</p>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon normal">
                        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    </div>
                    <div class="summary-details">
                        <h4>{{ $summaries['totals']['normal_nutrition'] ?? 0 }}</h4>
                        <p>Normal Nutrition</p>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon malnourished">
                        <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    </div>
                    <div class="summary-details">
                        <h4>{{ $summaries['totals']['malnourished'] ?? 0 }}</h4>
                        <p>Malnourished</p>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon obese">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="10" r="3"></circle><path d="M12 13a4 4 0 0 0-4 4h8a4 4 0 0 0-4-4z"></path></svg>
                    </div>
                    <div class="summary-details">
                        <h4>{{ $summaries['totals']['obese_count'] ?? 0 }}</h4>
                        <p>Overweight/Obese</p>
                    </div>
                </div>
            </div>

            <!-- Legend -->
            <div class="legend no-print">
                <div class="legend-item">
                    <div class="legend-color" style="background: #7f1d1d;"></div>
                    <span>Severely Wasted</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #dc2626;"></div>
                    <span>Wasted</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #059669;"></div>
                    <span>Normal</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #d97706;"></div>
                    <span>Overweight</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #991b1b;"></div>
                    <span>Obese</span>
                </div>
            </div>

            <!-- Main Data Table -->
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th rowspan="2" style="width: 40px;">No.</th>
                            <th rowspan="2" style="width: 120px;">LRN</th>
                            <th rowspan="2" style="width: 200px;">Name of Learner<br>(Last Name, First Name, Middle Name)</th>
                            <th rowspan="2" style="width: 80px;">Birthdate<br>(MM/DD/YYYY)</th>
                            <th rowspan="2" style="width: 50px;">Age</th>
                            <th rowspan="2" style="width: 60px;">Weight<br>(kg)</th>
                            <th rowspan="2" style="width: 60px;">Height<br>(m)</th>
                            <th rowspan="2" style="width: 70px;">Height²<br>(m²)</th>
                            <th colspan="2" class="section-header">NUTRITIONAL STATUS</th>
                            <th rowspan="2" style="width: 150px;">Remarks</th>
                        </tr>
                        <tr>
                            <th style="width: 100px;">BMI<br>(kg/m²)</th>
                            <th style="width: 120px;">Status</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @forelse($healthData as $index => $student)
                            @if($loop->first || $student['gender'] !== $healthData[$index - 1]['gender'])
                                <tr>
                                    <td colspan="11" class="gender-header">{{ strtoupper($student['gender']) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>{{ $student['no'] }}</td>
                                <td>{{ $student['lrn'] }}</td>
                                <td style="text-align: left; padding-left: 1rem;">{{ $student['name'] }}</td>
                                <td>{{ $student['birthday'] }}</td>
                                <td>{{ $student['age'] }}</td>
                                <td>{{ $student['weight'] }}</td>
                                <td>{{ $student['height'] }}</td>
                                <td>{{ $student['height_squared'] }}</td>
                                <td>{{ $student['bmi'] }}</td>
                                <td class="status-{{ str_replace(' ', '-', strtolower($student['nutritional_status'])) }}">
                                    {{ $student['nutritional_status'] }}
                                </td>
                                <td>{{ $student['remarks'] }}</td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="11" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                                <svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" stroke-width="2" fill="none" style="margin-bottom: 1rem; display: block; margin-left: auto; margin-right: auto;">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                                No health data available for the selected section/school year. Please ensure health assessments are recorded.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Summary Tables -->
            <div class="summary-section">
                <div class="summary-title">Summary Tables</div>
                <div class="summary-tables-grid">
                    <!-- Nutritional Status Summary -->
                    <div class="summary-table-container">
                        <div class="summary-table-title">NUTRITIONAL STATUS (BMI) SUMMARY</div>
                        <table class="summary-table">
                            <thead>
                                <tr>
                                    <th>Nutritional Status</th>
                                    <th>Male</th>
                                    <th>Female</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: left; font-weight: 700; color: #7f1d1d;">Severely Wasted</td>
                                    <td>{{ $summaries['nutritional']['severely_wasted']['male'] ?? 0 }}</td>
                                    <td>{{ $summaries['nutritional']['severely_wasted']['female'] ?? 0 }}</td>
                                    <td>{{ $summaries['nutritional']['severely_wasted']['total'] ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; font-weight: 700; color: #dc2626;">Wasted</td>
                                    <td>{{ $summaries['nutritional']['wasted']['male'] ?? 0 }}</td>
                                    <td>{{ $summaries['nutritional']['wasted']['female'] ?? 0 }}</td>
                                    <td>{{ $summaries['nutritional']['wasted']['total'] ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; font-weight: 700; color: #059669;">Normal</td>
                                    <td>{{ $summaries['nutritional']['normal']['male'] ?? 0 }}</td>
                                    <td>{{ $summaries['nutritional']['normal']['female'] ?? 0 }}</td>
                                    <td>{{ $summaries['nutritional']['normal']['total'] ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; font-weight: 700; color: #d97706;">Overweight</td>
                                    <td>{{ $summaries['nutritional']['overweight']['male'] ?? 0 }}</td>
                                    <td>{{ $summaries['nutritional']['overweight']['female'] ?? 0 }}</td>
                                    <td>{{ $summaries['nutritional']['overweight']['total'] ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; font-weight: 700; color: #991b1b;">Obese</td>
                                    <td>{{ $summaries['nutritional']['obese']['male'] ?? 0 }}</td>
                                    <td>{{ $summaries['nutritional']['obese']['female'] ?? 0 }}</td>
                                    <td>{{ $summaries['nutritional']['obese']['total'] ?? 0 }}</td>
                                </tr>
                                <tr class="total-row">
                                    <td style="text-align: left;">TOTAL</td>
                                    <td>{{ $summaries['totals']['total_male'] ?? 0 }}</td>
                                    <td>{{ $summaries['totals']['total_female'] ?? 0 }}</td>
                                    <td>{{ $summaries['totals']['total_students'] ?? 0 }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Height for Age Summary -->
                    <div class="summary-table-container">
                        <div class="summary-table-title">HEIGHT FOR AGE (HFA) SUMMARY</div>
                        <table class="summary-table">
                            <thead>
                                <tr>
                                    <th>HFA Status</th>
                                    <th>Male</th>
                                    <th>Female</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: left; font-weight: 700; color: #7f1d1d;">Severely Stunted</td>
                                    <td>{{ $summaries['hfa']['severely_stunted']['male'] ?? 0 }}</td>
                                    <td>{{ $summaries['hfa']['severely_stunted']['female'] ?? 0 }}</td>
                                    <td>{{ $summaries['hfa']['severely_stunted']['total'] ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; font-weight: 700; color: #dc2626;">Stunted</td>
                                    <td>{{ $summaries['hfa']['stunted']['male'] ?? 0 }}</td>
                                    <td>{{ $summaries['hfa']['stunted']['female'] ?? 0 }}</td>
                                    <td>{{ $summaries['hfa']['stunted']['total'] ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; font-weight: 700; color: #059669;">Normal</td>
                                    <td>{{ $summaries['hfa']['normal']['male'] ?? 0 }}</td>
                                    <td>{{ $summaries['hfa']['normal']['female'] ?? 0 }}</td>
                                    <td>{{ $summaries['hfa']['normal']['total'] ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; font-weight: 700; color: #0891b2;">Tall</td>
                                    <td>{{ $summaries['hfa']['tall']['male'] ?? 0 }}</td>
                                    <td>{{ $summaries['hfa']['tall']['female'] ?? 0 }}</td>
                                    <td>{{ $summaries['hfa']['tall']['total'] ?? 0 }}</td>
                                </tr>
                                <tr class="total-row">
                                    <td style="text-align: left;">TOTAL</td>
                                    <td>{{ $summaries['totals']['total_male'] ?? 0 }}</td>
                                    <td>{{ $summaries['totals']['total_female'] ?? 0 }}</td>
                                    <td>{{ $summaries['totals']['total_students'] ?? 0 }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Guidelines -->
            <div class="guidelines no-print">
                <div class="guidelines-title">Guidelines</div>
                <ol class="guidelines-list">
                    <li>This form shall be accomplished by the Class Adviser, MAPEH Teacher, School Nurse, or other qualified personnel within the <strong>first quarter of the school year</strong> or as needed.</li>
                    <li>All learners including Kindergarten shall be included in this form.</li>
                    <li>Height and weight shall be taken from actual measurements using calibrated weighing scales and stadiometers.</li>
                    <li><strong>Nutritional Status (BMI-for-Age):</strong> Weight in kilograms divided by height in meters squared (kg/m²), interpreted as:
                        <ul style="margin-top: 0.5rem; margin-left: 1.5rem;">
                            <li><strong>Severely Wasted:</strong> BMI < -3 SD</li>
                            <li><strong>Wasted:</strong> BMI -3 SD to <-2 SD</li>
                            <li><strong>Normal:</strong> BMI -2 SD to +1 SD</li>
                            <li><strong>Overweight:</strong> BMI >+1 SD to +2 SD</li>
                            <li><strong>Obese:</strong> BMI >+2 SD</li>
                        </ul>
                    </li>
                    <li><strong>Height-for-Age (HFA):</strong> Interpreted as Severely Stunted, Stunted, Normal, or Tall based on WHO Child Growth Standards.</li>
                    <li>Baseline data is collected at the beginning of the school year; endline data is collected at the end of the school year to measure improvement.</li>
                </ol>
            </div>

            <!-- Signatures -->
            <div class="signatures">
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <input type="text" 
                           class="editable-input" 
                           value="{{ auth()->user()->full_name ?? auth()->user()->name ?? 'Class Adviser Name' }}" 
                           placeholder="Enter Name"
                           id="conductedBy">
                    <div class="signature-title">Conducted/Assessed by:<br>(Class Adviser/MAPEH Teacher/School Nurse)</div>
                    <input type="text" 
                           class="editable-input editable-date" 
                           value="{{ now()->format('F d, Y') }}" 
                           placeholder="Enter Date"
                           id="conductedDate">
                </div>
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <input type="text" 
                           class="editable-input" 
                           value="{{ $school?->principal_name ?? 'School Principal' }}" 
                           placeholder="Enter Name"
                           id="certifiedBy">
                    <div class="signature-title">Certified Correct by:<br>(School Principal)</div>
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
                           value="Division Representative" 
                           placeholder="Enter Name"
                           id="reviewedBy">
                    <div class="signature-title">Reviewed by:<br>(Division Office Representative)</div>
                    <input type="text" 
                           class="editable-input editable-date" 
                           value="{{ now()->format('F d, Y') }}" 
                           placeholder="Enter Date"
                           id="reviewedDate">
                </div>
            </div>

            <!-- Footer -->
            <div class="sf8-footer">
                <strong>School Form 8 (SF8)</strong> - Page 1 of 1 | 
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
            const key = 'sf8_' + input.id;
            const saved = localStorage.getItem(key);
            if (saved && input.value === input.defaultValue) {
                input.value = saved;
            }
            
            input.addEventListener('change', function() {
                localStorage.setItem('sf8_' + this.id, this.value);
                showToast('Saved successfully!');
            });
            
            input.addEventListener('blur', function() {
                localStorage.setItem('sf8_' + this.id, this.value);
            });
        });
        
        // Print preparation
        window.addEventListener('beforeprint', () => document.body.classList.add('printing'));
        window.addEventListener('afterprint', () => document.body.classList.remove('printing'));
    </script>
</body>
</html>