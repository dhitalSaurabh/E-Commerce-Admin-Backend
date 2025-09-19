<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    public function registers(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $fields['password'] = Hash::make($fields['password']);
        $user = User::create($fields);

        $token = $user->createToken($user->name);

        return response()->json([
            'user' => $user,
            // 'token' => $token->plainTextToken,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('email', $request->email)->first();

        // Check if password is correct
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }
        $token = $user->createToken($user->name)->plainTextToken;
        // $accessToken = $token->accessToken;

        // $accessToken->expires_at = now()->addDay();
        // $token->accessToken->save();
        return response()->json([
            'user' => $user,
            'token' => $token,
            // 'expires_at' => $accessToken->expires_at,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'User Logged out',
            'token' => 'destroyed',
        ]);
    }
}
