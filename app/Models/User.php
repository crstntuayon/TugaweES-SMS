<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use App\Models\Student;
use Illuminate\Contracts\Auth\MustVerifyEmail;



class User extends Authenticatable implements MustVerifyEmail

{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
    'lrn',
    'first_name',
    'middle_name',
    'last_name',
    'suffix',
    'birthday',
    'username',
    'email',
    'password',
    'role_id',
  


];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
{
    return $this->belongsTo(Role::class);
}

public function student()
{
    return $this->hasOne(Student::class);
}

 public function sections()
    {
        return $this->hasMany(Section::class, 'teacher_id');
    }

public function teacher()
{
    return $this->hasOne(\App\Models\Teacher::class);
}
public function announcements()
{
    return $this->hasMany(Announcement::class);
}

}