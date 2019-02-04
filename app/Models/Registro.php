<?php

namespace App\Models;
use OwenIt\Auditing\Contracts\Auditable;

class Registro extends Model implements Auditable
{       
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['registro_hora', 'registro_fecha', 'registro_tipomarca', 'registro_comentarios', 'registro_registrado', 'registro_tipo', 'fk_empleado_cedula', 'fk_dispositivo_id'];
    public $timestamps = false;
    
    public function Empleado(){
        return $this->hasOne('App\Models\Empleado','empleado_cedula','fk_empleado_cedula');
    }
    
    public function Dispositivo(){
        return $this->hasOne('App\Models\Dispositivo','id','fk_dispositivo_id');
    }
    
    public function Eliminar(){
        $this->delete();    
    }
}
