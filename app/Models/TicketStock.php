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
}
