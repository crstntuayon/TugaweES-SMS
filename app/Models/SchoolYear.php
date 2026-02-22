<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Enrollment;

class SchoolYear extends Model
{
    protected $fillable = ['name', 'is_active'];

    // Scope to get the active school year
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Make it easy to switch active year
    public static function setActive($id)
    {
        // Set all others to false
        self::query()->update(['is_active' => false]);

        // Set the chosen one to true
        self::find($id)->update(['is_active' => true]);
    }

    // Access students THROUGH enrollments
    public function students()
    {
        return $this->hasManyThrough(
            Student::class,
            Enrollment::class,
            'school_year_id', // Foreign key on enrollments table
            'id',             // Foreign key on students table
            'id',             // Local key on school_years
            'student_id'      // Local key on enrollments
        );
    }

public function enrollments()
{
    return $this->hasMany(Enrollment::class);
}
}

