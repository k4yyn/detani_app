<?php
// database/migrations/2024_01_01_create_stock_transfers_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_id')->constrained('data')->onDelete('cascade');
            $table->integer('jumlah');
            $table->enum('dari_lokasi', ['gudang', 'kantin1'])->default('gudang');
            $table->enum('ke_lokasi', ['kantin1'])->default('kantin1'); // Phase 1 hanya kantin1
            $table->enum('status', ['pending', 'completed'])->default('completed');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->index(['dari_lokasi', 'ke_lokasi']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_transfers');
    }
};