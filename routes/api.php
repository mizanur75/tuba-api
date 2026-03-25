<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('videos', [ApiController::class, 'videos']);
    Route::get('about', [ApiController::class, 'about']);
    Route::get('steps', [ApiController::class, 'steps']);
    Route::get('packages', [ApiController::class, 'packages']);
});