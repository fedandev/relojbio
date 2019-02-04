<?php

namespace App\Policies;

use App\User;
use App\Models\Dispositivo;

class DispositivoPolicy extends Policy
{
    public function update(User $user, Dispositivo $dispositivo)
    {
        // return $dispositivo->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Dispositivo $dispositivo)
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
    
    
    public function download(User $user){
        // return $menu->user_id == $user->id;
        return true;
    }
}
