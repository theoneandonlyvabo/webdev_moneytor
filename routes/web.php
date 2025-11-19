<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing_page');
});

// If you want to use a Controller (better practice for complexity):
/*
Route::get('/', [LandingPageController::class, 'index'])->name('landing');
*/