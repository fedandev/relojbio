<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\EliminarRegistrosDuplicados;
use App\Console\Commands\MarcasAyer;
use App\Console\Commands\Tablon;
use App\Console\Commands\VencimientosEmpleados;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        EliminarRegistrosDuplicados::class,
        MarcasAyer::class,
        Tablon::class,
        VencimientosEmpleados::class 
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       $schedule->command('registros:delete')->dailyAt('09:00');  //12:00hs uruguay, 15:00hs servidor
       $schedule->command('registros:marcas_ayer')->dailyAt('15:00');     
       $schedule->command('tablon:update')->dailyAt('01:00');   //22:00hs uruguay, 01:00hs servidor
       $schedule->command('licencia:check')->dailyAt('15:00');
       $schedule->command('vencimientos_empl:check')->dailyAt('02:00');   //23:00hs uruguay, 02:00hs servidor
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
