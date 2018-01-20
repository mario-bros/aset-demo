<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusKepemilikanToAsetJemaat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aset_jemaat', function (Blueprint $table) {
            $table->string('status_kepemilikan', 100)->after('status_kepemilikan_lain_lain')->nullable();
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
            $table->dropColumn('status_kepemilikan');
        });
    }
}
