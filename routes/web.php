<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MoneytorController;

Route::get('/', function () {
    return view('landing');
});

Route::get('/chat', function () {
    return view('chat');
})->name('chat');

Route::get('/home', [MoneytorController::class, 'home_controller'])->name('home.show');
Route::get('/dashboard', [MoneytorController::class, 'dashboard_controller'])->name('dashboard.show');



Route::get('/login', function () {
    return view('login');
})->name('login.show');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');