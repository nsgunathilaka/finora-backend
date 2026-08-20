<?php

use App\Http\Responses\ApiResponse;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return ApiResponse::success(
        data: [
            'status' => 'ok',
        ],
        message: 'Finora API is running.'
    );
});


Route::post('/test-validation', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
    ]);

    return ApiResponse::success(
        message: 'Validation passed.'
    );
});