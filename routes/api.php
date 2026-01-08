<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StudentApiController;
use App\Http\Controllers\Api\CourseApiController;
use Illuminate\Support\Facades\Route;

// Public routes (no authentication required)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // Students API
    Route::get('students/export', [StudentApiController::class, 'export'])->name('api.students.export');
    Route::apiResource('students', StudentApiController::class)->names([
        'index' => 'api.students.index',
        'store' => 'api.students.store',
        'show' => 'api.students.show',
        'update' => 'api.students.update',
        'destroy' => 'api.students.destroy',
    ]);

    // Courses API
    Route::get('courses/export', [CourseApiController::class, 'export'])->name('api.courses.export');
    Route::apiResource('courses', CourseApiController::class)->names([
        'index' => 'api.courses.index',
        'store' => 'api.courses.store',
        'show' => 'api.courses.show',
        'update' => 'api.courses.update',
        'destroy' => 'api.courses.destroy',
    ]);
});