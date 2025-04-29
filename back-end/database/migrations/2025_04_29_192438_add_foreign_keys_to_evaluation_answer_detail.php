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
        Schema::table('evaluation_answer_detail', function (Blueprint $table) {
            // Thêm ràng buộc khóa ngoại cho cột evaluation_answer_id
            $table->foreign('evaluation_answer_id')
                  ->references('evaluation_answer_id')
                  ->on('evaluation_answers')
                  ->onDelete('cascade');

            // Thêm ràng buộc khóa ngoại cho cột evaluation_question_id
            $table->foreign('evaluation_question_id')
                  ->references('evaluation_question_id')
                  ->on('evaluation_questions')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluation_answer_detail', function (Blueprint $table) {
            // Xóa các ràng buộc khóa ngoại khi rollback
            $table->dropForeign(['evaluation_answer_id']);
            $table->dropForeign(['evaluation_question_id']);
        });
    }
};
