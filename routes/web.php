<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OAuthClientController;
use App\Http\Controllers\PasswordResetController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'createLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'createRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password', [PasswordResetController::class, 'createForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');

    Route::get('/reset-password/{token}', [PasswordResetController::class, 'createResetPassword'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.store');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/oauth/clients', [OAuthClientController::class, 'index'])->name('oauth.clients.index');
    Route::post('/oauth/clients', [OAuthClientController::class, 'store'])->name('oauth.clients.store');
    Route::delete('/oauth/clients/{clientId}', [OAuthClientController::class, 'destroy'])->name('oauth.clients.destroy');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
