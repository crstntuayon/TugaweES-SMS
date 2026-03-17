<?php

namespace App\Http\Controllers\Student;


use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $student = auth()->user()->student;
        
        $announcements = Announcement::visibleToStudent($student)
            ->with('author')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($announcement) {
                $announcement->is_read = DB::table('announcement_reads')
                    ->where('announcement_id', $announcement->id)
                    ->where('student_id', auth()->user()->student->id)
                    ->exists();
                return $announcement;
            });

        $unreadCount = $announcements->where('is_read', false)->count();

        return view('student.dashboard', compact('announcements', 'unreadCount'));
    }

    public function markAsRead(Announcement $announcement)
    {
        $studentId = auth()->user()->student->id;
        
        DB::table('announcement_reads')->insertOrIgnore([
            'announcement_id' => $announcement->id,
            'student_id' => $studentId,
            'read_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }
}