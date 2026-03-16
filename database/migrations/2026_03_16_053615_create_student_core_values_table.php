<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::create('student_core_values', function (Blueprint $table) {
        $table->id();
        $table->foreignId('student_id')->constrained()->onDelete('cascade');
        $table->foreignId('school_year_id')->constrained()->onDelete('cascade');
        $table->string('core_value'); // Maka-Diyos, Makatao, etc.
        $table->text('behavior_statement');
        $table->tinyInteger('quarter'); // 1, 2, 3, 4
        $table->string('mark', 2); // AO, SO, RO, NO
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_core_values');
    }
};
