<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    // CSV export routes (register before resource routes so 'export' isn't treated as {student}/{course})
    Route::get('students/export', [StudentController::class, 'export'])->name('students.export');
    Route::get('courses/export', [CourseController::class, 'export'])->name('courses.export');

    Route::resource('students', StudentController::class);
    Route::resource('courses', CourseController::class);
});
    