<?php

namespace App\Models;
use OwenIt\Auditing\Contracts\Auditable;

class Modulo extends Model implements Auditable
{       
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['modulo_nombre', 'modulo_descripcion'];
    public $timestamps = false;
    
    public function Perfiles()
    {
        return $this->belongsToMany('App\Models\Perfil', 'perfiles_modulos', 'fk_modulo_id', 'fk_perfil_id');
    }
    
    public function Menus()
    {
        return $this->belongsToMany('App\Models\Menu', 'modulos_menus', 'fk_modulo_id', 'fk_menu_id')->orderBy('menu_descripcion');
        
    }
    
     
    public function Eliminar(){
		
		if($this->Perfiles->count() > 0){
			$perfiles = $this->Perfiles()->get();
			foreach($perfiles as $p){
				$p->eliminar();
			}
		}
		
		if($this->Menus->count() > 0){
			$menus = $this->Menus()->get();
			foreach($menus as $m){
				$m->eliminar();
			}
		}
	
        $this->delete();    
    }
    
}
