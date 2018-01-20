<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWarnaStatusDokumenAset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aset_jemaat', function (Blueprint $table) {
            $table->char('warna_status_pos_pelkes', '12')->after('nama_bangunan')->nullable();
            $table->char('warna_status_kepemilikan_dokumen_imb', '12')->after('no_tgl_penerbitan_imb')->nullable();
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
            $table->dropColumn('warna_status_pos_pelkes');
            $table->dropColumn('warna_status_kepemilikan_dokumen_imb');
        });
    }
}
