<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Feriado extends Model implements Auditable
{       
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['feriado_nombre', 'feriado_coeficiente', 'feriado_minimo', 'feriado_fecha' , 'feriado_laborable'];
    public $timestamps = false;
}
