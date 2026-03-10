<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Fill any existing NULLs first
        DB::table('sections')
            ->whereNull('year_level')
            ->update(['year_level' => 1]); // default Grade 1

        DB::table('sections')
            ->whereNull('school_year')
            ->update(['school_year' => '2025-2026']); // default

        // Then alter the columns to NOT NULL
        Schema::table('sections', function (Blueprint $table) {
            $table->integer('year_level')->default(1)->nullable(false)->change();
            $table->string('school_year')->default('2025-2026')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->integer('year_level')->nullable()->default(null)->change();
            $table->string('school_year')->nullable()->default(null)->change();
        });
    }
};
