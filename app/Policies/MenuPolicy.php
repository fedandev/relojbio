<?php



namespace App\Policies;

use App\User;
use App\Models\Menu;

class MenuPolicy extends Policy
{
    
    
    public function update(User $user, Menu $menu)
    {
        return true;
    }

    public function destroy(User $user, Menu $menu)
    {
        return true;
    }
    
    public function index(User $user){
        return true;
    }


    public function show(User $user){
        return true;
    }  
    
    
    public function edit(User $user){
 
        return true;
    }
    
    public function store(User $user){
      
        return true;
    }
    
     public function create(User $user){
        
        return true;
    }
    
}
