<?php

namespace App\Policies;

use App\User;
use App\Models\TipoEmpleado;

class TipoEmpleadoPolicy extends Policy
{
    public function update(User $user, TipoEmpleado $tipo_empleado)
    {
        // return $tipo_empleado->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, TipoEmpleado $tipo_empleado)
    {
        return true;
    }
    
    public function index(User $user){
        // return $menu->user_id == $user->id;
        return true;
    }


    public function show(User $user){
        // return $menu->user_id == $user->id;
        return true;
    }
    
    
    public function edit(User $user){
        // return $menu->user_id == $user->id;
        return true;
    }
    
    public function store(User $user){
        // return $menu->user_id == $user->id;
        return true;
    }
    
     public function create(User $user){
        // return $menu->user_id == $user->id;
        return true;
    }
}
