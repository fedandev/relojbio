<?php

namespace App\Observers;

use App\Models\Audit;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class AuditObserver
{
    public function creating(Audit $audit)
    {
        //
    }

    public function updating(Audit $audit)
    {
        //
    }
}