<?php

namespace App\Models;
//use OwenIt\Auditing\Contracts\Auditable;

class Oficina extends Model //implements Auditable
{       
    //use \OwenIt\Auditing\Auditable;
    protected $fillable = ['oficina_nombre', 'oficina_descripcion', 'oficina_codigo', 'oficina_estado', 'fk_sucursal_id', 'fk_dispositivo_id','oficina_latitud', 'oficina_longitud'];
    public $timestamps = false;
    
    public function Sucursal(){
        return $this->hasOne('App\Models\Sucursal', 'id', 'fk_sucursal_id');
    }
    
    public function Dispositivo(){
        return $this->hasOne('App\Models\Dispositivo', 'id', 'fk_dispositivo_id');
    }
     
    public function Empleados(){
        return $this->hasMany('App\Models\Empleado','fk_oficina_id','id');
    } 
     
    
    public function Eliminar(){
        if($this->Empleados->count() > 0){
			$empleados = $this->Empleados()->get();
			foreach($empleados as $emp){
				$emp->eliminar();
			}
		}
        
        $this->delete();    
    }
}
