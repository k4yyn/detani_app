<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Buat migration baru atau update yang sudah ada
        Schema::table('transaksis', function (Blueprint $table) {
            // Jika kolom user_id belum ada, tambahkan
            if (!Schema::hasColumn('transaksis', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            }
            
            // Jika kolom kode_transaksi belum ada, tambahkan
            if (!Schema::hasColumn('transaksis', 'kode_transaksi')) {
                $table->string('kode_transaksi')->unique()->after('user_id');
            }
            
            // Pastikan kolom yang dibutuhkan ada
            if (!Schema::hasColumn('transaksis', 'total_harga')) {
                $table->decimal('total_harga', 15, 2)->after('kode_transaksi');
            }
            
            if (!Schema::hasColumn('transaksis', 'uang_dibayar')) {
                $table->decimal('uang_dibayar', 15, 2)->after('total_harga');
            }
            
            if (!Schema::hasColumn('transaksis', 'kembalian')) {
                $table->decimal('kembalian', 15, 2)->default(0)->after('uang_dibayar');
            }
        });
    }

    public function down()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'kode_transaksi', 'total_harga', 'uang_dibayar', 'kembalian']);
        });
    }
};