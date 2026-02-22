<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'teacher_id',
        'year_level',
        'school_year_id',
        'capacity',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function yearLevel()
    {
        return $this->belongsTo(YearLevel::class, 'year_level');
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Access students THROUGH enrollments
    public function students()
    {
        return $this->hasManyThrough(
            Student::class,
            Enrollment::class,
            'section_id',  // Foreign key on enrollments
            'id',          // Foreign key on students
            'id',          // Local key on sections
            'student_id'   // Local key on enrollments
        );
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function isFull($schoolYearId)
{
    return $this->enrollments()
        ->where('school_year_id', $schoolYearId)
        ->count() >= $this->capacity;
} 
}