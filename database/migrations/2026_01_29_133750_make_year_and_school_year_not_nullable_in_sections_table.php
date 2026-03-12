<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->string('year_level')->nullable(false)->change(); // NOT NULL string
            $table->string('school_year')->nullable(false)->change(); // NOT NULL string
        });
    }

    public function down()
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->string('year_level')->nullable()->change();
            $table->string('school_year')->nullable()->change();
        });
    }
};
