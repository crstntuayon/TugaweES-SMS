<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    // Show announcements
    public function index()
    {
        $announcements = Announcement::where('type', 'teacher')
            ->orWhere(function($q) {
                $q->where('type', 'admin')->where('target_audience', 'all');
            })
            ->latest()
            ->get();
            
        return view('teacher.dashboard', compact('announcements'));
    }

    // Store new announcement
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',              // Changed from 'message' to 'content'
            'target_audience' => 'required|string|in:all,students,parents,teachers,admin,specific_section',
            'grade_level' => 'nullable|string',
            'is_urgent' => 'nullable|boolean',
            'is_pinned' => 'nullable|boolean',
            'section_id' => 'nullable|exists:sections,id',
            'type' => 'required|in:admin,teacher',
        ]);

        Announcement::create([
            'title' => $validated['title'],
            'content' => $validated['content'],         // Changed from 'message'
            'target_audience' => $validated['target_audience'] ?? 'all',
            'grade_level' => $validated['grade_level'] ?? null,
            'is_urgent' => $validated['is_urgent'] ?? false,
            'is_pinned' => $validated['is_pinned'] ?? false,
            'section_id' => $validated['section_id'] ?? null,
            'user_id' => Auth::id(),
            'author_id' => Auth::id(),                  // Added author_id
            'type' => $validated['type'] ?? 'teacher',
        ]);

        return back()->with('success', 'Announcement posted successfully!');
    }

    // Update announcement
    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',              // Changed from 'message'
            'target_audience' => 'nullable|string',
            'grade_level' => 'nullable|string',
            'is_urgent' => 'nullable|boolean',
            'is_pinned' => 'nullable|boolean',
        ]);

        $announcement->update($validated);

        return response()->json(['success' => true]);
    }

    // Delete announcement
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return back()->with('success', 'Announcement deleted successfully!');
    }
}