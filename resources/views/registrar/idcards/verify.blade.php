<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ID Verification</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex justify-center items-center h-screen bg-gray-100">

<div class="bg-white p-6 rounded-lg shadow-md text-center w-80">
@if(isset($error))
    <p class="text-red-600 font-bold">{{ $error }}</p>
@else
    <h2 class="font-bold text-lg">{{ $person->first_name }} {{ $person->last_name }}</h2>
    <p class="text-sm uppercase text-gray-700">{{ $type ?? 'Student' }}</p>
    <p class="mt-1 text-xs text-gray-600">ID No: {{ $person->school_id }}</p>
    <p class="mt-2 text-xs {{ $expired ? 'text-red-600 font-bold' : 'text-green-600 font-semibold' }}">
        {{ $expired ? 'ID EXPIRED' : 'ID VALID' }}
    </p>
@endif
</div>

</body>
</html>
