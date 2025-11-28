<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
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
            'category_id' => 'required|exists:categories,id',
            'wallet_id' => 'required|exists:wallets,id',
            'description' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            // 1. Save Transaction
            Transaction::create([
                'user_id' => Auth::id(),
                'type' => $validated['type'],
                'amount' => $validated['amount'],
                'date' => $validated['date'],
                'category_id' => $validated['category_id'],
                'wallet_id' => $validated['wallet_id'],
                'description' => $validated['description'] ?? null,
            ]);

            // 2. Update Wallet Balance
            $wallet = Wallet::findOrFail($validated['wallet_id']);

            if ($validated['type'] === 'income') {
                $wallet->increment('balance', $validated['amount']);
            } else {
                $wallet->decrement('balance', $validated['amount']);
            }
        });

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil disimpan & Saldo diupdate! 🎉');
    }

    public function destroy($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);

        DB::transaction(function () use ($transaction) {
            // Reverse wallet balance
            $wallet = Wallet::find($transaction->wallet_id);

            if ($wallet) {
                if ($transaction->type === 'income') {
                    $wallet->decrement('balance', $transaction->amount);
                } else {
                    $wallet->increment('balance', $transaction->amount);
                }
            }

            $transaction->delete();
        });

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus!');
    }
}