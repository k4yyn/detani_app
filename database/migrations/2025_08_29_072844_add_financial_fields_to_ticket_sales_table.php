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
        Schema::table('ticket_sales', function (Blueprint $table) {
            $table->unsignedInteger('price_per_ticket')->default(0); // harga tiket otomatis
            $table->unsignedInteger('gross_total')->default(0);      // total kotor
            $table->unsignedInteger('discount')->default(0);         // diskon
            $table->unsignedInteger('net_total')->default(0);        // total bersih
            $table->text('notes')->nullable();                       // catatan
        });
    }

    public function down()
    {
        Schema::table('ticket_sales', function (Blueprint $table) {
            $table->dropColumn(['price_per_ticket', 'gross_total', 'discount', 'net_total', 'notes']);
        });
    }
};
