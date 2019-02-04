<?php

use Illuminate\Database\Seeder;
use App\Models\Sucursal;

class SucursalsTableSeeder extends Seeder
{
    public function run()
    {
        $sucursals = factory(Sucursal::class)->times(50)->make()->each(function ($sucursal, $index) {
            if ($index == 0) {
                // $sucursal->field = 'value';
            }
        });

        Sucursal::insert($sucursals->toArray());
    }

}

