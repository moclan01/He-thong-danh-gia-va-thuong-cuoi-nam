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
        Schema::create('criteria_results', function (Blueprint $table) {
            $table->string('criteria_result_id')->primary();
            $table->string('employee_code');
            $table->string('criteria_form_id');
            $table->float('score');
            $table->float('score_max');
        
            $table->foreign('employee_code')->references('code')->on('employees');
            $table->foreign('criteria_form_id')->references('criteria_form_id')->on('criteria_forms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criteria_results');
    }
};
