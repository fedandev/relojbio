<?php

namespace App\Policies;

use App\User;
use App\Models\Empleado;

class EmpleadoPolicy extends Policy
{
    public function update(User $user, Empleado $empleado)
    {
        // return $empleado->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Empleado $empleado)
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
        dump("asd");
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
