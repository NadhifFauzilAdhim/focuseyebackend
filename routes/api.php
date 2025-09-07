<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CaptureHistoryApiController;
use App\Http\Controllers\Api\HistoryActivityApiController;
use App\Http\Controllers\Api\SummaryApiController;
use App\Http\Controllers\Api\NewsController;

Route::post('/v1/register', [AuthApiController::class, 'register']);
Route::post('/v1/login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/v1/analytics/capture', [HistoryActivityApiController::class, 'store']);
    Route::get('/v1/analytics/history', [HistoryActivityApiController::class, 'index']);
    Route::delete('/v1/analytics/history/{analytic}', [HistoryActivityApiController::class, 'destroy']);
    Route::post('/v1/image/captures', [CaptureHistoryApiController::class, 'store']);
    Route::get('/v1/image/captures/{analytic_id}', [CaptureHistoryApiController::class, 'index']);
    Route::get('/v1/logout', [AuthApiController::class, 'logout']);
    Route::get('/v1/analytics/{analytic}/analyze', [SummaryApiController::class, 'generateSummary']);
    Route::get('/v1/news', [NewsController::class, 'getNews']);
});

