<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Autorizacion extends Model implements Auditable
{       
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['autorizacion_fechadesde', 'autorizacion_fechahasta', 'autorizacion_antesHorario', 'autorizacion_despuesHorario', 'autorizacion_descripcion', 'fk_empleado_id'];
    public $timestamps = false;

     public function Empleado()
    {
        return $this->hasOne('App\Models\Empleado', 'id', 'fk_empleado_id');
    }
}
