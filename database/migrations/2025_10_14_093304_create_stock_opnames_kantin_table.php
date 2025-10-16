<?php
// database/migrations/2024_01_01_create_stock_opnames_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_opnames_kantin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_id')->constrained('data')->onDelete('cascade');
            $table->enum('kantin_id', ['1'])->default('1'); // Phase 1 hanya kantin1
            $table->date('tanggal');
            $table->integer('stock_sistem');
            $table->integer('stock_fisik');
            $table->integer('selisih');
            $table->enum('status', ['match', 'selisih'])->default('match');
            $table->text('keterangan')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['kantin_id', 'tanggal']);
            $table->index(['data_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_opnames_kantin');
    }
};