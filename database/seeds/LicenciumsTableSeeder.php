<?php

use Illuminate\Database\Seeder;
use App\Models\Licencium;

class LicenciumsTableSeeder extends Seeder
{
    public function run()
    {
        $licenciums = factory(Licencium::class)->times(50)->make()->each(function ($licencium, $index) {
            if ($index == 0) {
                // $licencium->field = 'value';
            }
        });

        Licencium::insert($licenciums->toArray());
    }

}

