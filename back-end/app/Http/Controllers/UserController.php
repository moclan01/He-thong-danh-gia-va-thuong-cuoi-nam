<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'employee_code' => 'nullable|unique:users',
            'password' => 'required',
            'status' => 'required|in:active,inactive',
            'role' => 'required|in:admin,employee',
        ]);

        User::create([
            'username' => $request->username,
            'employee_code' => $request->employee_code,
            'password' => bcrypt($request->password), 
            'status' => $request->status,
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'Người dùng đã được tạo.');
    }
}
