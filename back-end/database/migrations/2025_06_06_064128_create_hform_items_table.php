<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hform_items', function (Blueprint $table) {
            $table->id('hform_item_id');

            // FK đến total_criteria_scores
            $table->unsignedBigInteger('total_criteria_score_id')->nullable();
            $table->foreign('total_criteria_score_id')
                ->references('total_criteria_score_id')  
                ->on('total_criteria_scores')
                ->onDelete('set null');

            $table->string('name'); // criteria_name
            $table->float('weighting')->nullable();
            $table->float('threshold')->nullable();
            $table->float('target')->nullable();
            $table->float('stretch')->nullable();
            $table->text('comments')->nullable();
            $table->float('FY_target')->nullable();
            $table->float('actual')->nullable(); // total_score_manager
            $table->float('score')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hform_items');
    }
};
