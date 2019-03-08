<?php

namespace App\Models;
//use OwenIt\Auditing\Contracts\Auditable;

class Turno extends Model //implements Auditable
{       
    //use \OwenIt\Auditing\Auditable;
    protected $fillable = ['turno_nombre', 'turno_lunes', 'turno_martes', 'turno_miercoles', 'turno_jueves', 'turno_viernes', 'turno_sabado', 'turno_domingo', 'fk_horario_id','turno_lunes_mh', 'turno_martes_mh', 'turno_miercoles_mh', 'turno_jueves_mh', 'turno_viernes_mh', 'turno_sabado_mh', 'turno_domingo_mh'];
    public $timestamps = false;
    
    public function Horario()
    {
        return $this->belongsTo('App\Models\Horario', 'fk_horario_id', 'id');
    }
    
    public function Trabaja()
    {
        return $this->hasMany('App\Models\Trabaja', 'fk_turno_id', 'id');
    }
    
    public function Eliminar(){
        if($this->Horario->count() > 0){
			$horarios = $this->Horario()->get();
			foreach($horarios as $h){
				$h->eliminar();
			}
		}
		
		if($this->Trabaja->count() > 0){
			$trabajas = $this->Trabaja()->get();
			foreach($trabajas as $t){
				$t->eliminar();
			}
		}
        
        $this->delete();    
    }
    
}
