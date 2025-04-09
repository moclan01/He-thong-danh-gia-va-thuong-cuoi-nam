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
        Schema::create('criteria_forms', function (Blueprint $table) {
            $table->string('criteria_form_id')->primary();
            $table->string('cycles_id');
            $table->string('criteria_id');
        
            $table->foreign('cycles_id')->references('cycles_id')->on('evaluation_cycles');
            $table->foreign('criteria_id')->references('criteria_id')->on('evaluation_criteria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criteria_forms');
    }
};
