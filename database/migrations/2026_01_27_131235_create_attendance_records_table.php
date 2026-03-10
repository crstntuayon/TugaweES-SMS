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
        Schema::create('attendance_records', function (Blueprint $table) {
         $table->id();
        $table->foreignId('section_id')->constrained()->cascadeOnDelete();
        $table->date('date');
        $table->foreignId('teacher_id')->constrained('users');
        $table->timestamps();

        $table->unique(['section_id', 'date']); // 1 attendance per section per day
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};
