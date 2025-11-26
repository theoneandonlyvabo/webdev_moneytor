<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User Login
        $user = User::create([
            'name' => 'Admin Moneytor',
            'email' => 'admin@moneytor.com',
            'password' => Hash::make('password'), // Passwordnya: password
        ]);

        // 2. Buat Akun (Dompet)
        $cash = Account::create([
            'user_id' => $user->id,
            'nama_akun' => 'Tunai / Dompet',
            'saldo' => 5000000 // Saldo awal 5 Juta
        ]);
        
        $bank = Account::create([
            'user_id' => $user->id,
            'nama_akun' => 'Bank BCA',
            'saldo' => 15000000 // Saldo awal 15 Juta
        ]);

        $ewallet = Account::create([
            'user_id' => $user->id,
            'nama_akun' => 'GoPay',
            'saldo' => 250000 // Saldo awal 250rb
        ]);

        // 3. Buat Kategori
        // Kategori Pengeluaran
        $catMakan = Category::create(['nama_kategori' => 'Makanan & Minuman', 'tipe' => 'expense']);
        $catTransport = Category::create(['nama_kategori' => 'Transportasi', 'tipe' => 'expense']);
        $catBelanja = Category::create(['nama_kategori' => 'Belanja Bulanan', 'tipe' => 'expense']);
        $catHiburan = Category::create(['nama_kategori' => 'Hiburan / Nonton', 'tipe' => 'expense']);
        
        // Kategori Pemasukan
        $catGaji = Category::create(['nama_kategori' => 'Gaji Bulanan', 'tipe' => 'income']);
        $catBonus = Category::create(['nama_kategori' => 'Bonus / THR', 'tipe' => 'income']);

        // 4. Buat 50 Transaksi Dumy (Acak)
        $accounts = [$cash, $bank, $ewallet];
        $categories = [$catMakan, $catTransport, $catBelanja, $catHiburan, $catGaji, $catBonus];

        for ($i = 0; $i < 50; $i++) {
            // Pilih akun dan kategori acak
            $randomAccount = $accounts[array_rand($accounts)];
            $randomCategory = $categories[array_rand($categories)];
            
            // Tentukan jumlah duit (kalau gaji gede, kalau makan kecil)
            $amount = match($randomCategory->tipe) {
                'income' => rand(1000000, 5000000),
                'expense' => rand(15000, 200000),
            };

            // Buat Transaksi
            Transaction::create([
                'account_id' => $randomAccount->id,
                'category_id' => $randomCategory->id,
                'tanggal' => Carbon::now()->subDays(rand(0, 30)), // Tanggal acak 30 hari terakhir
                'jumlah' => $amount,
                'deskripsi' => 'Transaksi otomatis #' . ($i + 1)
            ]);

            // Update Saldo Akun (Logika Sederhana)
            if ($randomCategory->tipe == 'income') {
                $randomAccount->increment('saldo', $amount);
            } else {
                $randomAccount->decrement('saldo', $amount);
            }
        }
    }
}