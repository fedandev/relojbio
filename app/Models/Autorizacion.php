<?php

namespace App\Models;
//use OwenIt\Auditing\Contracts\Auditable;

class Autorizacion extends Model //implements Auditable
{       
    //use \OwenIt\Auditing\Auditable;
    protected $fillable = ['autorizacion_dia', 'autorizacion_tipo', 'autorizacion_descripcion', 'autorizacion_autorizado', 'fk_empleado_id', 'fk_user_id'];
    public $timestamps = false;

     public function Empleado()
    {
        return $this->hasOne('App\Models\Empleado', 'id', 'fk_empleado_id');
    }
    
     public function Usuario()
    {
        return $this->hasOne('App\User', 'id', 'fk_user_id');
    }
    
    
}
