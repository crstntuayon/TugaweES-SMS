<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->date('date'); // actual date of attendance
            $table->tinyInteger('day'); // day number in month (1-31)
            $table->boolean('status')->default(0); // 1 = present, 0 = absent
            $table->timestamps();

            // Foreign key
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');

            // Prevent duplicate records
            $table->unique(['student_id', 'date', 'day']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendances');
    }
};
