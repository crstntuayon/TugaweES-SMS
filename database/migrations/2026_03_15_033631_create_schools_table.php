<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('schools')) {
            Schema::create('schools', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('school_id')->unique();
                $table->string('principal_name')->nullable();
                $table->string('head_name')->nullable();
                $table->string('address')->nullable();
                $table->string('district')->nullable();
                $table->string('division')->nullable();
                $table->string('region')->nullable();
                $table->string('contact_number')->nullable();
                $table->string('email')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};