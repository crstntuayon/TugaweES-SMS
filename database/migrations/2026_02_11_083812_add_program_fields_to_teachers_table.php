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
    Schema::table('teachers', function (Blueprint $table) {

        $table->string('position')->nullable();
        $table->integer('years_experience')->default(0);
        $table->string('grade_experience')->nullable();

        $table->integer('male_enrollment')->default(0);
        $table->integer('female_enrollment')->default(0);

        $table->string('prepared_by')->nullable();
        $table->string('conforme')->nullable();
        $table->string('approved_by')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            //
        });
    }
};
