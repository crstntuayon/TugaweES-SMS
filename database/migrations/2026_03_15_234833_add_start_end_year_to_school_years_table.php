<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('school_years', function (Blueprint $table) {
            $table->integer('start_year')->nullable();
            $table->integer('end_year')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('school_years', function (Blueprint $table) {
            $table->dropColumn(['start_year', 'end_year']);
        });
    }
};