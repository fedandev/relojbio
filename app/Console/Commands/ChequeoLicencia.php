<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\CheckLicenciaSysClockTrait;
class ChequeoLicencia extends Command
{
    use CheckLicenciaSysClockTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'licencia:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica el vencimiento de licencia de SysClock.';

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
        $this->ChequeoLicencia();
    }
}
