<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCoreValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'school_year_id',
        'core_value',
        'behavior_statement',
        'quarter',
        'mark',
    ];

    /**
     * Student relationship
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * School year relationship
     */
    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }
}