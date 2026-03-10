<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ElementarySubjectsSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            // Kindergarten
            ['code' => 'K_LIT', 'name' => 'Language Literacy', 'grade_level' => 'Kindergarten', 'components' => null],
            ['code' => 'K_NUM', 'name' => 'Number Readiness', 'grade_level' => 'Kindergarten', 'components' => null],
            ['code' => 'K_HEALTH', 'name' => 'Health & Safety', 'grade_level' => 'Kindergarten', 'components' => null],
            ['code' => 'K_PE', 'name' => 'Physical Education', 'grade_level' => 'Kindergarten', 'components' => null],

            // Grade 1
            ['code' => 'FIL1', 'name' => 'Filipino', 'grade_level' => 'Grade 1', 'components' => null],
            ['code' => 'ENG1', 'name' => 'English', 'grade_level' => 'Grade 1', 'components' => null],
            ['code' => 'MATH1', 'name' => 'Mathematics', 'grade_level' => 'Grade 1', 'components' => null],
            ['code' => 'ESP1', 'name' => 'Edukasyon sa Pagpapakatao', 'grade_level' => 'Grade 1', 'components' => null],
            ['code' => 'MAPEH1', 'name' => 'MAPEH', 'grade_level' => 'Grade 1', 
                'components' => json_encode(['Music', 'Arts', 'Physical Education', 'Health'])
            ],

            // Grade 2
            ['code' => 'FIL2', 'name' => 'Filipino', 'grade_level' => 'Grade 2', 'components' => null],
            ['code' => 'ENG2', 'name' => 'English', 'grade_level' => 'Grade 2', 'components' => null],
            ['code' => 'MATH2', 'name' => 'Mathematics', 'grade_level' => 'Grade 2', 'components' => null],
            ['code' => 'ESP2', 'name' => 'Edukasyon sa Pagpapakatao', 'grade_level' => 'Grade 2', 'components' => null],
            ['code' => 'MAPEH2', 'name' => 'MAPEH', 'grade_level' => 'Grade 2', 
                'components' => json_encode(['Music', 'Arts', 'Physical Education', 'Health'])
            ],
            ['code' => 'AP2', 'name' => 'Araling Panlipunan', 'grade_level' => 'Grade 2', 'components' => null],

            // Grade 3
            ['code' => 'FIL3', 'name' => 'Filipino', 'grade_level' => 'Grade 3', 'components' => null],
            ['code' => 'ENG3', 'name' => 'English', 'grade_level' => 'Grade 3', 'components' => null],
            ['code' => 'MATH3', 'name' => 'Mathematics', 'grade_level' => 'Grade 3', 'components' => null],
            ['code' => 'SCI3', 'name' => 'Science', 'grade_level' => 'Grade 3', 'components' => null],
            ['code' => 'ESP3', 'name' => 'Edukasyon sa Pagpapakatao', 'grade_level' => 'Grade 3', 'components' => null],
            ['code' => 'MAPEH3', 'name' => 'MAPEH', 'grade_level' => 'Grade 3', 
                'components' => json_encode(['Music', 'Arts', 'Physical Education', 'Health'])
            ],
            ['code' => 'AP3', 'name' => 'Araling Panlipunan', 'grade_level' => 'Grade 3', 'components' => null],

            // Grade 4
            ['code' => 'FIL4', 'name' => 'Filipino', 'grade_level' => 'Grade 4', 'components' => null],
            ['code' => 'ENG4', 'name' => 'English', 'grade_level' => 'Grade 4', 'components' => null],
            ['code' => 'MATH4', 'name' => 'Mathematics', 'grade_level' => 'Grade 4', 'components' => null],
            ['code' => 'SCI4', 'name' => 'Science', 'grade_level' => 'Grade 4', 'components' => null],
            ['code' => 'ESP4', 'name' => 'Edukasyon sa Pagpapakatao', 'grade_level' => 'Grade 4', 'components' => null],
            ['code' => 'MAPEH4', 'name' => 'MAPEH', 'grade_level' => 'Grade 4', 
                'components' => json_encode(['Music', 'Arts', 'Physical Education', 'Health'])
            ],
            ['code' => 'AP4', 'name' => 'Araling Panlipunan', 'grade_level' => 'Grade 4', 'components' => null],
            ['code' => 'EPP4', 'name' => 'Edukasyong Pantahanan at Pangkabuhayan', 'grade_level' => 'Grade 4', 'components' => null],

            // Grade 5
            ['code' => 'FIL5', 'name' => 'Filipino', 'grade_level' => 'Grade 5', 'components' => null],
            ['code' => 'ENG5', 'name' => 'English', 'grade_level' => 'Grade 5', 'components' => null],
            ['code' => 'MATH5', 'name' => 'Mathematics', 'grade_level' => 'Grade 5', 'components' => null],
            ['code' => 'SCI5', 'name' => 'Science', 'grade_level' => 'Grade 5', 'components' => null],
            ['code' => 'ESP5', 'name' => 'Edukasyon sa Pagpapakatao', 'grade_level' => 'Grade 5', 'components' => null],
            ['code' => 'MAPEH5', 'name' => 'MAPEH', 'grade_level' => 'Grade 5', 
                'components' => json_encode(['Music', 'Arts', 'Physical Education', 'Health'])
            ],
            ['code' => 'AP5', 'name' => 'Araling Panlipunan', 'grade_level' => 'Grade 5', 'components' => null],
            ['code' => 'EPP5', 'name' => 'Edukasyong Pantahanan at Pangkabuhayan', 'grade_level' => 'Grade 5', 'components' => null],

            // Grade 6
            ['code' => 'FIL6', 'name' => 'Filipino', 'grade_level' => 'Grade 6', 'components' => null],
            ['code' => 'ENG6', 'name' => 'English', 'grade_level' => 'Grade 6', 'components' => null],
            ['code' => 'MATH6', 'name' => 'Mathematics', 'grade_level' => 'Grade 6', 'components' => null],
            ['code' => 'SCI6', 'name' => 'Science', 'grade_level' => 'Grade 6', 'components' => null],
            ['code' => 'ESP6', 'name' => 'Edukasyon sa Pagpapakatao', 'grade_level' => 'Grade 6', 'components' => null],
            ['code' => 'MAPEH6', 'name' => 'MAPEH', 'grade_level' => 'Grade 6', 
                'components' => json_encode(['Music', 'Arts', 'Physical Education', 'Health'])
            ],
            ['code' => 'AP6', 'name' => 'Araling Panlipunan', 'grade_level' => 'Grade 6', 'components' => null],
            ['code' => 'EPP6', 'name' => 'Edukasyong Pantahanan at Pangkabuhayan', 'grade_level' => 'Grade 6', 'components' => null],
        ];

        DB::table('subjects')->insert($subjects);
    }
}
