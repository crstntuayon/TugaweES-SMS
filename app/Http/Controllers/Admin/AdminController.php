<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
  public function store(Request $request)
{
    $request->validate([
        'first_name' => 'required',
        'middle_name' => 'nullable',
        'last_name'  => 'required',
        'suffix'     => 'nullable',
        'birthday'   => 'nullable|date',
        'email'      => 'required|email|unique:users',
        'username'   => 'required|unique:users',
        'password'   => 'required|min:6',
    ]);

    User::create([
        'first_name' => $request->first_name,
        'middle_name' => $request->middle_name,
        'last_name'  => $request->last_name,
        'suffix'     => $request->suffix,
        'birthday'   => $request->birthday,
        'email'      => $request->email,
        'username'   => $request->username,
        'role_id'    => 1, // ADMIN
        'password'   => bcrypt($request->password),
    ]);

    return back()->with('success', 'Admin created successfully');
}

}
