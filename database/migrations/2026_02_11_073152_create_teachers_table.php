<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();

            // 🔗 Link to users table (login account)
            $table->foreignId('user_id')
                  ->unique()
                  ->constrained()
                  ->onDelete('cascade');

            // 👤 Personal Information
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();

            $table->date('birthday');

            // 📧 Contact
            $table->string('email')->nullable();
            $table->string('contact_number')->nullable();

            // 🧑‍🏫 Professional Info
            $table->string('employee_id')->nullable()->unique();
            $table->string('position')->default('Teacher'); 
            $table->date('date_hired')->nullable();

            // 📸 Profile Photo
            $table->string('photo')->nullable();

            // 🏫 Optional: advisory section
            $table->foreignId('advisory_section_id')
                  ->nullable()
                  ->constrained('sections')
                  ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
