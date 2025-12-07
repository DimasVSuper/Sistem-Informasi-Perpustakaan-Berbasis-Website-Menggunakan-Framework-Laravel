<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    BerandaController,
    Auth\LoginController,
    Auth\RegisterController,
    DashboardController
};

Route::middleware(['guest'])->group(function () {
    // Route Beranda untuk Guest
    Route::get('/', [BerandaController::class, 'index'])->name('home');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.show');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.show');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware(['admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Other authenticated routes...
});

Route::middleware(['pustakawan'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware(['anggota'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
