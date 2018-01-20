<?php

use Illuminate\Database\Seeder;


class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert([
            [
                'caption' => "Support",
                'url_link' => "#",
                'category' => "Root Menu With Badge",
                'parent_id' => null,
                'order' => 1,
                'attributes' => '{"menuIconClass": "flaticon-lifebuoy"}'
            ],
            [
                'caption' => "Reports",
                'url_link' => "#",
                'category' => "Menu Item Dot List",
                'parent_id' => 1,
                'order' => 2,
                'attributes' => '[]'
            ],
        ]);
    }
}