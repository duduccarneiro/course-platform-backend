<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\MeController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function() {
    Route::post('/register', RegisterUserController::class);

    Route::post('/token', [LoginController::class, 'store']);

    Route::middleware('auth:sanctum')->group(function() {
        Route::get('/me', [MeController::class, '__invoke']);
        Route::post('/logout', [LoginController::class, 'destroy']);

        Route::controller(EmailVerificationController::class)->group(function () {
            Route::post('email/verification-notification', 'sendVerificationEmail')
                ->middleware(['throttle:6,1']); // 6 requests dentro de 1 minuto
            Route::get('verify-email/{user}/{hash}', 'verify')
                ->name('verification.verify');

        });
    });
});

