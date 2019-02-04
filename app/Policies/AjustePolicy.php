<?php

namespace App\Policies;

use App\User;
use App\Models\Ajuste;

class AjustePolicy extends Policy
{
    public function update(User $user, Ajuste $ajuste)
    {
        // return $ajuste->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Ajuste $ajuste)
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
