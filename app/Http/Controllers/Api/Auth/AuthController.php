<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Responses\ApiResponse;
use App\Models\User;

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
}