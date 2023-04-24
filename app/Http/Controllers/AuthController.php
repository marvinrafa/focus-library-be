<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => "email|required|exists:users,email",
            'password' => "string|required"
        ]);

        if (auth()->attempt($data)) {
            /** @var \App\Models\User $user **/
            $user = auth()->user();
            $token = $user->createToken('LaravelAuthApp')->accessToken;

            return response()->json(['token' => $token, 'user' => $user], 200);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function getProfile(Request $request)
    {
        $user = Auth::user();
        info($user);
        return response()->json(['user' => $user], 200);
    }

    public function logout(Request $request)
    {
        /** @var \App\Models\User $user **/
        $user = Auth::user()->token();
        $user->revoke();
    }
}
