<?php

use Illuminate\Database\Seeder;
use App\Models\Oficina;

class OficinasTableSeeder extends Seeder
{
    public function run()
    {
        $oficinas = factory(Oficina::class)->times(50)->make()->each(function ($oficina, $index) {
            if ($index == 0) {
                // $oficina->field = 'value';
            }
        });

        Oficina::insert($oficinas->toArray());
    }

}

