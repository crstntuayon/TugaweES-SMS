<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentHealthRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'school_year_id',
        'weight',
        'height',
        'bmi',
        'nutritional_status',
        'hfa_status',
        'remarks'
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }
}