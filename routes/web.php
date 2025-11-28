<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\GeminiController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home.show');

// Auth Routes
Route::get('/login', function () {
    return view('login');
})->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Protected Routes (Require Authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Chat with Gyro
    Route::post('/chat', [GeminiController::class, 'ask'])->name('chat.ask');
    
    // Transactions
    Route::post('/transactions/store', [TransactionController::class, 'storeWeb'])->name('transactions.store');
    
    // Wallets
    Route::post('/wallets', [WalletController::class, 'store'])->name('wallets.store');
    Route::delete('/wallets/{id}', [WalletController::class, 'destroy'])->name('wallets.destroy');
});