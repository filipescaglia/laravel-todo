<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ping', function (Request $request) {
    return ['pong' => true];
});
Route::get('/unauthenticated', function () {
    return ['error' => 'User not logged!'];
})->name('login');

Route::post('/user', [AuthController::class, 'create']);
Route::middleware('auth:sanctum')->get('/auth/logout', [AuthController::class, 'logout']);
Route::post('/auth', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('/todo', [ApiController::class, 'store']);

Route::get('/todos', [ApiController::class, 'index']);

Route::get('/todo/{id}', [ApiController::class, 'show']);

Route::middleware('auth:sanctum')->put('/todo/{id}', [ApiController::class, 'update']);

Route::middleware('auth:sanctum')->delete('/todo/{id}', [ApiController::class, 'delete']);