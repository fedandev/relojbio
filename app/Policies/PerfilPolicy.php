<?php

namespace App\Policies;

use App\User;
use App\Models\Perfil;

class PerfilPolicy extends Policy
{
    public function update(User $user, Perfil $perfil)
    {
        // return $perfil->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Perfil $perfil)
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
    
    
    public function edit(User $user, Perfil $perfil){
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
