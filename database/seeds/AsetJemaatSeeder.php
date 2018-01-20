<?php

use Illuminate\Database\Seeder;
use App\Models\AsetJemaat;


class AsetJemaatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jemaatIndukTable = 'jemaat_induk';
        $jemaatAceh = DB::table($jemaatIndukTable)
            ->where('nama', 'GPIB BANDA ACEH')
            ->first();

        try {
            factory(App\Models\AsetJemaat::class)->create([
                    "id_jemaat_induk" => $jemaatAceh->id,
                    "kode_aset" => "03.01-07",
                    "no_urut_aset" => 1,
                    "status_kepemilikan" => AsetJemaat::$statusKepemilikanEnums['status_kepemilikan_lain_lain']
            ]);

            factory(App\Models\AsetJemaat::class, 3)->create([
                "id_jemaat_induk" => $jemaatAceh->id,
                "status_kepemilikan" => AsetJemaat::$statusKepemilikanEnums['status_kepemilikan_lain_lain']
            ]);
        } catch (\Illuminate\Database\QueryException $exception) {
            dd($exception->getMessage());
        }
    }
}