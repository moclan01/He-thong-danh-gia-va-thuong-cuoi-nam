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
        Schema::table('evaluation_criterias', function (Blueprint $table) {
            $table->foreign('criteria_form_id')
                ->references('criteria_form_id')
                ->on('criteria_forms')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluation_criterias', function (Blueprint $table) {
            $table->dropForeign(['criteria_form_id']);
        });
    }
};
