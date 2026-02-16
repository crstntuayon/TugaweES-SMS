<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('content');

            // Who posted it (Admin or Teacher)
            $table->enum('type', ['admin', 'teacher'])->default('admin');

            // The user who created it
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // OPTIONAL: Target specific section (nullable = whole school)
            $table->foreignId('section_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('cascade');

            // Pin announcement
            $table->boolean('is_pinned')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
