<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'is_approved',
        'company_id', 'title', 'phone', 'gender', 'dob', 'address', 'bio',
        'is_student_verified', 'bank_account', 'bank_name', 'bank_account_name', 'bank_qr_image', 'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // === Relationships ===

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function jobPostings()
    {
        return $this->hasMany(Job::class, 'employer_id');
    }

    public function miniTasks()
    {
        return $this->hasMany(MiniTask::class, 'employer_id');
    }

    public function miniTaskApplications()
    {
        return $this->hasMany(MiniTaskApplication::class);
    }

    public function verification()
    {
        return $this->hasOne(UserVerification::class);
    }

    // === Helpers ===

    public function isAdmin(): bool
    {
        return $this->role == 1;
    }

    public function isEmployer(): bool
    {
        return $this->role == 2;
    }

    public function isCandidate(): bool
    {
        return $this->role == 0;
    }
}
