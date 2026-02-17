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


    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

   
    public function yearLevel()
{
    return $this->belongsTo(YearLevel::class, 'year_level');
}

public function students()
{
    return $this->hasMany(Student::class);
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
public function schoolYear()
{
    return $this->belongsTo(\App\Models\SchoolYear::class);
}


}
