<?php

use Illuminate\Database\Seeder;
use App\Models\Estadistica;

class EstadisticasTableSeeder extends Seeder
{
    public function run()
    {
        $estadisticas = factory(Estadistica::class)->times(50)->make()->each(function ($estadistica, $index) {
            if ($index == 0) {
                // $estadistica->field = 'value';
            }
        });

        Estadistica::insert($estadisticas->toArray());
    }

}

