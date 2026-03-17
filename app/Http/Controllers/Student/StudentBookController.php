<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentBookController extends Controller
{
    /**
     * Store newly issued book to student
     */// app/Http/Controllers/StudentBookController.php

public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'book_code' => 'nullable|string|max:50',
        'reference_code' => 'nullable|string|max:50',
        'date_issued' => 'required|date',
        'condition' => 'required|in:new,good,fair,damaged,poor,lost',
        'subject_area' => 'nullable|string|max:100',
        'damage_details' => 'nullable|string|max:500',
        'loss_code' => 'nullable|string|max:50',
        'action_taken' => 'nullable|string|max:255',
        'remarks' => 'nullable|string|max:500',
    ]);

    $student = Auth::user()->student;

    $book = Book::create(array_merge($validated, [
        'student_id' => $student->id,
        'status' => 'issued',
    ]));

    return redirect()->back()->with('success', 'Book "' . $book->title . '" borrowed successfully.');
}

public function edit(Book $book)
{
    if ($book->student_id !== Auth::user()->student->id) {
        abort(403, 'Unauthorized action.');
    }
    
    return response()->json($book);
}

public function update(Request $request, Book $book)
{
    if ($book->student_id !== Auth::user()->student->id) {
        abort(403, 'Unauthorized action.');
    }
    
    if ($book->status !== 'issued') {
        return redirect()->back()->with('error', 'Only issued books can be edited.');
    }

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'book_code' => 'nullable|string|max:50',
        'reference_code' => 'nullable|string|max:50',
        'date_issued' => 'required|date',
        'condition' => 'required|in:new,good,fair,damaged,poor,lost',
        'subject_area' => 'nullable|string|max:100',
        'damage_details' => 'nullable|string|max:500',
        'loss_code' => 'nullable|string|max:50',
        'action_taken' => 'nullable|string|max:255',
        'remarks' => 'nullable|string|max:500',
    ]);

    $book->update($validated);

    return redirect()->back()->with('success', 'Book "' . $book->title . '" updated successfully.');
}

// ADD THIS NEW METHOD - Mark as Lost
public function markAsLost(Request $request, Book $book)
{
    if ($book->student_id !== Auth::user()->student->id) {
        abort(403, 'Unauthorized action.');
    }
    
    if ($book->status !== 'issued') {
        return redirect()->back()->with('error', 'Only issued books can be marked as lost.');
    }

    $validated = $request->validate([
        'loss_code' => 'required|string|max:50',
        'action_taken' => 'nullable|string|max:255',
        'remarks' => 'nullable|string|max:500',
    ]);

    $book->update(array_merge($validated, [
        'status' => 'lost',
        'condition' => 'lost',
    ]));

    return redirect()->back()->with('success', 'Book "' . $book->title . '" marked as lost.');
}

public function return(Request $request, Book $book)
{
    if ($book->student_id !== Auth::user()->student->id) {
        abort(403, 'Unauthorized action.');
    }

    $book->update([
        'status' => 'returned',
        'date_returned' => now(),
    ]);

    return redirect()->back()->with('success', 'Book returned successfully.');
}

    /**
     * Mark book as returned
     */
    public function returnBook(Request $request, Book $book)
    {
        // Verify ownership
        if ($book->student_id !== Auth::user()->student->id) {
            abort(403, 'Unauthorized action.');
        }

        $book->update([
            'status' => 'returned',
            'date_returned' => now(),
        ]);

        return redirect()->back()->with('success', 'Book "' . $book->title . '" marked as returned.');
    }
}