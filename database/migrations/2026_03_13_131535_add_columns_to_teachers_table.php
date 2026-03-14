<?php
// database/migrations/xxxx_xx_xx_add_sex_and_address_to_teachers.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->enum('sex', ['Male', 'Female'])->nullable()->after('birthday');
            $table->text('address')->nullable()->after('contact_number');
            $table->json('teaching_load')->nullable()->after('approved_by');
            // Optional: Add these if you want to store them
            $table->string('school')->nullable()->after('address');
            $table->string('district')->nullable()->after('school');
            $table->string('division')->nullable()->after('district');
            $table->string('region', 50)->nullable()->after('division');
            $table->string('grade_levels')->nullable()->after('region');
            $table->string('section_names')->nullable()->after('grade_levels');
        });
    }

    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn([
                'sex', 'address', 'teaching_load', 'school', 'district', 
                'division', 'region', 'grade_levels', 'section_names'
            ]);
        });
    }
};