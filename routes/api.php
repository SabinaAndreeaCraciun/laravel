<?php

use App\Http\Controllers\Api\StudentApiController;
use App\Http\Controllers\Api\CourseApiController;
use Illuminate\Support\Facades\Route;

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