<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiItem extends Model
{
    protected $table = 'transaksi_items';

    protected $fillable = [
        'transaksi_id',
        'plu',
        'nama_barang',
        'kategori',
        'qty',
        'harga_satuan',
        'diskon',
        'total',
    ];

    // Relasi: item milik transaksi tertentu
    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class);
    }
}
