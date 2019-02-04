<?php

use Illuminate\Database\Seeder;
use App\Models\Dispositivo;

class DispositivosTableSeeder extends Seeder
{
    public function run()
    {
        $dispositivos = factory(Dispositivo::class)->times(50)->make()->each(function ($dispositivo, $index) {
            if ($index == 0) {
                // $dispositivo->field = 'value';
            }
        });

        Dispositivo::insert($dispositivos->toArray());
    }

}

