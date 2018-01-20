<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeleteToAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_jemaat', function (Blueprint $table) {
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->softDeletes();
        });

        Schema::table('jemaat_induk', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('jenis_asset', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('mupel', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset_jemaat', function (Blueprint $table) {
            $table->dropColumn(['deleted_at', 'created_at', 'updated_at']);
        });

        Schema::table('jemaat_induk', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('jenis_asset', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('mupel', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
}
