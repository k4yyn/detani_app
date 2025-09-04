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
        Schema::create('ticket_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('month'); // Bulan stok
            $table->unsignedInteger('year'); // Tahun stok
            $table->unsignedInteger('initial_stock'); // Stok awal
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_stocks');
    }
};
