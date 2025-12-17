<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;

// Students API
Route::get('students', [StudentController::class, 'apiIndex']);
Route::post('students', [StudentController::class, 'apiStore']);
Route::get('students/{student}', [StudentController::class, 'apiShow']);
Route::put('students/{student}', [StudentController::class, 'apiUpdate']);
Route::delete('students/{student}', [StudentController::class, 'apiDestroy']);

// Courses API
Route::get('courses', [CourseController::class, 'apiIndex']);
Route::post('courses', [CourseController::class, 'apiStore']);
Route::get('courses/{course}', [CourseController::class, 'apiShow']);
Route::put('courses/{course}', [CourseController::class, 'apiUpdate']);
Route::delete('courses/{course}', [CourseController::class, 'apiDestroy']);