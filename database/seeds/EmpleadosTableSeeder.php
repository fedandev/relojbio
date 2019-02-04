<?php

use Illuminate\Database\Seeder;
use App\Models\Empleado;

class EmpleadosTableSeeder extends Seeder
{
    public function run()
    {
        $empleados = factory(Empleado::class)->times(50)->make()->each(function ($empleado, $index) {
            if ($index == 0) {
                // $empleado->field = 'value';
            }
        });

        Empleado::insert($empleados->toArray());
    }

}

