<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Match the column names in your database migration
    protected $fillable = [
        'user_id',
        'account_id',
        'category_id',
        'date',
        'amount', // Ensure this matches the migration (was 'jumlah' in error, but migration said 'amount')
        'description',
        'type'
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    // --- RELASI DATABASE (PENTING) ---

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // --- HELPER ATRIBUT (OPSIONAL TAPI BAGUS) ---
    // Ini biar di view bisa panggil $transaction->category_name_label

    public function getCategoryNameLabelAttribute()
    {
        // Kalau relasi category ada, ambil namanya. Kalau gak, return default.
        return $this->category->nama_kategori ?? 'Kategori Terhapus';
    }

    public function getAccountNameLabelAttribute()
    {
        return $this->account->nama_akun ?? 'Akun Terhapus';
    }
}