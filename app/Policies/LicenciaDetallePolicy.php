<?php

namespace App\Policies;

use App\User;
use App\Models\LicenciaDetalle;

class LicenciaDetallePolicy extends Policy
{
    public function update(User $user, LicenciaDetalle $licencia_detalle)
    {
        // return $licencia_detalle->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, LicenciaDetalle $licencia_detalle)
    {
        return true;
    }
}
