<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/email/verify/{id}/{hash}', [RegisterController::class, 'emailVerificationRequest'])
        ->middleware('signed')
        ->name('verification.verify');

Route::get('/email/verify-success', [RegisterController::class, 'emailVerificationSuccess'])
        ->name('verification.success');




    
        
