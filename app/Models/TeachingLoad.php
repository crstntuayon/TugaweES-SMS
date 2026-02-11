<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeachingLoad extends Model
{
    protected $fillable = [
    'teacher_id',
    'time',
    'minutes',
    'subject'
];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
