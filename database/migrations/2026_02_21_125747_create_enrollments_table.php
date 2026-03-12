<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();

            // Student reference
            $table->foreignId('student_id')
                  ->constrained()
                  ->onDelete('cascade');

            // School year reference
            $table->foreignId('school_year_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Section reference
            $table->foreignId('section_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Enrollment status
            $table->enum('status', [
                'enrolled',
                'promoted',
                'retained',
                'transferred',
                'completed'
            ])->default('enrolled');

            $table->timestamps();

            // Prevent duplicate enrollment in same school year
            $table->unique(['student_id', 'school_year_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};