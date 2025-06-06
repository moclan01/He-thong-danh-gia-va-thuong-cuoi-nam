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
        Schema::table('hform_items', function (Blueprint $table) {
            $table->unsignedBigInteger('how_form_id')->nullable()->after('hform_item_id');

            $table->foreign('how_form_id')
                  ->references('how_form_id')
                  ->on('how_forms')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hform_items', function (Blueprint $table) {
            $table->dropForeign(['how_form_id']);
            $table->dropColumn('how_form_id');
        });
    }
};
