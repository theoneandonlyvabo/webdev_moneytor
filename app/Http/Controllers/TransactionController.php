<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Account;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'account_id' => 'required|exists:accounts,id',
            'description' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Simpan transaksi
            Transaction::create([
                'user_id' => auth()->id(),
                'type' => $request->type,
                'amount' => $request->amount,
                'date' => $request->date,
                'category_id' => $request->category_id,
                'account_id' => $request->account_id,  // ← Ini yang penting
                'description' => $request->description,
            ]);

            // 2. Update saldo di account
            $account = Account::findOrFail($request->account_id);
            
            if ($request->type === 'income') {
                $account->saldo += $request->amount;
            } else {
                $account->saldo -= $request->amount;
            }
            
            $account->save();
        });

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil disimpan!');
    }
}