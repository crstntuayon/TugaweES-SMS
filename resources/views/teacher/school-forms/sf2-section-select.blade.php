<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Section - SF2 | Daily Attendance</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        
        :root {
            --primary: #059669;
            --primary-dark: #047857;
            --primary-light: #d1fae5;
            --secondary: #10b981;
            --accent: #34d399;
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
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--gray-50);
            min-height: 100vh;
            color: var(--gray-800);
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* Modern Background Pattern */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(ellipse 80% 50% at 20% 40%, rgba(5, 150, 105, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse 60% 40% at 80% 60%, rgba(16, 185, 129, 0.06) 0%, transparent 50%),
                radial-gradient(ellipse 50% 30% at 50% 100%, rgba(52, 211, 153, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        /* Glassmorphism Header */
        .top-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.6);
            padding: 16px 0;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
            position: relative;
            z-index: 1;
        }

        .nav-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Modern Back Button */
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: transparent;
            color: var(--gray-600);
            padding: 10px 18px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            border: 1px solid transparent;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .back-btn:hover {
            background: var(--gray-100);
            color: var(--primary);
            transform: translateX(-2px);
        }

        .back-btn i {
            font-size: 0.875rem;
            transition: transform 0.3s ease;
        }

        .back-btn:hover i {
            transform: translateX(-3px);
        }

        /* Breadcrumb & Title */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.875rem;
            color: var(--gray-500);
            margin-bottom: 4px;
        }

        .breadcrumb i {
            font-size: 0.75rem;
            color: var(--gray-400);
        }

        .page-title-nav {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--gray-800);
        }

        /* Main Content */
        .main-content {
            padding: 32px 0;
        }

        /* Hero Section */
        .hero {
            margin-bottom: 40px;
            animation: slideDown 0.6s ease-out;
        }

        .hero-card {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 24px;
            padding: 48px;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 
                0 20px 40px -10px rgba(5, 150, 105, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.1) inset;
        }

        .hero-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-card::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(52, 211, 153, 0.2) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .hero-icon {
            width: 88px;
            height: 88px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
            flex-shrink: 0;
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .hero-text h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 8px;
            letter-spacing: -0.02em;
        }

        .hero-text p {
            font-size: 1.125rem;
            opacity: 0.9;
            margin-bottom: 20px;
            font-weight: 400;
        }

        .badge-group {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .badge i {
            font-size: 0.875rem;
        }

        /* Stats Bar */
        .stats-bar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
            animation: slideUp 0.6s ease-out 0.1s both;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid var(--gray-200);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.08);
            border-color: var(--gray-300);
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .stat-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-icon-box {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
        }

        .stat-icon-box.emerald {
            background: var(--primary-light);
            color: var(--primary);
        }

        .stat-icon-box.teal {
            background: #ccfbf1;
            color: #0d9488;
        }

        .stat-icon-box.green {
            background: #d1fae5;
            color: var(--success);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--gray-800);
            line-height: 1;
        }

        /* Section Grid */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            animation: slideUp 0.6s ease-out 0.2s both;
        }

        .section-title-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title-group h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-800);
        }

        .section-count {
            background: var(--primary);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 700;
        }

        .view-toggle {
            display: flex;
            gap: 8px;
            background: var(--gray-100);
            padding: 4px;
            border-radius: 10px;
        }

        .view-btn {
            padding: 8px 16px;
            border: none;
            background: transparent;
            color: var(--gray-500);
            font-weight: 600;
            font-size: 0.875rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .view-btn.active {
            background: white;
            color: var(--gray-800);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .section-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        /* Modern Section Card */
        .section-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid var(--gray-200);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
            animation: fadeIn 0.5s ease-out both;
            position: relative;
        }

        .section-card:nth-child(1) { animation-delay: 0.1s; }
        .section-card:nth-child(2) { animation-delay: 0.15s; }
        .section-card:nth-child(3) { animation-delay: 0.2s; }
        .section-card:nth-child(4) { animation-delay: 0.25s; }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section-card:hover {
            transform: translateY(-4px) scale(1.01);
            box-shadow: 
                0 20px 40px -12px rgba(5, 150, 105, 0.15),
                0 0 0 1px rgba(5, 150, 105, 0.1);
            border-color: rgba(5, 150, 105, 0.2);
        }

        .card-top {
            background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
            padding: 28px;
            position: relative;
            border-bottom: 1px solid var(--gray-100);
        }

        .card-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--primary);
            border: 1px solid var(--gray-200);
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        }

        .section-icon-wrap {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            box-shadow: 0 10px 20px -5px rgba(5, 150, 105, 0.3);
        }

        .section-name {
            font-size: 1.375rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-meta {
            color: var(--gray-500);
            font-size: 0.95rem;
            font-weight: 500;
        }

        .card-bottom {
            padding: 24px 28px;
            background: white;
        }

        .stats-row {
            display: flex;
            gap: 16px;
            margin-bottom: 20px;
        }

        .mini-stat {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .mini-stat-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
        }

        .mini-stat-icon.blue {
            background: #eff6ff;
            color: #2563eb;
        }

        .mini-stat-icon.pink {
            background: #fdf2f8;
            color: #db2777;
        }

        .mini-stat-icon.green {
            background: #f0fdf4;
            color: #16a34a;
        }

        .card-action {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 20px;
            border-top: 1px solid var(--gray-100);
        }

        .action-text {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--primary);
        }

        .action-arrow {
            width: 36px;
            height: 36px;
            background: var(--gray-100);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-500);
            transition: all 0.3s ease;
        }

        .section-card:hover .action-arrow {
            background: var(--primary);
            color: white;
            transform: translateX(4px);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 40px;
            background: white;
            border-radius: 24px;
            border: 2px dashed var(--gray-200);
            animation: fadeIn 0.6s ease-out;
        }

        .empty-icon {
            width: 120px;
            height: 120px;
            background: var(--gray-50);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 3rem;
            color: var(--gray-300);
        }

        .empty-title {
            font-size: 1.5rem;
            color: var(--gray-700);
            font-weight: 700;
            margin-bottom: 12px;
        }

        .empty-text {
            font-size: 1rem;
            max-width: 400px;
            margin: 0 auto 24px;
            color: var(--gray-500);
            line-height: 1.6;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary);
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(5, 150, 105, 0.3);
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 32px;
            color: var(--gray-400);
            font-size: 0.875rem;
            border-top: 1px solid var(--gray-200);
            margin-top: 40px;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 24px;
            margin-bottom: 16px;
        }

        .footer-links a {
            color: var(--gray-500);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: var(--primary);
        }

        /* Animations */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

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

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 0 16px;
            }

            .hero-card {
                padding: 32px 24px;
            }

            .hero-content {
                flex-direction: column;
                text-align: center;
            }

            .hero-text h1 {
                font-size: 1.875rem;
            }

            .section-grid {
                grid-template-columns: 1fr;
            }

            .stats-bar {
                grid-template-columns: 1fr;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--gray-100);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--gray-400);
        }
    </style>
</head>
<body>

    <!-- Sticky Header -->
    <header class="top-header">
        <div class="container">
            <nav class="nav-content">
               
                
                <div class="nav-center" style="text-align: center;">
                    <div class="breadcrumb">
                        <span>Teacher Portal</span>
                        <i class="fas fa-chevron-right"></i>
                        <span>School Forms</span>
                        <i class="fas fa-chevron-right"></i>
                        <span style="color: var(--primary);">SF2</span>
                    </div>
                    <div class="page-title-nav">Daily Attendance</div>
                </div>

                <div class="nav-right" style="width: 140px;">
                    <!-- Spacer for balance -->
                </div>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            
            <!-- Hero Section -->
            <div class="hero">
                <div class="hero-card">
                    <div class="hero-content">
                        <div class="hero-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="hero-text">
                            <h1>Select Section</h1>
                            <p>Choose a section to record and manage daily learner attendance</p>
                            <div class="badge-group">
                                @if($activeSchoolYear)
                                    <div class="badge">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>S.Y. {{ $activeSchoolYear->name }}</span>
                                    </div>
                                @endif
                                <div class="badge">
                                    <i class="fas fa-file-alt"></i>
                                    <span>DepEd Official Form</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="stats-bar">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Total Sections</span>
                        <div class="stat-icon-box gray">
                            <i class="fas fa-chalkboard"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ $sections->count() }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Total Students</span>
                        <div class="stat-icon-box gray">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ $sections->sum(function($s) { return $s->students->count(); }) }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Current Month</span>
                        <div class="stat-icon-box gray">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div class="stat-value">{{ now()->format('M') }}</div>
                </div>
            </div>

            <!-- Sections Grid -->
            <div class="section-header">
                <div class="section-title-group">
                    <h2>Your Assigned Sections</h2>
                    <span class="section-count">{{ $sections->count() }}</span>
                </div>
                <div class="view-toggle">
                    <button class="view-btn active">
                        <i class="fas fa-th-large"></i> Grid
                    </button>
                    <button class="view-btn">
                        <i class="fas fa-list"></i> List
                    </button>
                </div>
            </div>

            @if($sections->count() > 0)
                <div class="section-grid">
                    @foreach($sections as $section)
                        @php
                            $maleCount = $section->students->where('sex', 'Male')->count();
                            $femaleCount = $section->students->where('sex', 'Female')->count();
                            $totalCount = $maleCount + $femaleCount;
                        @endphp
                        <a href="{{ route('teacher.school-forms.sf2', $section->id) }}" class="section-card">
                            <div class="card-top">
                                <span class="card-badge">Grade {{ $section->year_level }}</span>
                                <div class="section-icon-wrap">
                                    {{ substr($section->name, 0, 2) }}
                                </div>
                                <div class="section-name">
                                    Grade {{ $section->year_level }} - {{ $section->name }}
                                </div>
                                <div class="section-meta">
                                    <i class="fas fa-user-graduate" style="margin-right: 6px;"></i>
                                    {{ $totalCount }} Students Enrolled
                                </div>
                            </div>
                            <div class="card-bottom">
                                <div class="stats-row">
                                    <div class="mini-stat">
                                        <div class="mini-stat-icon blue">
                                            <i class="fas fa-male"></i>
                                        </div>
                                        <span>{{ $maleCount }} Male</span>
                                    </div>
                                    <div class="mini-stat">
                                        <div class="mini-stat-icon pink">
                                            <i class="fas fa-female"></i>
                                        </div>
                                        <span>{{ $femaleCount }} Female</span>
                                    </div>
                                    <div class="mini-stat">
                                        <div class="mini-stat-icon green">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <span>{{ $totalCount }} Total</span>
                                    </div>
                                </div>
                                <div class="card-action">
                                    <span class="action-text">Record Attendance</span>
                                    <div class="action-arrow">
                                        <i class="fas fa-arrow-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <div class="empty-title">No Sections Assigned</div>
                    <p class="empty-text">
                        You don't have any sections assigned for the current school year. 
                        Please contact your administrator for assistance.
                    </p>
                    <a href="{{ route('teacher.dashboard') }}" class="btn-primary">
                        <i class="fas fa-home"></i>
                        Return to Dashboard
                    </a>
                </div>
            @endif

        </div>
    </main>

    <!-- Floating Action Button Container -->
<div class="fab-container">
    <a href="{{ route('teacher.dashboard') }}" class="fab-button fab-back" title="Back to Dashboard">
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

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-links">
                <a href="#">Help Center</a>
                <a href="#">DepEd Guidelines</a>
                <a href="#">SF2 Manual</a>
                <a href="#">Support</a>
            </div>
            <p>
                <i class="fas fa-shield-alt" style="margin-right: 8px; color: var(--primary);"></i>
                School Form 2 (SF2) - Daily Attendance Report of Learners | DepEd Official Form
            </p>
            <p style="margin-top: 8px; font-size: 0.8rem; opacity: 0.7;">
                © 2024 School Management System. All rights reserved.
            </p>
        </div>
    </footer>

</body>
</html>