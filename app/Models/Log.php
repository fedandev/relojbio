<?php

namespace App\Models;

class Log extends Model
{
    protected $fillable = ['log_fecha', 'log_accion', 'log_tabla', 'log_parametro', 'log_otros', 'fk_usuario_id'];
    public $timestamps = false;
    
    public function Usuario()
    {
        return $this->hasOne('App\User', 'fk_usuario_id', 'id');
    }
}
