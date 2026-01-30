<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Change column to string
        Schema::table('sections', function (Blueprint $table) {
            $table->string('year_level')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        // Revert to integer if needed
        Schema::table('sections', function (Blueprint $table) {
            $table->integer('year_level')->nullable()->change();
        });
    }
};
