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
        Schema::table('job_postings', function (Blueprint $table) {
            $table->string('degree')->nullable()->after('experience'); // Bằng cấp
            $table->string('level')->nullable()->after('degree'); // Cấp bậc
            $table->integer('quantity')->default(1)->after('level'); // Số lượng
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_postings', function (Blueprint $table) {
            $table->dropColumn(['degree', 'level', 'quantity']);
        });
    }
};
