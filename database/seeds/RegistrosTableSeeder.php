<?php

use Illuminate\Database\Seeder;
use App\Models\Registro;

class RegistrosTableSeeder extends Seeder
{
    public function run()
    {
        $registros = factory(Registro::class)->times(50)->make()->each(function ($registro, $index) {
            if ($index == 0) {
                // $registro->field = 'value';
            }
        });

        Registro::insert($registros->toArray());
    }

}

