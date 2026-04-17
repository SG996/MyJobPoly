<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mini_task_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mini_task_id')->constrained('mini_tasks')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('cover_letter')->nullable();        // Giới thiệu bản thân
            $table->unsignedBigInteger('proposed_budget')->nullable(); // Đề xuất mức phí

            // Trạng thái ứng tuyển
            $table->enum('status', ['pending', 'accepted', 'rejected', 'completed'])->default('pending');

            // Tiến độ (user cập nhật)
            $table->unsignedTinyInteger('progress_percentage')->default(0); // 0-100
            $table->text('progress_notes')->nullable();
            $table->timestamp('completed_at')->nullable();

            // Thanh toán
            $table->unsignedBigInteger('payment_amount')->nullable();  // Số tiền thực tế
            $table->string('payment_proof')->nullable();               // Ảnh bill thanh toán (employer upload)
            $table->text('payment_note')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->unique(['mini_task_id', 'user_id']); // Mỗi user chỉ apply 1 lần
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mini_task_applications');
    }
};
