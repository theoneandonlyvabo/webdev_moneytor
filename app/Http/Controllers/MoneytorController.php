<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Jika nanti pakai database, import model di sini: use App\Models\Product;

class MoneytorController extends Controller
{
    public function home_controller()
    {
        return view('landing'); 
    }

    public function dashboard_controller()
    {
        return view('dashboard'); 
    }
}