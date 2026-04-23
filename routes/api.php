<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('videos', [ApiController::class, 'videos']);
    Route::get('about', [ApiController::class, 'about']);
    Route::get('steps', [ApiController::class, 'steps']);
    Route::get('packages', [ApiController::class, 'packages']);
    Route::get('settings', [ApiController::class, 'settings']);
    Route::post('checkout/session', [ApiController::class, 'checkoutSession']);
    Route::post('appointments', [ApiController::class, 'appointments']);
    Route::get('/appointments', [ApiController::class, 'index']);
});
