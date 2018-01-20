<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRegionColumnsToVarchar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jemaat_induk', function (Blueprint $table) {
            $table->string('id_kecamatan', 50)->nullable()->change();
            $table->string('id_kabupaten', 50)->nullable()->change();
            $table->string('id_propinsi', 50)->nullable()->change();
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
            $table->integer('id_kecamatan')->nullable()->change();
            $table->integer('id_kabupaten')->nullable()->change();
            $table->integer('id_propinsi')->nullable()->change();
        });
    }
}
