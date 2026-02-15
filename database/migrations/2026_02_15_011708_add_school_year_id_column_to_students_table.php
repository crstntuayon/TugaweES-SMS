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
        Schema::table('students', function (Blueprint $table) {
            //
             $table->foreignId('school_year_id')
                  ->nullable() // optional, if some students may not have a year yet
                  ->constrained('school_years') // references id in school_years
                  ->onDelete('cascade')
                  ->after('id'); // place it after id column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            //
                $table->dropForeign(['school_year_id']);
                $table->dropColumn('school_year_id');
                
        });
    }
};
