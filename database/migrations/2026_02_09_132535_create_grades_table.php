<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->decimal('quarter1', 5, 2)->nullable();
            $table->decimal('quarter2', 5, 2)->nullable();
            $table->decimal('quarter3', 5, 2)->nullable();
            $table->decimal('quarter4', 5, 2)->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');

            // One grade record per student
            $table->unique('student_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('grades');
    }
};
