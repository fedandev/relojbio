<?php

namespace App\Traits;
use App\Models\Ajuste;

trait LockableTrait
{
    
    public function getLockoutTime()
    {
        $ajuste = ajuste('time_lock');
        $lockout_time = $ajuste;                          //Tiempo en minutos para que se bloquee la cuenta por inactividad
        return $lockout_time;
    }

    public function hasLockoutTime()
    {
        return $this->getLockoutTime() > 0;
    }
}