<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TipoLibre;

class TipoLibrePolicy extends Policy
{
    public function update(User $user, TipoLibre $tipo_libre)
    {
        // return $tipo_libre->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, TipoLibre $tipo_libre)
    {
        return true;
    }
}
