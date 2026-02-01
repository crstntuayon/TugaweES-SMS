<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile | Tugawe Elementary</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-indigo-100 via-blue-100 to-sky-100 min-h-screen p-6">

<div class="max-w-7xl mx-auto space-y-6">

   <!-- HEADER (like teacher page with logo) -->
<header class="sticky top-0 z-50 backdrop-blur-lg bg-white/80 shadow-md rounded-xl">
    <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <!-- LEFT: LOGO + BACK + TITLE -->
        <div class="flex items-center gap-4">
            <!-- Back Button -->
            <a href="{{ route('admin.dashboard') }}"
               class="hover:bg-indigo-300 text-gray-700 px-3 py-2 rounded-lg shadow-sm transition flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                          d="M15 19l-7-7 7-7"/>
                </svg>
            </a>

            <!-- Logo -->
            <img src="{{ asset('images/logo.jpg') }}"
                 class="h-16 w-16 rounded-full shadow-lg ring-4 ring-indigo-200"
                 alt="School Logo">

            <!-- Title -->
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Profile</h1>
                <p class="text-sm text-gray-500">Manage your account and personal information</p>
            </div>
        </div>

       
</header>


    <!-- MAIN CONTENT -->
    <main class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Update Profile Information -->
        <div class="bg-white/90 backdrop-blur rounded-2xl shadow-lg p-6 hover:shadow-2xl transition-all duration-300">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A9 9 0 1116.879 6.196 9 9 0 015.121 17.804zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Update Profile
            </h2>
            <div class="space-y-4">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="bg-white/90 backdrop-blur rounded-2xl shadow-lg p-6 hover:shadow-2xl transition-all duration-300">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c.828 0 1.5.672 1.5 1.5S12.828 14 12 14s-1.5-.672-1.5-1.5S11.172 11 12 11zm0 0v2m0 0V11m0 2h0"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C6.477 2 2 6.477 2 12c0 1.657.403 3.215 1.106 4.607L12 22l8.894-5.393A9.002 9.002 0 0022 12c0-5.523-4.477-10-10-10z"/>
                </svg>
                Update Password
            </h2>
            <div class="space-y-4">
                @include('profile.partials.update-password-form')
            </div>
        </div>

       <!-- Delete Account Card -->
<div class="bg-white/90 backdrop-blur rounded-2xl shadow-lg p-6 hover:shadow-2xl transition-all duration-300">
    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4"/>
        </svg>
        Delete Account
    </h2>
    <p class="text-gray-600 mb-4">
        This action is <strong>permanent</strong>. All your data will be deleted.
    </p>
    <button onclick="showDeleteAccountModal()"
            class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg shadow-md font-medium">
        Delete Account
    </button>
</div>

<!-- DELETE ACCOUNT MODAL -->
<div id="deleteAccountModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-2xl text-center">
        <h3 class="text-lg font-bold mb-4">Confirm Account Deletion</h3>
        <p class="mb-6 text-gray-700">
            Are you sure you want to delete your account? This action will happen in 
            <span id="deleteAccountCountdown">5</span> seconds.
        </p>

        <div class="flex justify-center gap-4">
            <button onclick="cancelDeleteAccount()" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-lg">
                Cancel
            </button>
            <form id="deleteAccountForm" method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                    Delete Now
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    let deleteAccountTimeout;

    function showDeleteAccountModal() {
        const modal = document.getElementById('deleteAccountModal');
        const countdownEl = document.getElementById('deleteAccountCountdown');
        let counter = 5;

        countdownEl.textContent = counter;
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        deleteAccountTimeout = setInterval(() => {
            counter--;
            countdownEl.textContent = counter;
            if (counter <= 0) {
                clearInterval(deleteAccountTimeout);
                document.getElementById('deleteAccountForm').submit();
            }
        }, 1000);
    }

    function cancelDeleteAccount() {
        clearInterval(deleteAccountTimeout);
        document.getElementById('deleteAccountModal').classList.add('hidden');
    }
</script>


    </main>

</div>

</body>
</html>
