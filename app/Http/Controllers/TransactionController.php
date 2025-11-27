<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function storeWeb(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'category_id' => 'required|string',
            'wallet_id' => 'required|string',
            'description' => 'nullable|string',
        ]);

        Transaction::create([
            'user_id' => Auth::id(),
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'date' => $validated['date'],
            'category_id' => $validated['category_id'],
            'wallet_id' => $validated['wallet_id'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil disimpan! 🎉');
    }

    public function destroy($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);
        $transaction->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus!');
    }
}