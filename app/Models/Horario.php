<?php

namespace App\Models;
//use OwenIt\Auditing\Contracts\Auditable;

class Horario extends Model //implements Auditable
{       
    //use \OwenIt\Auditing\Auditable;
    protected $fillable = ['horario_nombre', 'horario_entrada', 'horario_salida', 'horario_comienzobrake', 'horario_finbrake', 'horario_tiempotarde', 'horario_salidaantes', 'horario_haybrake','horario_entrada_m', 'horario_salida_m', 'horario_comienzobrake_m', 'horario_finbrake_m','horario_haybrake_m'];
    public $timestamps = false;
    
    public function HorariosRotativos()
    {
        return $this->hasMany('App\Models\HorarioRotativo', 'fk_horario_id', 'id');
    }
    
    public function Turnos()
    {
        return $this->hasMany('App\Models\Turno', 'fk_horario_id', 'id');
    }
    
    public function Eliminar(){
		
		if($this->HorariosRotativos->count() > 0){
			$h_rotativos = $this->HorariosRotativos()->get();
			foreach($h_rotativos as $hr){
				$hr->eliminar();
			}
		}
		
		if($this->Turnos->count() > 0){
			$turnos = $this->Turnos()->get();
			foreach($turnos as $t){
				$t->eliminar();
			}
		}
		
        $this->delete();    
    }
    
    
}
