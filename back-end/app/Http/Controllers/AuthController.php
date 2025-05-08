<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{ 
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $account = Account::where('username', $request->username)->first();

        if (!$account || !Hash::check($request->password, $account->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if (!$account->token) {
            $account->token = Str::random(60);
            $account->save();
        }

        return response()->json([
            'message' => 'Login successful',
            'token' => $account->token,
            'user' => $account,
        ]);
    }

    public function logout(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Token is required'], 401);
        }

        $account = Account::where('token', $token)->first();

        if (!$account) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        if (!$account->token) {
            $account->token = Str::random(60);
            $account->save();
        }

        $account->token = null;
        $account->save();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
