<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet; // <--- 1. Pastikan Import Model Wallet
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Untuk Database Transaction (Opsional tapi recommended)

class TransactionController extends Controller
{
    public function storeWeb(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'category_id' => 'required|exists:categories,id', // Ganti string jadi exists biar aman
            'wallet_id' => 'required|exists:wallets,id',     // Pastikan wallet ID valid di DB
            'description' => 'nullable|string',
        ]);

        // Gunakan DB::transaction biar kalau error, semuanya batal (safety)
        DB::transaction(function () use ($validated) {
            
            // 2. Simpan Transaksi (Kode kamu yang lama)
            Transaction::create([
                'user_id' => Auth::id(),
                'type' => $validated['type'],
                'amount' => $validated['amount'],
                'date' => $validated['date'],
                'category_id' => $validated['category_id'],
                'wallet_id' => $validated['wallet_id'],
                'description' => $validated['description'] ?? null,
            ]);

            // 3. Update Saldo Dompet (LOGIKA BARU)
            $wallet = Wallet::findOrFail($validated['wallet_id']);

            if ($validated['type'] === 'income') {
                // Kalau pemasukan, saldo nambah
                $wallet->increment('balance', $validated['amount']);
            } else {
                // Kalau pengeluaran, saldo berkurang
                $wallet->decrement('balance', $validated['amount']);
            }
        });

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil disimpan & Saldo diupdate! 🎉');
    }

    public function destroy($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);
        
        // LOGIKA BARU: Kembalikan saldo sebelum hapus transaksi
        $wallet = Wallet::find($transaction->wallet_id);
        
        if ($wallet) {
            if ($transaction->type === 'income') {
                // Kalau hapus income, saldo dompet harus dikurangi balik
                $wallet->decrement('balance', $transaction->amount);
            } else {
                // Kalau hapus expense, uangnya "balik" ke dompet
                $wallet->increment('balance', $transaction->amount);
            }
        }

        $transaction->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus!');
    }
}