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
        Schema::table('transactions', function (Blueprint $table) {
            // Drop foreign key constraint dulu
            $table->dropForeign(['account_id']);
            
            // Ubah account_id jadi nullable
            $table->unsignedBigInteger('account_id')->nullable()->change();
            
            // Re-add foreign key constraint (nullable)
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['account_id']);
            
            // Ubah kembali jadi not nullable
            $table->unsignedBigInteger('account_id')->nullable(false)->change();
            
            // Re-add foreign key constraint
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }
};
