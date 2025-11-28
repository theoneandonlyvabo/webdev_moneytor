<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            // Fitur Bank Jago: Tipe dompet (pocket/jar)
            $table->enum('wallet_type', ['regular', 'savings', 'emergency', 'investment', 'spending', 'goal'])->default('regular')->after('name');
            // Target/goal untuk dompet (opsional, seperti tabungan untuk tujuan tertentu)
            $table->decimal('target_amount', 15, 2)->nullable()->after('balance');
            // Warna untuk visualisasi (opsional)
            $table->string('color', 7)->nullable()->after('target_amount');
            // Icon untuk visualisasi (opsional)
            $table->string('icon', 50)->nullable()->after('color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropColumn(['wallet_type', 'target_amount', 'color', 'icon']);
        });
    }
};
