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
        try {
            // Validasi input dari user
            $request->validate([
                'message' => 'required|string|max:1000'
            ]);

            $userMessage = $request->input('message');
            
            // Panggil Gemini Service
            $response = $this->gemini->generateContent($userMessage);

            // Return JSON response
            return response()->json([
                'success' => true,
                'reply' => $response ?? 'Maaf, gw lagi error nih. Coba lagi ya!'
            ]);

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Gemini API Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'reply' => 'Waduh, ada masalah nih. Coba lagi nanti ya! 🙏'
            ], 500);
        }
    }
}