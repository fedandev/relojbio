<?php

use Illuminate\Database\Seeder;
use App\Models\Ajuste;

class AjustesTableSeeder extends Seeder
{
    public function run()
    {
        $ajustes = factory(Ajuste::class)->times(50)->make()->each(function ($ajuste, $index) {
            if ($index == 0) {
                // $ajuste->field = 'value';
            }
        });

        Ajuste::insert($ajustes->toArray());
    }

}

