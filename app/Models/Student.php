<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    use HasFactory;
    
    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'suffix',
        'birthday', 'email', 'contact_number', 'sex',
        'section_id', 'lrn', 'address', 'photo', 'school_id', 'user_id', 'school_year_id', 'grade_level'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

  // THIS IS THE RELATIONSHIP YOU NEED
  public function sections()
{
    return $this->belongsToMany(\App\Models\Section::class, 'section_student')->withTimestamps();
}


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teacher()
{
    return $this->belongsTo(Teacher::class);
}

public function grades()
{
    return $this->hasMany(Grade::class);
}

public function attendances()
{
    return $this->hasMany(Attendance::class);
}

// Link student to school year
    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function gradesGroupedByLearningArea()
{
    return $this->grades
        ->groupBy('learning_area')
        ->map(function ($grades) {
            return [
                'q1'    => $grades->where('quarter', 1)->first()?->grade,
                'q2'    => $grades->where('quarter', 2)->first()?->grade,
                'q3'    => $grades->where('quarter', 3)->first()?->grade,
                'q4'    => $grades->where('quarter', 4)->first()?->grade,
                'final' => $grades->avg('grade'),
            ];
        });
}

}
