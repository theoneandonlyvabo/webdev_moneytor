<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Account;
use App\Models\Wallet;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'wallet_id' => 'required|exists:wallets,id',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'source' => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // Jika category_id ada (dari form), pakai itu. Jika tidak, buat default
                if (isset($validated['category_id']) && $validated['category_id']) {
                    $category = Category::findOrFail($validated['category_id']);
                } else {
                    // Buat atau ambil kategori default berdasarkan type
                    $categoryName = $validated['type'] === 'income' ? 'Pemasukan Lainnya' : 'Pengeluaran Lainnya';
                    $category = Category::firstOrCreate(
                        ['nama_kategori' => $categoryName, 'tipe' => $validated['type']],
                        ['nama_kategori' => $categoryName, 'tipe' => $validated['type']]
                    );
                }

                // 2. Update Wallet Balance DULU (dompet baru) - sebelum save transaction
                $wallet = Wallet::findOrFail($validated['wallet_id']);

                if ($validated['type'] === 'income') {
                    $wallet->increment('balance', $validated['amount']);
                } else {
                    // Pastikan balance tidak negatif
                    if ($wallet->balance < $validated['amount']) {
                        throw new \Exception('Saldo tidak cukup! Saldo saat ini: Rp ' . number_format($wallet->balance, 0, ',', '.'));
                    }
                    $wallet->decrement('balance', $validated['amount']);
                }

                // 1. Save Transaction SETELAH update balance
                Transaction::create([
                    'user_id' => Auth::id(),
                    'type' => $validated['type'],
                    'amount' => $validated['amount'],
                    'date' => $validated['date'],
                    'category_id' => $category->id,
                    'wallet_id' => $validated['wallet_id'],
                    'account_id' => null, // Tidak pakai account_id lagi, pakai wallet_id
                    'description' => $validated['description'] ?? $validated['source'] ?? null,
                ]);
            });

            return redirect()->route('dashboard')->with('success', 'Transaksi berhasil disimpan & Saldo diupdate! 🎉');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage() ?: 'Terjadi kesalahan saat menyimpan transaksi.');
        }
    }

    public function storeWeb(Request $request)
    {
        return $this->store($request);
    }

    public function destroy($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);

        DB::transaction(function () use ($transaction) {
            // Reverse wallet balance (dompet baru)
            if ($transaction->wallet_id) {
                $wallet = Wallet::find($transaction->wallet_id);
                if ($wallet) {
                    if ($transaction->type === 'income') {
                        $wallet->decrement('balance', $transaction->amount);
                    } else {
                        $wallet->increment('balance', $transaction->amount);
                    }
                }
            }
            
            // Backward compatibility: juga update account jika ada
            if ($transaction->account_id) {
                $account = Account::find($transaction->account_id);
                if ($account) {
                    if ($transaction->type === 'income') {
                        $account->decrement('saldo', $transaction->amount);
                    } else {
                        $account->increment('saldo', $transaction->amount);
                    }
                }
            }

            $transaction->delete();
        });

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus!');
    }
}