<?php

use Illuminate\Database\Seeder;
use App\Models\LibreDetalle;

class LibreDetallesTableSeeder extends Seeder
{
    public function run()
    {
        $libre_detalles = factory(LibreDetalle::class)->times(50)->make()->each(function ($libre_detalle, $index) {
            if ($index == 0) {
                // $libre_detalle->field = 'value';
            }
        });

        LibreDetalle::insert($libre_detalles->toArray());
    }

}

