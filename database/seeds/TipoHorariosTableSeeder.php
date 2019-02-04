<?php

use Illuminate\Database\Seeder;
use App\Models\TipoHorario;

class TipoHorariosTableSeeder extends Seeder
{
    public function run()
    {
        $tipo_horarios = factory(TipoHorario::class)->times(50)->make()->each(function ($tipo_horario, $index) {
            if ($index == 0) {
                // $tipo_horario->field = 'value';
            }
        });

        TipoHorario::insert($tipo_horarios->toArray());
    }

}

