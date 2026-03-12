<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->enum('graduation_status', ['active', 'candidate', 'graduated'])
                  ->default('active')
                  ->after('grade_level');
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('graduation_status');
        });
    }
};