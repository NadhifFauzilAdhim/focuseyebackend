<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('/student/{user:slug}', [DashboardController::class, 'show'])->middleware(['auth'])->name('student.detail');
Route::get('/students', \App\Livewire\StudentManager::class)->middleware(['auth'])->name('students.index');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/email/verify/{id}/{hash}', [RegisterController::class, 'emailVerificationRequest'])
    ->middleware('signed')
    ->name('verification.verify');

Route::get('/email/verify-success', [RegisterController::class, 'emailVerificationSuccess'])
    ->name('verification.success');
