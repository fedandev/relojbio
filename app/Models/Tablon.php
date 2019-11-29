<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tablon extends Model
{
    protected $table = 'tablon';
    public $timestamps = false;
    protected $fillable = ['tablon_fk_empleado_cedula', 'tablon_fecha', 'tablon_h_entrada','tablon_h_ini_brake','tablon_h_fin_brake','tablon_h_salida', 'tablon_h_debe_trabajar', 'tablon_h_trabajadas', 'tablon_h_extras','tablon_h_llegadas_tardes', 'tablon_es_dia_licencia', 'tablon_es_dia_libre', 'tablon_es_dia_feriado', 'tablon_es_dia_facturable','tablon_es_medio_horario', 'tablon_es_nocturno_horario', 'tablon_h_extras_auth', 'tablon_debe_trabajar'];
}
