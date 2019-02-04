<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenusTableSeeder extends Seeder
{
    public function run()
    {
        $menus = factory(Menu::class)->times(50)->make()->each(function ($menu, $index) {
            if ($index == 0) {
                // $menu->field = 'value';
            }
        });

        Menu::insert($menus->toArray());
    }

}

