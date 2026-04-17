<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('companies', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('address');
        $table->string('tax_code')->unique(); // Mã số thuế
        $table->string('email')->unique();
        $table->string('hotline');
        $table->string('logo')->nullable();   // Chuyển logo từ bảng Job sang đây
        $table->text('description')->nullable(); // Giới thiệu công ty
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
