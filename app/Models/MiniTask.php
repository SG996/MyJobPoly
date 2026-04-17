<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MiniTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id', 'title', 'slug', 'description', 'requirements',
        'type', 'budget_min', 'budget_max', 'location',
        'work_type', 'payment_type', 'max_workers', 'deadline',
        'status', 'is_active',
    ];

    protected $casts = [
        'deadline'   => 'datetime',
        'is_active'  => 'boolean',
        'budget_min' => 'integer',
        'budget_max' => 'integer',
    ];

    // Relationships
    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function applications()
    {
        return $this->hasMany(MiniTaskApplication::class);
    }

    public function acceptedApplications()
    {
        return $this->hasMany(MiniTaskApplication::class)->where('status', 'accepted');
    }

    public function completedApplications()
    {
        return $this->hasMany(MiniTaskApplication::class)->where('status', 'completed');
    }

    // Helper
    public function isInternship(): bool
    {
        return $this->type === 'internship';
    }

    public function requiresStudentVerification(): bool
    {
        return $this->type === 'internship';
    }

    public function isFull(): bool
    {
        return $this->acceptedApplications()->count() >= $this->max_workers;
    }

    public function remainingSlots(): int
    {
        return max(0, $this->max_workers - $this->acceptedApplications()->count());
    }

    public function timeRemaining(): string
    {
        $now = Carbon::now();
        $dl  = Carbon::parse($this->deadline);
        if ($dl->isPast()) return 'Đã hết hạn';

        $totalDiffMinutes = $now->diffInMinutes($dl);
        $days = floor($totalDiffMinutes / 1440);
        $hours = round(($totalDiffMinutes % 1440) / 60);

        // Adjust if rounded hours reach 24
        if ($hours == 24) {
            $days++;
            $hours = 0;
        }

        if ($days > 0) {
            return $hours > 0 ? "{$days} ngày {$hours} giờ" : "{$days} ngày";
        }
        
        return $hours > 0 ? "{$hours} giờ" : "Dưới 1 giờ";
    }

    public function budgetFormatted(): string
    {
        $min = number_format($this->budget_min) . 'đ';
        $max = number_format($this->budget_max) . 'đ';
        return $this->budget_max > 0 ? "{$min} - {$max}" : $min;
    }

    public function workTypeLabel(): string
    {
        return match($this->work_type) {
            'online'  => 'Làm online',
            'offline' => 'Làm trực tiếp',
            'hybrid'  => 'Hybrid',
            default   => $this->work_type,
        };
    }

    public function paymentTypeLabel(): string
    {
        return match($this->payment_type) {
            'per_project' => 'Trả theo dự án',
            'per_hour'    => 'Trả theo giờ',
            'per_month'   => 'Trả theo tháng',
            default       => $this->payment_type,
        };
    }

    // Auto slug from title
    public static function generateUniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $base = $slug;
        $i = 1;
        while (static::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    // Scopes
    public function scopeActive($q)
    {
        return $q->where('is_active', true)->where('status', 'open')->where('deadline', '>', now());
    }
}
