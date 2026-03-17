<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentHealthRecord;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentHealthController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'school_year_id' => 'required|exists:school_years,id',
            'weight' => 'required|numeric|min:0|max:200',
            'height' => 'required|numeric|min:0|max:300',
            'bmi' => 'nullable|numeric',
            'nutritional_status' => 'required|in:Severely Underweight,Underweight,Normal,Overweight,Obese',
            'hfa_status' => 'nullable|in:Severely Stunted,Stunted,Normal,Tall',
            'remarks' => 'nullable|string|max:1000',
        ]);

        // Calculate BMI if not provided
        if (empty($validated['bmi']) && $validated['height'] > 0) {
            $heightM = $validated['height'] / 100;
            $validated['bmi'] = round($validated['weight'] / ($heightM * $heightM), 2);
        }

        StudentHealthRecord::create($validated);

        return redirect()->back()->with('success', 'Health record added successfully.');
    }

    public function update(Request $request, StudentHealthRecord $healthRecord)
    {
        // Authorization check
        if ($healthRecord->student_id != $request->student_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'weight' => 'required|numeric|min:0|max:200',
            'height' => 'required|numeric|min:0|max:300',
            'bmi' => 'nullable|numeric',
            'nutritional_status' => 'required|in:Severely Underweight,Underweight,Normal,Overweight,Obese',
            'hfa_status' => 'nullable|in:Severely Stunted,Stunted,Normal,Tall',
            'remarks' => 'nullable|string|max:1000',
        ]);

        // Recalculate BMI
        if ($validated['height'] > 0) {
            $heightM = $validated['height'] / 100;
            $validated['bmi'] = round($validated['weight'] / ($heightM * $heightM), 2);
        }

        $healthRecord->update($validated);

        return redirect()->back()->with('success', 'Health record updated successfully.');
    }

    public function destroy(StudentHealthRecord $healthRecord)
    {
        $healthRecord->delete();
        return redirect()->back()->with('success', 'Health record deleted successfully.');
    }
}