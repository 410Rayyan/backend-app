<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 1. User Register
    public function register(Request $request)
    {
        // Simple input validation
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Check if email already used
        if (User::where('email', $request->email)->exists()) {
            return response()->json(['message' => 'Email already registered.'], 422);
        }

        // Save new user in MongoDB
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'guest',
            'phone' => $request->phone ?? null,
        ]);

        // Generate token
        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'message' => 'Account created successfully!',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    // 2. User Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Find user by email
        $user = User::where('email', $request->email)->first();

        // Check if user exists and password is correct
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Wrong email or password.'], 401);
        }

        // Generate token
        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'message' => 'Logged in successfully!',
            'user' => $user,
            'token' => $token,
        ]);
    }

    // 3. User Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully!',
        ]);
    }

    // 4. View own profile
    public function profile(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }
}
