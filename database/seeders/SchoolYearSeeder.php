<?php

namespace Database\Seeders; // <--- must be included

use Illuminate\Database\Seeder;
use App\Models\SchoolYear;

class SchoolYearSeeder extends Seeder
{
    public function run(): void
    {
        // Optional: first, clear old records
        SchoolYear::truncate();

        SchoolYear::create(['name' => '2025-2026', 'is_active' => true]);
        SchoolYear::create(['name' => '2026-2027', 'is_active' => false]);
        SchoolYear::create(['name' => '2027-2028', 'is_active' => false]);
        SchoolYear::create(['name' => '2028-2029', 'is_active' => false]);
        SchoolYear::create(['name' => '2029-2030', 'is_active' => false]);
        SchoolYear::create(['name' => '2030-2031', 'is_active' => false]);
        SchoolYear::create(['name' => '2031-2032', 'is_active' => false]);
        SchoolYear::create(['name' => '2032-2033', 'is_active' => false]);
        SchoolYear::create(['name' => '2033-2034', 'is_active' => false]);
    }
}
