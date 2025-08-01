<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailFieldsToTransaksisTable extends Migration
{
    public function up()
    {
        Schema::table('transaksis', function (Blueprint $table) {
           /* $table->string('kode_transaksi')->nullable()->unique()->after('id');*/
            $table->string('nama_pelanggan')->nullable()->after('kode_transaksi');
            $table->string('nomor_meja')->nullable()->after('nama_pelanggan');
            $table->text('keterangan_tambahan')->nullable()->after('nomor_meja');
        });
    }

    public function down()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['kode_transaksi', 'nama_pelanggan', 'nomor_meja', 'keterangan_tambahan']);
        });
    }
}
