<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAutoIncrementToAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jenis_asset', function($table) {
            $table->dropColumn('id');
        });

        Schema::table('jenis_asset', function (Blueprint $table) {
            $table->increments('id')->first();
        });

        Schema::table('mupel', function($table) {
            $table->dropColumn('id');
        });

        Schema::table('mupel', function (Blueprint $table) {
            $table->increments('id')->first();
        });
    }
}
