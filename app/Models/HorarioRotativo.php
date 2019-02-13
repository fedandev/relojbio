<?php

namespace App\Models;
//use OwenIt\Auditing\Contracts\Auditable;

class HorarioRotativo extends Model //implements Auditable
{       
    //use \OwenIt\Auditing\Auditable;
    protected $fillable = ['horariorotativo_nombre', 'horariorotativo_diacomienzo', 'horariorotativo_diastrabajo', 'fk_horario_id', 'horariorotativo_diaslibres'];
    public $timestamps = false;
    
    public function Horario()
    {
        return $this->belongsTo('App\Models\Horario', 'fk_horario_id');
    }
    
    public function Trabaja()
    {
        return $this->hasMany('App\Models\Trabaja', 'fk_horariorotativo_id', 'id');
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
