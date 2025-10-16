<?php
// database/migrations/2024_01_01_add_stock_fields_to_data_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data', function (Blueprint $table) {
            // Tambah field untuk multi-stock management
            $table->integer('stock_gudang')->default(0)->after('stok');
            $table->integer('stock_kantin1')->default(0)->after('stock_gudang');
            $table->integer('min_stock_kantin1')->default(5)->after('stock_kantin1');
            
            // Siapin untuk future expansion
            $table->integer('stock_kantin2')->default(0)->after('min_stock_kantin1');
            $table->integer('stock_kantin3')->default(0)->after('stock_kantin2');
            
            // Update stok field jadi total (backward compatibility)
            // Stok = stock_gudang + stock_kantin1 + stock_kantin2 + stock_kantin3
        });

        // Update data existing
        DB::table('data')->update([
            'stock_gudang' => DB::raw('stok'),
            'stock_kantin1' => 0
        ]);
    }

    public function down(): void
    {
        Schema::table('data', function (Blueprint $table) {
            $table->dropColumn([
                'stock_gudang',
                'stock_kantin1', 
                'min_stock_kantin1',
                'stock_kantin2',
                'stock_kantin3'
            ]);
        });
    }
};