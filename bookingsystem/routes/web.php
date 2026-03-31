<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect('/appointments'));

Route::get('/appointments', [AppointmentController::class, 'index']);
Route::get('/appointments/create', [AppointmentController::class, 'create']);
Route::post('/appointments', [AppointmentController::class, 'store']);
Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy']);
