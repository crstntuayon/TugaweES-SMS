

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
        }
    </style>
</head>

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
                </button>
            </div>
        </div>

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

          <!-- Email Input -->
<div class="relative mb-4">
    <input type="email" name="email" required
           placeholder="Email Address"
           class="w-full px-3 py-2 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm bg-white/80 backdrop-blur-sm text-sm hover:shadow-md">
@error('email')
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
            This Student Management System was developed by <strong>TriniTech</strong>, a team of 4th-year Information Technology students (Batch 2022-2026). - Negros Oriental State University
        </p>

        <!-- Developer List -->
        <ul class="space-y-4">
            
            <li class="flex items-center gap-3">
                <div class="bg-indigo-100 text-indigo-700 w-10 h-10 flex items-center justify-center rounded-full font-semibold">E</div>
                <div>
                    <p class="font-semibold text-indigo-900">Elfseria</p>
                    <p class="text-gray-500 text-sm">Developer/Programmer</p>
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
            <button onclick="closeModal('announceModal')" 
                    class="text-gray-400 hover:text-red-500 text-xl transition transform hover:scale-110">
                ✕
            </button>
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
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-indigo-700 flex items-center gap-2">
                👩‍🏫 Faculty Organizational Structure
            </h2>
            <button onclick="closeModal('facultyModal')" 
                    class="text-gray-400 hover:text-red-500 text-xl transition transform hover:scale-110">
                ✕
            </button>
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
