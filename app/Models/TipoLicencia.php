<?php

namespace App\Models;
//use OwenIt\Auditing\Contracts\Auditable;

class TipoLicencia extends Model //implements Auditable
{       
    //use \OwenIt\Auditing\Auditable;
    protected $fillable = ['tipolicencia_nombre', 'tipolicencia_descripcion'];
    public $timestamps = false;
    
    
    public function Licencias(){
        return $this->hasMany('App\Models\Licencia','fk_tipolicencia_id','id');
    }
    
    
    
    public function Eliminar(){
		
		if($this->Licencias->count() > 0){
			$licencias = $this->Licencias()->get();
			foreach($licencias as $lic){
				$lic->eliminar();
			}
		}
		
        $this->delete();    
    }
    
    
}
