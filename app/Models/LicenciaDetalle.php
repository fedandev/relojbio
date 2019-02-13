<?php

namespace App\Models;
//use OwenIt\Auditing\Contracts\Auditable;

class LicenciaDetalle extends Model //implements Auditable
{
    //use \OwenIt\Auditing\Auditable;
    protected $fillable = ['fecha_desde', 'fecha_hasta', 'aplica_sabado', 'aplica_domingo', 'aplica_libre', 'comentarios', 'fk_licencia_id'];
    public $timestamps = false;
    
    public function Licencia()
    {
        return $this->hasOne('App\Models\Licencia', 'id', 'fk_licencia_id');
    }
    
    
}
