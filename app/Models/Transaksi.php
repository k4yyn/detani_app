<?php
// app/Models/Transaksi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'user_id',
        'kode_transaksi',
        'invoice',
        'total_harga',
        'uang_dibayar',
        'kembalian',
        'nama_pelanggan',
        'nomor_meja',
        'keterangan',
        'keterangan_tambahan',
        'metode_pembayaran',
        'status_pembayaran'
    ];

    // Relasi ke tabel transaksi_details
    public function items()
    {
        return $this->hasMany(TransaksiDetail::class);
    }

    public function details()
    {
        return $this->hasMany(TransaksiDetail::class);
    }

    // ✅ Relasi ke User (yang tadi error)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
