<?php

use Faker as BaseFaker;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    $currTime = date('Y-m-d H:i:s', time());
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'pass_prompt' => 1,
        "created_at" => $currTime,
        "updated_at" => $currTime
    ];
});


$factory->define(App\Models\Menu::class, function (Faker $faker) {
    return [
        'caption' => $faker->name,
        'url_link' => $faker->url,
        'category' => $faker->words,
        'parent_id' => $faker->randomDigit,
        'order' => $faker->randomDigit,
        'attributes' => $faker->words,
    ];
});

$factory->define(App\Models\Mupel::class, function (Faker $faker) {
    return [
        'nama' => $faker->name,
    ];
});


$factory->define(App\Models\JemaatInduk::class, function (Faker $faker) {
    return [
        "id_mupel" => $faker->randomDigitNotNull,
        "nama" => $faker->name,
        "alamat_desa_kelurahan" => $faker->address,
        "id_kecamatan" => $faker->name,
        "id_kabupaten" => $faker->name,
        "id_propinsi" => $faker->name,
    ];
});


$localisedBRFaker = BaseFaker\Factory::create("pt_BR");
$localisedCZFaker = BaseFaker\Factory::create("cs_CZ");
$factory->define(App\Models\AsetJemaat::class, function (Faker $faker) use ($localisedBRFaker, $localisedCZFaker) {
    $currTime = date('Y-m-d H:i:s', time());
    return [
        'id_jemaat_induk' => $faker->randomDigitNotNull,
        'kode_aset' => $localisedBRFaker->cnpj,
        'no_urut_aset' => $faker->randomDigitNotNull,
        'alamat_persil_desa_kelurahan' => $faker->address,
        'kecamatan_persil' => $localisedCZFaker->region,
        'kabupaten_persil' => $localisedCZFaker->region,
        'propinsi_persil' => $localisedCZFaker->region,
        'tanggal_terbit_surat_ukur' => $faker->date,
        'no_surat_ukur' => $faker->randomNumber,
        'luas_tanah' => $faker->randomFloat,
        'status_kepemilikan_hm' => $faker->word,
        'status_kepemilikan_hgb' => $faker->word,
        'status_kepemilikan_girik' => $faker->word,
        'status_kepemilikan_lain_lain' => $faker->word,
        'status_kepemilikan' => $faker->word,
        'tgl_pengeluaran_sertifikat_surat' => $faker->date,
        'atas_nama' => $faker->name,
        'warna_status_kepemilikan' => $faker->hexcolor,
        'asal' => $faker->word,
        'masa_berlaku' => $faker->date,
        'masa_berlaku_hgb' => $faker->date,
        'nama_bangunan' => $faker->word,
        'luas_bangunan' => $faker->word,
        'warna_status_pos_pelkes' => $faker->hexcolor,
        'no_tgl_penerbitan_imb' => $faker->word,
        'njop' => $faker->randomNumber(9),
        'status_kelola' => $faker->word,
        'warna_status_kepemilikan_dokumen_imb' => $faker->hexcolor,
        'keberadaan_dokumen' => $faker->word,
        'warna_keberadaan_dokumen' => $faker->hexcolor,
        'keterangan' => $faker->word,
        'created_at' => $currTime,
        'updated_at' => $currTime,
    ];
});
