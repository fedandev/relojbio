<?php

use Illuminate\Database\Seeder;
use App\Models\Perfil;

class PerfilsTableSeeder extends Seeder
{
    public function run()
    {
        $perfils = factory(Perfil::class)->times(50)->make()->each(function ($perfil, $index) {
            if ($index == 0) {
                // $perfil->field = 'value';
            }
        });

        Perfil::insert($perfils->toArray());
    }

}

