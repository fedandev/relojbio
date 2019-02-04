<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{       
    protected $fillable = ['menu_padre_id', 'menu_descripcion', 'menu_posicion', 'menu_habilitado', 'menu_url', 'menu_icono', 'menu_formulario'];
    public $timestamps = false;
    
    public function Modulos()
    {
        return $this->belongsToMany('App\Models\Modulo', 'modulos_menus', 'fk_menu_id', 'fk_modulo_id');
    }
    
    
    public function menus_hijos(){
        //$hijos= Menu::where('menu_padre_id', '=', $this->id)->orderby('menu_posicion')->get();
        $menus_res = DB::select('select * from menus where menu_habilitado=1 and menu_padre_id= :menu_id and id in (select fk_menu_id from modulos_menus where fk_modulo_id in (select fk_modulo_id from perfiles_modulos where fk_perfil_id in (select fk_perfil_id from perfiles_usuarios where fk_user_id = :id))) order by menu_posicion', ['menu_id'=> $this->id,'id' => auth()->user()->id]);
        $menu_descripcion = $this->menu_descripcion;
       
        $hijos = Menu::hydrate($menus_res);
        return $hijos;
    }
    
    public function padre(){
        $padre = Menu::find($this->menu_padre_id);
        return $padre;
    }
    
    
   
    
    
}
