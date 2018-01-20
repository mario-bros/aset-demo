<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdMupelToAsetJemaat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();

        Schema::table('jemaat_induk', function (Blueprint $table) {
            $table->unsignedInteger('id_mupel')->nullable()->after('id');
            $table->foreign('id_mupel')->references('id')->on('mupel')->onDelete('cascade');
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
            $table->dropColumn('id_mupel');
        });
    }
}