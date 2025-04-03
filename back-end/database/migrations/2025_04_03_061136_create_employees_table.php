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
            $table->string('plant_id')->nullable();
            $table->string('department_id')->nullable();
            $table->string('fullname');
            $table->string('position');
            $table->date('start_date');
            $table->string('type');
            $table->boolean('eligible')->default(false);

            $table->foreign('plant_id')->references('plant_id')->on('plants')->onDelete('set null');
            $table->foreign('department_id')->references('department_id')->on('departments')->onDelete('set null');
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
