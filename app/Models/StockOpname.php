<?php
// app/Models/StockOpname.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    use HasFactory;

    // ✅ TAMBAH INI - Specify table name
    protected $table = 'stock_opnames_kantin';

    protected $fillable = [
        'data_id',
        'kantin_id', 
        'tanggal',
        'stock_sistem',
        'stock_fisik',
        'selisih',
        'status',
        'keterangan',
        'user_id'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relationships
    public function data()
    {
        return $this->belongsTo(Data::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Auto calculate selisih
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->selisih = $model->stock_fisik - $model->stock_sistem;
            $model->status = $model->selisih == 0 ? 'match' : 'selisih';
        });
    }

    // Scopes
    public function scopeKantin1($query)
    {
        return $query->where('kantin_id', '1');
    }

    public function scopeHariIni($query)
    {
        return $query->whereDate('tanggal', today());
    }

    public function scopeSelisih($query)
    {
        return $query->where('status', 'selisih');
    }
}