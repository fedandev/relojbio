<?php

namespace App\Policies;

use App\User;
use App\Models\Empresa;

class EmpresaPolicy extends Policy
{
    public function update(User $user, Empresa $empresa)
    {
        // return $empresa->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Empresa $empresa)
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
