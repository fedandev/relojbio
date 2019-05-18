<?php

namespace App\Traits;

trait LockableTrait
{
    
    public function getLockoutTime()
    {
        $lockout_time = 5;                          //Tiempo en minutos para que se bloquee la cuenta por inactividad
        return $lockout_time;
    }

    public function hasLockoutTime()
    {
        return $this->getLockoutTime() > 0;
    }
}