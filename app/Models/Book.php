<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'title',
        'subject_area',
        'book_code',
        'reference_code',
        'date_issued',
        'date_returned',
        'status',
        'condition',
        'damage_details',
        'loss_code',
        'action_taken',
        'remarks',
    ];

    protected $casts = [
        'date_issued' => 'date',
        'date_returned' => 'date',
    ];

    /**
     * Get the student that owns this book record
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Scope for issued books
     */
    public function scopeIssued($query)
    {
        return $query->where('status', 'issued');
    }

    /**
     * Scope for returned books
     */
    public function scopeReturned($query)
    {
        return $query->where('status', 'returned');
    }

    /**
     * Scope for lost books
     */
    public function scopeLost($query)
    {
        return $query->where('status', 'lost');
    }
}