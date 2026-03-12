<!DOCTYPE html>
<html>
<head>
    <title>Verify Email</title>
    @vite(['resources/css/app.css'])
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

<div class="bg-white p-8 rounded shadow text-center">
    <h2 class="text-xl font-bold mb-4">Verify Your Email</h2>

    <p class="mb-4 text-gray-600">
        Before accessing the system, please verify your email address.
    </p>

    @if (session('message'))
        <div class="text-green-600 mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            Resend Verification Email
        </button>
    </form>
</div>

</body>
</html>
