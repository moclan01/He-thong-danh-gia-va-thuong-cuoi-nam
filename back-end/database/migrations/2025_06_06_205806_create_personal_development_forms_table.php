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
        Schema::create('personal_development_forms', function (Blueprint $table) {
            $table->id('personal_development_form_id');
            $table->unsignedBigInteger('evaluation_cycle_id')->nullable();
            $table->foreign('evaluation_cycle_id')
                ->references('evaluation_cycle_id')
                ->on('evaluation_cycles')
                ->onDelete('set null');
            $table->string('form_name');
            $table->float('total_weighting')->nullable();
            $table->integer('total_score')->nullable();
            $table->string('status')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_development_forms');
    }
};
