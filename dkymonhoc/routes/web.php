<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect('/enrollments'));

Route::resource('students', StudentController::class)->only(['index', 'create', 'store', 'destroy']);
Route::resource('courses', CourseController::class)->only(['index', 'create', 'store', 'destroy']);
Route::resource('enrollments', EnrollmentController::class)->only(['index', 'create', 'store', 'destroy']);
