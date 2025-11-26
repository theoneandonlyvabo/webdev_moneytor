<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    
    // Izinkan kolom ini diisi data
    protected $fillable = ['user_id', 'nama_akun', 'saldo'];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}