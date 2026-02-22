<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Grade extends Model
{
    use HasFactory;

 protected $fillable = [
        'student_id', 'subject_id', 'year_level', 'quarter', 'grade', 'final_grade', 'components'
    ];


    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
     public function learningArea()
    {
        // Assuming grades.learning_area stores the code of the learning area
        return $this->belongsTo(LearningArea::class, 'learning_area', 'code');
    }
}

