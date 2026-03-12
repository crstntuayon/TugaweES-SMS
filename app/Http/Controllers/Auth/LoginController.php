<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //

    public function index()
{
    $teachers = Teacher::with('user')->get();

    return view('welcome', compact('teachers'));
}

public function create()
{
    $teachers = Teacher::with('sections')->get();

    return view('auth.login', compact('teachers'));
}
}
