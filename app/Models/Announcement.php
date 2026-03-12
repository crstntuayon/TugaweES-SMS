<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'type',
        'user_id',
        'section_id',
        'is_pinned',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // User who posted it
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Target section (optional)
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
