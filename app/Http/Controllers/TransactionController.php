<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Account;
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
            'account_id' => 'required|exists:accounts,id',
            'description' => 'nullable|string',
            'source' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            // 1. Save Transaction
            Transaction::create([
                'user_id' => Auth::id(),
                'type' => $validated['type'],
                'amount' => $validated['amount'],
                'date' => $validated['date'],
                'category_id' => $validated['category_id'],
                'account_id' => $validated['account_id'],
                'description' => $validated['description'] ?? $validated['source'] ?? null,
            ]);

            // 2. Update Account Balance
            $account = Account::findOrFail($validated['account_id']);

            if ($validated['type'] === 'income') {
                $account->increment('saldo', $validated['amount']);
            } else {
                $account->decrement('saldo', $validated['amount']);
            }
        });

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil disimpan & Saldo diupdate! 🎉');
    }

    public function storeWeb(Request $request)
    {
        return $this->store($request);
    }

    public function destroy($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);

        DB::transaction(function () use ($transaction) {
            // Reverse account balance
            $account = Account::find($transaction->account_id);

            if ($account) {
                if ($transaction->type === 'income') {
                    $account->decrement('saldo', $transaction->amount);
                } else {
                    $account->increment('saldo', $transaction->amount);
                }
            }

            $transaction->delete();
        });

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus!');
    }
}