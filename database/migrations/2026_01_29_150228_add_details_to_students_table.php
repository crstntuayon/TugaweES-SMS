<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            //
            $table->string('middle_name')->nullable()->after('first_name');
            $table->string('suffix')->nullable()->after('last_name');
            $table->date('birthday')->nullable()->after('suffix');
            $table->string('email')->nullable()->after('birthday')->unique();
            $table->string('contact_number')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            //
               $table->dropColumn(['middle_name', 'suffix', 'birthday', 'email', 'contact_number']);
        });
    }
};
