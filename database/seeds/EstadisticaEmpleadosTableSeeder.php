<?php

use Illuminate\Database\Seeder;
use App\Models\EstadisticaEmpleado;

class EstadisticaEmpleadosTableSeeder extends Seeder
{
    public function run()
    {
        $estadistica_empleados = factory(EstadisticaEmpleado::class)->times(50)->make()->each(function ($estadistica_empleado, $index) {
            if ($index == 0) {
                // $estadistica_empleado->field = 'value';
            }
        });

        EstadisticaEmpleado::insert($estadistica_empleados->toArray());
    }

}

