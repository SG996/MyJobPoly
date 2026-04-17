<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_student_verified')->default(false)->after('role');
            $table->string('bank_account')->nullable()->after('is_student_verified');   // Số tài khoản ngân hàng
            $table->string('bank_name')->nullable()->after('bank_account');             // Tên ngân hàng
            $table->string('bank_qr_image')->nullable()->after('bank_name');            // Ảnh QR
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_student_verified', 'bank_account', 'bank_name', 'bank_qr_image']);
        });
    }
};
