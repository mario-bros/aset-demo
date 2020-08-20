<?php

use Illuminate\Database\Seeder;

/**
 * Class AdminUserSeeder
 */
class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $currTime = date('Y-m-d H:i:s', time());
            factory(App\Models\User::class)->create([
                    "name" => "mario.fredrick",
                    "email" => "mario.fredrick@tnisiber.id",
                    "password" => bcrypt(env('ADMIN_PWD', 'password')),
                    "pass_prompt" => 0,
                    "created_at" => $currTime,
                    "updated_at" => $currTime
            ]);
        } catch (\Illuminate\Database\QueryException $exception) {
            dd($exception->getMessage());
        }
    }
}