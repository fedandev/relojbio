<?php

namespace App\Models;
use OwenIt\Auditing\Contracts\Auditable;

class HorarioSemanal extends Model implements Auditable
{       
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['horariosemanal_nombre', 'horariosemanal_horas'];
    public $timestamps = false;
    
    public function Trabaja()
    {
        return $this->hasMany('App\Models\Trabaja', 'fk_horario_id', 'id');
    }
    
    public function Eliminar(){
		
		if($this->Trabaja->count() > 0){
			$trabaja = $this->Trabaja()->get();
			foreach($trabaja as $t){
				$t->eliminar();
			}
		}
		
        $this->delete();    
    }
}
