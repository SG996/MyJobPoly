<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MiniTaskApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'mini_task_id', 'user_id', 'cover_letter', 'ai_summary', 'proposed_budget', 'cv_file',
        'status', 'progress_percentage', 'progress_notes', 'completed_at',
        'payment_amount', 'payment_proof', 'payment_note', 'paid_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'paid_at'      => 'datetime',
    ];

    public function miniTask()
    {
        return $this->belongsTo(MiniTask::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusLabel(): string
    {
        return match($this->status) {
            'pending'   => 'Chờ duyệt',
            'accepted'  => 'Đang thực hiện',
            'rejected'  => 'Bị từ chối',
            'completed' => 'Hoàn thành',
            default     => $this->status,
        };
    }

    public function statusColor(): string
    {
        return match($this->status) {
            'pending'   => 'warning',
            'accepted'  => 'info',
            'rejected'  => 'danger',
            'completed' => 'success',
            default     => 'secondary',
        };
    }

    public function isPaid(): bool
    {
        return $this->payment_proof !== null;
    }
}
