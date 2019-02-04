<?php

use Illuminate\Database\Seeder;
use App\Models\Trabaja;

class TrabajasTableSeeder extends Seeder
{
    public function run()
    {
        $trabajas = factory(Trabaja::class)->times(50)->make()->each(function ($trabaja, $index) {
            if ($index == 0) {
                // $trabaja->field = 'value';
            }
        });

        Trabaja::insert($trabajas->toArray());
    }

}

