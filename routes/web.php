<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MoneytorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;  // ← TAMBAHKAN INI
use App\Http\Controllers\TransactionController; // ← TAMBAHKAN INI







// GANTI JADI INI:
Route::get('/', [HomeController::class, 'index'])->name('home.show');
Route::get('/chat', function () {
    return view('chat');
})->name('chat');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/transactions/store', [TransactionController::class, 'storeWeb'])->name('transactions.store');// 1. REGISTER (POST) - Tambahkan ->name('register')
Route::post('/register', [AuthController::class, 'register'])->name('register');

// 2. LOGIN (POST) - Tambahkan ->name('login')
Route::post('/login', [AuthController::class, 'login'])->name('login');

// 3. LOGOUT (POST) - Tambahkan ->name('logout')
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 4. TAMPILAN LOGIN (GET)
// Biarkan saja namanya 'login.show' atau ganti jadi 'login.view' tidak masalah
Route::get('/login', function () {
    return view('login');
})->name('login.show');
Route::post('/transactions/store', [TransactionController::class, 'storeWeb'])->name('transactions.store');

Route::post('/wallets', [WalletController::class, 'store'])->name('wallets.store');
    Route::delete('/wallets/{id}', [WalletController::class, 'destroy'])->name('wallets.destroy');