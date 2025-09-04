<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'month',
        'year',
        'initial_stock',
        'original_stock',
    ];

    /**
     * Relasi ke penjualan tiket
     */
    public function sales()
    {
        return $this->hasMany(TicketSale::class);
    }

    /**
     * Hitung total tiket terjual
     */
    public function totalSold()
    {
        return $this->sales()->sum('sold_amount');
    }

    /**
     * Hitung sisa stok
     */
    public function remainingStock()
    {
        return $this->initial_stock - $this->totalSold();
    }

    /**
     * Hitung total penambahan stok setelah stok awal
     */
    public function totalAdditionalStock()
    {
        return $this->initial_stock - $this->original_stock;
    }

    /**
     * Cek apakah ada penambahan stok
     */
    public function hasAdditionalStock()
    {
        // Pastikan original_stock tidak null dan ada selisih
        if (is_null($this->original_stock)) {
            return false;
        }
        return $this->totalAdditionalStock() > 0;
    }
}