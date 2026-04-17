<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $guarded = [];

    // 1 Công ty có NHIỀU Công việc (1:N)
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    // 1 Công ty có NHIỀU Nhà tuyển dụng (1:N)
    public function employers()
    {
        return $this->hasMany(User::class, 'company_id', 'id');
    }
}