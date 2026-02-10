<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Verification</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">

    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md text-center">
        <h1 class="text-2xl font-bold text-green-600 mb-4">
            ✅ Student Verified
        </h1>

        <p class="text-gray-700 mb-2">
            <strong>Name:</strong> {{ $student->first_name }}  {{ $student->middle_name ?? 'N/A' }} {{ $student->last_name }}
        </p>

        <p class="text-gray-700 mb-2">
            <strong>School ID:</strong> {{ $student->school_id }}
        </p>

        <p class="text-gray-700 mb-2">
            <strong>Address:</strong> {{ $student->address ?? 'N/A' }}
        </p>

        
        <p class="text-gray-700 mb-2">
            <strong>Contact:</strong> {{ $student->contact_number ?? 'N/A' }}
        </p>

        <p class="text-gray-700 mb-2">
            <strong>Grade Level:</strong> {{ $student->grade_level ?? 'N/A' }}
        </p>
        
        <p class="text-gray-700 mb-2">
            <strong>Section:</strong> {{ $student->section ?? 'N/A' }}
        </p>

        <p class="text-gray-700">
            <strong>Status:</strong>
            <span class="text-green-600 font-semibold">Enrolled</span>
        </p>
    </div>

</body>
</html>
