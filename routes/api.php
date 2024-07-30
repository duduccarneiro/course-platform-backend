<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\MeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\RegisterUserController;
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
    });
});
