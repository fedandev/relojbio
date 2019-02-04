<?php

namespace App\Models;

class Audit extends Model 
{
    protected $fillable = ['user_id', 'event', 'auditable_id', 'auditable_type', 'old_values', 'new_values', 'url', 'ip_address', 'user_agent', 'tags'];
    
    public function User()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
   
}
