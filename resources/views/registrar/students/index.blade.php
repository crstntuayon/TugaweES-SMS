<!DOCTYPE html>
<html lang="en" x-data="studentTable()" x-init="init()">
<head>
<meta charset="UTF-8">
<title>Students | Registrar Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gradient-to-br from-indigo-100 to-blue-200 min-h-screen p-6 font-sans">

<!-- ================= HEADER ================= -->
<header class="max-w-7xl mx-auto mb-4 flex flex-col md:flex-row items-center md:justify-between gap-6 bg-white p-4 rounded-2xl shadow-md">
    <div class="flex items-center gap-4">
        <a href="{{ route('registrar.dashboard') }}" 
           class="flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-medium transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="text-sm md:text-base"></span>
        </a>
        <img src="{{ asset('images/logo.jpg') }}" class="h-16 w-16 rounded-full shadow-lg ring-4 ring-indigo-200" alt="Logo">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Students List</h1>
            <p class="text-gray-500 text-sm md:text-base">View all enrolled students in your system</p>
        </div>
    </div>
    <div class="flex items-center gap-3 mt-3 md:mt-0">
       
                <!-- ADD STUDENT BUTTON -->
                <button onclick="openAddStudentModal()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold
                               px-5 py-2.5 rounded-xl shadow-lg hover:scale-105 transition
                               whitespace-nowrap">
                    + Add Student
                </button>
    </div>
</header>

<!-- ================= SEARCH ================= -->
<div class="max-w-7xl mx-auto mb-4">
    <input type="text" placeholder="Search students..." x-model="search" 
           class="w-full md:w-1/3 px-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-indigo-500"
    >
</div>

<!-- ================= TABLE ================= -->
<div class="max-w-7xl mx-auto bg-white rounded-3xl shadow-2xl p-6 overflow-x-auto">
    <table class="w-full table-auto border-collapse border border-gray-200 text-sm">
        <thead class="bg-indigo-600 text-white">
            <tr>
                <th class="px-4 py-3 text-left font-medium">Photo</th>
                <th class="px-4 py-3 text-left font-medium">School ID</th>
                <th class="px-4 py-3 text-left font-medium">First Name</th>
                <th class="px-4 py-3 text-left font-medium">Middle Name</th>
                <th class="px-4 py-3 text-left font-medium">Last Name</th>
                <th class="px-4 py-3 text-left font-medium">Suffix</th>
                <th class="px-4 py-3 text-left font-medium">Sex</th>
                <th class="px-4 py-3 text-left font-medium">Contact</th>
                <th class="px-4 py-3 text-left font-medium">Email</th>
                <th class="px-4 py-3 text-left font-medium">Address</th>
                <th class="px-4 py-3 text-center font-medium">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <template x-for="student in filteredStudents()" :key="student.id">
                <tr class="hover:bg-indigo-50 transition cursor-pointer">
                    <td class="px-4 py-3">
                        <div class="w-12 h-12 rounded-full overflow-hidden border border-gray-300">
                            <img :src="student.photo ? '/storage/' + student.photo : '{{ asset('images/photo-placeholder.png') }}'" 
                                 alt="Photo" class="w-full h-full object-cover">
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-700" x-text="student.school_id ?? 'N/A'"></td>
                    <td class="px-4 py-3 text-gray-700" x-text="student.first_name"></td>
                    <td class="px-4 py-3 text-gray-700" x-text="student.middle_name"></td>
                    <td class="px-4 py-3 text-gray-700" x-text="student.last_name"></td>
                    <td class="px-4 py-3 text-gray-700" x-text="student.suffix ?? 'N/A'"></td>
                    <td class="px-4 py-3 text-gray-700" x-text="student.sex"></td>
                    <td class="px-4 py-3 text-gray-700" x-text="student.contact_number"></td>
                    <td class="px-4 py-3 text-gray-700" x-text="student.email"></td>
                    <td class="px-4 py-3 text-gray-700" x-text="student.address"></td>
                    <td class="px-4 py-3 text-center flex justify-center gap-2">
                        <button type="button"
                                @click="openEditStudentModal(student)"
                                class="text-yellow-500 hover:text-yellow-700 transition transform hover:scale-110">
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
         viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M11 5h2m2 2l6 6-6 6-6-6 6-6zM4 21h16"/>
    </svg>
                        </button>
                        <button type="button" @click="openDeleteModal(student)" 
                                class="text-red-500 hover:text-red-700 hover:scale-110 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4"/>
                                    </svg>
                        </button>
                    </td>
                </tr>
            </template>
            <tr x-show="filteredStudents().length === 0">
                <td colspan="11" class="text-center py-4 text-gray-500">No students found.</td>
            </tr>
        </tbody>
    </table>
</div>

<!-- ================= EDIT MODAL ================= -->
<div id="editStudentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl p-6 relative overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-bold mb-4">Edit Student</h2>
        <form id="editStudentForm" method="POST" enctype="multipart/form-data" :action="`/registrar/students/${studentEdit.id}`">
            @csrf
            @method('PUT')
            <input type="hidden" name="student_id" x-model="studentEdit.id">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="first_name" x-model="studentEdit.first_name" placeholder="First Name" class="px-4 py-2 border rounded-lg">
                <input type="text" name="middle_name" x-model="studentEdit.middle_name" placeholder="Middle Name" class="px-4 py-2 border rounded-lg">
                <input type="text" name="last_name" x-model="studentEdit.last_name" placeholder="Last Name" class="px-4 py-2 border rounded-lg" >
                <input type="text" name="suffix" x-model="studentEdit.suffix" placeholder="Suffix" class="px-4 py-2 border rounded-lg">
            </div>

            <input type="date" name="birthday" x-model="studentEdit.birthday" class="w-full mt-3 px-4 py-2 border rounded-lg" >
            <input type="email" name="email" x-model="studentEdit.email" placeholder="Email" class="w-full mt-3 px-4 py-2 border rounded-lg">
            <input type="text" name="contact_number" x-model="studentEdit.contact_number" placeholder="Contact Number" class="w-full mt-3 px-4 py-2 border rounded-lg">
            
            <select name="sex" x-model="studentEdit.gender" class="w-full mt-3 px-4 py-2 border rounded-lg" >
                <option value="">Select Sex</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            
            <select name="section_id" x-model="studentEdit.section_id" class="w-full mt-3 px-4 py-2 border rounded-lg" >
                <option value="">-- Select Section --</option>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}">{{ $section->year_level }} - {{ $section->name }} ({{ $section->school_year }})</option>
                @endforeach
            </select>

            <div class="mb-3 mt-3">
                <label for="editPhoto" class="block text-sm font-medium text-gray-700">Profile Photo</label>
                <input type="file" name="photo" id="editPhoto" accept="image/*" class="mt-1 block w-full" @change="previewPhoto">
                <div class="mt-2">
                    <img :src="studentEdit.photo ? '/storage/' + studentEdit.photo : '{{ asset('images/photo-placeholder.png') }}'" class="w-24 h-24 object-cover rounded-full border" alt="Photo Preview">
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-4">
                <button type="button" @click="closeEditStudentModal()" class="bg-gray-300 px-4 py-2 rounded-lg">Cancel</button>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg">Update</button>
            </div>
        </form>
        <button @click="closeEditStudentModal()" class="absolute top-3 right-3 text-xl">✕</button>
    </div>
</div>

<!-- ================= DELETE MODAL ================= -->
<div id="deleteStudentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 relative text-center">
        <h2 class="text-xl font-bold mb-4">Delete Student</h2>
        <p>Are you sure you want to delete <span x-text="studentDelete.first_name"></span>?</p>
        <p x-show="countdown > 0" class="mt-2 text-red-500 font-semibold">Deleting in <span x-text="countdown"></span> seconds...</p>
        <div class="flex justify-center gap-3 mt-4">
            <button type="button" @click="closeDeleteModal()" class="bg-gray-300 px-4 py-2 rounded-lg">Cancel</button>
            <form :action="`/registrar/students/${studentDelete.id}`" method="POST" @submit.prevent="confirmDelete($event)">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded-lg">Delete</button>
            </form>
        </div>
        <button @click="closeDeleteModal()" class="absolute top-3 right-3 text-xl">✕</button>
    </div>
</div>


<<<<<<< HEAD



=======
>>>>>>> 363cc25 (when adding student it also create stud. account)
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
<<<<<<< HEAD
       <form method="POST" 
      action="{{ route('admin.students.store') }}" 
      enctype="multipart/form-data"
      class="space-y-4">

=======
        <form method="POST" action="{{ route('admin.students.store') }}" class="space-y-4">
>>>>>>> 363cc25 (when adding student it also create stud. account)
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

<<<<<<< HEAD
            <!-- SECTION + SCHOOL YEAR -->
            <div>
                <select name="section_id" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                    <option value="">-- Select Section --</option>
                    @if(isset($sections) && $sections->count())
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}"
                                {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                {{ $section->year_level }} - {{ $section->name }} ({{ $section->school_year }})
                            </option>
                        @endforeach
                    @else
                        <option value="">No sections available</option>
                    @endif
                </select>
            </div>  

              <!-- PHOTO UPLOAD -->
            <div class="mb-3 mt-3">
                <label for="editPhoto" class="block text-sm font-medium text-gray-700">Profile Photo</label>
                <input type="file" name="photo" id="editPhoto" accept="image/*" class="mt-1 block w-full">
                <div class="mt-2">
                    <img id="photoPreview" src="{{ asset('images/photo-placeholder.png') }}" class="w-24 h-24 object-cover rounded-full border" alt="Photo Preview">
                </div>
            </div>


=======
            
>>>>>>> 363cc25 (when adding student it also create stud. account)
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
<<<<<<< HEAD
<script>

    
    // STUDENT MODAL FUNCTIONS
    function openAddStudentModal() {
    const modal = document.getElementById('addStudentModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeAddStudentModal() {
    const modal = document.getElementById('addStudentModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
=======
>>>>>>> 363cc25 (when adding student it also create stud. account)

<script>
function studentTable() {
    return {
        search: '',
        students: @json($students),
        studentEdit: {},
        studentDelete: {},
        countdown: 5,
        countdownTimer: null,

        init() {},

        filteredStudents() {
            if(this.search === '') return this.students;
            return this.students.filter(s => {
                const fullName = `${s.first_name} ${s.last_name}`.toLowerCase();
                return fullName.includes(this.search.toLowerCase());
            });
        },

        openEditStudentModal(student) {
            this.studentEdit = {...student};
            document.getElementById('editStudentModal').classList.remove('hidden');
        },

        closeEditStudentModal() {
            document.getElementById('editStudentModal').classList.add('hidden');
        },

        previewPhoto(event) {
            const reader = new FileReader();
            reader.onload = e => this.studentEdit.photo = e.target.result;
            reader.readAsDataURL(event.target.files[0]);
        },

        openDeleteModal(student) {
            this.studentDelete = {...student};
            this.countdown = 5;
            document.getElementById('deleteStudentModal').classList.remove('hidden');
            this.countdownTimer = setInterval(() => {
                if(this.countdown > 1) {
                    this.countdown--;
                } else {
                    this.confirmDeleteAutomatically();
                }
            }, 1000);
        },

        closeDeleteModal() {
            clearInterval(this.countdownTimer);
            document.getElementById('deleteStudentModal').classList.add('hidden');
        },

        confirmDeleteAutomatically() {
            clearInterval(this.countdownTimer);
            // submit form programmatically
            const form = document.querySelector(`#deleteStudentModal form`);
            if(form) form.submit();
        },

        confirmDelete(e) {
            clearInterval(this.countdownTimer);
            e.target.submit();
        }
    }
}
</script>

</body>
</html>
