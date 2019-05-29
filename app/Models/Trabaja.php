<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Trabaja extends Model implements Auditable
{       
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['trabaja_fechainicio', 'trabaja_fechafin', 'fk_horariorotativo_id', 'fk_turno_id', 'fk_horariosemanal_id', 'fk_empleado_id'];
    public $timestamps = false;
    
    public function Turno()
    {
        return $this->hasOne('App\Models\Turno','id','fk_turno_id');
    }
    
    public function HorarioRotativo()
    {
        return $this->hasOne('App\Models\HorarioRotativo','id','fk_horariorotativo_id');
    }
    
    public function HorarioSemanal()
    {
        return $this->hasOne('App\Models\HorarioSemanal','id','fk_horariosemanal_id');
    }
    
    public function Empleado()
    {
        return $this->belongsTo('App\Models\Empleado','fk_empleado_id','id');
    }
    
    public function Eliminar(){
        $this->delete();    
    }
}
