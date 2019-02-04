<?php

use Illuminate\Database\Seeder;
use App\Models\LicenciaDetalle;

class LicenciaDetallesTableSeeder extends Seeder
{
    public function run()
    {
        $licencia_detalles = factory(LicenciaDetalle::class)->times(50)->make()->each(function ($licencia_detalle, $index) {
            if ($index == 0) {
                // $licencia_detalle->field = 'value';
            }
        });

        LicenciaDetalle::insert($licencia_detalles->toArray());
    }

}

