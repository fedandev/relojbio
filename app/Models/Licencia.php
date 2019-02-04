<?php

namespace App\Models;
use OwenIt\Auditing\Contracts\Auditable;

class Licencia extends Model implements Auditable
{       
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['licencia_anio', 'licencia_cantidad', 'licencia_observaciones', 'fk_tipolicencia_id', 'fk_empleado_id'];
    public $timestamps = false;
    
    public function Empleado()
    {
        return $this->hasOne('App\Models\Empleado', 'id', 'fk_empleado_id');
    }
    
    public function TipoLicencia()
    {
        return $this->hasOne('App\Models\TipoLicencia', 'id', 'fk_tipolicencia_id');
    }
    
    
    public function LicenciaDetalles()
    {
        return $this->hasMany('App\Models\LicenciaDetalle','fk_licencia_id','id');
    }
    
    public function Eliminar(){
        foreach($this->LicenciaDetalles()->get() as $ld ){
				$ld->eliminar();
		}
        $this->delete();    
    }
    
}
