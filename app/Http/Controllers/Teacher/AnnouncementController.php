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
        $announcements = Announcement::where('type', 'teacher')->latest()->get();
        return view('teacher.dashboard', compact('announcements')); // your dashboard view
    }

    // Store new announcement
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Announcement::create([
            'title' => $request->title,
            'content' => $request->message,
            'user_id' => Auth::id(),
            'type' => 'teacher',
        ]);

        return back()->with('success', 'Announcement posted successfully!');
    }

    // Update announcement
    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $announcement->update([
            'title' => $request->title,
            'content' => $request->message,
        ]);

        return response()->json(['success' => true]); // for Axios
    }

    // Delete announcement
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return back()->with('success', 'Announcement deleted successfully!');
    }
}
