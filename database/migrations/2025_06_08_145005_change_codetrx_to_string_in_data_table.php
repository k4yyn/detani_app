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
            if (!Schema::hasColumn('data', 'codetrx')) {
                $table->string('codetrx', 50)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('data', function (Blueprint $table) {
            if (Schema::hasColumn('data', 'codetrx')) {
                $table->dropColumn('codetrx');
            }
        });
    }
};
