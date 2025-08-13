<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CaptureHistoryApiController;
use App\Http\Controllers\Api\HistoryActivityApiController;


Route::post('/v1/register', [AuthApiController::class, 'register']);
Route::post('/v1/login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->post('/v1/analytics/capture', [HistoryActivityApiController::class, 'store']);
Route::middleware('auth:sanctum')->post('/v1/image/captures', [CaptureHistoryApiController::class, 'store']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
