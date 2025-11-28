<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // 1. Total Net Worth = Saldo dari Accounts + Saldo dari Wallets
        $totalSaldoAccounts = Account::where('user_id', $userId)->sum('saldo');
        $totalSaldoWallets = Wallet::where('user_id', $userId)->sum('balance');
        $totalSaldo = $totalSaldoAccounts + $totalSaldoWallets;

        // 2. Pemasukan Bulan Ini (dari wallets ATAU accounts)
        $pemasukan = Transaction::where(function($q) use ($userId) {
                $q->whereHas('wallet', function($query) use ($userId) {
                    $query->where('user_id', $userId);
                })->orWhereHas('account', function($query) use ($userId) {
                    $query->where('user_id', $userId);
                });
            })
            ->whereHas('category', function($q) {
                $q->where('tipe', 'income');
            })
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // 3. Pengeluaran Bulan Ini (dari wallets ATAU accounts)
        $pengeluaran = Transaction::where(function($q) use ($userId) {
                $q->whereHas('wallet', function($query) use ($userId) {
                    $query->where('user_id', $userId);
                })->orWhereHas('account', function($query) use ($userId) {
                    $query->where('user_id', $userId);
                });
            })
            ->whereHas('category', function($q) {
                $q->where('tipe', 'expense');
            })
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // 4. Recent Activity: Transactions + Wallet Creation
        $recentTransactions = Transaction::with(['category', 'account', 'wallet'])
            ->where(function($q) use ($userId) {
                $q->whereHas('wallet', function($query) use ($userId) {
                    $query->where('user_id', $userId);
                })->orWhereHas('account', function($query) use ($userId) {
                    $query->where('user_id', $userId);
                });
            })
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get()
            ->map(function($transaction) {
                return [
                    'type' => 'transaction',
                    'id' => $transaction->id,
                    'transaction_type' => $transaction->type,
                    'amount' => $transaction->amount,
                    'date' => $transaction->date,
                    'description' => $transaction->description,
                    'category' => $transaction->category,
                    'wallet' => $transaction->wallet,
                    'account' => $transaction->account,
                    'created_at' => $transaction->created_at,
                    'sort_date' => $transaction->created_at,
                ];
            });

        // Recent Wallet Creation
        $recentWallets = Wallet::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function($wallet) {
                return [
                    'type' => 'wallet',
                    'id' => $wallet->id,
                    'name' => $wallet->name,
                    'balance' => $wallet->balance,
                    'wallet_type' => $wallet->wallet_type,
                    'created_at' => $wallet->created_at,
                    'date' => $wallet->created_at->format('Y-m-d'),
                    'sort_date' => $wallet->created_at,
                ];
            });

        // Gabungkan dan sort by created_at
        $recentActivity = $recentTransactions->concat($recentWallets)
            ->sortByDesc('sort_date')
            ->take(10)
            ->values();

        // 5. Chart Data (Spending Breakdown dari wallets ATAU accounts)
        $pieChartData = Transaction::with('category')
            ->where(function($q) use ($userId) {
                $q->whereHas('wallet', function($query) use ($userId) {
                    $query->where('user_id', $userId);
                })->orWhereHas('account', function($query) use ($userId) {
                    $query->where('user_id', $userId);
                });
            })
            ->whereHas('category', function($q) {
                $q->where('tipe', 'expense');
            })
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->selectRaw('category_id, sum(amount) as total')
            ->groupBy('category_id')
            ->get();

        $chartLabels = $pieChartData->map(fn($item) => $item->category->nama_kategori ?? 'Unknown')->toArray();
        $chartValues = $pieChartData->map(fn($item) => $item->total)->toArray();

        // 6. Dropdown Data
        $accounts = Account::where('user_id', $userId)->get();
        $incomeCategories = Category::where('tipe', 'income')->get();
        
        // 4 Kategori Expense Tetap untuk Donut Chart yang Bagus
        $expenseCategories = Category::where('tipe', 'expense')
            ->whereIn('nama_kategori', ['Makanan & Minuman', 'Transportasi', 'Belanja', 'Lainnya'])
            ->get();
        
        // Jika kategori belum ada, buat otomatis
        if ($expenseCategories->count() < 4) {
            $defaultCategories = [
                ['nama_kategori' => 'Makanan & Minuman', 'tipe' => 'expense'],
                ['nama_kategori' => 'Transportasi', 'tipe' => 'expense'],
                ['nama_kategori' => 'Belanja', 'tipe' => 'expense'],
                ['nama_kategori' => 'Lainnya', 'tipe' => 'expense'],
            ];
            
            foreach ($defaultCategories as $cat) {
                Category::firstOrCreate(
                    ['nama_kategori' => $cat['nama_kategori'], 'tipe' => $cat['tipe']],
                    $cat
                );
            }
            
            $expenseCategories = Category::where('tipe', 'expense')
                ->whereIn('nama_kategori', ['Makanan & Minuman', 'Transportasi', 'Belanja', 'Lainnya'])
                ->get();
        }

        // 7. Wallets Data
        $wallets = Wallet::where('user_id', $userId)->get();

        return view('dashboard', compact(
            'totalSaldo',
            'pemasukan',
            'pengeluaran',
            'recentActivity',
            'chartLabels',
            'chartValues',
            'accounts',
            'incomeCategories',
            'expenseCategories',
            'wallets'
        ));
    }
}