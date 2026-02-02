<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Print School ID - Side by Side</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

<style>
body {
    background: #f3f4f6;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8mm;
    padding: 1rem;
    font-family: 'Inter', sans-serif;
}
.id-wrapper {
    display: flex;
    flex-direction: column; /* stack multiple students vertically */
    gap: 12mm;
}
/* Horizontal layout: front + back side by side */
.id-row {
    display: flex;
    gap: 6mm;
}
/* CR80 PVC Portrait: 54mm x 85.6mm */
.id-card {
    width: 54mm;
    height: 85.6mm;
    border-radius: 3mm;
    background: white;
    position: relative;
    overflow: hidden;
    border: 0.5mm solid #d1d5db;
    box-shadow: 0 4px 10px rgba(0,0,0,.15);
    padding-top: 6mm;
    display: flex;
    flex-direction: column;
}
.photo {
    width: 20mm;
    height: 25mm;
    object-fit: cover;
    border-radius: 2mm;
    border: 0.5mm solid #cbd5e1;
    background: #f8fafc;
}
@media print {
    body * { visibility: hidden; }
    #id-content, #id-content * { visibility: visible; }
    #id-content { position: absolute; top: 0; left: 0; width: 100%; }
    .no-print { display: none; }
}
</style>
</head>
<body>

@php
$roleColors = [
    'student' => 'bg-indigo-700',
    'teacher' => 'bg-emerald-700',
];
@endphp

<div id="id-content" class="id-wrapper">
@foreach($people as $person)
<div class="id-row">
  <!-- FRONT -->
<div class="id-card">
    <div class="h-[15mm] {{ $roleColors[$type] }} flex items-center justify-center gap-2 text-white">
        <img src="{{ asset('images/logo.jpg') }}" class="w-10 h-10 rounded-full bg-white p-1">
        <div class="text-center leading-tight">
            <p class="text-[8px] font-bold">TUGAWE ELEMENTARY SCHOOL</p>
            <p class="text-[7px]">Dauin District</p>
        </div>
    </div>

    <div class="flex flex-col items-center mt-2 gap-1">
        <!-- AUTO ID PHOTO -->
        <img src="{{ $person->photo 
            ? asset('storage/'.$person->photo) 
            : asset('images/photo-placeholder.png') }}" 
            class="photo">

        <p class="font-bold text-[7px] uppercase text-gray-800 mt-1">
            {{ $person->last_name }}, {{ $person->first_name }}
        </p>
        <p class="text-[6px] font-semibold text-gray-600 uppercase">{{ $type }}</p>
        <p class="mt-1 text-[6px]">
            <strong>ID No:</strong> {{ $person->school_id }}
        </p>

        <div class="mt-2">
            {!! QrCode::size(50)->generate(route('registrar.idcards.verify', $person->school_id)) !!}
        </div>
    </div>
</div>


    <!-- BACK -->
    <div class="id-card">
        <div class="h-[15mm] bg-gray-800 flex items-center justify-center text-white text-[7px] font-bold">
            SCHOOL IDENTIFICATION CARD
        </div>
        <div class="px-2 py-2 text-[6.5px] text-gray-700 leading-tight flex flex-col justify-between h-full">
            <div>
                <p><strong>School:</strong> Tugawe Elementary School</p>
                <p><strong>Address:</strong> Tugawe, Dauin, Negros Oriental</p>
                <p><strong>Contact:</strong> (035) 123-4567</p>
                <p><strong>Email:</strong> info@school.edu.ph</p>
                 <hr class="my-1">
                 <p><strong>Emergency Contact Information</strong></p>
                 <br>
                 <p><strong>Contact: </strong></p>


                 <hr class="my-1">
                <p class="text-justify">This ID is non-transferable. If found, please return to the Registrar. Carry it at all times while on campus.</p>
                <p class="mt-1"><strong>Valid Until:</strong><br>{{ $person->created_at->addYears(4)->format('M d, Y') }}</p>
            </div>
            <!-- Signatories -->
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
    </div>
</div>
@endforeach
</div>

<!-- ACTION BUTTONS -->
<div class="flex justify-center gap-4 mt-4 no-print">
    <a href="{{ route('registrar.dashboard') }}" 
   class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
    <!-- SVG Left Arrow -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
    </svg>
</a>

    <button onclick="window.print()" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Print ID</button>
    <button onclick="exportAsImage()" class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700">Export Image</button>
</div>

<script>
function exportAsImage() {
    const idContent = document.getElementById('id-content');
    html2canvas(idContent, { scale: 3, backgroundColor: null }).then(canvas => {
        canvas.toBlob(blob => {
            const link = document.createElement('a');
            link.download = '{{ $person->first_name ?? "ID" }}_ID.png';
            link.href = URL.createObjectURL(blob);
            link.click();
        }, 'image/png');
    });
}
</script>

</body>
</html>
