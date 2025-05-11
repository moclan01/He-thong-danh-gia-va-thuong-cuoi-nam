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
        Schema::table('evaluation_answer_detail', function (Blueprint $table) {
            $table->float('employee_score')->nullable()->after('score');
            $table->float('manager_score')->nullable()->after('employee_score');
            $table->float('supervisor_score')->nullable()->after('manager_score');
            $table->float('director_score')->nullable()->after('supervisor_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluation_answer_detail', function (Blueprint $table) {
            $table->dropColumn([
                'employee_score',
                'manager_score',
                'supervisor_score',
                'director_score'
            ]);
        });
    }
};
