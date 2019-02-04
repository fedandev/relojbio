<?php

use Illuminate\Database\Seeder;
use App\Models\HorarioRotativo;

class HorarioRotativosTableSeeder extends Seeder
{
    public function run()
    {
        $horario_rotativos = factory(HorarioRotativo::class)->times(50)->make()->each(function ($horario_rotativo, $index) {
            if ($index == 0) {
                // $horario_rotativo->field = 'value';
            }
        });

        HorarioRotativo::insert($horario_rotativos->toArray());
    }

}

