<?php

use Illuminate\Database\Seeder;
use App\Models\Modulo;

class ModulosTableSeeder extends Seeder
{
    public function run()
    {
        $modulos = factory(Modulo::class)->times(50)->make()->each(function ($modulo, $index) {
            if ($index == 0) {
                // $modulo->field = 'value';
            }
        });

        Modulo::insert($modulos->toArray());
    }

}

