<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;

Route::get('/', function () {
    return view('welcome');
});

// CSV export routes (register before resource routes so 'export' isn't treated as {student}/{course})
Route::get('students/export', [StudentController::class, 'export'])->name('students.export');
Route::get('courses/export', [CourseController::class, 'export'])->name('courses.export');

Route::resource('students', StudentController::class);
Route::resource('courses', CourseController::class);
    