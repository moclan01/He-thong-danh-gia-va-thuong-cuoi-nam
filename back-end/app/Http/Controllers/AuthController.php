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

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Thông tin đăng nhập không đúng'], 401);
        }

        $user = Auth::user();

        // Kiểm tra xem user có role nào hợp lệ không
        $userRoles = $user->getRoleNames()->toArray();

        $matchedRole = null;

        foreach ($this->allowedRoles as $role) {
            if (in_array($role, $userRoles)) {
                $matchedRole = $role;
                break;
            }
        }

        if (!$matchedRole) {
            return response()->json(['message' => 'Không có quyền đăng nhập hệ thống'], 403);
        }

        // Tạo token nếu hợp lệ
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Đăng nhập thành công',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'role' => $matchedRole,
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Đăng xuất thành công',
        ]);
    }

    public function profile(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
            'roles' => $request->user()->getRoleNames()
        ]);
    }
}
