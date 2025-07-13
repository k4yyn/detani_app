<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;

    protected $table = 'data';

      protected $fillable = [
        'codetrx',
        'nama_barang',
        'kategori',
        'deskripsi',
        'stok',
        'harga_pokok',
        'harga_jual',
        'lokasi_penyimpanan',
    ];
}
