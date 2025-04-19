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
        Schema::table('employees', function (Blueprint $table) {
            $table->foreign('plant_id')
                ->references('plant_id')
                ->on('plants')
                ->onDelete('set null');

            $table->foreign('department_id')
                ->references('department_id')
                ->on('departments')
                ->onDelete('set null');

            $table->foreign('position_id')
                ->references('position_id')
                ->on('positions')
                ->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['plant_id']);
            $table->dropForeign(['department_id']);
            $table->dropForeign(['position_id']);
        });
    }
};
