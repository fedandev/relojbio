<?php

use Illuminate\Database\Seeder;
use App\Models\Feriado;

class FeriadosTableSeeder extends Seeder
{
    public function run()
    {
        $feriados = factory(Feriado::class)->times(50)->make()->each(function ($feriado, $index) {
            if ($index == 0) {
                // $feriado->field = 'value';
            }
        });

        Feriado::insert($feriados->toArray());
    }

}

