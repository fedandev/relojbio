<?php

use Illuminate\Database\Seeder;
use App\Models\TipoEmpleado;

class TipoEmpleadosTableSeeder extends Seeder
{
    public function run()
    {
        $tipo_empleados = factory(TipoEmpleado::class)->times(50)->make()->each(function ($tipo_empleado, $index) {
            if ($index == 0) {
                // $tipo_empleado->field = 'value';
            }
        });

        TipoEmpleado::insert($tipo_empleados->toArray());
    }

}

