<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Trabaja;

class Empleado extends Model implements Auditable
{       
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['empleado_cedula', 'empleado_codigo', 'empleado_nombre', 'empleado_apellido', 'empleado_correo', 'empleado_telefono', 'empleado_fingreso', 'empleado_estado', 'fk_tipoempleado_id', 'fk_oficina_id', 'empleado_fec_venc_cedula', 'empleado_fec_venc_lic_cond', 'empleado_fec_venc_salud'];
    public $timestamps = false;
    
    public function Oficina(){
        return $this->hasOne('App\Models\Oficina','id','fk_oficina_id');
    }
    
    public function TipoEmpleado(){
        return $this->hasOne('App\Models\TipoEmpleado','id','fk_tipoempleado_id');
    }
    
    public function Trabaja(){
        return $this->hasMany('App\Models\Trabaja','fk_empleado_id','id');
    }
    
    public function Registros(){
        return $this->hasMany('App\Models\Registro','fk_empleado_cedula','empleado_cedula');
    }
    
    public function Licencias(){
        return $this->hasMany('App\Models\Licencia','fk_empleado_id','id');
    }
    
    public function Libres(){
        return $this->hasMany('App\Models\LibreDetalle','fk_empleado_id','id');
    }
    
    public function HorarioEnFecha($fecha){
        $trabaja = Trabaja::where('fk_empleado_id', '=', $this->id)->where('trabaja_fechainicio', '<=', $fecha)->where('trabaja_fechafin', '>=', $fecha)->with(['turno', 'HorarioRotativo', 'HorarioSemanal'])->first();
        return $trabaja;
    }
    
    public function Eliminar(){
        if($this->registros->count() > 0){
			$registros = $this->registros()->get();
			foreach($registros as $reg){
				$reg->eliminar();			//funcion del modelo Registro
			}
		}
		
		if($this->licencias->count() > 0){
			$licencias = $this->licencias()->get();
			foreach($licencias as $li){
				$li->eliminar();
			}
		}
		
		if($this->trabaja->count() > 0){
			$trabaja = $this->trabaja()->get();
			foreach($trabaja as $tra){
				$tra->eliminar();
			}
		}
		
		if($this->Libres->count() > 0){
			$libres= $this->Libres()->get();
			foreach($libres as $lib){
				$lib->eliminar();
			}
		}
		
        $this->delete();    
    }
    
}
