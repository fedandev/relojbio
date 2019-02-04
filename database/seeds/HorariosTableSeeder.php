<?php

use Illuminate\Database\Seeder;
use App\Models\Horario;

class HorariosTableSeeder extends Seeder
{
    public function run()
    {
        $horarios = factory(Horario::class)->times(50)->make()->each(function ($horario, $index) {
            if ($index == 0) {
                // $horario->field = 'value';
            }
        });

        Horario::insert($horarios->toArray());
    }

}

