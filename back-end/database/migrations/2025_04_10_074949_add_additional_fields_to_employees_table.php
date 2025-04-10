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
            $table->string('division')->nullable();
            $table->string('basic')->nullable();
            $table->string('grade')->nullable();
            $table->string('stafftype')->nullable();
            $table->string('manager_code')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['division', 'basic', 'grade', 'stafftype', 'manager_code']); // Xóa các cột
        });
    }
};
