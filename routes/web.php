<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\Google2FaController;


Route::redirect('/', '/app/v1/login');

Route::prefix('app/v1/')->group(function () {
    Auth::routes([
        'verify'    => true,
    ]);
    Route::get('reload-captcha', [LoginController::class, 'reloadCaptcha']);
});

Route::group(['prefix' => '/google'], function () {
    Route::name('google.')->group(function () {
        Route::controller(Google2FaController::class)->group(function () {
            Route::get('/otp-validation', 'validation')->name('validation')->middleware('auth', 'web');
            Route::post('/validation-2fa', 'google2FaValidator')->name('validation.2fa');
        });
    });
});

