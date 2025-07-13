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
        Schema::table('data', function (Blueprint $table) {
            $table->string('codetrx', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
        public function down()
    {
        Schema::table('data', function (Blueprint $table) {
            $table->decimal('codetrx', 15, 2)->change();
        });
    }
};
