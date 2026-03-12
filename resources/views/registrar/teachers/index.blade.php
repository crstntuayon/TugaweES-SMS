<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teachers | Registrar Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-indigo-100 to-blue-200 min-h-screen p-6 font-sans">

    <!-- ================= HEADER ================= -->
    <header class="max-w-7xl mx-auto mb-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-1">Teachers List</h1>
            <p class="text-gray-500 text-sm md:text-base">View all registered teachers</p>
        </div>
        <a href="{{ route('registrar.dashboard') }}"
           class="text-indigo-600 hover:text-indigo-800 font-medium transition flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Dashboard
        </a>
    </header>

    <!-- ================= TABLE CARD ================= -->
    <div class="max-w-7xl mx-auto bg-white rounded-3xl shadow-2xl p-6 overflow-x-auto transition transform hover:scale-105">
        <table class="w-full table-auto border-collapse border border-gray-200">
            <thead class="bg-green-600 text-white rounded-t-3xl">
                <tr>
                    <th class="px-4 py-3 text-left font-medium">ID</th>
                    <th class="px-4 py-3 text-left font-medium">First Name</th>
                    <th class="px-4 py-3 text-left font-medium">Last Name</th>
                    <th class="px-4 py-3 text-left font-medium">Email</th>
                </tr>
            </thead>
            <tbody>
                @forelse($teachers as $teacher)
                    <tr class="border-b hover:bg-green-50 transition duration-200 cursor-pointer">
                        <td class="px-4 py-3 text-gray-700">{{ $teacher->id }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $teacher->first_name }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $teacher->last_name }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $teacher->email }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">
                            No teachers found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>
</html>
