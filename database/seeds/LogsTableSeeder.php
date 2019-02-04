<?php

use Illuminate\Database\Seeder;
use App\Models\Log;

class LogsTableSeeder extends Seeder
{
    public function run()
    {
        $logs = factory(Log::class)->times(50)->make()->each(function ($log, $index) {
            if ($index == 0) {
                // $log->field = 'value';
            }
        });

        Log::insert($logs->toArray());
    }

}

