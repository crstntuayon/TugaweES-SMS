<?php

namespace App\Http\Controllers\Registrar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use PhpOffice\PhpWord\TemplateProcessor;


class IDCardController extends Controller
{
    // Show the ID issuance form
    public function index()
    {
        $students = Student::all();
        $teachers = Teacher::all();
        return view('registrar.idcards.index', compact('students', 'teachers'));
    }

    // Generate/assign school ID
   public function generate(Request $request)
{
    // Validate input
    $request->validate([
        'type' => 'required|in:student,teacher',
        'id' => 'required|integer',
    ]);

    $type = $request->type;
    $personId = $request->id;

    // Generate unique school ID
    $year = date('Y');
    $prefix = $type === 'student' ? 'S' : 'T';
    $schoolId = $prefix . '-' . $year . '-' . str_pad($personId, 5, '0', STR_PAD_LEFT);

    // Save ID to database
    if ($type === 'student') {
        $person = Student::findOrFail($personId);
    } else {
        $person = Teacher::findOrFail($personId);
    }

    $person->school_id = $schoolId;
    $person->save();

    // Redirect to printable page
    return redirect()->route('registrar.idcards.print', ['type' => $type, 'id' => $personId]);

}

    // Show printable ID card
    public function print($type, $id)
    {
        if ($type === 'student') {
            $person = Student::findOrFail($id);
        } else {
            $person = Teacher::findOrFail($id);
        }

        return view('registrar.idcards.print', compact('person', 'type'));
    }

   // Single ID print
    public function printSingle($type, $id)
{
    $person = $type === 'teacher' 
        ? Teacher::findOrFail($id) 
        : Student::findOrFail($id);

    // Wrap the single person into a collection
    $people = collect([$person]);

    return view('registrar.idcards.print', compact('people', 'type'));
}

    // Bulk print by class/section
    public function printBulk(Request $request)
{
    $sectionId = $request->input('section_id');
    $type = 'student';

    $people = Student::where('section_id', $sectionId)->get();

    return view('registrar.idcards.print', compact('people', 'type'));
}

    // QR verification page
    public function verify($schoolId)
    {
        $person = Student::where('school_id', $schoolId)->first()
                ?? Teacher::where('school_id', $schoolId)->first();

        if (!$person) {
            return view('registrar.idcards.verify')->with('error', 'Invalid or expired ID.');
        }

        // Check expiry
        $issuedAt = $person->created_at;
        $validUntil = $issuedAt->copy()->addYears(4);
        $expired = now()->gt($validUntil);

        return view('registrar.idcards.verify', compact('person', 'expired'));
    }

public function exportId($personId)
{
    $person = Person::find($personId); // student or teacher
    $template = new TemplateProcessor(resource_path('templates/id_template.docx'));

    $template->setValue('name', $person->first_name . ' ' . $person->last_name);
    $template->setValue('school_id', $person->school_id);
    $template->setValue('type', ucfirst($person->type));
    $template->setValue('section', $person->section->name ?? 'N/A');
    
    // For photos
    $photoPath = $person->photo ? storage_path('app/public/photos/'.$person->photo) : public_path('images/photo-placeholder.png');
    $template->setImageValue('photo', ['path' => $photoPath, 'width' => 70, 'height' => 90, 'ratio' => true]);

    $fileName = $person->first_name . '_' . $person->last_name . '_ID.docx';
    $template->saveAs(storage_path('app/public/'.$fileName));

    return response()->download(storage_path('app/public/'.$fileName));
}

}
