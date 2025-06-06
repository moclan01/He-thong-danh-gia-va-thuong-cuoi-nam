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
        Schema::create('wform_items', function (Blueprint $table) {
            $table->id('wform_item_id');

            // FK đến what_forms
            $table->unsignedBigInteger('what_form_id')->nullable();
            $table->foreign('what_form_id')
                ->references('what_form_id')
                ->on('what_forms')
                ->onDelete('set null');

            $table->unsignedBigInteger('personal_development_form_id')->nullable();
            $table->foreign('personal_development_form_id')
                ->references('personal_development_form_id')
                ->on('personal_development_forms')
                ->onDelete('set null');

            $table->string('name'); 
            $table->float('weighting')->nullable();
            $table->float('threshold')->nullable();
            $table->float('target')->nullable();
            $table->float('stretch')->nullable();
            $table->text('comments')->nullable();
            $table->float('FY_target')->nullable();
            $table->float('actual')->nullable(); 
            $table->float('score')->nullable();
            $table->float('m')->nullable();
            $table->float('n')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wform_items');
    }
};
