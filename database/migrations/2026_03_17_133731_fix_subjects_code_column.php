<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            // Option 1: Make it nullable
            $table->string('code')->nullable()->change();
            
            // OR Option 2: Add default value
            // $table->string('code')->default('TBD')->change();
        });
    }

    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->string('code')->nullable(false)->change();
        });
    }
};