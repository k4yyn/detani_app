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
        Schema::table('ticket_stocks', function (Blueprint $table) {
            $table->integer('original_stock')->after('initial_stock')->nullable();
        });
        
        // Update existing records: set original_stock = initial_stock for existing data
        DB::table('ticket_stocks')->whereNull('original_stock')->update([
            'original_stock' => DB::raw('initial_stock')
        ]);
        
        // Make original_stock not nullable after data migration
        Schema::table('ticket_stocks', function (Blueprint $table) {
            $table->integer('original_stock')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ticket_stocks', function (Blueprint $table) {
            $table->dropColumn('original_stock');
        });
    }
};