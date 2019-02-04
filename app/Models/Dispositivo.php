<?php

namespace App\Models;
use OwenIt\Auditing\Contracts\Auditable;

class Dispositivo extends Model implements Auditable
{       
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['dispositivo_nombre', 'dispositivo_serial', 'dispositivo_modelo', 'dispositivo_ip', 'dispositivo_puerto', 'dispositivo_usuario', 'dispositivo_password', 'fk_empresa_id'];
    public $timestamps = false;
    
    public function Empresa(){
        return $this->hasOne('App\Models\Empresa','id','fk_empresa_id');
    }
    
    public function Registros(){
        return $this->hasMany('App\Models\Registro','fk_dispositivo_id', 'id');
    }
    
    public function Oficinas(){
        return $this->hasMany('App\Models\Oficina','fk_dispositivo_id','id');
    }
    
    public function Eliminar(){
		if($this->registros->count() > 0){
			$registros = $this->registros()->get();
			foreach($registros as $reg){
				$reg->eliminar();			
			}
		}
		
		if($this->oficinas->count() > 0){
			$oficinas = $this->oficinas()->get();
			foreach($oficinas as $of){
				$of->eliminar();
			}
		}
        $this->delete();    
    }
    
}
