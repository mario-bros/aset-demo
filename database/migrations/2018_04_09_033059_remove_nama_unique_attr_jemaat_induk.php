<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveNamaUniqueAttrJemaatInduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jemaat_induk', function (Blueprint $table) {
            $table->dropIndex('nama_UNIQUE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jemaat_induk', function (Blueprint $table) {
            $table->dropIndex('nama_UNIQUE');
        });
    }
}
