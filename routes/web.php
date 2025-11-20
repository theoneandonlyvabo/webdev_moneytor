<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MoneytorController;

Route::get('/', function () {
    return view('landing');
});

Route::get('/home', [MoneytorController::class, 'home_controller'])->name('home.show');
Route::get('/dashboard', [MoneytorController::class, 'dashboard_controller'])->name('dashboard.show');