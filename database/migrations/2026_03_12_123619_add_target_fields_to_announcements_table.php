<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->string('target_audience')->default('all')->after('content'); // all, students, teachers, parents
            $table->string('grade_level')->nullable()->after('target_audience');
            $table->boolean('is_urgent')->default(false)->after('grade_level');
            $table->foreignId('author_id')->nullable()->constrained('users')->after('is_urgent');
        });
    }

    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn(['target_audience', 'grade_level', 'is_urgent', 'author_id']);
        });
    }
};