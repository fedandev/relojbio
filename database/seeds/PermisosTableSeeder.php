<?php

use Illuminate\Database\Seeder;
use App\Models\Permiso;

class PermisosTableSeeder extends Seeder
{
    public function run()
    {
        $permisos = factory(Permiso::class)->times(50)->make()->each(function ($permiso, $index) {
            if ($index == 0) {
                // $permiso->field = 'value';
            }
        });

        Permiso::insert($permisos->toArray());
    }

}

