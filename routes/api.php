<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use Facade\FlareClient\Api;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ping', function (Request $request) {
    return [
        'pong' => true
    ];
});

Route::post('/todo', [ApiController::class, 'store']);

Route::get('/todos', [ApiController::class, 'index']);

Route::get('/todo/{id}', [ApiController::class, 'show']);

Route::put('/todo/{id}', [ApiController::class, 'update']);

Route::delete('/todo/{id}', [ApiController::class, 'delete']);