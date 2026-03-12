<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 7945d1551f9510fadfced8469c757ebd7da4a99a
@php
    use App\Models\Teacher;
    use App\Models\Announcement;
    use App\Models\Student;
    use App\Models\Section;
    
    $announcements = Announcement::latest()->take(6)->get();
    $teachers = Teacher::all();
    $students = Student::whereHas('enrollments', function($q) {
        $q->where('status', 'enrolled');
    })->get();
    $sections = Section::whereHas('schoolYear', function($q) {
        $q->where('is_active', true);
    })->get();
    
    $principal = $teachers->where('position', 'Principal')->first();
    $vicePrincipals = $teachers->whereIn('position', ['Vice Principal', 'Assistant Principal']);
    $teachingStaff = $teachers->whereNotIn('position', ['Principal', 'Vice Principal', 'Assistant Principal']);
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugawe Elementary School | Official Website</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Modern Color Palette - Teal & Coral Theme */
        :root {
            --primary: #0d9488;      /* Teal 600 */
            --primary-dark: #0f766e; /* Teal 700 */
            --primary-light: #14b8a6; /* Teal 500 */
            --accent: #f97316;       /* Orange 500 */
            --accent-light: #fb923c; /* Orange 400 */
            --bg-warm: #fdf8f6;      /* Warm off-white */
            --text-dark: #1e293b;    /* Slate 800 */
            --text-muted: #64748b;   /* Slate 500 */
        }

        .grain {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 50;
            opacity: 0.02;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
        }

        /* Animated Background */
        .hero-bg {
            background: linear-gradient(135deg, #f0fdfa 0%, #fdf8f6 50%, #fff7ed 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-bg::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(20, 184, 166, 0.15) 0%, transparent 70%);
            animation: float 20s infinite ease-in-out;
        }

        .hero-bg::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(249, 115, 22, 0.1) 0%, transparent 70%);
            animation: float 25s infinite ease-in-out reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, -30px) scale(1.1); }
        }

        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .glass-dark {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Text Balance */
        .text-balance { text-wrap: balance; }
        
        /* Card Hover Effects */
        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -15px rgba(13, 148, 136, 0.15);
        }

        /* Primary Button */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        .btn-primary:hover::before {
            left: 100%;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px -10px rgba(13, 148, 136, 0.4);
        }

        /* Accent Button */
        .btn-accent {
            background: linear-gradient(135deg, var(--accent) 0%, #ea580c 100%);
            transition: all 0.3s ease;
        }
        .btn-accent:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px -10px rgba(249, 115, 22, 0.4);
        }

        /* Navigation Link Animation */
        .nav-link {
            position: relative;
            color: var(--text-muted);
            transition: color 0.3s;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s ease;
            border-radius: 2px;
        }
        .nav-link:hover {
            color: var(--primary-dark);
        }
        .nav-link:hover::after {
            width: 100%;
        }

        /* Side Panel Animation */
        .side-panel {
            position: fixed;
            top: 0;
            right: -100%;
            width: 100%;
            max-width: 480px;
            height: 100vh;
            background: white;
            z-index: 100;
            transition: right 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: -10px 0 40px rgba(0,0,0,0.1);
            overflow-y: auto;
        }

        .side-panel.active {
            right: 0;
        }

        .side-panel-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 99;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .side-panel-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Form Slide Animation */
        .form-container {
            position: relative;
            overflow: hidden;
            min-height: 400px;
        }

        .form-slide {
            position: absolute;
            width: 100%;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0;
            transform: translateX(50px);
            pointer-events: none;
        }

        .form-slide.active {
            opacity: 1;
            transform: translateX(0);
            pointer-events: all;
            position: relative;
        }

        .form-slide.exit-left {
            opacity: 0;
            transform: translateX(-50px);
        }

        /* Decorative Elements */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.4;
            animation: blob-float 10s infinite ease-in-out;
        }

        @keyframes blob-float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Stats Counter Animation */
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            border: 1px solid rgba(13, 148, 136, 0.1);
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            border-color: rgba(13, 148, 136, 0.3);
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Input Focus Effects */
        .input-field {
            transition: all 0.3s ease;
            border: 2px solid #e2e8f0;
        }
        .input-field:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1);
        }

        /* Custom Checkbox */
        .custom-checkbox {
            appearance: none;
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid #cbd5e1;
            border-radius: 0.375rem;
            cursor: pointer;
            position: relative;
            transition: all 0.2s;
        }
        .custom-checkbox:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        .custom-checkbox:checked::after {
            content: '';
            position: absolute;
            left: 5px;
            top: 2px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
<<<<<<< HEAD
=======
=======


@php
    use App\Models\Teacher;
    use App\Models\Announcement;


$announcements = Announcement::latest()->get();
    $teachers = Teacher::all();
@endphp
@vite(['resources/css/app.css', 'resources/js/app.js'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Student Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes float {
            0%,100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .modal-enter {
            animation: fadeUp 0.3s ease-out;
>>>>>>> 613e1229c52f180efb9f6039d1dc4243eba34df1
>>>>>>> 7945d1551f9510fadfced8469c757ebd7da4a99a
        }
    </style>
</head>

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 7945d1551f9510fadfced8469c757ebd7da4a99a
<body class="antialiased text-slate-800 bg-white">

    <div class="grain"></div>

    <!-- Navigation -->
    <nav class="fixed w-full z-40 glass border-b border-slate-200/60">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center h-20">
                <a href="#" class="flex items-center gap-3 group">
                    <div class="relative">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="h-12 w-12 rounded-xl object-cover shadow-lg group-hover:scale-105 transition-transform">
                        <div class="absolute inset-0 bg-teal-500/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-base font-bold text-slate-900 leading-tight">Tugawe Elementary School</p>
                        <p class="text-xs text-teal-600 font-medium">DepEd Negros Oriental</p>
                    </div>
                </a>

                <div class="hidden md:flex items-center gap-8">
                    <a href="#about" class="nav-link text-sm font-medium">About</a>
                    <a href="#announcements" class="nav-link text-sm font-medium">Announcements</a>
                    <a href="#faculty" class="nav-link text-sm font-medium">Faculty</a>
                    <button onclick="openAuthPanel('login')" class="btn-primary text-white text-sm font-semibold px-6 py-2.5 rounded-full shadow-lg shadow-teal-500/30">
                        Sign In
                    </button>
                </div>

                <button onclick="toggleMobileMenu()" class="md:hidden p-2 text-slate-600 hover:text-teal-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
<<<<<<< HEAD
=======
=======
<body class="min-h-screen bg-gradient-to-br from-indigo-200 via-blue-100 to-purple-200 relative overflow-hidden font-sans">

<!-- Animated Background Blobs -->
<div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-400 opacity-30 rounded-full blur-3xl animate-pulse"></div>
<div class="absolute bottom-0 -right-40 w-96 h-96 bg-purple-400 opacity-30 rounded-full blur-3xl animate-pulse"></div> 

<!-- MAIN CONTENT -->
<div class="flex items-center justify-center min-h-screen pt-24 px-4">

    <!-- Glass Card (smaller) -->
    <div class="relative w-full max-w-sm bg-white/50 backdrop-blur-3xl border border-white/30
                rounded-3xl shadow-2xl p-6 animate-[fadeUp_0.6s_ease-out]">

        <!-- Hamburger Dropdown -->
        <div class="relative mb-4">
            <button id="hamburgerBtn" class="p-2 rounded-lg bg-white/50 backdrop-blur-xl shadow-md hover:bg-white/70 transition transform hover:scale-105">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <div id="hamburgerDropdown"
                 class="hidden absolute right-0 mt-2 w-40 bg-white/90 backdrop-blur-xl rounded-xl shadow-lg py-2 z-50">
                <button onclick="openModal('homeModal')" class="block w-full text-left px-3 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-800 transition rounded-md">
                    About
                </button>
                <button onclick="openModal('devModal')" class="block w-full text-left px-3 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-800 transition rounded-md">
                    Developers
                </button>
                <button onclick="openModal('announceModal')" class="block w-full text-left px-3 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-800 transition rounded-md">
                    Announcements
                </button>
                <button onclick="openModal('facultyModal')" class="block w-full text-left px-3 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-800 transition rounded-md">
                    Faculty
>>>>>>> 613e1229c52f180efb9f6039d1dc4243eba34df1
>>>>>>> 7945d1551f9510fadfced8469c757ebd7da4a99a
                </button>
            </div>
        </div>

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 7945d1551f9510fadfced8469c757ebd7da4a99a
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden glass border-t border-slate-200">
            <div class="px-6 py-4 space-y-3">
                <a href="#about" class="block text-sm font-medium text-slate-600 py-2 hover:text-teal-600">About</a>
                <a href="#announcements" class="block text-sm font-medium text-slate-600 py-2 hover:text-teal-600">Announcements</a>
                <a href="#faculty" class="block text-sm font-medium text-slate-600 py-2 hover:text-teal-600">Faculty</a>
                <button onclick="openAuthPanel('login')" class="w-full btn-primary text-white text-sm font-semibold px-5 py-3 rounded-full mt-2 shadow-lg shadow-teal-500/30">
                    Sign In to Portal
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-bg min-h-screen flex items-center pt-20 relative">
        <!-- Decorative Blobs -->
        <div class="blob bg-teal-300 w-96 h-96 top-20 -left-20"></div>
        <div class="blob bg-orange-300 w-80 h-80 bottom-20 right-10 animation-delay-2000"></div>
        
        <div class="max-w-7xl mx-auto px-6 py-20 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-teal-50 border border-teal-100 mb-6">
                        <span class="w-2 h-2 rounded-full bg-teal-500 animate-pulse"></span>
                        <span class="text-sm font-semibold text-teal-700">Department of Education • Region VII</span>
                    </div>
                    
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-slate-900 leading-[1.1] mb-6 text-balance">
                        Building <span class="gradient-text">foundations</span> for lifelong learning
                    </h1>
                    
                    <p class="text-lg md:text-xl text-slate-600 mb-8 leading-relaxed text-balance max-w-xl">
                        Tugawe Elementary School provides quality basic education to the children of 
                        Dauin, Negros Oriental. Committed to academic excellence and holistic development.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button onclick="openAuthPanel('login')" class="btn-primary text-white px-8 py-4 rounded-full font-semibold inline-flex items-center justify-center gap-2 shadow-xl shadow-teal-500/30 text-base">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Student Portal
                        </button>
                        <a href="#announcements" class="px-8 py-4 rounded-full font-semibold text-slate-700 bg-white border-2 border-slate-200 hover:border-teal-500 hover:text-teal-600 inline-flex items-center justify-center gap-2 transition-all shadow-lg hover:shadow-xl">
                            Latest Updates
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </a>
                    </div>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-3 gap-4 mt-12 pt-8 border-t border-slate-200/60">
                        <div>
                            <p class="text-3xl font-bold text-teal-600">{{ $students->count() }}+</p>
                            <p class="text-sm text-slate-500 font-medium">Students</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-orange-500">{{ $teachers->count() }}+</p>
                            <p class="text-sm text-slate-500 font-medium">Teachers</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-teal-600">{{ $sections->count() }}</p>
                            <p class="text-sm text-slate-500 font-medium">Sections</p>
                        </div>
                    </div>
                </div>

                <!-- Hero Image/Illustration Area -->
                <div class="relative hidden lg:block">
                    <div class="relative z-10 bg-white p-4 rounded-3xl shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-500">
                        <div class="aspect-[4/3] bg-gradient-to-br from-teal-50 to-orange-50 rounded-2xl overflow-hidden relative">
                            <img src="{{ asset('images/logo.jpg') }}" alt="School Campus" class="w-full h-full object-cover opacity-90">
                            <div class="absolute inset-0 bg-gradient-to-t from-teal-900/20 to-transparent"></div>
                        </div>
                    </div>
                    <!-- Floating Card -->
                    <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-2xl shadow-xl border border-slate-100 z-20 max-w-xs animate-bounce" style="animation-duration: 3s;">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-900">DepEd Certified</p>
                                <p class="text-xs text-slate-500">Excellence in Education</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-24 bg-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-teal-50/50 to-transparent"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="order-2 lg:order-1 relative">
                    <div class="aspect-[4/3] bg-gradient-to-br from-teal-100 to-orange-100 rounded-3xl overflow-hidden shadow-2xl relative group">
                        <img src="{{ asset('images/logo.jpg') }}" alt="School Campus" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-teal-900/30 to-transparent"></div>
                    </div>
                    
                    <!-- Mission Card -->
                    <div class="absolute -bottom-8 -right-8 bg-white p-8 rounded-2xl shadow-2xl border border-slate-100 max-w-sm z-10">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-teal-500 to-teal-600 flex items-center justify-center mb-4 shadow-lg shadow-teal-500/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <p class="text-lg font-bold text-slate-900 mb-2">Our Mission</p>
                        <p class="text-slate-600 leading-relaxed">
                            To provide quality basic education that is accessible to all learners in our community.
                        </p>
                    </div>
                </div>

                <div class="order-1 lg:order-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-50 border border-orange-100 mb-4">
                        <span class="text-xs font-bold text-orange-600 uppercase tracking-wider">About Our School</span>
                    </div>
                    
                    <h2 class="text-4xl md:text-5xl font-bold text-slate-900 mb-6 text-balance leading-tight">
                        Dedicated to nurturing <span class="text-teal-600">young minds</span> in the heart of Dauin
                    </h2>
                    
                    <div class="prose prose-slate text-slate-600 text-lg leading-relaxed space-y-4">
                        <p>
                            Tugawe Elementary School is a public educational institution under the Department of Education, 
                            serving the elementary education needs of Barangay Tugawe and neighboring communities in Dauin, Negros Oriental.
                        </p>
                        <p>
                            Our school is committed to providing accessible, quality basic education that develops 
                            academically competent, socially responsible, and morally upright individuals.
                        </p>
                    </div>
                    
                    <div class="mt-10 grid grid-cols-2 gap-6">
                        <div class="stat-card">
                            <p class="text-sm text-slate-500 mb-1 font-medium">School ID</p>
                            <p class="text-xl font-bold text-slate-900">120231</p>
                        </div>
                        <div class="stat-card">
                            <p class="text-sm text-slate-500 mb-1 font-medium">District</p>
                            <p class="text-xl font-bold text-slate-900">Dauin District</p>
                        </div>
                        <div class="stat-card">
                            <p class="text-sm text-slate-500 mb-1 font-medium">Division</p>
                            <p class="text-xl font-bold text-slate-900">Negros Oriental</p>
                        </div>
                        <div class="stat-card">
                            <p class="text-sm text-slate-500 mb-1 font-medium">Region</p>
                            <p class="text-xl font-bold text-slate-900">VII - Central Visayas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Announcements Section -->
    <section id="announcements" class="py-24 bg-slate-50 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-50 border border-teal-100 mb-4">
                        <span class="text-xs font-bold text-teal-600 uppercase tracking-wider">School Updates</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold text-slate-900">Announcements</h2>
                </div>
                @if($announcements->count() > 3)
                <button onclick="openModal('allAnnouncementsModal')" class="group flex items-center gap-2 text-sm font-semibold text-teal-600 hover:text-teal-700 transition-colors bg-white px-4 py-2 rounded-full shadow-md hover:shadow-lg">
                    View all updates
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </button>
                @endif
            </div>

            @if($announcements->count())
            <div class="grid md:grid-cols-3 gap-8">
                @foreach($announcements->take(3) as $announcement)
                <article class="bg-white rounded-2xl p-6 card-hover border border-slate-100 relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-1 h-full bg-gradient-to-b from-teal-500 to-teal-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-2 h-2 rounded-full bg-orange-400"></div>
                        <time class="text-sm font-semibold text-slate-400">
                            {{ $announcement->created_at->format('F d, Y') }}
                        </time>
                    </div>
                    
                    <h3 class="text-xl font-bold text-slate-900 mb-3 line-clamp-2 group-hover:text-teal-600 transition-colors">
                        {{ $announcement->title }}
                    </h3>
                    
                    <p class="text-slate-600 line-clamp-3 mb-6 leading-relaxed">
                        {{ $announcement->content }}
                    </p>
                    
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-teal-100 to-teal-200 flex items-center justify-center text-sm font-bold text-teal-700">
                            {{ substr($announcement->user->name, 0, 1) }}
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-slate-900 block">{{ $announcement->user->name }}</span>
                            <span class="text-xs text-slate-500">Administrator</span>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
            @else
            <div class="text-center py-16 bg-white rounded-2xl border border-slate-100 shadow-sm">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-slate-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <p class="text-slate-500 font-medium">No announcements posted at this time.</p>
            </div>
            @endif
        </div>
    </section>

    <!-- Faculty Section -->
    <section id="faculty" class="py-24 bg-white relative overflow-hidden">
        <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-to-t from-teal-50/30 to-transparent"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-50 border border-orange-100 mb-4">
                    <span class="text-xs font-bold text-orange-600 uppercase tracking-wider">Our People</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-slate-900 mb-6">School Faculty & Staff</h2>
                <p class="text-lg text-slate-600 leading-relaxed">
                    Meet the dedicated educators and administrators committed to providing 
                    quality education to our learners.
                </p>
            </div>

            @if($teachers->count())
            <!-- Principal -->
            @if($principal)
            <div class="flex justify-center mb-16">
                <div class="text-center group">
                    <div class="relative inline-block mb-6">
                        <div class="absolute inset-0 bg-gradient-to-br from-teal-400 to-orange-400 rounded-3xl rotate-6 opacity-20 group-hover:rotate-12 transition-transform"></div>
                        <div class="relative w-40 h-40 mx-auto rounded-3xl overflow-hidden bg-slate-100 shadow-2xl border-4 border-white">
                            <img src="{{ $principal->photo ? asset('storage/'.$principal->photo) : asset('images/photo-placeholder.png') }}" 
                                 alt="{{ $principal->first_name }} {{ $principal->last_name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="absolute -bottom-3 -right-3 w-12 h-12 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-1">{{ $principal->first_name }} {{ $principal->last_name }}</h3>
                    <p class="text-teal-600 font-semibold">School Principal</p>
                </div>
            </div>
            @endif

            <!-- Teaching Staff Preview -->
            @if($teachingStaff->count())
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6">
                @foreach($teachingStaff->take(6) as $teacher)
                <div class="text-center group">
                    <div class="relative mb-4 mx-auto w-24 h-24">
                        <div class="absolute inset-0 bg-gradient-to-br from-teal-200 to-orange-200 rounded-2xl rotate-3 opacity-0 group-hover:opacity-100 group-hover:rotate-6 transition-all duration-300"></div>
                        <div class="relative w-24 h-24 mx-auto rounded-2xl overflow-hidden bg-slate-100 shadow-lg border-2 border-white">
                            <img src="{{ $teacher->photo ? asset('storage/'.$teacher->photo) : asset('images/photo-placeholder.png') }}"
                                 alt="{{ $teacher->first_name }} {{ $teacher->last_name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        </div>
                    </div>
                    <h4 class="text-sm font-bold text-slate-900 truncate px-2 mb-1">
                        {{ $teacher->first_name }} {{ $teacher->last_name }}
                    </h4>
                    <p class="text-xs text-slate-500 font-medium bg-slate-100 px-2 py-1 rounded-full inline-block">
                        {{ $teacher->position ?? 'Teacher' }}
                    </p>
                </div>
                @endforeach
            </div>
            @endif

            @if($teachers->count() > 7)
            <div class="text-center mt-12">
                <button onclick="openModal('facultyModal')" class="group inline-flex items-center gap-2 px-8 py-4 rounded-full border-2 border-slate-200 text-sm font-semibold text-slate-700 hover:border-teal-500 hover:text-teal-600 hover:bg-teal-50 transition-all shadow-md hover:shadow-lg">
                    View complete faculty list
                    <svg class="w-4 h-4 group-hover:translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
            </div>
            @endif
            @else
            <div class="text-center py-16 bg-slate-50 rounded-2xl">
                <p class="text-slate-500 font-medium">Faculty information currently unavailable.</p>
            </div>
            @endif
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-24 bg-slate-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-teal-900/20 to-slate-900"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-orange-500/10 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-4xl md:text-5xl font-bold mb-6">Get in touch</h2>
                    <p class="text-slate-400 text-lg mb-10 leading-relaxed">
                        For inquiries regarding enrollment, student records, or other school matters, 
                        please contact us or visit the school administration office.
                    </p>
                    
                    <div class="space-y-6">
                        <div class="flex items-start gap-4 group">
                            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0 group-hover:bg-teal-500/20 transition-colors">
                                <svg class="w-6 h-6 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-lg mb-1">Address</p>
                                <p class="text-slate-400">Tugawe, Dauin, Negros Oriental, Philippines</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4 group">
                            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0 group-hover:bg-orange-500/20 transition-colors">
                                <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-lg mb-1">Email</p>
                                <p class="text-slate-400">tugawe.es@deped.gov.ph</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="glass-dark rounded-3xl p-8 border border-white/10">
                    <h3 class="text-2xl font-bold mb-6 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-teal-400 animate-pulse"></span>
                        School Hours
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-4 border-b border-white/10">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-teal-500/20 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-slate-300">Monday - Friday</span>
                            </div>
                            <span class="font-semibold text-lg">7:00 AM - 4:00 PM</span>
                        </div>
                        <div class="flex justify-between items-center py-4 border-b border-white/10 opacity-60">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-slate-700 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                    </svg>
                                </div>
                                <span class="text-slate-400">Saturday & Sunday</span>
                            </div>
                            <span class="font-medium">Closed</span>
                        </div>
                    </div>
                    <div class="mt-8 pt-6 border-t border-white/10">
                        <div class="flex items-start gap-3 text-sm text-slate-400">
                            <svg class="w-5 h-5 text-orange-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p>For urgent matters, please contact the school directly during operating hours.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-950 text-slate-400 py-12 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/logo.jpg') }}" class="h-10 w-10 rounded-lg object-cover opacity-80 ring-2 ring-teal-500/30">
                    <div>
                        <span class="text-white font-bold block">Tugawe Elementary School</span>
                        <span class="text-xs">Excellence in Education</span>
                    </div>
                </div>
                <div class="flex items-center gap-6 text-sm">
                    <a href="#" class="hover:text-teal-400 transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-teal-400 transition-colors">Terms of Use</a>
                    <a href="#" class="hover:text-teal-400 transition-colors">Contact</a>
                </div>
                <p class="text-xs text-slate-600">
                    © {{ date('Y') }} Department of Education. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Side Panel Auth Container -->
    <div id="sidePanelOverlay" class="side-panel-overlay" onclick="closeAuthPanel()"></div>
    
    <div id="authSidePanel" class="side-panel">
        <div class="min-h-full flex flex-col bg-gradient-to-b from-slate-50/50 to-white">
            <!-- Header -->
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-white sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <img src="{{ asset('images/logo.jpg') }}" class="h-10 w-10 rounded-xl object-cover shadow-md ring-2 ring-teal-100">
                        <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-teal-500 rounded-full border-2 border-white"></div>
                    </div>
                    <div>
                        <h2 class="font-bold text-slate-900 text-lg">Tugawe ES Portal</h2>
                        <p class="text-xs text-slate-500">Student Management System</p>
                    </div>
                </div>
                <button onclick="closeAuthPanel()" class="w-10 h-10 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 hover:text-slate-700 transition-all duration-200 hover:rotate-90">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Auth Mode Indicator -->
            <div class="px-6 pt-6 pb-2">
                <div class="flex items-center gap-3 mb-2">
                    <div id="authModeIcon" class="w-12 h-12 rounded-2xl bg-gradient-to-br from-teal-500 to-teal-600 flex items-center justify-center shadow-lg shadow-teal-500/25 transition-all duration-300">
                        <svg id="signinIcon" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        <svg id="signupIcon" class="w-6 h-6 text-white hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 id="authTitle" class="text-xl font-bold text-slate-900 transition-all duration-300">Welcome Back</h3>
                        <p id="authSubtitle" class="text-sm text-slate-500 transition-all duration-300">Sign in to access your account</p>
                    </div>
                </div>
            </div>

            <!-- Toggle Switch -->
            <div class="px-6 py-4">
                <div class="relative bg-slate-100 rounded-2xl p-1.5 flex items-center">
                    <div id="toggleSlider" class="absolute left-1.5 w-[calc(50%-6px)] h-[calc(100%-12px)] bg-white rounded-xl shadow-sm transition-all duration-300 ease-out"></div>
                    <button onclick="switchAuthMode('login')" id="loginTab" class="relative z-10 flex-1 py-2.5 text-sm font-semibold text-teal-700 transition-colors duration-300 text-center">
                        Sign In
                    </button>
                    <button onclick="switchAuthMode('register')" id="registerTab" class="relative z-10 flex-1 py-2.5 text-sm font-semibold text-slate-500 transition-colors duration-300 text-center">
                        Student Sign Up
                    </button>
                </div>
            </div>

            <!-- Forms Container -->
            <div class="flex-1 p-6 relative overflow-hidden">
                <!-- Login Form -->
                <div id="loginForm" class="form-slide active space-y-5">
                    <form method="POST" action="{{ route('login') }}" class="space-y-5" onsubmit="handleAuthSubmit(event, 'login')">
                        @csrf
                        
                        <div class="space-y-4">
                            <div class="group">
                                <label class="block text-sm font-semibold text-slate-700 mb-2 group-focus-within:text-teal-600 transition-colors">Username</label>
                                <div class="relative">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-teal-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="username" required
                                           class="input-field w-full pl-12 pr-4 py-3.5 rounded-xl outline-none bg-white border-2 border-slate-200 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all"
                                           placeholder="Enter your username">
                                </div>
                                @error('username')
                                    <p class="text-red-500 text-sm mt-2 flex items-center gap-1 animate-pulse">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="group">
                                <label class="block text-sm font-semibold text-slate-700 mb-2 group-focus-within:text-teal-600 transition-colors">Password</label>
                                <div class="relative">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-teal-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </div>
                                    <input type="password" name="password" id="loginPassword" required
                                           class="input-field w-full pl-12 pr-12 py-3.5 rounded-xl outline-none bg-white border-2 border-slate-200 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all"
                                           placeholder="Enter your password">
                                    <button type="button" onclick="togglePassword('loginPassword')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors p-1 hover:bg-slate-100 rounded-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

<<<<<<< HEAD
                       
=======
                      
>>>>>>> 7945d1551f9510fadfced8469c757ebd7da4a99a

                        <button type="submit" id="loginSubmitBtn" class="w-full btn-primary text-white py-4 rounded-xl font-bold text-base flex items-center justify-center gap-2 shadow-xl shadow-teal-500/30 hover:shadow-teal-500/40 transform hover:-translate-y-0.5 transition-all duration-200">
                            <span id="loginBtnText">Sign In to Portal</span>
                            <svg id="loginSpinner" class="hidden w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </form>

                    <!-- Help Box -->
                    <div class="mt-6 p-4 bg-blue-50 border border-blue-100 rounded-xl">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-blue-900 mb-1">Need Help?</p>
                                <p class="text-xs text-blue-700 leading-relaxed">Contact your class adviser or the school admin office if you're having trouble signing in.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Student Registration Form -->
                <div id="registerForm" class="form-slide exit-left space-y-5">
                    <div class="bg-gradient-to-r from-orange-50 to-amber-50 border border-orange-100 rounded-xl p-4 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-orange-900">Student Registration Only</p>
                                <p class="text-xs text-orange-700">This portal is exclusively for enrolled students.</p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-4">
@csrf

<!-- Name -->
<div class="grid grid-cols-3 gap-4">
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">First Name</label>
        <input type="text" name="first_name" required
        class="input-field w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-teal-500">
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Middle Name</label>
        <input type="text" name="middle_name"
        class="input-field w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-teal-500">
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Last Name</label>
        <input type="text" name="last_name" required
        class="input-field w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-teal-500">
    </div>
</div>

<!-- Suffix + Birthday -->
<div class="grid grid-cols-2 gap-4">

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Suffix</label>
        <input type="text" name="suffix"
        class="input-field w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-teal-500"
        placeholder="Jr., III">
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Birthday</label>
        <input type="date" name="birthday" required
        class="input-field w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-teal-500">
    </div>

</div>

<!-- LRN + Sex -->
<div class="grid grid-cols-2 gap-4">

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">LRN</label>
        <input type="text" name="lrn" id="lrn"
        maxlength="12" required
        value="120231"
        class="input-field w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-teal-500">
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Sex</label>
        <select name="sex"
        class="input-field w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-teal-500">
            <option value="">Select Sex</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
    </div>

</div>

<!-- Email + Username -->
<div class="grid grid-cols-2 gap-4">

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
        <input type="email" name="email"
        class="input-field w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-teal-500">
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Username</label>
        <input type="text" name="username"
        placeholder="Leave blank to auto generate"
        class="input-field w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-teal-500">
    </div>

</div>

<!-- Contact + Address -->
<div class="grid grid-cols-2 gap-4">

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Contact Number</label>

        <div class="flex items-center gap-2">
            <span class="px-3 py-3 bg-gray-100 rounded-xl border text-sm">+63</span>

            <input type="text" name="contact_number"
            maxlength="13"
            class="input-field w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-teal-500"
            placeholder="917 123 4567">
        </div>
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Address</label>
        <input type="text" name="address"
        class="input-field w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-teal-500">
    </div>

</div>

<!-- Password -->
<div class="grid grid-cols-2 gap-4">

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
        <input type="password" name="password" required
        class="input-field w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-teal-500">
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">Confirm Password</label>
        <input type="password" name="password_confirmation" required
        class="input-field w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-teal-500">
    </div>

</div>

<!-- Photo -->
<div>
<label class="block text-sm font-semibold text-slate-700 mb-2">Photo</label>
<input type="file" name="photo" accept="image/*"
class="block w-full text-sm text-slate-500">
</div>

<button type="submit"
class="w-full btn-accent text-white py-4 rounded-xl font-bold shadow-xl">
Create Student Account
</button>

</form>

                    <!-- Verification Note -->
                    <div class="mt-4 p-4 bg-amber-50 border border-amber-100 rounded-xl">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-amber-900 mb-1">Account Verification Required</p>
                                <p class="text-xs text-amber-800 leading-relaxed">Your account will be reviewed by the school admin before activation. You'll receive a notification once approved.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-6 border-t border-slate-100 bg-slate-50/50">
                <p class="text-xs text-center text-slate-500 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Secured by Tugawe ES Admin • DepEd Negros Oriental
                </p>
            </div>
        </div>
    </div>

    <!-- All Announcements Modal -->
    <div id="allAnnouncementsModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal('allAnnouncementsModal')"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="bg-white w-full max-w-3xl max-h-[85vh] overflow-y-auto rounded-3xl shadow-2xl">
                <div class="sticky top-0 bg-white border-b border-slate-100 p-6 flex items-center justify-between z-10">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">All Announcements</h2>
                        <p class="text-sm text-slate-500">Stay updated with school news</p>
                    </div>
                    <button onclick="closeModal('allAnnouncementsModal')" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-slate-200 hover:text-slate-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <div class="p-6 space-y-6">
                    @foreach($announcements as $announcement)
                    <article class="pb-6 border-b border-slate-100 last:border-0 hover:bg-slate-50 p-4 rounded-xl transition-colors">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="px-3 py-1 rounded-full bg-teal-50 text-teal-700 text-xs font-bold">News</span>
                            <time class="text-sm text-slate-400">
                                {{ $announcement->created_at->format('F d, Y') }}
                            </time>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $announcement->title }}</h3>
                        <p class="text-slate-600 leading-relaxed">{{ $announcement->content }}</p>
                        <div class="mt-4 flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-teal-100 to-teal-200 flex items-center justify-center text-xs font-bold text-teal-700">
                                {{ substr($announcement->user->name, 0, 1) }}
                            </div>
                            <span class="text-sm text-slate-500">Posted by <span class="font-semibold text-slate-700">{{ $announcement->user->name }}</span></span>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Faculty Modal -->
    <div id="facultyModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal('facultyModal')"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="bg-white w-full max-w-5xl max-h-[90vh] overflow-y-auto rounded-3xl shadow-2xl">
                <div class="sticky top-0 bg-white border-b border-slate-100 p-6 flex items-center justify-between z-10">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">Faculty & Staff</h2>
                        <p class="text-sm text-slate-500">Tugawe Elementary School</p>
                    </div>
                    <button onclick="closeModal('facultyModal')" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-slate-200 hover:text-slate-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                @if($teachers->count())
                <div class="p-8 space-y-12">
                    @if($principal)
                    <div class="text-center pb-12 border-b border-slate-100">
                        <div class="relative inline-block mb-6">
                            <div class="absolute inset-0 bg-gradient-to-br from-teal-400 to-orange-400 rounded-3xl rotate-3 opacity-20"></div>
                            <div class="relative w-32 h-32 mx-auto rounded-3xl overflow-hidden bg-slate-100 shadow-xl border-4 border-white">
                                <img src="{{ $principal->photo ? asset('storage/'.$principal->photo) : asset('images/photo-placeholder.png') }}" 
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="absolute -bottom-2 -right-2 bg-teal-500 text-white p-2 rounded-xl shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900">{{ $principal->first_name }} {{ $principal->last_name }}</h3>
                        <p class="text-teal-600 font-semibold">School Principal</p>
                    </div>
                    @endif

                    @if($teachingStaff->count())
                    <div>
                        <h4 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-8 text-center">Teaching Staff</h4>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                            @foreach($teachingStaff as $teacher)
                            <div class="text-center group">
                                <div class="relative mb-4 mx-auto w-20 h-20">
                                    <div class="absolute inset-0 bg-gradient-to-br from-teal-200 to-orange-200 rounded-2xl rotate-3 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    <div class="relative w-20 h-20 mx-auto rounded-2xl overflow-hidden bg-slate-100 shadow-md border-2 border-white">
                                        <img src="{{ $teacher->photo ? asset('storage/'.$teacher->photo) : asset('images/photo-placeholder.png') }}"
                                             class="w-full h-full object-cover">
                                    </div>
                                </div>
                                <h5 class="text-sm font-bold text-slate-900 mb-1">{{ $teacher->first_name }} {{ $teacher->last_name }}</h5>
                                <p class="text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded-full inline-block">{{ $teacher->position ?? 'Teacher' }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Mobile Menu Toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Side Panel Auth Functions
        function openAuthPanel(mode = 'login') {
            const panel = document.getElementById('authSidePanel');
            const overlay = document.getElementById('sidePanelOverlay');
            
            panel.classList.add('active');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
            
            if (mode === 'register') {
                switchAuthMode('register');
            } else {
                switchAuthMode('login');
            }
        }

        function closeAuthPanel() {
            const panel = document.getElementById('authSidePanel');
            const overlay = document.getElementById('sidePanelOverlay');
            
            panel.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        function switchAuthMode(mode) {
            const slider = document.getElementById('toggleSlider');
            const loginTab = document.getElementById('loginTab');
            const registerTab = document.getElementById('registerTab');
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            
            // Update toggle slider
            if (mode === 'register') {
                slider.style.transform = 'translateX(100%)';
                loginTab.classList.remove('text-teal-700');
                loginTab.classList.add('text-slate-500');
                registerTab.classList.remove('text-slate-500');
                registerTab.classList.add('text-orange-600');
                
                // Update header
                document.getElementById('authTitle').textContent = 'Student Registration';
                document.getElementById('authSubtitle').textContent = 'Create your student account';
                document.getElementById('signinIcon').classList.add('hidden');
                document.getElementById('signupIcon').classList.remove('hidden');
                document.getElementById('authModeIcon').classList.remove('from-teal-500', 'to-teal-600');
                document.getElementById('authModeIcon').classList.add('from-orange-500', 'to-orange-600');
                
                // Switch forms
                loginForm.classList.remove('active');
                loginForm.classList.add('exit-left');
                registerForm.classList.add('active');
                registerForm.classList.remove('exit-left');
            } else {
                slider.style.transform = 'translateX(0)';
                loginTab.classList.add('text-teal-700');
                loginTab.classList.remove('text-slate-500');
                registerTab.classList.add('text-slate-500');
                registerTab.classList.remove('text-orange-600');
                
                // Update header
                document.getElementById('authTitle').textContent = 'Welcome Back';
                document.getElementById('authSubtitle').textContent = 'Sign in to access your account';
                document.getElementById('signinIcon').classList.remove('hidden');
                document.getElementById('signupIcon').classList.add('hidden');
                document.getElementById('authModeIcon').classList.add('from-teal-500', 'to-teal-600');
                document.getElementById('authModeIcon').classList.remove('from-orange-500', 'to-orange-600');
                
                // Switch forms
                registerForm.classList.remove('active');
                registerForm.classList.add('exit-left');
                loginForm.classList.add('active');
                loginForm.classList.remove('exit-left');
            }
        }

        // Password Toggle
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const type = input.type === 'password' ? 'text' : 'password';
            input.type = type;
        }

        // Form Submit Handler
        function handleAuthSubmit(event, type) {
            event.preventDefault();
            const btn = type === 'login' ? document.getElementById('loginSubmitBtn') : document.getElementById('regSubmitBtn');
            const text = type === 'login' ? document.getElementById('loginBtnText') : document.getElementById('regBtnText');
            const spinner = type === 'login' ? document.getElementById('loginSpinner') : document.getElementById('regSpinner');
            
            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');
            text.textContent = type === 'login' ? 'Signing in...' : 'Creating account...';
            spinner.classList.remove('hidden');
            
            // Submit the form after a brief delay to show loading state
            setTimeout(() => {
                event.target.submit();
            }, 800);
        }

        // Modal Functions
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Close on Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAuthPanel();
                ['allAnnouncementsModal', 'facultyModal'].forEach(id => closeModal(id));
            }
        });

        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Close mobile menu if open
                    document.getElementById('mobileMenu').classList.add('hidden');
                }
            });
        });

        // Intersection Observer for fade-in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.querySelectorAll('section').forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(20px)';
            section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(section);
        });
    </script>

    @if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
            confirmButtonColor: '#0d9488',
            background: '#ffffff',
            color: '#1e293b',
            iconColor: '#0d9488'
        });
    </script>
    @endif
</body>
<<<<<<< HEAD
</html>
=======
</html>
=======
        <!-- Logo / Header -->
        <div class="text-center mb-6 animate-[float_4s_ease-in-out_infinite]">
            <img src="{{ asset('images/logo.jpg') }}"
                 class="mx-auto h-20 w-20 rounded-full shadow-xl mb-3 ring-4 ring-indigo-300 border-2 border-white object-cover"
                 alt="School Logo">

            <h1 class="text-xl font-bold text-gray-900 tracking-wide drop-shadow-sm">Student Management System</h1>
            <p class="text-xs text-gray-600 mt-1">Tugawe Elementary School</p>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-4">
            @csrf

        <!-- Username Input -->
<div class="relative mb-4">
    <input type="text" name="username" required
           placeholder="Username"
           class="w-full px-3 py-2 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm bg-white/80 backdrop-blur-sm text-sm hover:shadow-md">

    @error('username')
        <div class="text-red-500 text-xs mt-1">
            {{ $message }}
        </div>
    @enderror
</div>


<!-- Password Input -->
<div class="relative mb-4">
    <input id="password" type="password" name="password" required
           placeholder="Password"
           class="w-full px-3 py-2 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm pr-10 bg-white/80 backdrop-blur-sm text-sm hover:shadow-md">
    <button type="button" onclick="togglePassword()"
            class="absolute right-3 top-2.5 text-gray-400 hover:text-indigo-600 transition text-sm">
        👁
    </button>
</div>


<!-- remember me and forgot password links -->
        <div class="flex items-center justify-between mt-4 text-sm">
            <label class="flex items-center gap-2 text-gray-600">
                <input type="checkbox" name="remember" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150">
                Remember me
            </label>
            <a href="{{ route('password.request') }}" class="text-indigo-600 hover:underline">
                Forgot password?
            </a>
        </div>

           <!-- Submit Button -->
<button type="submit"
        id="loginBtn"
        class="w-full py-2.5 rounded-xl font-semibold text-white
               bg-gradient-to-r from-indigo-600 to-purple-600
               hover:from-indigo-700 hover:to-purple-700
               transition-all duration-300 shadow-md hover:shadow-lg
               active:scale-95 text-sm flex items-center justify-center gap-2">

    <!-- Button Text -->
    <span id="loginText">Log in</span>

    <!-- Spinner (hidden by default) -->
    <svg id="loginSpinner"
         class="hidden w-4 h-4 animate-spin"
         xmlns="http://www.w3.org/2000/svg"
         fill="none"
         viewBox="0 0 24 24">
        <circle class="opacity-25"
                cx="12"
                cy="12"
                r="10"
                stroke="currentColor"
                stroke-width="4"></circle>
        <path class="opacity-75"
              fill="currentColor"
              d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
    </svg>
</button>

        </form>

       
        <!-- Register Link -->
        <p class="mt-4 text-center text-xs text-gray-600">
            Don’t have an account?
            <a href="{{ route('register') }}" class="text-indigo-600 hover:underline font-medium">
                Register
            </a>
        </p>

        <!-- Footer -->
        <div class="text-center text-xs text-gray-400 mt-6">
            © {{ date('Y') }} Tugawe ES • All Rights Reserved
        </div>
    </div>
</div>


<!-- ================= MODALS ================= -->

@php
$modalClass = "hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50";
@endphp

<!-- About Modal -->
<div id="homeModal" class="{{ $modalClass }}" onclick="outsideClose(event,'homeModal')">
    <div class="bg-white rounded-2xl p-8 w-full max-w-lg shadow-2xl modal-enter">
        <h2 class="text-2xl font-bold text-indigo-700 mb-4">Welcome to TugaweES - SMS</h2>
        <p class="text-gray-600 leading-relaxed">
            Our system manages enrollment, grading, student records,
            and faculty information efficiently and securely.
        </p>
        <button onclick="closeModal('homeModal')"
                class="mt-6 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xl transition">
            Close
        </button>
    </div>
</div>

<!-- Developers Modal -->
<div id="devModal" class="{{ $modalClass }}" onclick="outsideClose(event,'devModal')">
    <div class="bg-white rounded-3xl p-8 w-full max-w-lg shadow-2xl modal-enter animate-fadeIn relative">
        
        <!-- Header -->
        <h2 class="text-2xl font-bold text-indigo-700 mb-4 flex items-center gap-2">
            💻 System Developers
        </h2>

        <!-- Description -->
        <p class="text-gray-600 mb-6">
            This Student Management System was developed by <strong>TriniTech</strong>, a team of 4th-year BS in Information Technology students of Negros Oriental State University (Batch 2022-2026).
        </p>

        <!-- Developer List -->
        <ul class="space-y-4">
            
            <li class="flex items-center gap-3">
                <div class="bg-indigo-100 text-indigo-700 w-10 h-10 flex items-center justify-center rounded-full font-semibold">E</div>
                <div>
                    <p class="font-semibold text-indigo-900">Elfseria</p>
                    <p class="text-gray-500 text-sm">System Developer/Programmer</p>
                </div>
            </li>
            <li class="flex items-center gap-3">
                <div class="bg-indigo-100 text-indigo-700 w-10 h-10 flex items-center justify-center rounded-full font-semibold">E</div>
                <div>
                    <p class="font-semibold text-indigo-900">Evarocksredhell</p>
                    <p class="text-gray-500 text-sm">Documentation</p>
                </div>
            </li>
            <li class="flex items-center gap-3">
                <div class="bg-indigo-100 text-indigo-700 w-10 h-10 flex items-center justify-center rounded-full font-semibold">E</div>
                <div>
                    <p class="font-semibold text-indigo-900">Ezimei</p>
                    <p class="text-gray-500 text-sm">Researcher</p>
                </div>
            </li>
        </ul>
<!-- Footer -->
        <div class="text-center text-xs text-gray-400 mt-8">
            © {{ date('Y') }} Tugawe ES • All Rights Reserved       
        </div>  

    </div>
</div>
        
    </div>
</div>

<!-- Optional animation style -->
<style>
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
.animate-fadeIn {
    animation: fadeIn 0.25s ease-out;
}
</style>


<!-- Announcements Modal -->
<div id="announceModal" class="{{ $modalClass }}" onclick="outsideClose(event,'announceModal')">
    <div class="bg-white/90 backdrop-blur-md rounded-3xl p-6 w-full max-w-lg shadow-2xl modal-enter max-h-[70vh] overflow-y-auto">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-indigo-700 flex items-center gap-2">
                <span>📢</span> Announcements
            </h2>
           
        </div>

        <!-- Announcement List -->
        @if($announcements->count())
        <ul class="space-y-4">
            @foreach($announcements as $announcement)
            <li class="bg-gradient-to-r from-indigo-50 to-purple-50 p-4 rounded-2xl shadow hover:shadow-lg transition transform hover:-translate-y-1 hover:scale-[1.02]">
                
                <!-- Title -->
                <h3 class="font-semibold text-indigo-900 text-lg mb-1">{{ $announcement->title }}</h3>
                
                <!-- Content -->
                <p class="text-gray-700 text-sm">{{ $announcement->content }}</p>
                
                <!-- Footer: Posted by + Date -->
                <div class="flex justify-between items-center mt-2 text-xs text-gray-500">
                    <span>Posted by: {{ $announcement->user->name }}</span>
                    <span>{{ $announcement->created_at->format('M d, Y') }}</span>
                </div>
            </li>
            @endforeach
        </ul>
        @else
        <p class="text-gray-500 text-center py-4">No announcements yet.</p>
        @endif
<!-- Footer -->
        <div class="text-center text-xs text-gray-400 mt-8">
            © {{ date('Y') }} Tugawe ES • All Rights Reserved       
        </div>  

    </div>
</div>

<!-- Faculty Modal -->
<div id="facultyModal" class="{{ $modalClass }} fixed inset-0 bg-black/50 backdrop-blur-md flex items-center justify-center z-50 px-4" onclick="outsideClose(event,'facultyModal')">
    <div class="bg-white/90 backdrop-blur-md rounded-3xl p-6 w-full max-w-6xl shadow-2xl modal-enter max-h-[80vh] overflow-y-auto">

  <!-- Header -->
<div class="flex items-center justify-center mb-6 relative gap-4">

    <!-- Left Logo (Circular) -->
    <div class="h-20 w-20 rounded-full overflow-hidden border border-gray-200 shadow-sm">
        <img src="{{ asset('images/logo1.png') }}" alt="Left Logo" class="h-full w-full object-cover">
    </div>

    <!-- Center Text -->
    <div class="text-center">
        <p class="font-bold uppercase text-xs">Republic of the Philippines</p>
        <p class="font-bold uppercase text-sm">Department of Education</p>
        <p class="text-xs">Division of Negros Oriental</p>
        <h2 class="text-2xl font-bold text-indigo-700 mt-1">
            Faculty Organizational Structure
        </h2>

        <p class="text-xs">Tugawe Elementary School | 120231</p>
    </div>

    <!-- Right Logo (Circular) -->
    <div class="h-20 w-20 rounded-full overflow-hidden border border-gray-200 shadow-sm">
        <img src="{{ asset('images/logo.jpg') }}" alt="Right Logo" class="h-full w-full object-cover">
    </div>

</div>


        <!-- Organizational Chart -->
        @if(isset($teachers) && $teachers->count())
        <div class="flex flex-col items-center space-y-6">

            {{-- Principal --}}
            @php
                $principal = $teachers->where('position', 'Principal')->first();
            @endphp
            @if($principal)
            <div class="flex flex-col items-center bg-gradient-to-br from-indigo-100 to-purple-100 p-6 rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:scale-105">
                <img src="{{ $principal->photo ? asset('storage/'.$principal->photo) : asset('images/photo-placeholder.png') }}"
                     class="w-28 h-28 rounded-full mb-2 object-cover border-4 border-indigo-500">
                <h3 class="text-lg font-bold text-center">{{ $principal->first_name }} {{ $principal->last_name }}</h3>
                <p class="text-sm text-indigo-600 text-center">{{ $principal->position }}</p>
            </div>
            @endif

            {{-- Vice Principals / Heads --}}
            @php
                $heads = $teachers->whereIn('position', ['Vice Principal', 'Department Head']);
            @endphp
            @if($heads->count())
            <div class="flex flex-wrap justify-center gap-6 mt-4">
                @foreach($heads as $head)
                <div class="flex flex-col items-center bg-white/90 backdrop-blur-sm rounded-2xl p-4 shadow hover:shadow-lg transition transform hover:scale-105 w-40">
                    <img src="{{ $head->photo ? asset('storage/'.$head->photo) : asset('images/photo-placeholder.png') }}"
                         class="w-20 h-20 rounded-full mb-2 object-cover border-2 border-indigo-300">
                    <h3 class="text-sm font-bold text-center">{{ $head->first_name }} {{ $head->last_name }}</h3>
                    <p class="text-xs text-indigo-600 text-center">{{ $head->position }}</p>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Teachers --}}
            @php
                $teachersList = $teachers->whereNotIn('position', ['Principal','Vice Principal','Department Head'])->sortByDesc('years_experience');
            @endphp
            @if($teachersList->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-6">
                @foreach($teachersList as $teacher)
                <div class="flex flex-col items-center bg-white/90 backdrop-blur-sm rounded-2xl p-4 shadow hover:shadow-lg transition transform hover:scale-105">
                    <img src="{{ $teacher->photo ? asset('storage/'.$teacher->photo) : asset('images/photo-placeholder.png') }}"
                         class="w-20 h-20 rounded-full mb-2 object-cover">
                    <h3 class="text-sm font-bold text-center">{{ $teacher->first_name }} {{ $teacher->middle_name }} {{ $teacher->last_name }} {{ $teacher->suffix }}</h3>
                    <p class="text-xs text-gray-500 text-center">{{ $teacher->position ?? 'Teacher' }}</p>
                    @if($teacher->advisorySection)
                    <p class="text-xs text-indigo-600 text-center mt-1">
                        Adviser • Grade {{ $teacher->advisorySection->year_level }} - {{ $teacher->advisorySection->name }}
                    </p>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

        </div>
        @endif

        <!-- Footer -->
        <div class="text-center text-xs text-gray-400 mt-8">
            © {{ date('Y') }} Tugawe ES • All Rights Reserved       
        </div>  

    </div>
</div>


<!-- Scripts -->
<script>
const btn = document.getElementById('hamburgerBtn');
const dropdown = document.getElementById('hamburgerDropdown');

btn.addEventListener('click', () => dropdown.classList.toggle('hidden'));

window.addEventListener('click', (e) => {
    if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.classList.add('hidden');
    }
});

function togglePassword() {
    const password = document.getElementById('password');
    password.type = password.type === 'password' ? 'text' : 'password';
}

function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}

function outsideClose(event, id) {
    if (event.target.id === id) {
        closeModal(id);
    }
}


// Login form submission with loading state
document.getElementById('loginForm').addEventListener('submit', function () {
    const btn = document.getElementById('loginBtn');
    const text = document.getElementById('loginText');
    const spinner = document.getElementById('loginSpinner');

    // Disable button
    btn.disabled = true;
    btn.classList.add('opacity-70', 'cursor-not-allowed');

    // Change text
    text.textContent = "Signing in...";

    // Show spinner
    spinner.classList.remove('hidden');
});

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: "{{ session('success') }}",
    confirmButtonColor: '#4f46e5',
    background: '#eef2ff',
    color: '#1e1b4b'
});
</script>
@endif

</body>
</html>
>>>>>>> 613e1229c52f180efb9f6039d1dc4243eba34df1
>>>>>>> 7945d1551f9510fadfced8469c757ebd7da4a99a
