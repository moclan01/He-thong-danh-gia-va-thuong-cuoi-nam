<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('evaluation_criteria', function (Blueprint $table) {
            $table->string('criteria_id')->primary();
            $table->string('department_id'); 
            $table->string('criteria_name');
            $table->text('description')->nullable();
            $table->decimal('weight', 5, 2)->default(1.00); // Giá trị mặc định 1.00
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            // Khóa ngoại tham chiếu đến bảng departments
            $table->foreign('department_id')->references('department_id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_criteria');
    }
};
