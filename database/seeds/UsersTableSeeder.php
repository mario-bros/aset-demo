<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
 
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usersTable = 'users';
        $rolesTable = 'roles';
        $mupelTable = 'mupel';
        $jemaatIndukTable = 'jemaat_induk';

        $currTime = date('Y-m-d H:i:s', time());

        DB::table($usersTable)->insert([
            [
                'name' => "Stefan",
                'email' => "sinode@gpib.id",
                'password' => bcrypt('password'),
                'pass_prompt' => 1,
                "created_at" => $currTime,
                "updated_at" => $currTime
            ],
            [
                'name' => "mupel.aceh",
                'email' => "mupel.aceh@gpib.id",
                'password' => bcrypt('password'),
                'pass_prompt' => 1,
                "created_at" => $currTime,
                "updated_at" => $currTime
            ],
            [
                'name' => "jemaat.aceh.banda.aceh",
                'email' => "jemaat.aceh.banda.aceh@gpib.id",
                'password' => bcrypt('password'),
                'pass_prompt' => 1,
                "created_at" => $currTime,
                "updated_at" => $currTime
            ],
        ]);

        $adminUser = DB::table($usersTable)
            ->where('name', 'mario.fredrick')
            ->first();

        $sinodeUser = DB::table($usersTable)
            ->where('name', 'Stefan')
            ->first();

        $mupelAcehUser = DB::table($usersTable)
            ->where('name', 'mupel.aceh')
            ->first();

        $jemaatAcehUser = DB::table($usersTable)
            ->where('name', 'jemaat.aceh.banda.aceh')
            ->first();

        $adminRole = DB::table($rolesTable)
            ->where('name', 'Admin')
            ->first();

        $sinodeRole = DB::table($rolesTable)
            ->where('name', 'Sinode')
            ->first();

        $mupelRole = DB::table($rolesTable)
            ->where('name', 'Mupel')
            ->first();

        $jemaatRole = DB::table($rolesTable)
            ->where('name', 'Jemaat')
            ->first();

        DB::table('user_roles')->insert([
            [
                'id_user' => $adminUser->id,
                'id_role' => $adminRole->id,
                "created_at" => $currTime,
                "updated_at" => $currTime
            ],
            [
                'id_user' => $sinodeUser->id,
                'id_role' => $sinodeRole->id,
                "created_at" => $currTime,
                "updated_at" => $currTime
            ],
            [
                'id_user' => $mupelAcehUser->id,
                'id_role' => $mupelRole->id,
                "created_at" => $currTime,
                "updated_at" => $currTime
            ],
            [
                'id_user' => $jemaatAcehUser->id,
                'id_role' => $jemaatRole->id,
                "created_at" => $currTime,
                "updated_at" => $currTime
            ],
        ]);
 
        $mupelAceh = DB::table($mupelTable)
            ->where('nama', 'SUMATERA UTARA & ACEH')
            ->first();

        $jemaatAceh = DB::table($jemaatIndukTable)
            ->where('nama', 'GPIB BANDA ACEH')
            ->first();

        DB::table('user_profiles')->insert([
            [
                'id_user' => $adminUser->id,
                'first_name' => "Mario",
                'last_name' => "Boboho",
                'phone_number' => "08119541261",
                'access_data' => json_encode([ Role::$accessDataTypes[Role::ROLE_ADMIN] => 1]),
                "created_at" => $currTime,
                "updated_at" => $currTime
            ],
            [
                'id_user' => $sinodeUser->id,
                'first_name' => "Sinode",
                'last_name' => "GPIB",
                'phone_number' => "08119541261",
                'access_data' => json_encode([Role::$accessDataTypes[Role::ROLE_SINODE] => 1]),
                "created_at" => $currTime,
                "updated_at" => $currTime
            ],
            [
                'id_user' => $mupelAcehUser->id,
                'first_name' => "Mupel",
                'last_name' => "Sumatera Utara & Aceh",
                'phone_number' => "08119541261",
                'access_data' => json_encode([Role::$accessDataTypes[Role::ROLE_MUPEL] => $mupelAceh->id]),
                "created_at" => $currTime,
                "updated_at" => $currTime
            ],
            [
                'id_user' => $jemaatAcehUser->id,
                'first_name' => "Jemaat",
                'last_name' => "GPIB ANUGERAH PANGKALAN BRANDAN",
                'phone_number' => "08119541261",
                'access_data' => json_encode([Role::$accessDataTypes[Role::ROLE_JEMAAT] => $jemaatAceh->id]),
                "created_at" => $currTime,
                "updated_at" => $currTime
            ],
        ]);
    }
}
