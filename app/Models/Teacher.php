<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use App\Models\User;


class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'birthday',
        'email',
        'contact_number',
        'employee_id',
        'position',
        'date_hired',
        'photo',
        'advisory_section_id',

    'years_experience',
    'grade_experience',
    'male_enrollment',
    'female_enrollment',
    'prepared_by',
    'conforme',
    'approved_by'

        ];


    public function students()
{
    return $this->hasMany(Student::class);
}

 public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function advisorySection()
    {
        return $this->belongsTo(Section::class, 'advisory_section_id');
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class);
    }

    // Add this:
    public function teachingLoad()
    {
        return $this->hasMany(TeachingLoad::class); // Make sure TeachingLoad model exists
    }

}
