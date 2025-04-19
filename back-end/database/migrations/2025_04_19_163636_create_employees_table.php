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
        Schema::create('employees', function (Blueprint $table) {
            $table->string('code')->primary();
            $table->foreignId('plant_id')->nullable();
            $table->foreignId('department_id')->nullable();
            $table->foreignId('position_id')->nullable();
            $table->string('code_r')->nullable(); 
            $table->string('fullname');
            $table->string('division');
            $table->string('basic');
            $table->string('grade');
            $table->string('stafftype');
            $table->date('start_date');
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
