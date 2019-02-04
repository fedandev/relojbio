<?php

use Illuminate\Database\Seeder;
use App\Models\Audit;

class AuditsTableSeeder extends Seeder
{
    public function run()
    {
        $audits = factory(Audit::class)->times(50)->make()->each(function ($audit, $index) {
            if ($index == 0) {
                // $audit->field = 'value';
            }
        });

        Audit::insert($audits->toArray());
    }

}

