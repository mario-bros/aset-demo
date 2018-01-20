<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMasaBerlakuHgbToAsetJemaatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aset_jemaat', function (Blueprint $table) {
            $table->date('masa_berlaku_hgb')->after('masa_berlaku')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aset_jemaat', function (Blueprint $table) {
            $table->dropColumn('masa_berlaku_hgb');
        });
    }
}
