<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeYearLevelAndSchoolYearNotNullableInSectionsTable extends Migration
{
    public function up()
    {
        // Make year_level and school_year NOT NULL
        Schema::table('sections', function (Blueprint $table) {
            $table->string('year_level')->nullable(false)->change();
            $table->string('school_year')->nullable(false)->change();
        });
    }

    public function down()
    {
        // Revert to nullable
        Schema::table('sections', function (Blueprint $table) {
            $table->string('year_level')->nullable()->change();
            $table->string('school_year')->nullable()->change();
        });
    }
}
