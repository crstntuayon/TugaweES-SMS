<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Dashboard | Student Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-green-100 to-blue-200 p-6">

    <!-- Header -->
    <header class="max-w-7xl mx-auto flex items-center justify-between mb-8">
        <div class="flex items-center space-x-4">
            <img src="{{ asset('images/logo.jpg') }}" class="h-16 w-16 rounded-full shadow" alt="School Logo">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Teacher Dashboard</h1>
               <p class="text-gray-600 mt-1">
    Welcome, {{ auth()->user()->email }}!
</p>
            </div>
        </div>

        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow transition">
            Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </header>

    <!-- Sections -->
    <main class="max-w-7xl mx-auto space-y-6">
        @if($sections->isEmpty())
            <div class="bg-white rounded-2xl shadow p-6 text-center text-gray-600">
                You are not assigned to any section yet.
            </div>
        @endif

        @foreach($sections as $section)
            <div class="bg-white rounded-2xl shadow overflow-hidden">
                <div class="bg-green-600 text-white px-6 py-4 font-semibold text-lg">
                    Section: {{ $section->name }}
                </div>

                <div class="p-6">
                    @if($section->students->isEmpty())
                        <p class="text-gray-600">No students enrolled.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 table-auto">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">#</th>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Student Name</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($section->students as $index => $student)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2">{{ $student->first_name }} {{ $student->last_name }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </main>

</body>
</html>
