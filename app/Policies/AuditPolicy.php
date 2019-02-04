<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Audit;

class AuditPolicy extends Policy
{
    public function update(User $user, Audit $audit)
    {
        // return $audit->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Audit $audit)
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
    
    
    public function search(User $user){
        // return $menu->user_id == $user->id;
        return true;
    }
    
   
    
}
