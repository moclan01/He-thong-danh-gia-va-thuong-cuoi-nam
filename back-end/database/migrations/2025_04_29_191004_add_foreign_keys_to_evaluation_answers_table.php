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
        Schema::table('evaluation_answers', function (Blueprint $table) {
            $table->foreign('code')
                  ->references('code')
                  ->on('employees')
                  ->onDelete('cascade');

            $table->foreign('criteria_form_id')
                  ->references('criteria_form_id')
                  ->on('criteria_form')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluation_answers', function (Blueprint $table) {
            // Xóa các ràng buộc khóa ngoại khi rollback
            $table->dropForeign(['code']);
            $table->dropForeign(['criteria_form_id']);
        });
    }
};
