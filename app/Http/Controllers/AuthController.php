<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
