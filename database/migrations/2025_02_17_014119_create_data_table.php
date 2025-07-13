<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        if (!Schema::hasTable('data')) {
            Schema::create('data', function (Blueprint $table) {
                $table->id();
                $table->string('codetrx', 50); // ubah jadi string
                $table->string('nama_barang');
                $table->string('kategori');
                $table->text('deskripsi')->nullable();
                $table->integer('stok'); // stok bisa integer saja kalau stok adalah jumlah barang
                $table->decimal('harga_pokok', 16, 2);
                $table->decimal('harga_jual', 15, 2);
                $table->string('lokasi_penyimpanan');
                $table->timestamps();
            });
        }
    }



    /**
     * Rollback migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('data');
    }
};
