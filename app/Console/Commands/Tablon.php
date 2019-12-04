<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\TablonTrait;

class Tablon extends Command
{
     use TablonTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tablon:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza Tablon';

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
       $ok = $this->Tablon();      
    }
}
