<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;

class SchoolFormController extends Controller
{
    public function sf9(Student $student)
    {
        return view('admin.forms.sf9', compact('student'));
    }


    public function downloadSf9(Student $student)
    {
        $pdf = Pdf::loadView('admin.forms.sf9-pdf', compact('student'));
        return $pdf->download('SF9_'.$student->last_name.'.pdf');
    }


    public function sf10(Student $student)
    {
        return view('admin.forms.sf10', compact('student'));
    }
    public function downloadSf10(Student $student)
{
    $pdf = Pdf::loadView('admin.forms.sf10', compact('student'));
    return $pdf->download("SF10_{$student->last_name}.pdf");
}


}

