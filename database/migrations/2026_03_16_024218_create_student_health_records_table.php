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
       Schema::create('student_health_records', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')->constrained()->onDelete('cascade');
    $table->foreignId('school_year_id')->constrained()->onDelete('cascade');
    $table->decimal('weight', 5, 2)->nullable(); // in kg
    $table->decimal('height', 5, 2)->nullable(); // in cm
    $table->decimal('bmi', 5, 2)->nullable();
    $table->string('nutritional_status')->nullable(); // Severely Wasted, Wasted, Normal, Overweight, Obese
    $table->string('hfa_status')->nullable(); // Severely Stunted, Stunted, Normal, Tall
    $table->text('remarks')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_health_records');
    }
};
