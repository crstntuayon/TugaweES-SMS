<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student | Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-100 to-blue-200 flex items-center justify-center p-6">

<div class="w-full max-w-lg bg-white rounded-2xl shadow-xl p-8 animate-fadeIn">

    <!-- Header -->
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Add New Student</h1>
        <p class="text-gray-500 mt-1">Enroll a student into a section</p>
    </div>

    <!-- Student Form -->
    <form method="POST" action="{{ route('admin.students.store') }}" class="space-y-4">
        @csrf

        <!-- NAME FIELDS -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">First Name</label>
                <input name="first_name" type="text" required
                       class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Middle Name</label>
                <input name="middle_name" type="text"
                       class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Last Name</label>
                <input name="last_name" type="text" required
                       class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Suffix</label>
                <input name="suffix" type="text" placeholder="Jr., Sr."
                       class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2">
            </div>
        </div>

        <!-- LRN -->
        <div>
            <label class="block text-sm font-medium text-gray-700">LRN (Learner Reference Number)</label>
            <input name="lrn" type="text" required
                   class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2">
        </div>

        <!-- Birthday -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Birthday</label>
            <input name="birthday" type="date" required
                   class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2">
        </div>

        <!-- Email -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input name="email" type="email" required
                   class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2">
        </div>

        <!-- Contact Number -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Contact Number</label>
            <input name="contact_number" type="text"
                   class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2">
        </div>

        <!-- Address (NEW) -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Home Address</label>
            <textarea name="address" rows="2"
                      class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2"
                      placeholder="Barangay, Municipality, Province"></textarea>
        </div>

        <!-- Section -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Select Section</label>
            <select name="section_id" required
                    class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2">
                <option value="">-- Choose Section --</option>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}">
                        {{ $section->year_level }} - {{ $section->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Submit -->
        <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-lg shadow-lg transition hover:scale-105">
            Save Student
        </button>
    </form>

    <!-- Back -->
    <a href="{{ route('admin.dashboard') }}"
       class="mt-6 inline-block text-indigo-600 hover:underline font-medium">
        &larr; Back to Dashboard
    </a>
</div>

<style>
    .animate-fadeIn {
        animation: fadeIn 0.8s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

</body>
</html>
