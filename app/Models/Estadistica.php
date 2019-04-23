<?php

namespace App\Models;

class Estadistica extends Model
{
    protected $fillable = ['fecha_desde', 'fecha_hasta', 'total_horas_trabajadas', 'total_horas_extras', 'total_llegadas_tardes', 'total_debe_trabajar'];
}
