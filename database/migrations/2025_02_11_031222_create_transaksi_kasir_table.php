<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('transaksi_kasir', function (Blueprint $table) {
            $table->id();
            $table->string('plu')->unique();// PLU (Product Lookup Code)
            $table->string('deskripsi'); // Deskripsi produk
            $table->integer('qty'); // Jumlah produk
            $table->decimal('harga', 10, 2); // Harga produk
            $table->decimal('diskon', 10, 2)->default(0); // Diskon produk
            $table->decimal('total', 10, 2); // Total harga produk
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    public function down() {
        Schema::dropIfExists('transaksi_kasir'); 
    }  
};
