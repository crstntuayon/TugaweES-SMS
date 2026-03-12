<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->string('year_level')->default('Kindergarten')->change();
            $table->string('school_year')->default(date('Y') . '-' . (date('Y') + 1))->change();
        });
    }

    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->string('year_level')->default(null)->change();
            $table->string('school_year')->default(null)->change();
        });
    }
};
