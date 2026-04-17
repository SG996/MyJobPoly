<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mini_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('requirements')->nullable(); // Yêu cầu kỹ năng
            $table->enum('type', ['freelance', 'internship'])->default('freelance'); // freelance hoặc thực tập
            $table->unsignedBigInteger('budget_min')->default(0);
            $table->unsignedBigInteger('budget_max')->default(0);
            $table->string('location')->default('Toàn quốc');
            $table->enum('work_type', ['online', 'offline', 'hybrid'])->default('online');
            $table->enum('payment_type', ['per_project', 'per_hour', 'per_month'])->default('per_project');
            $table->unsignedInteger('max_workers')->default(1); // Số người cần tuyển
            $table->dateTime('deadline');
            $table->enum('status', ['open', 'in_progress', 'completed', 'cancelled'])->default('open');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mini_tasks');
    }
};
