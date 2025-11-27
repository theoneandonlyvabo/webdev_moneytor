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
            'password' => Hash::make('password'),
        ]);

        // 2. Buat Akun (Dompet)
        $cash = Account::create([
            'user_id' => $user->id,
            'nama_akun' => 'Tunai / Dompet',
            'saldo' => 5000000
        ]);
        
        $bank = Account::create([
            'user_id' => $user->id,
            'nama_akun' => 'Bank BCA',
            'saldo' => 15000000
        ]);

        $ewallet = Account::create([
            'user_id' => $user->id,
            'nama_akun' => 'GoPay',
            'saldo' => 250000
        ]);

        // 3. Buat Kategori
        // Income
        $catGaji = Category::create(['nama_kategori' => 'Gaji Bulanan', 'tipe' => 'income']);
        $catBonus = Category::create(['nama_kategori' => 'Bonus / THR', 'tipe' => 'income']);
        $catFreelance = Category::create(['nama_kategori' => 'Freelance', 'tipe' => 'income']);
        
        // Expense
        $catMakan = Category::create(['nama_kategori' => 'Makanan & Minuman', 'tipe' => 'expense']);
        $catTransport = Category::create(['nama_kategori' => 'Transportasi', 'tipe' => 'expense']);
        $catBelanja = Category::create(['nama_kategori' => 'Belanja Bulanan', 'tipe' => 'expense']);
        $catHiburan = Category::create(['nama_kategori' => 'Hiburan / Nonton', 'tipe' => 'expense']);
        $catTagihan = Category::create(['nama_kategori' => 'Tagihan & Listrik', 'tipe' => 'expense']);

        // 4. Buat 50 Transaksi Dumy
        $accounts = [$cash, $bank, $ewallet];
        $categories = [$catMakan, $catTransport, $catBelanja, $catHiburan, $catTagihan, $catGaji, $catBonus, $catFreelance];

        for ($i = 0; $i < 50; $i++) {
            $randomAccount = $accounts[array_rand($accounts)];
            $randomCategory = $categories[array_rand($categories)];
            
            $amount = match($randomCategory->tipe) {
                'income' => rand(1000000, 5000000),
                'expense' => rand(15000, 200000),
            };

            // INI BAGIAN YANG TADI SALAH (Sekarang sudah diperbaiki ke Bahasa Inggris)
            Transaction::create([
                'user_id' => $user->id,
                'account_id' => $randomAccount->id,
                'category_id' => $randomCategory->id,
                'date' => Carbon::now()->subDays(rand(0, 30)), // Dulu 'tanggal'
                'amount' => $amount,                           // Dulu 'jumlah'
                'description' => 'Transaksi otomatis #' . ($i + 1), // Dulu 'deskripsi'
                'type' => $randomCategory->tipe
            ]);

            // Update Saldo
            if ($randomCategory->tipe == 'income') {
                $randomAccount->increment('saldo', $amount);
            } else {
                $randomAccount->decrement('saldo', $amount);
            }
        }
    }
}