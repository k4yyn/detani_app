<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiKasir extends Model
{
    protected $table = 'transaksi_kasir';

    protected $fillable = [
        'plu',
        'deskripsi',
        'kategori',
        'qty',
        'harga',
        'diskon',
        'total'
    ];

    // Jika nanti mau sambungkan ke transaksi utama (opsional)
    // public function transaksi()
    // {
    //     return $this->belongsTo(Transaksi::class);
    // }
}
