<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Route;


class Policy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
        debug_to_console('construct-policy');
    }
    
    public function before($user, $ability){
        
	    $controller = controllerFromRoute();
	    debug_to_console('controller:'.$controller );
	    
	    // 1= Agregar 2= Modificar 3= Eliminar 4= Consultar
	    switch ($ability) {
            case 'create':
                $id_permiso = 1;
                break;
            case 'update':
                $id_permiso = 2;
                break;
            case 'destroy':
                $id_permiso = 3;
                break;
            case 'index':
                $id_permiso = 4;
                break;
            case 'edit':
                $id_permiso = 2;
                break;
            case 'show':
                $id_permiso = 4;
                break;
            case 'store':
                $id_permiso = 4;
                break;
        }
	    //debug_to_console('idpermiso:'.$id_permiso);
	
	
	    return menuHabilitado( $controller, $id_permiso );
	    
	   
	    
	} // before
	
	
}
