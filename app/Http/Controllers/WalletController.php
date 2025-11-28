<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'balance' => 'nullable|numeric|min:0',
            'wallet_type' => 'nullable|in:regular,savings,emergency,investment,spending,goal',
            'target_amount' => 'nullable|numeric|min:0',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
        ]);

        $wallet = Wallet::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'balance' => $validated['balance'] ?? 0,
            'wallet_type' => $validated['wallet_type'] ?? 'regular',
            'target_amount' => $validated['target_amount'] ?? null,
            'color' => $validated['color'] ?? null,
            'icon' => $validated['icon'] ?? null,
        ]);

        return redirect()->route('dashboard')->with('success', 'Dompet berhasil ditambahkan! 🎉');
    }

    public function destroy($id)
    {
        $wallet = Wallet::where('user_id', Auth::id())->findOrFail($id);
        
        $wallet->delete();

        return redirect()->route('dashboard')->with('success', 'Dompet berhasil dihapus!');
    }
}

