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

        // 1. Total Saldo
        $totalSaldo = Account::where('user_id', $userId)->sum('saldo');

        // 2. Pemasukan Bulan Ini
        $pemasukan = Transaction::whereHas('account', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereHas('category', function($q) {
                $q->where('tipe', 'income');
            })
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // 3. Pengeluaran Bulan Ini
        $pengeluaran = Transaction::whereHas('account', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereHas('category', function($q) {
                $q->where('tipe', 'expense');
            })
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // 4. Recent Transactions
        $recentTransactions = Transaction::with(['category', 'account'])
            ->whereHas('account', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        // 5. Chart Data
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

        // 6. Dropdown Data
        $accounts = Account::where('user_id', $userId)->get();
        $incomeCategories = Category::where('tipe', 'income')->get();
        $expenseCategories = Category::where('tipe', 'expense')->get();

        // 7. Wallets Data
        $wallets = Wallet::where('user_id', $userId)->get();

        return view('dashboard', compact(
            'totalSaldo',
            'pemasukan',
            'pengeluaran',
            'recentTransactions',
            'chartLabels',
            'chartValues',
            'accounts',
            'incomeCategories',
            'expenseCategories',
            'wallets'
        ));
    }
}