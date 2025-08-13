<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CaptureHistoryApiController;
use App\Http\Controllers\Api\HistoryActivityApiController;


Route::post('/v1/register', [AuthApiController::class, 'register']);
Route::post('/v1/login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/v1/analytics/capture', [HistoryActivityApiController::class, 'store']);
    Route::get('/v1/analytics/history', [HistoryActivityApiController::class, 'index']);
    Route::post('/v1/image/captures', [CaptureHistoryApiController::class, 'store']);
    Route::get('/v1/image/captures/{analytic_id}', [CaptureHistoryApiController::class, 'index']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
