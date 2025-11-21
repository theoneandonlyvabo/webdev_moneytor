<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Jangan lupa import Controller-nya!
use App\Http\Controllers\GeminiController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// INI JALUR UTAMA KITA
Route::post('/chat', [GeminiController::class, 'ask']);