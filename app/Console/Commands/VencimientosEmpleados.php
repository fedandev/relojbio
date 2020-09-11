<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\VencimientosEmpleadosTrait;
use Log;
class VencimientosEmpleados extends Command
{
     use VencimientosEmpleadosTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vencimientos_empl:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Chequea Vencimientos Empleados';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      Log::info("INICIA ejecucion de VencimientosEmpleados: ". date('Y-m-d H:i:s',strtotime('now')));
      $ok = $this->VencimientosEmpleados();      
      Log::info("FINALIZA ejecucion de VencimientosEmpleados: ". date('Y-m-d H:i:s',strtotime('now')));
    }
}
