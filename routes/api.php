<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function() {

});

Route::post('/auth/teste', [RegisterController::class, 'teste']);

Route::post('/auth/register', [RegisterController::class, 'store'])
                ->middleware('guest');
