<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\Wallet; // <--- 1. WAJIB: Import Model Wallet di sini
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // --- LOGIKA LAMA (Tetap Dipertahankan) ---
        $totalSaldo = Account::where('user_id', $userId)->sum('saldo');

        // Hitung Pemasukan
        $pemasukan = Transaction::whereHas('account', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereHas('category', function($q) {
                $q->where('tipe', 'income');
            })
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // Hitung Pengeluaran
        $pengeluaran = Transaction::whereHas('account', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereHas('category', function($q) {
                $q->where('tipe', 'expense');
            })
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // 5 Transaksi Terakhir
        $recentTransactions = Transaction::with(['category', 'account'])
            ->whereHas('account', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        // Grafik Donat
        $pieChartData = Transaction::with('category')
            ->whereHas('account', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereHas('category', function($q) {
                $q->where('tipe', 'expense');
            })
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->selectRaw('category_id, sum(amount) as total')
            ->groupBy('category_id')
            ->get();
            
        $chartLabels = $pieChartData->map(fn($item) => $item->category->nama_kategori)->toArray();
        $chartValues = $pieChartData->map(fn($item) => $item->total)->toArray();

        // Data Lama
        $accounts = Account::where('user_id', $userId)->get();
        $incomeCategories = Category::where('tipe', 'income')->get();
        $expenseCategories = Category::where('tipe', 'expense')->get();

        // --- 2. TAMBAHAN BARU: DATA WALLETS ---
        // Ambil data dompet untuk fitur 'Kantong' baru
        $wallets = \App\Models\Wallet::where('user_id', $userId)->get();
        // 3. Masukkan 'wallets' ke dalam compact()
        return view('dashboard', compact(
            'totalSaldo', 'pemasukan', 'pengeluaran', 'recentTransactions', 
            'chartLabels', 'chartValues',
            'accounts', 'incomeCategories', 'expenseCategories',
            'wallets' // <--- Jangan lupa ini!
        ));
    }
}