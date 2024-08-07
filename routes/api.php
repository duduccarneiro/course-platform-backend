<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\MeController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Instructor\InstructorCourseController;
use App\Http\Controllers\Instructor\InstructorLectureContentController;
use App\Http\Controllers\Instructor\InstructorLectureController;
use App\Http\Controllers\Instructor\InstructorSectionController;
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

Route::get('/categories', CategoryController::class);


/** INSTRUCTOR ROUTES */

Route::scopeBindings()->group(function () {
    Route::group([
        'middleware' => 'auth:sanctum',
        'prefix' => 'instructor'
    ], function() {
        // Courses basic information
        Route::controller(InstructorCourseController::class)->group(function () {
            Route::get('/courses', 'index');
            Route::post('/courses', 'store');
            Route::get('/c/{course}', 'show');
            Route::get('/c/{course}/basic', 'getBasicInfo');
            Route::put('/c/{course}/basic', 'updateBasicInfo');
            Route::put('/c/{course}/status', 'updateStatus');
            Route::post('/c/{course}/cover', 'cover');
            Route::get('/c/{course}/curriculum', 'curriculum');
        });

        // Course Sections
        Route::controller(InstructorSectionController::class)->group(function () {
            Route::post('/c/{course}/sections', 'store');
            Route::put('/c/{course}/sections/{section}', 'update');
            Route::delete('/c/{course}/sections/{section}', 'destroy');
        });

        // Course Lectures
        Route::controller(InstructorLectureController::class)->group(function () {
            Route::post('/c/{course}/sections/{section}/lectures', 'store');
            Route::put('/c/{course}/lectures/{lecture}', 'update');
            Route::delete('/c/{course}/lectures/{lecture}', 'destroy');
        });

        // Lectures content
        Route::controller(InstructorLectureContentController::class)->group(function () {
            Route::put('/c/{course}/lectures/{lecture}/article', 'update');
            Route::post('/lectures/{lecture}/chunk', 'upload');
        });
    });
});
