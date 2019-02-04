<?php

namespace App\Observers;

use App\Models\Log;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class LogObserver
{
    public function creating(Log $log)
    {
        //
    }

    public function updating(Log $log)
    {
        //
    }
}