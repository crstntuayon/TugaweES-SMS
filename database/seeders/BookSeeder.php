<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Student;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();
        
        $subjects = ['Mathematics', 'Science', 'English', 'Filipino', 'Araling Panlipunan', 'MAPEH', 'ESP'];
        
        foreach ($students as $student) {
            // Create 5-7 books per student
            $bookCount = rand(5, 7);
            
            for ($i = 0; $i < $bookCount; $i++) {
                $subject = $subjects[array_rand($subjects)];
                
                Book::create([
                    'student_id' => $student->id,
                    'title' => "Grade {$student->section->year_level} {$subject} Textbook",
                    'subject_area' => $subject,
                    'book_code' => 'BK-' . strtoupper(uniqid()),
                    'reference_code' => 'ISBN-' . rand(1000000000, 9999999999),
                    'date_issued' => now()->subMonths(rand(1, 8)),
                    'status' => ['issued', 'returned', 'lost'][array_rand(['issued', 'returned', 'lost'])],
                    'condition' => ['new', 'good', 'fair', 'damaged'][array_rand(['new', 'good', 'fair', 'damaged'])],
                    'loss_code' => null,
                    'action_taken' => null,
                    'remarks' => null,
                ]);
            }
        }
    }
}