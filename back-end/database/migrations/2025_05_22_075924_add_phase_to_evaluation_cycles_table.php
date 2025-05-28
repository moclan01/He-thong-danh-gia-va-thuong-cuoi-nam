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
        Schema::table('evaluation_cycles', function (Blueprint $table) {
        $table->string('phase')->default('not_started'); // employee, manager, supervisor, closed
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluation_cycles', function (Blueprint $table) {
            $table->dropColumn(['phase']);
        });
    }
};
