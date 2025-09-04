<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('status_pembayaran')->default('Lunas'); // atau 'Belum Lunas'
            $table->string('metode_pembayaran')->nullable(); // Cash, QRIS, dll
        });
    }

    public function down()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['status_pembayaran', 'metode_pembayaran']);
        });
    }

};
