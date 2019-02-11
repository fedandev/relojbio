<?php

namespace App\Models;
use OwenIt\Auditing\Contracts\Auditable;

class Empresa extends Model implements Auditable
{       
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['empresa_nombre', 'empresa_telefono', 'empresa_estado', 'empresa_ingreso','empresa_email', 'empresa_email2', 'empresa_telefono2'];
    public $timestamps = false;
    
    public function Dispositivos(){
        return $this->hasMany('App\Models\Dispositivo','fk_empresa_id','id');
    }
    
    
    public function Sucursales(){
        return $this->hasMany('App\Models\Sucursal','fk_empresa_id','id');
    }
    
    public function Eliminar(){
		
		if($this->dispositivos->count() > 0){
			$dispositivos = $this->dispositivos()->get();
			foreach($dispositivos as $d){
				$d->eliminar();
			}
		}
		
		if($this->Sucursales->count() > 0){
			$sucursales = $this->Sucursales()->get();
			foreach($sucursales as $suc){
				$suc->eliminar();
			}
		}
		
		
		
        $this->delete();    
    }
    
}
