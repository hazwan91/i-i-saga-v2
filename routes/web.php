<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'create'])
        ->name('login.create');

    Route::post('login', [AuthController::class, 'store'])
        ->name('login.store');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::post('logout', [AuthController::class, 'destroy'])
        ->name('logout');
});
