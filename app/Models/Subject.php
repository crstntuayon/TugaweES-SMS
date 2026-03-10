<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{

    protected $fillable = ['code', 'name', 'grade_level', 'components'];

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}

