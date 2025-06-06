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
        Schema::create('total_criteria_scores', function (Blueprint $table) {
            $table->id('total_criteria_score_id')->primary();

            $table->unsignedBigInteger('evaluation_answer_id');
            $table->unsignedBigInteger('evaluation_criteria_id');

            $table->integer('total_score_manager')->nullable();
            $table->timestamps();

            // Khóa ngoại (phải chỉ rõ cột trong bảng tham chiếu)
            $table->foreign('evaluation_answer_id')
                ->references('evaluation_answer_id')
                ->on('evaluation_answers')
                ->onDelete('cascade');

            $table->foreign('evaluation_criteria_id')
                ->references('evaluation_criteria_id')
                ->on('evaluation_criterias')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('total_criteria_scores');
    }
};
