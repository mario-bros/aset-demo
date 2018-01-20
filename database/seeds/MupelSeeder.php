<?php

use Illuminate\Database\Seeder;


class MupelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            factory(App\Models\Mupel::class)->create([
                    "nama" => "SUMATERA UTARA & ACEH",
            ]);
        } catch (\Illuminate\Database\QueryException $exception) {

        }
    }
}