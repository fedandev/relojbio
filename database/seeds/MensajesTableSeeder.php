<?php

use Illuminate\Database\Seeder;
use App\Models\Mensaje;

class MensajesTableSeeder extends Seeder
{
    public function run()
    {
        $mensajes = factory(Mensaje::class)->times(50)->make()->each(function ($mensaje, $index) {
            if ($index == 0) {
                // $mensaje->field = 'value';
            }
        });

        Mensaje::insert($mensajes->toArray());
    }

}

