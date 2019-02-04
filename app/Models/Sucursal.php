<?php

namespace App\Models;
use OwenIt\Auditing\Contracts\Auditable;

class Sucursal extends Model implements Auditable
{       
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['sucursal_nombre', 'sucursal_descripcion', 'fk_empresa_id'];
    public $timestamps = false;
    
    public function Empresa(){
        return $this->hasOne('App\Models\Empresa','id','fk_empresa_id');
    }
    
    public function Oficinas(){
        return $this->hasMany('App\Models\Oficina','fk_sucursal_id','id');
    }
    
    
    public function Eliminar(){
        if($this->Oficinas->count() > 0){
			$oficinas = $this->Oficinas()->get();
			foreach($oficinas as $o){
				$o->eliminar();
			}
		}
	
	    $this->delete();    
    }
}
