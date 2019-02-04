<?php

use Illuminate\Database\Seeder;
use App\Models\Empresa;

class EmpresasTableSeeder extends Seeder
{
    public function run()
    {
        $empresas = factory(Empresa::class)->times(50)->make()->each(function ($empresa, $index) {
            if ($index == 0) {
                // $empresa->field = 'value';
            }
        });

        Empresa::insert($empresas->toArray());
    }

}

