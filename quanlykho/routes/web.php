<?php

use App\Http\Controllers\DepotController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DepotController::class, 'index']);
Route::get('/depots', [DepotController::class, 'index']);
Route::get('/depots/create', [DepotController::class, 'create']);
Route::post('/depots/store', [DepotController::class, 'store']);
Route::delete('/depots/{id}', [DepotController::class, 'destroy']);
