<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MoneytorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;


Route::get('/', [HomeController::class, 'index'])->name('home.show');
Route::get('/chat', function () {
return view('chat');
})->name('chat');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
});

// LOGIN
Route::post('/login', [AuthController::class, 'login'])->name('login');

// LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//TAMPILAN LOGIN
Route::get('/login', function () {
    return view('login');
})->name('login.show');
Route::post('/transactions/store', [TransactionController::class, 'storeWeb'])->name('transactions.store');

Route::post('/wallets', [WalletController::class, 'store'])->name('wallets.store');
    Route::delete('/wallets/{id}', [WalletController::class, 'destroy'])->name('wallets.destroy');