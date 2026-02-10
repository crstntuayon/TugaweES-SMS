<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Print School IDs - Bulk Adaptive</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

<style>
body {
    font-family: 'Inter', sans-serif;
    background: #f3f4f6;
    padding: 1rem;
}

/* Page wrapper */
.page {
    display: flex;
    flex-wrap: wrap;
    justify-content: center; /* center horizontally */
    align-items: flex-start; /* start vertically, we can adjust per page */
    gap: 8mm;
    margin-bottom: 10mm;
    page-break-after: always;
}

/* Front + back ID row */
.id-row {
    display: flex;
    gap: 6mm;
    flex-shrink: 0;
}

/* PVC ID card (portrait) */
.id-card {
    width: 54mm;
    height: 85.6mm;
    border-radius: 3mm;
    background: white;
    overflow: hidden;
    border: 0.5mm solid #d1d5db;
    box-shadow: 0 4px 10px rgba(0,0,0,.15);
    display: flex;
    flex-direction: column;
    padding: 0.5rem;
}

/* ID photo */
.photo {
    width: 20mm;
    height: 25mm;
    object-fit: cover;
    border-radius: 2mm;
    border: 0.5mm solid #cbd5e1;
    background: #f8fafc;
}

/* Print styling */
@media print {
    body * { visibility: hidden; }
    #id-content, #id-content * { visibility: visible; }
    #id-content { 
        position: absolute; 
        top: 0; 
        left: 0; 
        width: 100%; 
        display: flex;
        flex-wrap: wrap;
        justify-content: center; /* center horizontally */
        align-items: center; /* center vertically */
    }
    .page {
        justify-content: center;
        align-items: center;
        page-break-after: always;
    }
    .no-print { display: none; }
}
</style>
</head>
<body>

@php
$roleColors = ['student' => 'bg-indigo-700'];
$cardsPerPage = 6;
@endphp

<div id="id-content">
    @foreach($students->chunk($cardsPerPage) as $studentPage)
    <div class="page">
        @foreach($studentPage as $student)
        <div class="id-row">


           <!-- FRONT -->
<div class="id-card relative overflow-hidden bg-white">

    <!-- RIGHT HALF BACKGROUND LOGO (FULL HEIGHT) -->
    <img
        src="{{ asset('images/logo.jpg') }}"
        class="absolute right-[-35%] top-1/2 -translate-y-1/2 h-[120%] opacity-[0.08] rotate-[-12deg] pointer-events-none"
        alt="School Logo Background"
    >

    <!-- HEADER -->
    <div class="h-[15mm] {{ $roleColors['student'] }} flex items-center justify-center gap-2 text-white relative z-10">
        <img src="{{ asset('images/logo.jpg') }}" class="w-10 h-10 rounded-full bg-white p-1">
        <div class="text-center leading-tight">
            <p class="text-[8px] font-bold tracking-wide">
                TUGAWE ELEMENTARY SCHOOL
            </p>
            <p class="text-[7px] opacity-90">
                Dauin District | School ID: 120231
            </p>
        </div>
    </div>

    <!-- BODY -->
    <div class="flex flex-col items-center mt-2 gap-1 relative z-10">

        <!-- PHOTO -->
        <img
            src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('images/photo-placeholder.png') }}"
            class="photo border-2 border-white shadow-md"
        >

        <!-- NAME -->
        <p class="font-bold text-[9px] uppercase text-gray-900 mt-1 text-center leading-tight">
            {{ $student->first_name }} {{ $student->middle_name ?? '' }} {{ $student->last_name }}
        </p>

        <!-- ROLE -->
        <p class="text-[13px] font-semibold text-gray-600 uppercase tracking-wide">
            STUDENT
        </p>

        <!-- DIVIDER -->
        <div class="w-10 h-[1px] bg-gray-300 my-1"></div>

        <!-- ID -->
        <p class="mt-1 text-[6px] text-center text-gray-700">
            <strong>ID No:</strong> {{ $student->school_id }}
        </p>

        <!-- QR -->
        <div class="mt-2 p-1 bg-white rounded shadow-sm">
            {!! QrCode::size(50)->generate(
                route('admin.students.verify', $student->school_id)
            ) !!}
        </div>

    </div>

    <!-- MICRO-TEXT SECURITY -->
    <p class="absolute bottom-1 left-0 right-0 text-[4px] text-gray-400 text-center tracking-widest">
        TUGAWE ELEMENTARY SCHOOL • OFFICIAL STUDENT IDENTIFICATION
    </p>

</div>

           <!-- BACK -->
<div class="id-card relative overflow-hidden bg-white">

    <!-- RIGHT HALF BACKGROUND LOGO -->
    <img
        src="{{ asset('images/logo.jpg') }}"
        class="absolute right-[-35%] top-1/2 -translate-y-1/2 h-[120%] opacity-[0.08] rotate-[-12deg] pointer-events-none"
        alt="School Logo Background"
    >

    <!-- HEADER -->
    <div class="h-[15mm] {{ $roleColors['student'] }} flex items-center justify-center text-white relative z-10">
        
        <div class="text-center leading-tight">
            <p class="text-[8px] font-bold tracking-wide">
                SCHOOL IDENTIFICATION CARD
            </p>
            <p class="text-[7px] opacity-90">
                Tugawe Elementary School
            </p>
        </div>
    </div>

    <!-- BODY -->
    <div class="px-2 py-2 text-[6.5px] text-gray-700 leading-tight flex flex-col justify-between h-full relative z-10">

        <!-- SCHOOL INFO & EMERGENCY -->
        <div class="space-y-1">
            <p><strong>School:</strong> Tugawe Elementary School</p>
            <p><strong>Address:</strong> Tugawe, Dauin, Negros Oriental</p>
            <p><strong>Contact:</strong> (035) 123-4567</p>
            <p><strong>Email:</strong> info@school.edu.ph</p>
            <hr class="my-1 border-gray-300">
            <p><strong>Emergency Contact:</strong> {{ $student->contact_number ?? 'N/A' }}</p>
            <hr class="my-1 border-gray-300">
            <p class="text-justify">
                This ID is non-transferable. If found, please return to the Registrar. Carry it at all times while on campus.
            </p>
            <p class="mt-1">
                <strong>Valid Until:</strong><br>{{ $student->created_at->addYears(4)->format('M d, Y') }}
            </p>
            
        </div>

        <!-- SIGNATURES -->
        <div class="flex justify-between mt-2">
            <div class="text-center">
                <p>____________________</p>
                <p class="text-[6px]">Registrar</p>
            </div>
            <div class="text-center">
                <p>____________________</p>
                <p class="text-[6px]">Principal</p>
            </div>
        </div>
    </div>

    <!-- MICRO-TEXT SECURITY -->
    <p class="absolute bottom-1 left-0 right-0 text-[4px] text-gray-400 text-center tracking-widest">
        TUGAWE ELEMENTARY SCHOOL • OFFICIAL STUDENT IDENTIFICATION • BACKSIDE
    </p>

</div>


        </div>
        @endforeach
    </div>
    @endforeach
</div>

<!-- ACTION BUTTONS -->
<div class="flex justify-center gap-4 mt-4 no-print">
    <a href="{{ route('admin.dashboard') }}" 
      class="hover:bg-indigo-300 text-gray-700 px-3 py-2 rounded-lg shadow-sm transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                              d="M15 19l-7-7 7-7"/>
                    </svg>
    </a>
    <button onclick="window.print()" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Print IDs</button>
    <button onclick="exportAsImage()" class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700">Export Image</button>
</div>

<script>
function exportAsImage() {
    const idContent = document.getElementById('id-content');
    html2canvas(idContent, { scale: 3, backgroundColor: null }).then(canvas => {
        canvas.toBlob(blob => {
            const link = document.createElement('a');
            link.download = 'student_IDs.png';
            link.href = URL.createObjectURL(blob);
            link.click();
        }, 'image/png');
    });
}
</script>

</body>
</html>
