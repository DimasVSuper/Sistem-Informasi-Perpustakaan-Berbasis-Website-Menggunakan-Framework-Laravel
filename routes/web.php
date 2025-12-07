<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    BerandaController,
    DashboardController,
    CategoryController,
    BookController,
    LoanController,
    UserController,
    FineController,
    Auth\LoginController,
    Auth\RegisterController,
};

// ============================================
// PUBLIC ROUTES (untuk guest dan authenticated)
// ============================================
Route::get('/', [BerandaController::class, 'index'])->name('home');

Route::middleware(['guest'])->group(function () {
    // Authentication
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
});

// ============================================
// LOGOUT ROUTE (untuk semua yang sudah login)
// ============================================
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ============================================
// ADMIN ROUTES
// ============================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // User/Pustakawan Management
    Route::resource('users', UserController::class);
});

// ============================================
// PUSTAKAWAN ROUTES
// ============================================
Route::middleware(['auth', 'pustakawan'])->prefix('pustakawan')->name('pustakawan.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Book Management
    Route::resource('books', BookController::class);
    
    // Category Management
    Route::resource('categories', CategoryController::class);
    
    // Loan Management
    Route::resource('loans', LoanController::class);
    
    // Fine Management
    Route::resource('fines', FineController::class);
});

// ============================================
// ANGGOTA ROUTES
// ============================================
Route::middleware(['auth', 'anggota'])->prefix('anggota')->name('anggota.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Loan Management (limited for anggota)
    Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
    Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
    Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
    Route::get('/loans/{loan}', [LoanController::class, 'show'])->name('loans.show');
    Route::put('/loans/{loan}', [LoanController::class, 'update'])->name('loans.update');
});
