<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Empresa;
use Mail;
use Log;
class MarcasAyer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'registros:marcas_ayer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
          $key_app = 'eQXSUoh4RkX5DvTktmlT7+SVueSChf5mrqlJscwK8KU=';
          app('App\Http\Controllers\ReportesRESTController')->empleadosMarcasAyer($key_app);
          Log::info("Se ejecuto el reporte correctamente");
    }
}
