<?php

use Illuminate\Database\Seeder;
use App\Models\HorarioSemanal;

class HorarioSemanalsTableSeeder extends Seeder
{
    public function run()
    {
        $horario_semanals = factory(HorarioSemanal::class)->times(50)->make()->each(function ($horario_semanal, $index) {
            if ($index == 0) {
                // $horario_semanal->field = 'value';
            }
        });

        HorarioSemanal::insert($horario_semanals->toArray());
    }

}

