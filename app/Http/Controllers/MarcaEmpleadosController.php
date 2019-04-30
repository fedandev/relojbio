<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\MarcaEmpleadoRequest;

use App\Models\Registro;
use App\Models\Empleado;
use DateTime;

class MarcaEmpleadosController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        /*if (ajuste('audit') != 'S'){
    		Dispositivo::disableAuditing();
        }else{
        	Dispositivo::enableAuditing();
        }*/
    }

	public function index(){
		//Falta la parte de chequear si esta autorizado para ver y entrar en este formulario
		$latitud = ajuste('latitud');
		$longitud = ajuste('longitud');
        return view('marcaempleado.index', compact('latitud', 'longitud'));
	}
	
    public function store(MarcaEmpleadoRequest $request){
        
        if(auth()->user()->fk_empleado_cedula != ''){
        	$fecha = new DateTime();
        	$hoy = $fecha->format('Y-m-d');
        	$fechahora = $request->input('hora');
        	
        	$empleado = Empleado::where('empleado_cedula',auth()->user()->fk_empleado_cedula)->first();
        	
        	$horario = horarioAfecha($empleado->id,$hoy);
        	
        	if($horario[0] == "00:00:00"){
        		$ayer = date("d-m-Y",strtotime($hoy."- 1 days")); 
        		$registros = Registro::where('fk_empleado_cedula',auth()->user()->fk_empleado_cedula)->where('registro_fecha',$ayer)->get();	
        	}else{
        		$registros = Registro::where('fk_empleado_cedula',auth()->user()->fk_empleado_cedula)->where('registro_fecha',$hoy)->get();	
        	}
        	
        	$ultimoRegistro = $registros->last();
        	
        	if($ultimoRegistro == null){
        		$tipo_marca = "I";
        		$registro = new Registro();
				$registro->registro_hora = $hoy." ".$fechahora;
				$registro->registro_fecha = $fecha->format('Y-m-d');
				$registro->registro_tipomarca = 'Mobile';
				$registro->registro_comentarios = "Cargado desde Mobile";
				$registro->registro_tipo = $tipo_marca;
				$registro->registro_registrado = "NO";
				$registro->fk_empleado_cedula = auth()->user()->fk_empleado_cedula;
				$registro->save();
				
				return redirect()->route('marcaempleado.index')->with('info', 'Marca ENTRADA registrada con éxito.');
        	}else{
        		if($ultimoRegistro->registro_tipo == "I"){
	        		$tipo_marca = "O";
	        		$registro = new Registro();
					$registro->registro_hora = $hoy." ".$fechahora;
					$registro->registro_fecha = $hoy;
					$registro->registro_tipomarca = 'Mobile';
					$registro->registro_comentarios = "Cargado desde Mobile";
					$registro->registro_tipo = $tipo_marca;
					$registro->registro_registrado = "NO";
					$registro->fk_empleado_cedula = auth()->user()->fk_empleado_cedula;
					$registro->save();
					
					return redirect()->route('marcaempleado.index')->with('info', 'Marca SALIDA registrada con éxito.');
        		}else{
        			$tipo_marca = "I";
	        		$registro = new Registro();
					$registro->registro_hora = $hoy." ".$fechahora;
					$registro->registro_fecha = $fecha->format('Y-m-d');
					$registro->registro_tipomarca = 'Mobile';
					$registro->registro_comentarios = "Cargado desde Mobile";
					$registro->registro_tipo = $tipo_marca;
					$registro->registro_registrado = "NO";
					$registro->fk_empleado_cedula = auth()->user()->fk_empleado_cedula;
					$registro->save();
					
					return redirect()->route('marcaempleado.index')->with('info', 'Marca ENTRADA registrada con éxito.');
        		}
        	}
        	
        	
        	
        	
        	
        	
        	
        	
	        $tipo_marca = $request->input('tipo_marca');
	        $registro = new Registro();
			$registro->registro_hora = $fecha;
			$registro->registro_fecha = $fecha->format('Y-m-d');
			$registro->registro_tipomarca = 'Mobile';
			$registro->registro_comentarios = "Cargado desde Mobile";
			$registro->registro_tipo = $tipo_marca;
			$registro->registro_registrado = "NO";
			$registro->fk_empleado_cedula = auth()->user()->fk_empleado_cedula;
			$registro->save();
			
			return redirect()->route('marcaempleado.index')->with('info', 'Marca registrada con éxito.');
        }else{
        	return redirect()->route('marcaempleado.index')->with('error', 'Usuario no permitido para realizar marcas');
        }
	
		
		
	}
	
}
