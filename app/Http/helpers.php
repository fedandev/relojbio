<?php
//ARCHIVO PARA REUTILIZACION DE FUNCIONES PARA USO EN FRONT
use Illuminate\Support\Str;
use App\Models\Ajuste;
use App\Models\Menu;
use App\Models\Trabaja;
use App\Models\Registro;
use App\Models\LicenciaDetalle;
use App\SumaTiempos;

function isActiveRoute($route, $output = 'active'){   
    $ruta_actual = Route::getCurrentRoute()->uri();
   
    if ( $ruta_actual == $route) {
        return $output;
    }
}

function isClassLogin($class){
    if (auth()) {
        return ''; 
    }else{
        return $class;
    }
}

function routeIndex($controller){
    $url = str_before($controller,'Controller');
    return Str::lower($url);
}

function controllerFromRoute(){
    $route = Route::currentRouteName();
    $pos = strpos($route, '.');
    
    if($pos != 0){
        $controller = substr($route, 0, $pos);
    }else{
        $controller = $route;
    }
    return $controller;
}

function cacheQuery($sql, $timeout = 60) {
    return Cache::remember(md5($sql), $timeout, function() use ($sql) {
        return DB::select(DB::raw($sql));
    });
}
 
//$cache = $this->cacheQuery("SOME COMPLEX JOINS ETC..", 30);

function getMenusUser(){
    $menus = cacheQuery("select * from menus where menu_habilitado=1 and id in (select fk_menu_id from modulos_menus where fk_modulo_id in (select fk_modulo_id from perfiles_modulos where fk_perfil_id in (select fk_perfil_id from perfiles_usuarios where fk_user_id = ". auth()->user()->id . " )))", 30);
    return $menus;
}

function getMenusUser2(){
    $menus = DB::select('select * from menus where menu_habilitado=1 and id in (select fk_menu_id from modulos_menus where fk_modulo_id in (select fk_modulo_id from perfiles_modulos where fk_perfil_id in (select fk_perfil_id from perfiles_usuarios where fk_user_id = :id_user)))', ['id_user' =>auth()->user()->id]);									

    return $menus;
}

function ajuste($valor){
    $ajuste = Ajuste::where('ajuste_nombre','=',$valor)->first();
    if ($ajuste){
        return $ajuste->ajuste_valor;
    }else{
        return null;
    }
    
}

function debug_to_console( $data ) {
    if (ajuste('debug') =='S'){
        $output = $data;
        if ( is_array( $output ) ){
            $output = implode( ',', $output);
        }
        echo "<script>console.log( 'Debug: " . $output . "' );</script>";
    }
}

function menuHabilitado( $controller, $permiso ) {
    $menu = cacheQuery("SELECT * FROM menus WHERE menu_formulario = '". $controller . "'");
    //$menu = DB::select("SELECT * FROM menus WHERE menu_formulario = '". $controller . "'");
    if(count($menu) > 0){
        
        $menu_id = $menu[0]->id;
        debug_to_console('menuid:'. $menu_id);
      
        $permiso = DB::select('select * from permisos where id= :id_permiso and id in 
                                (select permiso_id from  perfiles_permisos where perfil_id in 
			                        (select fk_perfil_id from perfiles_modulos where fk_modulo_id in	
						                (select fk_modulo_id from modulos_menus where fk_menu_id = :menu_id) 
						                and fk_perfil_id in (select fk_perfil_id from perfiles_usuarios where fk_user_id =:id_user)))',
						                ['id_user' =>auth()->user()->id, ':id_permiso'=>$permiso, 'menu_id' => $menu_id]
						      );
	    if ($permiso){
	        return true;
	    }
    }
    return false;
}    

function formatHora( $datetime, $format_hora ) {
    $hora = strtotime($datetime);
    $hora = date($format_hora, $hora);
    return  $hora;
}

function formatFecha( $date , $format_fecha = null) {
    $fecha = strtotime($date);
    if(!$format_fecha){
        $format_fecha=ajuste('date_format');
    }
    $fecha = date($format_fecha, $fecha);
    //dd($fecha);
    return  $fecha;
}

function horarioAfecha($idEmpleado, $fecha){
    $trabaja = Trabaja::where('fk_empleado_id', '=', $idEmpleado)->where('trabaja_fechainicio', '<=', $fecha)->where('trabaja_fechafin', '>=', $fecha)->get();
    $horario[0] = '';
    $horario[1] = '';
    $horario[2] = '';
    $horario[3] = '';
    if($trabaja){
        if(!is_null($trabaja[0]->fk_horariorotativo_id)){
            if($trabaja[0]->horariorotativo->horario->horario_haybrake == "S"){
                $horario[0] = $trabaja[0]->horariorotativo->horario->horario_entrada;
                $horario[1] = $trabaja[0]->horariorotativo->horario->horario_comienzobrake;
                $horario[2] = $trabaja[0]->horariorotativo->horario->horario_finbrake;
                $horario[3] = $trabaja[0]->horariorotativo->horario->horario_salida;
            }else{
                $horario[0] = $trabaja[0]->horariorotativo->horario->horario_entrada;
                $horario[1]=  $trabaja[0]->horariorotativo->horario->horario_salida;
            }
        }elseif(!is_null($trabaja[0]->fk_turno_id)){
            if($trabaja[0]->turno->horario->horario_haybrake == "S"){
                $horario[0] = $trabaja[0]->turno->horario->horario_entrada;
                $horario[1] = $trabaja[0]->turno->horario->horario_comienzobrake;
                $horario[2] = $trabaja[0]->turno->horario->horario_finbrake;
                $horario[3] = $trabaja[0]->turno->horario->horario_salida;
            }else{
                $horario[0] = $trabaja[0]->turno->horario->horario_entrada;
                $horario[1] = $trabaja[0]->turno->horario->horario_salida;
            }
        }
    } 
    return $horario;
}

function totalHorasAfecha($horario){
    $horas = '';
    if(count($horario) == 2){
        $horas = date('H:i:s', strtotime($horario[1]) - strtotime($horario[0]));
    }elseif(count($horario) == 4){
        $horas = date('H:i:s', strtotime($horario[1]) - strtotime($horario[0]) + strtotime($horario[3]) - strtotime($horario[2]));
    }
    return $horas;
}

function totalExtras($registros, $horarioAhacer){
    $fecha = ""; $total = ""; $cedula = ""; $horasHechas = ""; $primero = "S";
    $ajuste = Ajuste::where('ajuste_nombre','=','minimo_extras')->first();
    $iArray = 0;
    $array = array();
    $tiempos = array();
    foreach($registros as $registro){
        if($primero == "S"){
            $fecha = $registro->registro_fecha;
            $total = $registro->registro_totalHoras;
            $cedula = $registro->fk_empleado_cedula;
            array_push($tiempos, $registro->registro_totalHoras);
            $primero = "N";
        }else{
            if($fecha == $registro->registro_fecha && $cedula == $registro->fk_empleado_cedula){
                //$horasHechas = date('H:i:s', strtotime($total) + strtotime($registro->registro_totalHoras));
                array_push($tiempos, $registro->registro_totalHoras);
            }else{
                $tiempoTrabajado = new SumaTiempos();
                
                foreach ($tiempos as $parcial) {
                    $tiempoTrabajado->sumaTiempo(new SumaTiempos($parcial));
                }
                
                if($horarioAhacer < $tiempoTrabajado->verTiempoFinal()){
                    $resta = date('H:i:s', strtotime($tiempoTrabajado->verTiempoFinal()) - strtotime($horarioAhacer));
                }else{
                    $resta = "-".date('H:i:s', strtotime($horarioAhacer) - strtotime($tiempoTrabajado->verTiempoFinal()));
                }
                
                if($resta > $ajuste->ajuste_valor){
                    $array[$iArray][0] = $cedula;
                    $array[$iArray][1] = $fecha;
                    $array[$iArray][2] = $resta;
                    $iArray++;
                }
                $fecha = $registro->registro_fecha;
                $total = $registro->registro_totalHoras;
                $cedula = $registro->fk_empleado_cedula;
                $tiempos = array();
                array_push($tiempos, $registro->registro_totalHoras);
            }
        }
    }
    return $array;
}

function RegistrosLicencia($arrayDias, $cedulaEmpleado, $entrada, $salida){
    foreach($arrayDias as $dia){
        $registroEntrada = new Registro();
		$registroEntrada->registro_hora = $dia[0]. " " .$entrada;
		$registroEntrada->registro_fecha = $dia[0];
		$registroEntrada->registro_tipomarca = "Automático";
		$registroEntrada->registro_comentarios = "Licencia aplicada.";
		$registroEntrada->registro_tipo = "I";
		$registroEntrada->registro_registrado = "NO";
		$registroEntrada->fk_empleado_cedula = $cedulaEmpleado;
		
		$registroEntrada->save();
		
		$registroSalida = new Registro();
		$registroSalida->registro_hora = $dia[0]. " " .$salida;
		$registroSalida->registro_fecha = $dia[0];
		$registroSalida->registro_tipomarca = "Automático";
		$registroSalida->registro_comentarios = "Licencia aplicada.";
		$registroSalida->registro_tipo = "O";
		$registroSalida->registro_registrado = "NO";
		$registroSalida->fk_empleado_cedula = $cedulaEmpleado;
		
		$registroSalida->save();
    }
}

function RegistrosLibres($arrayDias, $cedulaEmpleado, $tipoLibre, $entrada, $salida){
    foreach($arrayDias as $dia){
        $registroEntrada = new Registro();
		$registroEntrada->registro_hora = $dia[0]. " " .$entrada;
		$registroEntrada->registro_fecha = $dia[0];
		$registroEntrada->registro_tipomarca = "Automático";
		$registroEntrada->registro_comentarios = "Libre Concedido - ". $tipoLibre;
		$registroEntrada->registro_tipo = "I";
		$registroEntrada->registro_registrado = "NO";
		$registroEntrada->fk_empleado_cedula = $cedulaEmpleado;
		
		
		$registroEntrada->save();
		
		$registroSalida = new Registro();
		$registroSalida->registro_hora = $dia[0]. " " .$salida;
		$registroSalida->registro_fecha = $dia[0];
		$registroSalida->registro_tipomarca = "Automático";
		$registroSalida->registro_comentarios = "Libre Concedido - ". $tipoLibre;
		$registroSalida->registro_tipo = "O";
		$registroSalida->registro_registrado = "NO";
		$registroSalida->fk_empleado_cedula = $cedulaEmpleado;
		
		$registroSalida->save();
    }
}

function existeLicencia($fechaInicio, $fechaFin, $fk_licencia_id ){
	debug_to_console($fk_licencia_id);
	$cant_licencias= LicenciaDetalle::whereBetween('fecha_desde',[$fechaInicio, $fechaFin])->where('fk_licencia_id', '=', $fk_licencia_id)->count();
	debug_to_console($cant_licencias);
	if ($cant_licencias > 0){
		return Redirect()->back()->withErrors(['Ya existe licencia para el periodo de fecha seleccionado.']);
	}
}
