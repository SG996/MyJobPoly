<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
{
    Schema::create('job_postings', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug')->unique();

        // Thêm khóa ngoại liên kết với bảng companies
        $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');

        $table->string('salary');
        $table->string('location');
        $table->string('experience');
        $table->date('deadline');
        $table->text('description');
        $table->text('requirements');
        $table->text('benefits');
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->foreignId('employer_id')->constrained('users')->onDelete('cascade');
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
