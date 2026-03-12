<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::table('grades', function (Blueprint $table) {
    $table->string('component')->nullable()->after('subject_id');

    $table->unique(
        ['student_id', 'subject_id', 'component', 'quarter'],
        'grades_unique_entry'
    );
});
        
    }

    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropColumn('component');
            $table->dropUnique('grades_unique_entry');
            
        });
    }
};
