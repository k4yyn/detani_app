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
        Schema::create('ticket_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_stock_id')->constrained('ticket_stocks')->onDelete('cascade'); // Relasi stok
            $table->date('date'); // Tanggal penjualan
            $table->unsignedInteger('sold_amount'); // Jumlah tiket terjual
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // User yang input
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_sales');
    }
};
