<?php

use Illuminate\Database\Seeder;
use App\Models\Sesion;

class SesionsTableSeeder extends Seeder
{
    public function run()
    {
        $sesions = factory(Sesion::class)->times(50)->make()->each(function ($sesion, $index) {
            if ($index == 0) {
                // $sesion->field = 'value';
            }
        });

        Sesion::insert($sesions->toArray());
    }

}

