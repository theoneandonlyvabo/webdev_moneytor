<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    // Menentukan kolom mana yang boleh diisi data
    protected $fillable = [
        'user_id',
        'name',
        'balance',
        'wallet_type',
        'target_amount',
        'color',
        'icon',
    ];

    // Relasi ke User (Dompet milik siapa?)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}