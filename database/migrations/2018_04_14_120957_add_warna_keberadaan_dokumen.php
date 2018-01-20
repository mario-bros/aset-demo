<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class AddWarnaKeberadaanDokumen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aset_jemaat', function (Blueprint $table) {
            $table->char('warna_keberadaan_dokumen', '12')->after('keberadaan_dokumen')->nullable();
        });

        //DB::statement("ALTER TABLE `aset_jemaat` MODIFY COLUMN foo DATE AFTER bar");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aset_jemaat', function (Blueprint $table) {
            $table->dropColumn('warna_keberadaan_dokumen');
        });
    }
}
