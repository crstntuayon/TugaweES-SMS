<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ElementarySubjectsSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            'English',
            'Filipino',
            'Mathematics',
            'Science',
            'Araling Panlipunan',
            'Edukasyong Pantahanan at Pangkabuhayan (EPP)',
            'Music, Arts, PE, and Health (MAPEH)',
            'Values Education'
        ];

        $now = Carbon::now();

        foreach ($subjects as $subject) {
            DB::table('subjects')->insert([
                'name' => $subject,
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }
    }
}
