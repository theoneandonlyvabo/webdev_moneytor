<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        // 1. AMBIL DATA KURS (Pakai Cache biar gak nembak API terus)
        $currencyRates = Cache::remember('live_rates_final_v2', 60 * 60, function () {
            
            $currencies = ['USD', 'SGD', 'JPY', 'EUR', 'GBP'];
            $data = [];

            try {
                // 2. TEMBAK API (Bypass SSL Verify)
                // Kita ambil base USD dulu karena API gratisan biasanya base-nya USD
                $response = Http::withoutVerifying()
                    ->timeout(5)
                    ->get("https://api.exchangerate-api.com/v4/latest/IDR");
                
                // 3. Jika Berhasil
                if ($response->successful()) {
                    $json = $response->json();
                    $rates = $json['rates'] ?? []; // Ambil array 'rates'

                    foreach ($currencies as $code) {
                        // Cek apakah mata uang ada di daftar
                        if (isset($rates[$code])) {
                            // Rumus: 1 Asing = 1 / Rate IDR
                            $rateIDR = 1 / $rates[$code];

                            // Simulasi naik/turun (Random kecil)
                            $changePercent = rand(-150, 150) / 100; // -1.5% s.d 1.5%
                            $changeAmount = $rateIDR * ($changePercent / 100);
                            
                            $data[] = [
                                'code' => $code . '/IDR',
                                'rate' => number_format($rateIDR, 2, ',', '.'),
                                'change' => number_format(abs($changeAmount), 2, ',', '.'), // Pakai ABS biar gak ada minus double
                                'percentage' => $changePercent,
                                'isUp' => $changePercent >= 0
                            ];
                        }
                    }
                    
                    // Kalau data kosong (misal key rates gak ketemu), lempar ke catch
                    if (empty($data)) {
                        throw new \Exception("Data kosong");
                    }

                    return $data;
                }
                
                // Kalau API Gagal
                return $this->getBackupData();

            } catch (\Exception $e) {
                // Kalau Internet Mati / Error
                return $this->getBackupData();
            }
        });

        // 2. HITUNG JUMLAH USER (Asli + 500)
        $totalUsers = User::count() + 500;

        // 3. KIRIM KE TAMPILAN
        return view('landing', compact('currencyRates', 'totalUsers'));
    }

    // Fungsi Data Cadangan (Anti Kosong)
    private function getBackupData() {
        return [
            ['code' => 'USD/IDR', 'rate' => '15.950,00', 'change' => '150,00', 'percentage' => 0.45, 'isUp' => true],
            ['code' => 'SGD/IDR', 'rate' => '11.850,00', 'change' => '50,00', 'percentage' => 0.12, 'isUp' => true],
            ['code' => 'JPY/IDR', 'rate' => '106,20', 'change' => '1,20', 'percentage' => -0.55, 'isUp' => false],
            ['code' => 'EUR/IDR', 'rate' => '17.100,00', 'change' => '200,00', 'percentage' => -1.15, 'isUp' => false],
            ['code' => 'GBP/IDR', 'rate' => '20.050,00', 'change' => '100,00', 'percentage' => 0.30, 'isUp' => true],
        ];
    }
}