<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect('/orders'));

Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/create', [OrderController::class, 'create']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{order}', [OrderController::class, 'show']);
Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus']);
Route::delete('/orders/{order}', [OrderController::class, 'destroy']);
