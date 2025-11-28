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
            $question = $request->input('question');
            
            if (empty($question)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pertanyaan tidak boleh kosong.'
                ], 400);
            }

            // Generate response dari Gemini
            $answer = $this->gemini->generateContent($question);

            if (!$answer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mendapatkan response dari AI.'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'answer' => $answer
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Gemini API Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}