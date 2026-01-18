<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::post('/refresh', [AuthController::class, 'refresh'])
    ->middleware('auth:api');
Route::middleware(['auth:api'])->group(function () {

    // user routes
    Route::get('/profile', function () {
        return auth()->user();
    });

    // admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/users', function () {
            return \App\Models\User::all();
        });
    });
});