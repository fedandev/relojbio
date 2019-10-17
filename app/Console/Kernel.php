<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\EliminarRegistrosDuplicados;
use App\Console\Commands\MarcasAyer;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
       EliminarRegistrosDuplicados::class,
       MarcasAyer::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $hora_marcas_ayer = ajuste('hora_marcas_ayer');
        $hora_registro_delete= ajuste('hora_registro_delete');
        if($hora_marcas_ayer == null){
          $hora_marcas_ayer = '12:00';
        }
        if($hora_registro_delete == null){
          $hora_registro_delete = '12:00';
        }
        $schedule->command('registros:delete')->dailyAt($hora_registro_delete);
        $schedule->command('registros:marcas_ayer')->dailyAt($hora_marcas_ayer);
        
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        
        require base_path('routes/console.php');
    }
}
