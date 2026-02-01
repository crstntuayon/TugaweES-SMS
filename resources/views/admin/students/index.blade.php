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
                <!-- SEARCH -->
                <div class="relative w-full md:w-64">
                    <input type="text" id="searchInput"
                           placeholder="Search..."
                           class="w-full px-4 py-2.5 rounded-xl shadow-md border border-gray-200
                                  focus:outline-none focus:ring-2 focus:ring-indigo-400
                                  focus:border-indigo-400 transition">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">🔍</span>
                </div>

                <!-- ADD STUDENT BUTTON -->
                <button onclick="openAddStudentModal()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold
                               px-5 py-2.5 rounded-xl shadow-lg hover:scale-105 transition
                               whitespace-nowrap">
                    + Add Student
                </button>
            </div>
        </div>
    </header>

    @if(session('success'))
<div id="successAlert"
     class="flex items-center justify-between gap-4
            bg-green-100 border border-green-300 text-green-800
            px-6 py-4 rounded-xl shadow-lg transition-all duration-500">

    <div class="flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-6 w-6 text-green-600"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 13l4 4L19 7"/>
        </svg>
        <span class="font-semibold">
            {{ session('success') }}
        </span>
    </div>

    <button onclick="closeSuccessAlert()"
            class="text-green-700 hover:text-red-500 text-xl font-bold">
        ✕
    </button>
</div>
@endif
<script>

function closeSuccessAlert(){
    const alert = document.getElementById('successAlert');
    if(alert){
        alert.classList.add('opacity-0');
        setTimeout(() => alert.remove(), 500);
    }
}

// auto-hide after 5 seconds
setTimeout(() => {
    closeSuccessAlert();
}, 5000);


</script>

    <!-- STUDENT CARDS GROUPED BY SECTION + YEAR -->
    @php
        $groupedStudents = $students->groupBy(function($student) {
            return ($student->section->year_level ?? 'N/A') . ' - ' . ($student->section->name ?? 'Not Assigned');
        });
        $colors = ['green','blue','indigo','purple','pink','yellow','red','teal'];
    @endphp

    @forelse($groupedStudents as $groupName => $groupStudents)
        <div class="mb-8">
            <!-- GROUP HEADER -->
            @php $headerColor = $colors[crc32($groupName) % count($colors)]; @endphp
            <h2 class="sticky top-0 bg-{{ $headerColor }}-200 text-{{ $headerColor }}-800 font-bold px-4 py-2 rounded-lg shadow-sm mb-4 z-10">
                Section: {{ $groupName }}
            </h2>

            <!-- CARDS GRID -->
            <div  id="studentsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($groupStudents as $student)
                    @php
                        $initials = strtoupper(substr($student->first_name,0,1) . substr($student->last_name,0,1));
                        $sectionName = $student->section->name ?? 'Not Assigned';
                        $yearLevel = $student->section->year_level ?? 'N/A';
                        $index = crc32($yearLevel) % count($colors);
                        $color = $colors[$index];
                    @endphp

                    <div class="student-card group bg-white rounded-3xl p-6 shadow-lg border border-gray-100
                                transition-all duration-300 hover:-translate-y-1
                                hover:shadow-2xl hover:border-indigo-200">

                        <!-- HEADER -->
                        <div class="flex justify-between items-start mb-5">
                          <!-- AVATAR + NAME -->
<div class="flex items-center gap-4">
    <!-- PROFILE PHOTO -->
    <div class="w-16 h-16 rounded-full
                overflow-hidden
                shadow-inner
                transition group-hover:scale-105">
        <img src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/photo-placeholder.png') }}"
             alt="{{ $student->first_name }} {{ $student->last_name }}"
             class="w-full h-full object-cover">
    </div>

                                <div>
                                    <h2 class="text-lg font-bold text-gray-800 leading-tight">
                                        {{ $student->first_name }} {{ $student->last_name }}
                                    </h2>
                                    <p class="text-xs text-gray-500 mt-1">
                                        LRN: {{ $student->lrn }}
                                    </p>
                                </div>
                            </div>

                            <!-- ACTIONS -->
                            <div class="flex gap-3 opacity-0 group-hover:opacity-100 transition">
            <button
     type="button"
    onclick="openEditStudentModal(this)"
    data-id="{{ $student->id }}"
    data-first="{{ $student->first_name }}"
    data-middle="{{ $student->middle_name ?? '' }}"
    data-last="{{ $student->last_name }}"
    data-suffix="{{ $student->suffix ?? '' }}"
    data-birthday="{{ $student->birthday }}"
    data-email="{{ $student->email }}"
    data-contact="{{ $student->contact_number ?? '' }}"
    data-sex="{{ $student->sex ?? '' }}"
    data-section_id="{{ $student->section_id ?? '' }}"

    
    class="text-yellow-500 hover:text-yellow-700 transition transform hover:scale-110"
>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M11 5h2m2 2l6 6-6 6-6-6 6-6zM4 21h16"/>
    </svg>
</button>



                                <button onclick="showDeleteModal({{ $student->id }})"
                                        title="Delete"
                                        class="text-red-500 hover:text-red-700 hover:scale-110 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- INFO BADGES -->
                        <div class="space-y-2 text-sm">
                            @if($student->email)
                                <span class="flex items-center gap-2 px-3 py-1.5 rounded-full
                                             bg-indigo-50 text-indigo-700 font-medium">
                                    📧 {{ $student->email }}
                                </span>
                            @endif

                            @if($student->contact_number)
                                <span class="flex items-center gap-2 px-3 py-1.5 rounded-full
                                             bg-green-50 text-green-700 font-medium">
                                    📞 {{ $student->contact_number }}
                                </span>
                            @endif

                            @if($student->sex)
                                <span class="flex items-center gap-2 px-3 py-1.5 rounded-full
                                             bg-purple-50 text-purple-700 font-medium">
                                    ⚥ {{ ucfirst($student->sex) }}
                                </span>
                            @endif

                            @if($student->birthday)
                                <span class="flex items-center gap-2 px-3 py-1.5 rounded-full
                                             bg-pink-50 text-pink-700 font-medium">
                                    🎂 {{ \Carbon\Carbon::parse($student->birthday)->format('F d, Y') }}
                                </span>
                            @endif

                            @if($student->address)
                                <span class="flex items-center gap-2 px-3 py-1.5 rounded-full
                                             bg-yellow-50 text-yellow-700 font-medium">
                                    📍 {{ $student->address }}
                                </span>
                            @endif

                           <!-- SECTION PILL -->
<span class="flex items-center gap-2 px-3 py-1.5 rounded-full
             bg-{{ $color }}-100 text-{{ $color }}-800 font-semibold text-xs">
    Section: {{ $sectionName }} | Status: {{ $yearLevel }} | Year: {{ $student->section->school_year ?? 'N/A' }}
</span>

                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <p class="col-span-full text-center text-gray-500 py-10">
            No students found.
        </p>
    @endforelse

</div>

<!-- DELETE MODAL -->
<div id="deleteModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-2xl text-center">
        <h3 class="text-lg font-bold mb-4">Confirm Deletion</h3>
        <p class="mb-6 text-gray-700">
            Are you sure you want to delete this student? This action will happen in 
            <span id="deleteCountdown">5</span> seconds.
        </p>

        <div class="flex justify-center gap-4">
            <button onclick="cancelDelete()" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-lg">Cancel</button>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                    Delete Now
                </button>
            </form>
        </div>
    </div>
</div>


<!-- ADD STUDENT MODAL -->
<div id="addStudentModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl p-6 relative overflow-y-auto max-h-[90vh]">

        <!-- MODAL HEADER -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Add New Student</h2>
            <button type="button" onclick="closeAddStudentModal()"
                    class="text-gray-500 hover:text-red-500 text-2xl font-bold">
                &times;
            </button>
        </div>

        <!-- STUDENT FORM -->
      <form method="POST" 
      action="{{ route('admin.students.store') }}" 
      enctype="multipart/form-data"
      class="space-y-4">

            @csrf

            <!-- NAME FIELDS -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <input type="text" name="first_name" placeholder="First Name" required
                       value="{{ old('first_name') }}"
                       class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">

                <input type="text" name="middle_name" placeholder="Middle Name"
                       value="{{ old('middle_name') }}"
                       class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">

                <input type="text" name="last_name" placeholder="Last Name" required
                       value="{{ old('last_name') }}"
                       class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">

                <input type="text" name="suffix" placeholder="Suffix (Jr., Sr.)"
                       value="{{ old('suffix') }}"
                       class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">

                <input type="text" name="lrn" placeholder="LRN" required
                       value="{{ old('lrn') }}"
                       class="px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
            </div>

            <!-- SEX SELECT -->
            <select name="sex" required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300">
                <option value="">-- Select Sex --</option>
                <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
            </select>

            <!-- BIRTHDAY -->
            <div>
                <label class="block text-sm text-gray-600 mb-1">Birthday</label>
                <input type="date" name="birthday" required
                       value="{{ old('birthday') }}"
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-pink-400 focus:border-pink-400">
            </div>

            <!-- EMAIL -->
            <div>
                <input type="email" name="email" placeholder="Email Address" required
                       value="{{ old('email') }}"
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
            </div>

            <!-- CONTACT NUMBER -->
            <div>
                <input type="text" name="contact_number" placeholder="Contact Number"
                       value="{{ old('contact_number') }}"
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-green-400 focus:border-green-400">
            </div>

            <!-- ADDRESS -->
            <div>
                <textarea name="address" rows="2" placeholder="Home Address"
                          class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400">{{ old('address') }}</textarea>
            </div>

             <!-- PHOTO UPLOAD -->
            <div class="mb-3 mt-3">
                <label for="editPhoto" class="block text-sm font-medium text-gray-700">Profile Photo</label>
                <input type="file" name="photo" id="editPhoto" accept="image/*" class="mt-1 block w-full">
                <div class="mt-2">
                    <img id="photoPreview" src="{{ asset('images/photo-placeholder.png') }}" class="w-24 h-24 object-cover rounded-full border" alt="Photo Preview">
                </div>
            </div>


            <!-- ACTION BUTTONS -->
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeAddStudentModal()"
                        class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-lg font-medium">
                    Cancel
                </button>
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow-md font-medium">
                    Save Student
                </button>
            </div>
        </form>
    </div>
</div>

<!-- EDIT STUDENT MODAL -->
<div id="editStudentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl p-6 relative overflow-y-auto max-h-[90vh]">

        <h2 class="text-xl font-bold mb-4">Edit Student</h2>

        <!-- FORM -->
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

            <!-- BIRTHDAY -->
            <input type="date" name="birthday" id="edit_student_birthday" class="w-full mt-3 px-4 py-2 border rounded-lg" required>

            <!-- EMAIL -->
            <input type="email" name="email" id="edit_student_email" placeholder="Email Address" class="w-full mt-3 px-4 py-2 border rounded-lg" required>

            <!-- CONTACT NUMBER -->
            <input type="text" name="contact_number" id="edit_student_contact" placeholder="Contact Number" class="w-full mt-3 px-4 py-2 border rounded-lg">

            <!-- SEX -->
            <select name="sex" id="edit_student_sex" class="w-full mt-3 px-4 py-2 border rounded-lg" required>
                <option value="">Select Sex</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

            <!-- SECTION -->
            <select name="section_id" id="edit_student_section" class="w-full mt-3 px-4 py-2 border rounded-lg" required>
                <option value="">-- Select Section --</option>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}">
                        {{ $section->year_level }} - {{ $section->name }} ({{ $section->school_year }})
                    </option>
                @endforeach
            </select>

            <!-- PHOTO UPLOAD -->
            <div class="mb-3 mt-3">
                <label for="editPhoto" class="block text-sm font-medium text-gray-700">Profile Photo</label>
                <input type="file" name="photo" id="editPhoto" accept="image/*" class="mt-1 block w-full">
                <div class="mt-2">
                    <img id="photoPreview" src="{{ asset('images/photo-placeholder.png') }}" class="w-24 h-24 object-cover rounded-full border" alt="Photo Preview">
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="flex justify-end gap-3 mt-4">
                <button type="button" onclick="closeEditStudentModal()" class="bg-gray-300 px-4 py-2 rounded-lg">Cancel</button>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg">Update</button>
            </div>
        </form>

        <button onclick="closeEditStudentModal()" class="absolute top-3 right-3 text-xl">✕</button>
    </div>
</div>

<!-- JS: Populate modal + Live preview -->
<script>
function openEditStudentModal(button) {
    const studentId = button.dataset.id;
    const first = button.dataset.first;
    const middle = button.dataset.middle ?? '';
    const last = button.dataset.last;
    const suffix = button.dataset.suffix ?? '';
    const birthday = button.dataset.birthday;
    const email = button.dataset.email;
    const contact = button.dataset.contact ?? '';
    const sex = button.dataset.sex ?? '';
    const sectionId = button.dataset.section_id ?? '';
    const photo = button.dataset.photo ?? null;

    // Fill form
    document.getElementById('editStudentForm').action = `/students/${studentId}`;
    document.getElementById('edit_student_first').value = first;
    document.getElementById('edit_student_middle').value = middle;
    document.getElementById('edit_student_last').value = last;
    document.getElementById('edit_student_suffix').value = suffix;
    document.getElementById('edit_student_birthday').value = birthday;
    document.getElementById('edit_student_email').value = email;
    document.getElementById('edit_student_contact').value = contact;
    document.getElementById('edit_student_sex').value = sex;
    document.getElementById('edit_student_section').value = sectionId;

    // Show existing photo or placeholder
    document.getElementById('photoPreview').src = photo 
        ? `{{ asset('storage') }}/${photo}`
        : '{{ asset("images/photo-placeholder.png") }}';

    // Show modal
    document.getElementById('editStudentModal').classList.remove('hidden');
}

function closeEditStudentModal() {
    document.getElementById('editStudentModal').classList.add('hidden');
}

// Live preview for newly selected photo
document.getElementById('editPhoto').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('photoPreview').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>


<script>
    let deleteTimeout;

    function showDeleteModal(studentId) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const countdownEl = document.getElementById('deleteCountdown');

        form.action = `/admin/students/${studentId}`;
        let counter = 5;
        countdownEl.textContent = counter;
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        deleteTimeout = setInterval(() => {
            counter--;
            countdownEl.textContent = counter;
            if(counter <= 0){
                clearInterval(deleteTimeout);
                form.submit();
            }
        }, 1000);
    }

    function cancelDelete() {
        clearInterval(deleteTimeout);
        document.getElementById('deleteModal').classList.add('hidden');
    }

    // Live search
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const value = this.value.toLowerCase();
        document.querySelectorAll('.student-card').forEach(card => {
            card.style.display = card.innerText.toLowerCase().includes(value) ? 'block' : 'none';
        });
    });

    // ADD STUDENT MODAL
    function openAddStudentModal() {
        document.getElementById('addStudentModal').classList.remove('hidden');
        document.getElementById('addStudentModal').classList.add('flex');
    }
    function closeAddStudentModal() {
        document.getElementById('addStudentModal').classList.add('hidden');
    }


    // EDIT STUDENT MODAL function
  function openEditStudentModal(el) {
    const modal = document.getElementById('editStudentModal');
    const form = document.getElementById('editStudentForm');

    // Set correct PUT route for the student
    form.action = `{{ url('admin/students') }}/${el.dataset.id}`;

    // Populate fields
    document.getElementById('edit_student_first').value = el.dataset.first;
    document.getElementById('edit_student_middle').value = el.dataset.middle || '';
    document.getElementById('edit_student_last').value = el.dataset.last;
    document.getElementById('edit_student_suffix').value = el.dataset.suffix || '';
    document.getElementById('edit_student_birthday').value = el.dataset.birthday || '';
    document.getElementById('edit_student_email').value = el.dataset.email;
    document.getElementById('edit_student_contact').value = el.dataset.contact || '';
    document.getElementById('edit_student_sex').value = el.dataset.sex || '';
    document.getElementById('edit_student_section').value = el.dataset.section_id || '';

    // Show modal
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeEditStudentModal() {
    const modal = document.getElementById('editStudentModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}


const editPhotoInput = document.getElementById('editPhoto');
const photoPreview = document.getElementById('photoPreview');

editPhotoInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            photoPreview.src = e.target.result;
        }
        reader.readAsDataURL(file);
    } else {
        photoPreview.src = '{{ asset("images/photo-placeholder.png") }}';
    }
});
</script>


<script>
const editPhotoInput = document.getElementById('editPhoto');
const photoPreview = document.getElementById('photoPreview');

editPhotoInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            photoPreview.src = e.target.result;
        }
        reader.readAsDataURL(file);
    } else {
        photoPreview.src = '{{ asset("images/photo-placeholder.png") }}';
    }
});
</script>


</body>
</html>
