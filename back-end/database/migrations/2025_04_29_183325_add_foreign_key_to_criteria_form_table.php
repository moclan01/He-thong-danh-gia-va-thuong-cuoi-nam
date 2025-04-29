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
        Schema::table('criteria_form', function (Blueprint $table) {
            $table->foreign('evaluation_cycle_id')
                ->references('evaluation_cycle_id')
                ->on('evaluation_cycles')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('criteria_form', function (Blueprint $table) {
            $table->dropForeign(['evaluation_cycle_id']);
        });
    }
};
