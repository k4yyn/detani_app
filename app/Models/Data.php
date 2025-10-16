<?php
// app/Models/Data.php

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
        'stock_gudang',
        'stock_kantin1',
        'min_stock_kantin1',
        'stock_kantin2', 
        'stock_kantin3'
    ];

    // Update stok total ketika model disave
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->stok = $model->stock_gudang + $model->stock_kantin1 + $model->stock_kantin2 + $model->stock_kantin3;
        });
    }

    // Relationships
    public function stockOpnames()
    {
        return $this->hasMany(StockOpname::class);
    }

    public function stockTransfers()
    {
        return $this->hasMany(StockTransfer::class);
    }

    // Scopes
    public function scopeStokRendahKantin1($query)
    {
        return $query->where('stock_kantin1', '<=', DB::raw('min_stock_kantin1'));
    }

    public function scopeTersediaDiGudang($query)
    {
        return $query->where('stock_gudang', '>', 0);
    }
}