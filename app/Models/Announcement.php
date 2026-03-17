<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'target_audience',
        'grade_level',
        'is_urgent',
        'type',
        'user_id',
        'section_id',
        'is_pinned',
        'author_id',
    ];

    protected $casts = [
        'is_urgent' => 'boolean',
        'is_pinned' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    // Scope for student-visible announcements
    public function scopeVisibleToStudent($query, $student)
    {
        return $query->where(function ($q) use ($student) {
            $q->where('target_audience', 'all')
              ->orWhere(function ($q2) use ($student) {
                  $q2->where('target_audience', 'grade_level')
                       ->where('grade_level', $student->grade_level);
              })
              ->orWhere(function ($q3) use ($student) {
                  $q3->where('target_audience', 'section')
                       ->where('section_id', $student->section_id);
              });
        })
        ->where('type', 'teacher') // Only teacher announcements for students
        ->orWhere(function ($q) {
            $q->where('type', 'admin')
              ->where('target_audience', 'all');
        });
    }
}