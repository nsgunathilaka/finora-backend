<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return ApiResponse::success(
            data: [
                'user' => $user,
            ],
            message: 'Registration successful.',
            status: 201
        );
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ApiResponse::error(
                message: 'Invalid credentials.',
                status: 401
            );
        }

        $token = $user->createToken('finora-api')->plainTextToken;

        return ApiResponse::success(
            data: [
                'user' => $user,
                'token' => $token,
            ],
            message: 'Login successful.'
        );
    }

    public function me()
    {
        return ApiResponse::success(
            data: [
                'user' => request()->user(),
            ],
            message: 'Authenticated user retrieved successfully.'
        );
    }
}
