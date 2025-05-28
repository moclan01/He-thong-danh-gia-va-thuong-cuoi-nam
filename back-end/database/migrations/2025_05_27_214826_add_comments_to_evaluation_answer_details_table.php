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
        Schema::table('evaluation_answer_details', function (Blueprint $table) {
            $table->text('employee_comment')->nullable()->after('employee_score');
            $table->text('supervisor_comment')->nullable()->after('supervisor_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('evaluation_answer_details', function (Blueprint $table) {
            $table->dropColumn(['employee_comment', 'supervisor_comment']);
        });
    }
};
