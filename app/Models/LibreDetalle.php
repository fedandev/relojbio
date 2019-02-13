<?php

namespace App\Models;
//use OwenIt\Auditing\Contracts\Auditable;

class LibreDetalle extends Model //implements Auditable
{       
    //use \OwenIt\Auditing\Auditable;
    public $timestamps = false;
    
    protected $fillable = ['fecha_desde', 'fecha_hasta', 'comentarios', 'fk_tipo_libre_id', 'fk_empleado_id'];
    
    public function TipoLibre(){
        return $this->hasOne('App\Models\TipoLibre', 'id', 'fk_tipo_libre_id');
    }
    
    public function Empleado(){
        return $this->hasOne('App\Models\Empleado', 'id', 'fk_empleado_id');
    }
    
    
}
