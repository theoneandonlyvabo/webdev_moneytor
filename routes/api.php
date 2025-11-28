<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeminiController;

// Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Route yang butuh Token (Harus Login dulu)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    // Pindahkan route transactions ke dalam sini biar aman (opsional)
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// INI JALUR UTAMA KITA
// Chat route - tidak perlu auth karena sudah di dashboard yang protected
Route::post('/chat', [GeminiController::class, 'ask']);