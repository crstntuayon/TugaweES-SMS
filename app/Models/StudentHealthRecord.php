<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentHealthRecord extends Model
{
    use HasFactory;

    // Specify the exact table name
    protected $table = 'student_health_records';

    protected $fillable = [
        'student_id',
        'school_year_id',
        'weight',
        'height',
        'bmi',
        'nutritional_status',
        'hfa_status',
        'remarks',
    ];

    protected $casts = [
        'weight' => 'float',
        'height' => 'float',
        'bmi' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the student that owns this health record.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the school year for this health record.
     */
    public function schoolYear(): BelongsTo
    {
        return $this->belongsTo(SchoolYear::class);
    }
}