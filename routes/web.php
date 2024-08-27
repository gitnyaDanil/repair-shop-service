<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    CustomerController,
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

    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::post('/customer', [CustomerController::class, 'store'])->name('customer.store');
});

