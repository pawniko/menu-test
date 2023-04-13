<?php

use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Currency routes
Route::get('/currencies', [CurrencyController::class, 'index']);

// Order routes
Route::get('/orders/calculation', [OrderController::class, 'calculation']);
Route::post('/orders', [OrderController::class, 'store']);
