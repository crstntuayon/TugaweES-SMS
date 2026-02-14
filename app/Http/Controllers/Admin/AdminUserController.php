<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class AdminUserController extends Controller
{
    public function index()
    {
        // paginate for large number of users
        $users = User::with('role')->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name'  => 'required|string|max:255',
            'suffix'     => 'nullable|string|max:10',
            'birthday'   => 'nullable|date',
            'email'      => 'required|email|unique:users,email,'.$user->id,
            'username'   => 'required|unique:users,username,'.$user->id,
            'password'   => 'nullable|min:6',
        ]);

        $user->update($request->all());

        return back()->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
  public function liveSearch(Request $request)
{
    $search = $request->search;

    $users = User::where('first_name', 'like', "%{$search}%")
        ->orWhere('last_name', 'like', "%{$search}%")
        ->limit(5)
        ->get();

    return response()->json($users);
}


}
