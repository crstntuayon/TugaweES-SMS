<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sections | Registrar Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-100 to-blue-200 min-h-screen p-6">

    <header class="max-w-7xl mx-auto mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Sections List</h1>
        <a href="{{ route('registrar.dashboard') }}" class="text-indigo-600 hover:underline">&larr; Back to Dashboard</a>
    </header>

    <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow p-6">
        <table class="w-full table-auto border border-gray-200 rounded-lg">
            <thead class="bg-yellow-500 text-white">
                <tr>
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Section Name</th>
                    <th class="px-4 py-2 text-left">Year Level</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sections as $section)
                    <tr class="border-b hover:bg-yellow-50">
                        <td class="px-4 py-2">{{ $section->id }}</td>
                        <td class="px-4 py-2">{{ $section->name }}</td>
                        <td class="px-4 py-2">{{ $section->year_level }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
