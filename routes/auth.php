<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::post('/session', [AuthenticatedSessionController::class, 'store'])
                ->middleware('guest')
                ->name('login');

Route::delete('/session', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware('auth')
                ->name('logout');
