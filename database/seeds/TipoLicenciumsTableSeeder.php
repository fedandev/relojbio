<?php

use Illuminate\Database\Seeder;
use App\Models\TipoLicencium;

class TipoLicenciumsTableSeeder extends Seeder
{
    public function run()
    {
        $tipo_licenciums = factory(TipoLicencium::class)->times(50)->make()->each(function ($tipo_licencium, $index) {
            if ($index == 0) {
                // $tipo_licencium->field = 'value';
            }
        });

        TipoLicencium::insert($tipo_licenciums->toArray());
    }

}

