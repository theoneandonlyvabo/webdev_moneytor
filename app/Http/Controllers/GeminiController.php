<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeminiService;
use Illuminate\Support\Facades\Log;

class GeminiController extends Controller
{
    protected $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function ask(Request $request)
    {
        try {
            // Validasi input (support both 'message' and 'question' for compatibility)
            $userMessage = $request->input('question') ?? $request->input('message');
            
            if (empty($userMessage)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pertanyaan tidak boleh kosong.'
                ], 400);
            }

            // Generate response dari Gemini dengan personality Gyro
            $answer = $this->gemini->generateContent($userMessage);

            if (!$answer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mendapatkan response dari AI.'
                ], 500);
            }

            // Return format yang compatible dengan frontend
            return response()->json([
                'success' => true,
                'data' => [
                    'answer' => $answer
                ],
                'reply' => $answer // Backward compatibility
            ]);

        } catch (\Exception $e) {
            Log::error('Gemini API Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Waduh, ada masalah nih. Coba lagi nanti ya! 🙏',
                'reply' => 'Waduh, ada masalah nih. Coba lagi nanti ya! 🙏'
            ], 500);
        }
    }
}