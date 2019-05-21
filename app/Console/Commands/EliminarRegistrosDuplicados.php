<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class EliminarRegistrosDuplicados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'registros:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina todos los registros duplicados';

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
        DB::statement('CREATE TEMPORARY TABLE t1 SELECT * FROM registros GROUP BY registro_hora, registro_fecha, registro_tipo, fk_empleado_cedula');
        DB::statement('DELETE FROM registros WHERE id NOT IN (SELECT id FROM t1)');
        Log::info("Se eliminaron los registros dobles");
    }
}
