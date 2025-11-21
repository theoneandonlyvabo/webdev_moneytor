<?php

namespace App\Http\Controllers; // <--- Biarin bawaan Laravel

use Illuminate\Http\Request;
use App\Services\GeminiService; // <--- Jangan lupa import Service lo
use Illuminate\Support\Facades\Log;

class GeminiController extends Controller // <--- Pastikan extends Controller
{
    protected $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function ask(Request $request)
    {
        // ... paste logic ask() lo disini ...
    }
}