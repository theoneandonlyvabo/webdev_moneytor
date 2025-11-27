<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke User
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Jenis: Pemasukan / Pengeluaran
            $table->enum('type', ['income', 'expense']);
            
            // Nominal Uang
            $table->decimal('amount', 15, 2);
            
            // Tanggal
            $table->date('date'); 
            
            // PERBAIKAN 1: Pakai 'foreignId' biar connect ke tabel Categories
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            
            // PERBAIKAN 2: Ganti 'wallet_id' jadi 'account_id' (Wajib sama dengan Controller!)
            $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade'); 
            
            // Catatan
            $table->text('description')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};