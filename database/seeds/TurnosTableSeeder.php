<?php

use Illuminate\Database\Seeder;
use App\Models\Turno;

class TurnosTableSeeder extends Seeder
{
    public function run()
    {
        $turnos = factory(Turno::class)->times(50)->make()->each(function ($turno, $index) {
            if ($index == 0) {
                // $turno->field = 'value';
            }
        });

        Turno::insert($turnos->toArray());
    }

}

