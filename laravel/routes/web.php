<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    // Routes yang tidak memerlukan middleware auth:web
    Route::get('login', 'LoginPage')->name('login');
    Route::post('auth/login/submit', 'LocalLoginSubmit')->name('login.submit');
    Route::get('platform/redirect', 'RedirectToPlatform')->name('platform.redirect');
    Route::get('google/callback', 'HandleGoogleCallback');
    Route::get('facebook/callback', 'HandleFacebookCallback');
    Route::get('github/callback', 'HandleGithubCallback');

    // Group route dengan prefix 'auth' dan middleware 'auth:web'
    Route::prefix('auth')->middleware(['auth:web'])->group(function () {
        Route::get('redirect', 'LocalRedirect')->name('redirect');
        Route::get('callback', 'LocalCallback')->name('callback');
    });

    
});
