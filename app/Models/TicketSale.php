<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketSale extends Model
{
    use HasFactory;

    protected $fillable = [
    'ticket_stock_id',
    'date',
    'sold_amount',
    'user_id',
    'price_per_ticket',
    'gross_total',
    'discount',
    'net_total',
    'notes',
];

    /**
     * Relasi ke stok tiket
     */
    public function stock()
    {
        return $this->belongsTo(TicketStock::class, 'ticket_stock_id');
    }

    /**
     * Relasi ke user (kasir yang input)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
