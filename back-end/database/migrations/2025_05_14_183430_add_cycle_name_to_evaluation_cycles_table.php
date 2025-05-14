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
            $table->string('cycle_name')->nullable()->after('evaluation_cycle_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluation_cycles', function (Blueprint $table) {
            $table->dropColumn('cycle_name');
        });
    }
};
