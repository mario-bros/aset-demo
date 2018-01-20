<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNjopStatusKelolaToAsetJemaat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aset_jemaat', function (Blueprint $table) {
            $table->decimal('njop', 14, 2)->after('no_tgl_penerbitan_imb')->nullable();
            $table->string('status_kelola', 50)->after('njop')->nullable();
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
            $table->dropColumn('njop');
            $table->dropColumn('status_kelola');
        });
    }
}
