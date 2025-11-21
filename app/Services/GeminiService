<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        // Kita ambil dari config, bukan env() langsung (best practice caching)
        $this->apiKey = config('services.gemini.key');
        $this->baseUrl = config('services.gemini.base_url');
    }

    public function generateContent(string $prompt): ?string
    {
        // Pakai model flash biar cepet. Ganti ke 'gemini-1.5-pro' kalau butuh lebih pinter.
        $url = "{$this->baseUrl}/models/gemini-1.5-flash:generateContent?key={$this->apiKey}";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);

        if ($response->failed()) {
            // Lempar error biar ditangkep Controller
            $response->throw();
        }

        // Parsing JSON response dari Google
        return $response['candidates'][0]['content']['parts'][0]['text'] ?? null;
    }
}