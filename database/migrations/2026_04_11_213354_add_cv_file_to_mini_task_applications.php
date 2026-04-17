<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mini_task_applications', function (Blueprint $table) {
            $table->string('cv_file')->nullable()->after('proposed_budget')
                  ->comment('Path to uploaded CV/portfolio file');
        });
    }

    public function down(): void
    {
        Schema::table('mini_task_applications', function (Blueprint $table) {
            $table->dropColumn('cv_file');
        });
    }
};
