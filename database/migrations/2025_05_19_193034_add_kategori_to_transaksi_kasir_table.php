<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKategoriToTransaksiKasirTable extends Migration
{
    public function up()
    {
        Schema::table('transaksi_kasir', function (Blueprint $table) {
            $table->string('kategori')->after('deskripsi')->nullable();
        });
    }

    public function down()
    {
        Schema::table('transaksi_kasir', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
}