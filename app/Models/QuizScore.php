<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'section_id',
        'quiz_title',
        'score',
        'total_score',
        'date'
    ];

    protected $casts = [
        'date' => 'date',
        'score' => 'decimal:2',
        'total_score' => 'decimal:2'
    ];

    /**
     * Student relationship
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Section relationship
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}