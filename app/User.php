<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre','estado','observaciones','email', 'password', 'fk_empleado_cedula'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function Perfiles()
    {
        return $this->belongsToMany('App\Models\Perfil', 'perfiles_usuarios', 'fk_user_id', 'fk_perfil_id');
    }
    
    public function MenusHabilitados(){
        //$menus_res = DB::select('select * from menus where id in (select fk_menu_id from modulos_menus where fk_modulo_id in (select fk_modulo_id from perfiles_modulos where fk_perfil_id in (select fk_perfil_id from perfiles_usuarios where fk_user_id = :id))) order by menu_posicion', ['id' =>auth()->user()->id]); 
        $menus_res = DB::select('select * from menus where menu_habilitado=1 and menu_padre_id=0 and id in (select fk_menu_id from modulos_menus where fk_modulo_id in (select fk_modulo_id from perfiles_modulos where fk_perfil_id in (select fk_perfil_id from perfiles_usuarios where fk_user_id = :id))) order by menu_posicion', ['id' =>auth()->user()->id]); 
        $menus = Menu::hydrate($menus_res);
        return $menus;
    }
    
    
    public function Empleado(){
        return $this->hasOne('App\Models\Empleado','empleado_cedula','fk_empleado_cedula');
    }
}
