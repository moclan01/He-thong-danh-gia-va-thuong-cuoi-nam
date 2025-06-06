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
            $table->float('m')->nullable()->after('score');  // hoặc chọn vị trí phù hợp
            $table->float('n')->nullable()->after('m');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hform_items', function (Blueprint $table) {
            $table->dropColumn(['m', 'n']);
        });
    }
};
