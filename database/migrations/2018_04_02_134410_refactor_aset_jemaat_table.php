<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefactorAsetJemaatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aset_jemaat', function (Blueprint $table) {
            $table->unsignedInteger('id_jemaat_induk')->after('id');
            $table->dropColumn('nama_mupel');
            $table->dropColumn('nama_jemaat_induk');
            $table->dropColumn('alamat_desa_kelurahan_jemaat_induk');
            $table->dropColumn('kecamatan_jemaat_induk');
            $table->dropColumn('kabupaten_jemaat_induk');
            $table->dropColumn('propinsi_jemaat_induk');
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
            $table->dropColumn('id_jemaat_induk');
            $table->string('nama_mupel', 45);
            $table->string('nama_jemaat_induk', 45);
            $table->text('alamat_desa_kelurahan_jemaat_induk')->nullable();
            $table->string('kecamatan_jemaat_induk', 45)->nullable();
            $table->string('kabupaten_jemaat_induk', 45)->nullable();
            $table->string('propinsi_jemaat_induk', 45)->nullable();
        });
    }
}
