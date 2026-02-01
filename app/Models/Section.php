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
        return $this->belongsToMany(Student::class, 'enrollments');
    }

}
