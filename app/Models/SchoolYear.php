<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function students()
{
    return $this->hasMany(Student::class);
}

}

