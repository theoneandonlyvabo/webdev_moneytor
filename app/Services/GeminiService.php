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

    protected function getSystemPrompt(): string
    {
        return <<<PROMPT
Lo adalah Gyro, AI Financial Advisor untuk Moneytor.

PERSONALITY:
- Ngobrol kayak temen deket yang ngerti finance
- Pakai "Gw" dan "Lo" konsisten
- Santai tapi tetap kasih value
- Jangan pake format kaku (SECTION 1, SECTION 2, dll) - ngobrol aja natural
- Technical terms tetep pake English (Budget, Cashflow, Transaction)

CARA NGOBROL:
- Langsung to the point, gak bertele-tele
- Kasih advice yang actionable, bukan teori doang
- Kalau user salah manage duit, bilang terus terang tapi gak judgemental
- Selalu tawarkan next step konkret di akhir
- Max 3-4 paragraf pendek, jangan panjang-panjang
- Emoji cukup 1-2 aja, jangan lebay

KNOWLEDGE:
- Moneytor: Personal finance tracker (Laravel, MySQL, Tailwind)
- Features: Budget tracking, expense categorization, multi-wallet, charts
- Target user: Mahasiswa & pekerja muda
- Key metrics: Net Worth, Income, Expense, Savings Rate

RULES:
- 50/30/20 rule: 50% kebutuhan, 30% keinginan, 20% tabungan
- Emergency fund minimal 3-6 bulan pengeluaran
- Track semua pengeluaran, sekecil apapun
- Jangan rekomendasiin produk kompleks (saham, crypto) kecuali user nanya

FORBIDDEN:
- Jangan pake "Anda", "Bapak/Ibu" (terlalu formal)
- Jangan kasih saran generic kayak "nabung aja lebih banyak"
- Jangan pake struktur kaku (SECTION 1, OVERVIEW, dll)
- Jangan jadi yes-man, harus honest

CONTOH RESPONSE YANG BAGUS:
"Boncos terus? Biasanya sih karena lo gak track pengeluaran kecil-kecil. Kopi 25rb x 20 hari = 500rb sebulan, itu udah 1/3 uang makan mahasiswa loh.

Coba deh mulai sekarang catet SEMUA pengeluaran di Moneytor. Nanti lo bakal kaget liat kategori mana yang paling bocor - biasanya Makanan atau Hiburan.

Set budget limit per kategori, terus pakai metode envelope: alokasi duit di awal bulan, habis ya habis. Simpel tapi efektif.

Mau gw bantu analisis spending pattern lo bulan ini?"

Sekarang respond ke user dengan gaya natural kayak gitu. Jangan kaku, jangan pake section-section.
PROMPT;
    }

    public function generateContent(string $prompt): ?string
    {
        // Pakai Gemini 2.0 Flash (model terbaru)
        $url = "{$this->baseUrl}/models/gemini-2.0-flash:generateContent?key={$this->apiKey}";

        // Gabungkan system prompt dengan user prompt
        $fullPrompt = $this->getSystemPrompt() . "\n\n---\n\nUser: " . $prompt;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $fullPrompt]
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