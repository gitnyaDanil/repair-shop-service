<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    ServiceController
};

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['guest']], function() {
    Route::view('/login', 'pages.LoginIndex')->name('login');
    Route::post('login', [AuthController::class, 'attempt'])->name('auth.login-attempt');
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('/', function () {
        return view('App');
    })->name('app');

    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('/service', [ServiceController::class, 'index'])->name('service.index');
    Route::post('/service', [ServiceController::class, 'store'])->name('service.store');
});

