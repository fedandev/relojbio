<?php

namespace App\Models;
//use OwenIt\Auditing\Contracts\Auditable;

class Ajuste extends Model //implements Auditable
{       
    //use \OwenIt\Auditing\Auditable;
    protected $fillable = ['ajuste_nombre', 'ajuste_valor', 'ajuste_descripcion'];
    public $timestamps = false;
}
