<?php

namespace App\Models;
use OwenIt\Auditing\Contracts\Auditable;

class TipoEmpleado extends Model implements Auditable
{       
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['tipoempleado_nombre', 'tipoempleado_descripcion', 'fk_tipohorario_id'];
    public $timestamps = false;
    
    public function TipoHorario()
    {
        return $this->hasOne('App\Models\TipoHorario','id','fk_tipohorario_id');
    }
}
