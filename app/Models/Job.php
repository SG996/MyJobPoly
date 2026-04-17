<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'job_postings';

    protected $guarded = [];

    // Mối quan hệ với bảng Công ty (Đã có)
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // THÊM ĐOẠN NÀY VÀO: Mối quan hệ với bảng Danh mục
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}

?>