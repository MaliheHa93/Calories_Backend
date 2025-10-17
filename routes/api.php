<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FoodController;
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
use App\Http\Controllers\Api\SimulationController;

Route::prefix('simulate')->group(function () {
    Route::post('/register-meal', [SimulationController::class, 'registerMeal']);
    Route::get('/daily-summary', [SimulationController::class, 'dailySummary']);
    Route::get('/stats', [SimulationController::class, 'weeklyStats']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
