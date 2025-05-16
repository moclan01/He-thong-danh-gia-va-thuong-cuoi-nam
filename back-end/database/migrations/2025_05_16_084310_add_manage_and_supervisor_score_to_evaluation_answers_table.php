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
        Schema::table('evaluation_answers', function (Blueprint $table) {
            $table->integer('total_score_manage')->nullable()->after('total_score');
            $table->integer('total_score_supervisor')->nullable()->after('total_score_manage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluation_answers', function (Blueprint $table) {
            $table->dropColumn(['total_score_manage', 'total_score_supervisor']);
        });
    }
};
