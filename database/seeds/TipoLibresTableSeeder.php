<?php

use Illuminate\Database\Seeder;
use App\Models\TipoLibre;

class TipoLibresTableSeeder extends Seeder
{
    public function run()
    {
        $tipo_libres = factory(TipoLibre::class)->times(50)->make()->each(function ($tipo_libre, $index) {
            if ($index == 0) {
                // $tipo_libre->field = 'value';
            }
        });

        TipoLibre::insert($tipo_libres->toArray());
    }

}

