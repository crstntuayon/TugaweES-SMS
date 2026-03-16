<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Enrollment;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Student extends Model
{

    use HasFactory;
    
    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'suffix',
        'birthday', 'email', 'contact_number', 'sex',
        'section_id', 'lrn', 'address', 'photo', 'school_id', 'user_id', 'school_year_id', 'grade_level'
    ];


    protected $casts = [
    'date_of_birth' => 'date', // or 'birthday' => 'date' depending on your column name
    // ... other casts
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


//update march 15, 2025 -- start
  public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
      /**
     * Get count of books by status
     */
    public function booksCountByStatus(string $status): int
    {
        return $this->books()->where('status', $status)->count();
    }

    /**
     * Check if student has any pending books
     */
    public function hasPendingBooks(): bool
    {
        return $this->books()->where('status', 'issued')->exists();
    }
    // end

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

public function enrollments()
{
    return $this->hasMany(Enrollment::class);
}

// App/Models/Student.php
public function scopeGraduated($query)
{
    return $query->where('graduation_status', 'graduated');
}

public function scopeCandidate($query)
{
    return $query->where('graduation_status', 'candidate');
}

public function scopeActive($query)
{
    return $query->where('graduation_status', 'active');
}


    /**
     * Get full name attribute
     */
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * ✅ ADD THIS: Quiz scores relationship
     */
    public function quizScores()
    {
        return $this->hasMany(QuizScore::class);
    }
}
