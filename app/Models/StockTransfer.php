<?php
// app/Models/StockTransfer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_id',
        'jumlah',
        'dari_lokasi', 
        'ke_lokasi',
        'status',
        'user_id',
        'keterangan'
    ];

    // Relationship ke Data (Barang)
    public function data()
    {
        return $this->belongsTo(Data::class);
    }

    // Relationship ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope untuk filter
    public function scopeHariIni($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeKeKantin1($query)
    {
        return $query->where('ke_lokasi', 'kantin1');
    }
}