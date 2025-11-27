<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id(); // Primary Key
            
            // Relasi ke User (Pemilik Dompet)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Nama Dompet (Contoh: BCA, GoPay, Tunai)
            $table->string('nama_akun'); 
            
            // Saldo (Decimal biar akurat uangnya, default 0)
            $table->decimal('saldo', 15, 2)->default(0);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};