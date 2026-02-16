<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'name',
        'year_level',   // MUST be fillable
        'school_year',  // MUST be fillable
        'capacity',
        'teacher_id',   // if you are assigning teachers
        
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


}
