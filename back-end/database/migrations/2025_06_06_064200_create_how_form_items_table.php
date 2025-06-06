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
        Schema::create('how_form_items', function (Blueprint $table) {
            $table->id('how_form_items_id');

            $table->unsignedBigInteger('how_form_id');
            $table->unsignedBigInteger('hform_item_id');

            $table->foreign('how_form_id')
                  ->references('how_form_id')
                  ->on('how_forms')
                  ->onDelete('cascade');

            $table->foreign('hform_item_id')
                  ->references('hform_item_id')
                  ->on('hform_items') 
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('how_form_items');
    }
};
