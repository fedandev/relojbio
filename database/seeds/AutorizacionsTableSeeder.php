<?php

use Illuminate\Database\Seeder;
use App\Models\Autorizacion;

class AutorizacionsTableSeeder extends Seeder
{
    public function run()
    {
        $autorizacions = factory(Autorizacion::class)->times(50)->make()->each(function ($autorizacion, $index) {
            if ($index == 0) {
                // $autorizacion->field = 'value';
            }
        });

        Autorizacion::insert($autorizacions->toArray());
    }

}

