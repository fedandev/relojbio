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
		$this->Prueba();
        return view('marcaempleado.index', compact('latitud', 'longitud','rango_max'));
	}
	
	
	public function Prueba(){
		$Empleado = Empleado::where('empleado_cedula',"48806420")->first();		//PONER FOREACH PARA QUE RECORRA TODOS LOS EMPLEADOS
		$fecha = "2019-04-30";													//CAMBIAR A FECHA DE HOY
		$horario = horarioAfecha( $Empleado->id, $fecha);
		
		if($horario[6] == "S"){
			//Horario con brake
			$reg_x_dia_min = 4;
			
		}else{
			//Horario sin brake
			$reg_x_dia_min = 4;
			$registros = Registro::where('registro_fecha',$fecha)->where('fk_empleado_cedula',$Empleado->empleado_cedula)->get();
			$cant_reg = count($registros);
			if($cant_reg < 4){
				//LE FALTO MARCAR
				if($this->ChequearSalidaEntrada($entradas) == "Entrada"){
					dd("Se olvido de marcar entrada");
				}else{
					dd("Se olvido de marcar salida");
				}
			}elseif($cant_reg%2!=0){
				//MARCO MAS DE 4 REGISTROS PERO LE FALTO MARCAR UNO (O LE SOBRA UNO? COMO SE ESO?)
				$entradas = Registro::where('registro_fecha',$fecha)->where('fk_empleado_cedula',$Empleado->empleado_cedula)->where('registro_tipo','I')->get();
				if($this->ChequearSalidaEntrada($entradas) == "Entrada"){
					dd($entradas);
				}else{
					dd("Se olvido de marcar salida");
				}
			}else{
				//TIENE TODAS LAS MARCAS PERO NO SE SI CADA ENTRADA TIENE SU SALIDA, AHORA VOY A CHEQUEAR ESO
				$entradas = Registro::where('registro_fecha',$fecha)->where('fk_empleado_cedula',$Empleado->empleado_cedula)->where('registro_tipo','I')->get();
				$salidas = Registro::where('registro_fecha',$fecha)->where('fk_empleado_cedula',$Empleado->empleado_cedula)->where('registro_tipo','O')->get();
				if(count($entradas) != count($salidas)){
					if($this->ChequearSalidaEntrada($entradas) == "Entrada"){
						dd("Se equivoco puse salida en vez de entrada");
					}elseif($this->ChequearSalidaEntrada($entradas) == "Salida"){
						dd("Se equivoco puse entrada en vez de salida");
					}
				}
			}
		}
	}
	
	public function ChequearSalidaEntrada($entradas){
		if(count($entradas)%2!=0){
			return "Entrada";
		}else{
			return "Salida";
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
    public function store(MarcaEmpleadoRequest $request){
        
        if(auth()->user()->fk_empleado_cedula != ''){
        	$distancia = $request->input('distancia');
        	$distancia = $distancia * 1000;
        	$rango_max = ajuste('rango_gps');
        
        	if($distancia > $rango_max){
        		return redirect()->route('marcaempleado.index')->with('error', 'Fuera de rango');
        	}
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
			return redirect()->route('marcaempleado.index')->with('info', 'Marca registrada con éxito.');
        }else{
        	return redirect()->route('marcaempleado.index')->with('error', 'Usuario no permitido para realizar marcas');
        }
	}
	
}
