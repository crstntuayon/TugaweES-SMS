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
        'section_id', 'lrn', 'address', 'photo', 'school_id'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

  // THIS IS THE RELATIONSHIP YOU NEED
    public function sections()
    {
        return $this->belongsToMany(Section::class, 'enrollments');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teacher()
{
    return $this->belongsTo(Teacher::class);
}

}
