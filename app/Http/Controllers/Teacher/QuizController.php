<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuizScore;
use App\Models\Student;
use App\Models\Section;
use App\Models\Announcement;
use App\Models\SchoolYear;

class QuizController extends Controller
{
     /**
     * Show the quiz recording interface (spreadsheet style)
     */
public function index(Section $section)
{
    // ✅ Safer: Get students and manually load scores if relationship exists
    $students = $section->students()
        ->orderBy('last_name')
        ->orderBy('first_name')
        ->get();

    // Manually attach quiz scores for each student
    $studentsWithStats = $students->map(function($student) use ($section) {
        // ✅ Safe query instead of relationship
        $scores = QuizScore::where('student_id', $student->id)
            ->where('section_id', $section->id)
            ->orderBy('date', 'desc')
            ->get();

        $totalScore = $scores->sum('score');
        $totalPossible = $scores->sum('total_score');
        $average = $totalPossible > 0 ? round(($totalScore / $totalPossible) * 100, 2) : 0;
        
        // Create lookup array for quick access
        $student->quiz_lookup = $scores->keyBy('quiz_title');
        $student->quizScores = $scores; // Mimic relationship for blade compatibility
        
        $student->quiz_stats = [
            'total_score' => $totalScore,
            'total_possible' => $totalPossible,
            'average' => $average,
            'count' => $scores->count()
        ];
        
        return $student;
    });

    // Get unique quiz titles
    $quizTitles = QuizScore::where('section_id', $section->id)
        ->select('quiz_title', 'date', 'total_score')
        ->distinct()
        ->orderBy('date', 'desc')
        ->get()
        ->unique('quiz_title')
        ->pluck('quiz_title')
        ->toArray();

    // All sections for the dropdown
    $sections = Section::orderBy('year_level')->orderBy('name')->get();
    
    $announcements = Announcement::with('user') // eager load poster
        ->orderBy('created_at', 'desc')
        ->get();
    
    // ✅ ADD THESE LINES - Fetch active school year and quarter
    $activeSchoolYear = SchoolYear::where('is_active', true)->first();
    $activeQuarter = $this->getActiveQuarter(); // or fetch from settings

    return view('teacher.quiz.index', compact(
        'announcements', 
        'sections', 
        'section', 
        'studentsWithStats', 
        'quizTitles',
        'activeSchoolYear',  // ✅ Add this
        'activeQuarter'      // ✅ Add this
    ));
}

// ✅ ADD THIS METHOD to your controller (or use a helper/trait)
private function getActiveQuarter(): int
{
    // Option 1: Get from database settings
    // $setting = Setting::where('key', 'active_quarter')->first();
    // return $setting ? (int) $setting->value : 1;
    
    // Option 2: Auto-calculate based on current date (Philippine school calendar)
    $month = now()->month;
    $day = now()->day;
    
    // Q1: June - August
    if ($month >= 6 && $month <= 8) {
        return 1;
    }
    // Q2: September - November
    elseif ($month >= 9 && $month <= 11) {
        return 2;
    }
    // Q3: December - February
    elseif ($month == 12 || $month <= 2) {
        return 3;
    }
    // Q4: March - May
    else {
        return 4;
    }
}

    /**
     * Store new quiz scores (batch processing)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'quiz_title' => 'required|string|max:255',
            'scores' => 'required|array',
            'scores.*.student_id' => 'required|exists:students,id',
            'scores.*.score' => 'nullable|numeric|min:0',  // ✅ Changed to nullable
            'scores.*.total_score' => 'required|numeric|min:1',
            'date' => 'required|date'
        ]);

        $inserted = 0;
        foreach ($validated['scores'] as $scoreData) {
            // ✅ Fixed: Better check for empty scores
            if (!isset($scoreData['score']) || $scoreData['score'] === '' || $scoreData['score'] === null) {
                continue;
            }

            // ✅ Added: Check if score already exists for this student/quiz combo
            $existing = QuizScore::where('student_id', $scoreData['student_id'])
                ->where('section_id', $validated['section_id'])
                ->where('quiz_title', $validated['quiz_title'])
                ->first();

            if ($existing) {
                // Update existing score
                $existing->update([
                    'score' => $scoreData['score'],
                    'total_score' => $scoreData['total_score'],
                    'date' => $validated['date']
                ]);
            } else {
                // Create new score
                QuizScore::create([
                    'student_id' => $scoreData['student_id'],
                    'section_id' => $validated['section_id'],
                    'quiz_title' => $validated['quiz_title'],
                    'score' => $scoreData['score'],
                    'total_score' => $scoreData['total_score'],
                    'date' => $validated['date']
                ]);
            }
            $inserted++;
        }

        return back()->with('success', "Quiz scores recorded/updated for {$inserted} students!");
    }

    /**
     * Update existing quiz score (AJAX)
     */
    public function update(Request $request, QuizScore $quizScore)
    {
        $validated = $request->validate([
            'score' => 'required|numeric|min:0',
            'total_score' => 'sometimes|required|numeric|min:1'  // ✅ Added: Allow updating total too
        ]);

        $quizScore->update($validated);

        // ✅ Added: Return updated stats for real-time UI updates
        return response()->json([
            'success' => true, 
            'message' => 'Score updated!',
            'data' => [
                'score' => $quizScore->score,
                'total_score' => $quizScore->total_score,
                'percentage' => round(($quizScore->score / $quizScore->total_score) * 100, 2)
            ]
        ]);
    }

    /**
     * Delete quiz score
     */
    public function destroy(QuizScore $quizScore)
    {
        $quizScore->delete();
        
        // ✅ Added: Check if this was the last quiz with this title
        $remaining = QuizScore::where('section_id', $quizScore->section_id)
            ->where('quiz_title', $quizScore->quiz_title)
            ->count();

        return back()->with('success', 'Quiz score deleted!' . 
            ($remaining === 0 ? ' This was the last record for this quiz.' : ''));
    }

    /**
     * ✅ NEW: Get quiz history for a specific student
     */
    public function studentHistory(Section $section, Student $student)
    {
        $scores = $student->quizScores()
            ->where('section_id', $section->id)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'student' => $student->name,
            'scores' => $scores,
            'stats' => [
                'total_quizzes' => $scores->count(),
                'average' => $scores->count() > 0 ? 
                    round(($scores->sum('score') / $scores->sum('total_score')) * 100, 2) : 0
            ]
        ]);
    }

    /**
     * ✅ NEW: Delete entire quiz (all scores for a quiz title)
     */
    public function destroyQuiz(Request $request, Section $section)
    {
        $validated = $request->validate([
            'quiz_title' => 'required|string'
        ]);

        $deleted = QuizScore::where('section_id', $section->id)
            ->where('quiz_title', $validated['quiz_title'])
            ->delete();

        return back()->with('success', "Deleted {$deleted} records for quiz '{$validated['quiz_title']}'");
    }
}