<?php

namespace App\Models;

class Permiso extends Model
{
    protected $fillable = ['permiso_nombre', 'permiso_habilita'];
    public $timestamps = false;
    
    public function Perfiles()
    {
        return $this->belongsToMany('App\Models\Perfil', 'pefiles_permisos', 'fk_permiso_id', 'fk_perfil_id')->withPivot('permisoperfil_habilita');
    }
}
