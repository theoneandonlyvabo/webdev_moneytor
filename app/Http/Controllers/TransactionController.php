<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // 1. GET /api/transactions
    // Mengambil semua data transaksi (terbaru paling atas)
    public function index()
    {
        $transactions = Transaction::with(['category', 'account'])
                        ->orderBy('date', 'desc') // Urutkan dari tanggal terbaru
                        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Transaksi Berhasil Diambil',
            'data'    => $transactions
        ], 200);
    }

    // 2. POST /api/transactions
    // Menambah transaksi baru
    public function store(Request $request)
    {
        // Validasi input dari frontend
        $validated = $request->validate([
            'account_id'  => 'required|exists:accounts,id',
            'category_id' => 'required|exists:categories,id',
            'tanggal'     => 'required|date',
            'jumlah'      => 'required|numeric',
            'deskripsi'   => 'nullable|string',
        ]);

        // Simpan ke database
        $transaction = Transaction::create($validated);

        // Update saldo akun otomatis
        $account = \App\Models\Account::find($request->account_id);
        $category = \App\Models\Category::find($request->category_id);

        if ($category->tipe == 'income') {
            $account->increment('saldo', $request->jumlah);
        } else {
            $account->decrement('saldo', $request->jumlah);
        }

        return response()->json([
            'success' => true,
            'message' => 'Transaksi Berhasil Ditambahkan',
            'data'    => $transaction
        ], 201);
    }
}