<?php

use Illuminate\Database\Seeder;
use App\Models\Conversacion;

class ConversacionsTableSeeder extends Seeder
{
    public function run()
    {
        $conversacions = factory(Conversacion::class)->times(50)->make()->each(function ($conversacion, $index) {
            if ($index == 0) {
                // $conversacion->field = 'value';
            }
        });

        Conversacion::insert($conversacions->toArray());
    }

}

