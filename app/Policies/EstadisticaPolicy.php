<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Estadistica;

class EstadisticaPolicy extends Policy
{
    public function update(User $user, Estadistica $estadistica)
    {
        // return $estadistica->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Estadistica $estadistica)
    {
        return true;
    }
}
