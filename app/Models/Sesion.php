<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Sesion extends Model implements Auditable
{       
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['sesion_equipo', 'sesion_fecha', 'sesion_hora'];
    public $timestamps = false;
}
