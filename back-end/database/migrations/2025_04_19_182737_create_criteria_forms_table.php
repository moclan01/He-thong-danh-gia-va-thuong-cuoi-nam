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
            $table->id('criteria_form_id')->primary();
            $table->foreignId('evaluation_cycle_id')->nullable();
            $table->string('criteria_form_name');
            $table->timestamps();

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
