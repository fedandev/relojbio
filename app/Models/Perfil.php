<?php

namespace App\Models;
use App\Models\Permiso;
//use OwenIt\Auditing\Contracts\Auditable;

class Perfil extends Model //implements Auditable
{       
    //use \OwenIt\Auditing\Auditable;
    protected $fillable = ['perfil_nombre', 'perfil_descripcion'];
    public $timestamps = false;
    
    public function permisos(){
        return $this->belongsToMany(Permiso::class, 'perfiles_permisos');
    }
    
    public function Modulos()
    {
        return $this->belongsToMany('App\Models\Modulo', 'perfiles_modulos', 'fk_perfil_id', 'fk_modulo_id');
    }
    
    public function Usuarios()
    {
        return $this->belongsToMany('App\User', 'perfiles_usuarios', 'fk_perfil_id', 'fk_user_id');
    }
    
    
    public function Eliminar(){
        if($this->permisos->count() > 0){
			$permisos = $this->permisos()->get();
			foreach($permisos as $p){
				$p->eliminar();
			}
		}
		
		if($this->Modulos->count() > 0){
			$modulos = $this->Modulos()->get();
			foreach($modulos as $m){
				$m->eliminar();
			}
		}
        
        $this->delete();    
    }
}
