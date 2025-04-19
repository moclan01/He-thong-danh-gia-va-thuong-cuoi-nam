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
        Schema::create('evaluation_answer_detail', function (Blueprint $table) {
            $table->id('evaluation_answer_detail_id')->primary();
            $table->foreignId('evaluation_question_id');
            $table->foreignId('evaluation_answer_id');
            $table->integer('score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_answer_detail');
    }
};
