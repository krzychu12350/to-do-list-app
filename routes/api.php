<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\TaskHistoryController;
use App\Http\Controllers\API\TaskTokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')
        ->delete('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')
    ->name('api')
    ->apiResource('tasks', TaskController::class);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tasks/{task}/history', [TaskHistoryController::class, 'index']);
    Route::post('/tasks/{task}/share', [TaskTokenController::class, 'generateLink']);
});