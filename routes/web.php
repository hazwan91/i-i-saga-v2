<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['guest'])->name('guest.')->group(function () {
    Route::get('login', [AuthController::class, 'create'])
        ->name('login.create');

    Route::post('login', [AuthController::class, 'store'])
        ->name('login.store');
});

Route::middleware(['auth', 'verified'])->name('auth.')->group(function () {
    Route::resource('', \App\Http\Controllers\Auth\Home\IndexController::class)
        ->only(['index'])
        ->names([
            'index' => 'home.index'
        ]);

    Route::post('logout', [AuthController::class, 'destroy'])
        ->name('logout');
});
