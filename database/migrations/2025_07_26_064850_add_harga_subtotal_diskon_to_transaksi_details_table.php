<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaksi_details', function (Blueprint $table) {
            $table->decimal('harga', 10, 2)->after('nama_manual');
            $table->decimal('subtotal', 10, 2)->after('qty');
            $table->decimal('diskon', 10, 2)->default(0)->after('harga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi_details', function (Blueprint $table) {
            $table->dropColumn(['harga', 'subtotal', 'diskon']);
        });
    }
};