<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students | Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-100 to-blue-200 p-6">

<div class="max-w-7xl mx-auto space-y-6">

    <!-- HEADER -->
    <header class="sticky top-0 z-50 backdrop-blur-lg bg-white/80 shadow-md rounded-xl">
        <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-6">

            <!-- LEFT: BACK + LOGO + TITLE -->
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.dashboard') }}"
                   class="hover:bg-indigo-300 text-gray-700 px-3 py-2 rounded-lg shadow-sm transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                              d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>

                <img src="{{ asset('images/logo.jpg') }}"
                     class="h-16 w-16 rounded-full shadow-lg ring-4 ring-indigo-200"
                     alt="School Logo">

                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Student Management</h1>
                    <p class="text-sm text-gray-500">Tugawe Elementary School</p>
                </div>
            </div>

            <!-- RIGHT: SEARCH + ADD BUTTON -->
            <div class="flex items-center gap-3 w-full md:w-auto">
                <input type="text"
                       id="studentSearch"
                       placeholder="Search student..."
                       class="px-4 py-2 rounded-xl border border-gray-300 
                              focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400
                              shadow-sm w-full md:w-64">
                <button onclick="openAddStudentModal()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold
                               px-5 py-2.5 rounded-xl shadow-lg hover:scale-105 transition
                               whitespace-nowrap">
                    + Add Student
                </button>
            </div>
        </div>
    </header>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        title: 'Success!',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonText: 'OK',
        confirmButtonColor: '#6366f1'
    });
});
</script>
@endif

<!-- STUDENTS TABLE -->
<div class="overflow-x-auto bg-white rounded-2xl shadow border">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-100 uppercase text-xs text-gray-600">
            <tr>
                <th class="px-5 py-3 text-left">No.</th>
                <th class="px-5 py-3 text-left">Student</th>
                <th class="px-5 py-3 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($students->sortBy('last_name') as $student)
            <tr class="hover:bg-indigo-50 transition student-row"
                data-search="{{ strtolower($student->first_name.' '.$student->middle_name.' '.$student->last_name.' '.$student->school_id) }}">
                <td class="px-5 py-4">{{ $loop->iteration }}</td>
                <td class="px-5 py-4">
                    <div class="flex items-center gap-4">
                        <img src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/photo-placeholder.png') }}"
                             class="w-12 h-12 rounded-full object-cover shadow" alt="Photo">
                        <div>
                            <p class="font-semibold text-gray-800 leading-tight">
                                {{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name }} {{ $student->suffix }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">S-ID: {{ $student->school_id }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-4 text-center">
                    <div class="flex justify-center gap-3 relative">
                        <div class="relative inline-block text-left">
                            <button onclick="toggleFormDropdown({{ $student->id }})"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded-lg text-xs">
                                School Forms
                            </button>
                            <div id="formDropdown{{ $student->id }}"
                                 class="hidden absolute right-0 mt-2 w-36 bg-white border rounded-lg shadow-lg z-50">
                                <a href="{{ route('admin.sf9.show', $student->id) }}" class="block px-4 py-2 text-sm hover:bg-indigo-100">SF9</a>
                                <a href="{{ route('admin.sf10.show', $student->id) }}" class="block px-4 py-2 text-sm hover:bg-indigo-100">SF10</a>
                                <button onclick="openEditStudentModal(this)"
                                        data-id="{{ $student->id }}"
                                        data-first="{{ $student->first_name }}"
                                        data-middle="{{ $student->middle_name ?? '' }}"
                                        data-last="{{ $student->last_name }}"
                                        data-suffix="{{ $student->suffix ?? '' }}"
                                        data-birthday="{{ $student->birthday }}"
                                        data-email="{{ $student->email }}"
                                        data-contact="{{ $student->contact_number ?? '' }}"
                                        data-sex="{{ $student->sex ?? '' }}"
                                        data-address="{{ $student->address ?? '' }}"
                                        data-photo="{{ $student->photo ?? '' }}"
                                        class="block px-4 py-2 text-sm hover:bg-indigo-100">
                                    Update Student
                                </button>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
function toggleFormDropdown(studentId) {
    let dropdown = document.getElementById('formDropdown' + studentId);
    dropdown.classList.toggle('hidden');
}

document.addEventListener('click', function(event) {
    document.querySelectorAll('[id^="formDropdown"]').forEach(dropdown => {
        if (!dropdown.contains(event.target) &&
            !dropdown.previousElementSibling.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
});
</script>

<!-- ================= ADD STUDENT MODAL ================= -->
<div id="addStudentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl p-6 relative overflow-y-auto max-h-[90vh]">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Add New Student</h2>
            <button type="button" onclick="closeAddStudentModal()" class="text-gray-500 hover:text-red-500 text-2xl font-bold">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.students.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <input type="text" name="first_name" placeholder="First Name" required value="{{ old('first_name') }}" class="px-4 py-2 rounded-lg border">
                <input type="text" name="middle_name" placeholder="Middle Name" value="{{ old('middle_name') }}" class="px-4 py-2 rounded-lg border">
                <input type="text" name="last_name" placeholder="Last Name" required value="{{ old('last_name') }}" class="px-4 py-2 rounded-lg border">
                <input type="text" name="suffix" placeholder="Suffix (Jr., Sr.)" value="{{ old('suffix') }}" class="px-4 py-2 rounded-lg border">
                <input type="text" name="lrn" placeholder="LRN" required value="{{ old('lrn') }}" class="px-4 py-2 rounded-lg border">
            </div>
            <select name="sex" required class="w-full px-4 py-2 rounded-lg border">
                <option value="">-- Select Sex --</option>
                <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
            <input type="date" name="birthday" required value="{{ old('birthday') }}" class="w-full px-4 py-2 rounded-lg border">
            <input type="email" name="email" placeholder="Email Address" required value="{{ old('email') }}" class="w-full px-4 py-2 rounded-lg border">
            <input type="text" name="contact_number" placeholder="Contact Number" value="{{ old('contact_number') }}" class="w-full px-4 py-2 rounded-lg border">
            <select name="school_year_id" required class="w-full px-4 py-2 rounded-lg border">
                <option value="">-- Select School Year --</option>
                @foreach($schoolYears as $year)
                    <option value="{{ $year->id }}" {{ old('school_year_id') == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
                @endforeach
            </select>
            <input list="addresses" id="address" name="address" placeholder="Enter your address" value="{{ old('address') }}" class="w-full px-4 py-2 rounded-lg border">
            <datalist id="addresses">
                <option value="Bulak, Dauin, Negros Oriental">
                <option value="Libjo, Dauin, Negros Oriental">
                <option value="Lipayo, Dauin, Negros Oriental">
                <option value="Mag-aso, Dauin, Negros Oriental">
                <option value="Tugawe, Dauin, Negros Oriental">
            </datalist>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="password" name="password" placeholder="Password" required class="px-4 py-2 rounded-lg border">
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required class="px-4 py-2 rounded-lg border">
            </div>
            <div class="mb-3 mt-3">
                <label for="addPhoto" class="block text-sm font-medium text-gray-700">Profile Photo</label>
                <input type="file" name="photo" id="addPhoto" accept="image/*" class="mt-1 block w-full">
                <div class="mt-2">
                    <img id="addPhotoPreview" src="{{ asset('images/photo-placeholder.png') }}" class="w-24 h-24 object-cover rounded-full border" alt="Photo Preview">
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeAddStudentModal()" class="bg-gray-300 px-4 py-2 rounded-lg font-medium">Cancel</button>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg shadow-md font-medium">Save Student</button>
            </div>
        </form>
    </div>
</div>

<!-- ================= EDIT STUDENT MODAL ================= -->
<div id="editStudentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl p-6 relative overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-bold mb-4">Edit Student</h2>
        <form id="editStudentForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- NAME FIELDS -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="first_name" id="edit_student_first" placeholder="First Name" class="px-4 py-2 border rounded-lg" required>
                <input type="text" name="middle_name" id="edit_student_middle" placeholder="Middle Name" class="px-4 py-2 border rounded-lg">
                <input type="text" name="last_name" id="edit_student_last" placeholder="Last Name" class="px-4 py-2 border rounded-lg" required>
                <input type="text" name="suffix" id="edit_student_suffix" placeholder="Suffix" class="px-4 py-2 border rounded-lg">
            </div>

            <!-- BIRTHDAY FIELD -->
            <input type="date" name="birthday" id="edit_student_birthday" class="w-full mt-3 px-4 py-2 border rounded-lg" required>
           
           <!-- EMAIL FIELD (READONLY) -->
           <div class="relative mt-3">
    <label for="edit_student_email" class="block text-gray-700 text-sm font-medium mb-1">
        Email Address
    </label>
    <input type="email"
           name="email"
           id="edit_student_email"
           placeholder="Email Address"
           value="{{ old('email', $student->email) }}"
           readonly
           class="w-full mt-1 px-4 py-2 border rounded-lg bg-gray-100 cursor-not-allowed"
           onfocus="showEmailTooltip()">

    <!-- Tooltip -->
    <span id="emailTooltip"
          class="absolute left-2 top-full mt-1 text-xs text-white bg-gray-800 px-2 py-1 rounded opacity-0 transition-opacity duration-300 pointer-events-none">
        This field is uneditable
    </span>
</div>

<script>
function showEmailTooltip() {
    const tooltip = document.getElementById('emailTooltip');
    tooltip.classList.add('opacity-100'); // Show tooltip
    setTimeout(() => {
        tooltip.classList.remove('opacity-100'); // Hide after 2 seconds
    }, 2000);
}
</script>

       <!-- CONTACT NUMBER -->
            <input type="text" name="contact_number" id="edit_student_contact" placeholder="Contact Number" class="w-full mt-3 px-4 py-2 border rounded-lg">

       <!--SEX SELECTION-->
            <select name="sex" id="edit_student_sex" class="w-full mt-3 px-4 py-2 border rounded-lg" required>
                <option value="">Select Sex</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

        <!-- ADDRESS FIELD WITH SUGGESTIONS -->
            <div class="mt-3">
                <label for="edit_student_address" class="block text-gray-700 text-sm font-medium mb-1">Home Address</label>
                <input list="addresses_list" id="edit_student_address" name="address" placeholder="Enter your address" class="w-full px-4 py-2 rounded-lg border">
                <datalist id="addresses_list">
                    <option value="Bulak, Dauin, Negros Oriental">
                    <option value="Libjo, Dauin, Negros Oriental">
                    <option value="Lipayo, Dauin, Negros Oriental">
                    <option value="Mag-aso, Dauin, Negros Oriental">
                    <option value="Tugawe, Dauin, Negros Oriental">
                </datalist>
            </div>

            <!--EDIT PHOTO-->
            <div class="mb-3 mt-3">
                <label for="editPhoto" class="block text-sm font-medium text-gray-700">Profile Photo</label>
                <input type="file" name="photo" id="editPhoto" accept="image/*" class="mt-1 block w-full">
                <div class="mt-2">
                    <img id="photoPreview" src="{{ asset('images/photo-placeholder.png') }}" class="w-24 h-24 object-cover rounded-full border" alt="Photo Preview">
                </div>
            </div>


            <div class="flex justify-end gap-3 mt-4">
                <button type="button" onclick="closeEditStudentModal()" class="bg-gray-300 px-4 py-2 rounded-lg">Cancel</button>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg">Update</button>
            </div>
        </form>
        <button onclick="closeEditStudentModal()" class="absolute top-3 right-3 text-xl">✕</button>
    </div>
</div>

<script>
/* ------------------ MODAL FUNCTIONS ------------------ */
function openAddStudentModal() {
    document.getElementById('addStudentModal').classList.remove('hidden');
    document.getElementById('addStudentModal').classList.add('flex');
}
function closeAddStudentModal() {
    document.getElementById('addStudentModal').classList.add('hidden');
    document.getElementById('addStudentModal').classList.remove('flex');
}
function openEditStudentModal(button) {
    const modal = document.getElementById('editStudentModal');
    const form = document.getElementById('editStudentForm');
    form.action = `{{ url('admin/students') }}/${button.dataset.id}`;
    document.getElementById('edit_student_first').value = button.dataset.first;
    document.getElementById('edit_student_middle').value = button.dataset.middle || '';
    document.getElementById('edit_student_last').value = button.dataset.last;
    document.getElementById('edit_student_suffix').value = button.dataset.suffix || '';
    document.getElementById('edit_student_birthday').value = button.dataset.birthday || '';
    document.getElementById('edit_student_email').value = button.dataset.email || '';
    document.getElementById('edit_student_contact').value = button.dataset.contact || '';
    document.getElementById('edit_student_sex').value = button.dataset.sex || '';
    document.getElementById('edit_student_address').value = button.dataset.address || '';
    document.getElementById('photoPreview').src = button.dataset.photo ? `{{ asset('storage') }}/${button.dataset.photo}` : '{{ asset("images/photo-placeholder.png") }}';
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeEditStudentModal() {
    const modal = document.getElementById('editStudentModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

/* ------------------ PHOTO PREVIEW ------------------ */
document.getElementById('editPhoto').addEventListener('change', function(){
    const file = this.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = e => document.getElementById('photoPreview').src = e.target.result;
        reader.readAsDataURL(file);
    } else {
        document.getElementById('photoPreview').src = '{{ asset("images/photo-placeholder.png") }}';
    }
});
document.getElementById('addPhoto').addEventListener('change', function(){
    const file = this.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = e => document.getElementById('addPhotoPreview').src = e.target.result;
        reader.readAsDataURL(file);
    } else {
        document.getElementById('addPhotoPreview').src = '{{ asset("images/photo-placeholder.png") }}';
    }
});

/* ------------------ SEARCH FILTER ------------------ */
document.getElementById('studentSearch').addEventListener('input', function(){
    const query = this.value.toLowerCase();
    document.querySelectorAll('.student-row').forEach(row => {
        const text = row.dataset.search;
        row.style.display = text.includes(query) ? '' : 'none';
    });
});
</script>

</div>
</body>
</html>
