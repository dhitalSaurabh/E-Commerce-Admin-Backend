<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function registers(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'mobile_number' => 'required|string|unique:customers,mobile_number',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $fields['password'] = Hash::make($fields['password']);
        $user = Customer::create($fields);

        $token = $user->createToken($user->name);

        return response()->json([
            'customer' => $user,
            'token' => $token->plainTextToken,
        ]);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:customers,email',
            'password' => 'required|string|min:8',
        ]);

        $user = Customer::where('email', $request->email)->first();

        // Check if password is correct
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }
        // // ✅ Check if mobile is verified
        // if (is_null($user->mobile_verified_at)) {
        //     return response()->json(['message' => 'Mobile number is not verified.'], 403);
        // }

        $token = $user->createToken($user->name);
        $accessToken = $token->accessToken;

        $accessToken->expires_at = now()->addDay();
        $token->accessToken->save();
        return response()->json([
            'customer' => $user,
            'token' => $token,
            'expires_at' => $accessToken->expires_at,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Customer Logged out']);
    }
}
