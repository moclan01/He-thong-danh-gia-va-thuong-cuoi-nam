<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $allowedRoles = ['admin', 'director', 'supervisor', 'manager', 'employee'];

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Kiểm tra thông tin đăng nhập
        if (!Auth::guard('api')->attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $account = Auth::guard('api')->user();

        if ($account->status !== 'active') {
            return response()->json(['message' => 'Account is not active'], 403);
        }

        $token = $account->createToken('authToken')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $account->id,
                'username' => $account->username,
                'role' => $account->role,
                'code' => $account->code,
            ],
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }

}
