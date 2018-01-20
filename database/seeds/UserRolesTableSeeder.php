<?php

use Illuminate\Database\Seeder;
 
class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rolesTable = 'roles';
        $usersTable = 'users';

        $userAdmin = DB::table($usersTable)
            ->where('name', 'mario.fredrick')
            ->first();

        $userMupelAceh = DB::table($usersTable)
            ->where('name', 'mupel.aceh')
            ->first();

        $userJemaatAceh = DB::table($usersTable)
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
                'id_user' => 1,
                'id_role' => $adminRole->id,
                "created_at" => date('Y-m-d H:i:s', time()),
                "updated_at" => date('Y-m-d H:i:s', time())
            ],
            [
                'id_user' => 2,
                'id_role' => 3,
                "created_at" => date('Y-m-d H:i:s', time()),
                "updated_at" => date('Y-m-d H:i:s', time())
            ],
            [
                'id_user' => 3,
                'id_role' => 4,
                "created_at" => date('Y-m-d H:i:s', time()),
                "updated_at" => date('Y-m-d H:i:s', time())
            ],
        ]);
    }
}
