<?php

namespace App\Policies;

use App\User;
use App\Models\Autorizacion;

class AutorizacionPolicy extends Policy
{
    public function update(User $user, Autorizacion $autorizacion)
    {
        // return $autorizacion->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Autorizacion $autorizacion)
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
