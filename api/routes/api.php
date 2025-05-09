<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TrainingsController;
use App\Http\Controllers\NutritionPlansController;
use App\Http\Controllers\ProgressLogsController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'userProfile']);
    Route::apiResource('/treinos', TrainingsController::class);
    Route::get('/progresso', [ProgressLogsController::class, 'index']);
});

Route::apiResource('/planos', NutritionPlansController::class);
