<?php

namespace App\Models;
//use OwenIt\Auditing\Contracts\Auditable;

class TipoHorario extends Model //implements Auditable
{       
    //use \OwenIt\Auditing\Auditable;
    protected $fillable = ['tipohorario_nombre', 'tipohorario_descripcion'];
    public $timestamps = false;
    
    public function TipoEmpleado()
    {
        return $this->hasMany('App\Models\TipoEmpleado','fk_tipohorario_id','id');
    }
    
    public function Eliminar(){
		
		if($this->TipoEmpleado->count() > 0){
			$tipo_empleado = $this->TipoEmpleado()->get();
			foreach($tipo_empleado as $t){
				$t->eliminar();
			}
		}
		
        $this->delete();    
    }
}
