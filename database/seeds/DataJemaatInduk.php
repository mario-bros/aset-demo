<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


/**
 * Class AdminUserSeeder
 */
class DataJemaatInduk extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mupelTable = 'mupel';

        $mupelAceh = DB::table($mupelTable)
            ->where('nama', 'SUMATERA UTARA & ACEH')
            ->first();

        try {
            factory(App\Models\JemaatInduk::class)->create(
                [
                    "id_mupel" => $mupelAceh->id,
                    "nama" => "GPIB BANDA ACEH",
                    "alamat_desa_kelurahan" => "Jl. Krakatau No.14A Desa Pulo Brayan Darat II",
                    "id_kecamatan" => "Aceh Timur",
                    "id_kabupaten" => "Aceh Timur",
                    "id_propinsi" => "Aceh",
                ]
            );
        } catch (\Illuminate\Database\QueryException $exception) {

        }
    }
}