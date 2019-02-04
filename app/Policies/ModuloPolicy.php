<?php

namespace App\Policies;

use App\User;
use App\Models\Modulo;

class ModuloPolicy extends Policy
{
    public function update(User $user, Modulo $modulo)
    {
        // return $modulo->user_id == $user->id;
        return true;
    } 

    public function destroy(User $user, Modulo $modulo)
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
        debug_to_console('modulo.edit');
        return true;
    }
    
    public function store(User $user){
        debug_to_console('modulo.store');
        return true;
    }
    
     public function create(User $user){
        // return $menu->user_id == $user->id;
        return true;
    }
}
