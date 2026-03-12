<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Issue School ID | Registrar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 min-h-screen font-sans p-6">

<div class="max-w-3xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Issue School ID</h1>

   <form action="{{ route('registrar.id.generate') }}" method="POST" class="space-y-4">
    @csrf
    <select name="type" id="id_type" required>
        <option value="student">Student</option>
        <option value="teacher">Teacher</option>
    </select>

    <select name="id" id="person_id" required>
        @foreach($students as $student)
            <option value="{{ $student->id }}">Student: {{ $student->first_name }}</option>
        @endforeach
        @foreach($teachers as $teacher)
            <option value="{{ $teacher->id }}">Teacher: {{ $teacher->first_name }}</option>
        @endforeach
    </select>

    <button type="submit">Generate & Print ID</button>
</form>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const typeSelect = document.getElementById('id_type');
    const personSelect = document.getElementById('person_id');
    const generatedInput = document.getElementById('generated_id');

    function generateID() {
        const type = typeSelect.value;
        const personId = personSelect.value;
        if (!personId) return;


        const prefix = type === 'student' ? 'TES-S' : 'TES-T';

        const prefix = type === 'student' ? 'S' : 'T';

        const year = new Date().getFullYear();
        generatedInput.value = `${prefix}-${year}-${String(personId).padStart(5, '0')}`;
    }

    typeSelect.addEventListener('change', generateID);
    personSelect.addEventListener('change', generateID);
});
</script>
</body>
</html>
