<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\MarcaEmpleadoRequest;

use App\Models\Registro;
use App\Models\Empleado;
use App\Models\Oficina;
use DateTime;

class MarcaEmpleadosController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('auth.lock');
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
		
        return view('marcaempleado.index', compact('latitud', 'longitud','rango_max'));
	}
	
	public function guardar(Request $request){
		$data = $request->get('image');
		if (preg_match('/data:image\/(gif|jpeg|png);base64,(.*)/i', $data, $matches)) {
			$imageType = $matches[1];
			$imageData = base64_decode($matches[2]);
			$image = imagecreatefromstring($imageData);
			$filename = md5($imageData) . '.png';
			
			if (imagepng($image, public_path().'/images/' . $filename)) {
				
				//$return = $this->store($request);
				//echo json_encode(array('filename' => '/images/' . $filename));
			} else {
				//return redirect()->route('marcaempleado.index')->with('error', 'Usuario no permitido para realizar marcas');
			}
		} else {
			return redirect()->route('marcaempleado.index')->with('error', 'Usuario no permitido para realizar marcas');
		}
		
	}
	
    public function store(MarcaEmpleadoRequest $request){
    	
    	$data = $request->input('imageData');
		if (preg_match('/data:image\/(gif|jpeg|png);base64,(.*)/i', $data, $matches)) {
			$imageType = $matches[1];
			$imageData = base64_decode($matches[2]);
			$image = imagecreatefromstring($imageData);
			$filename = md5($imageData) . '.png';
			
			if (imagepng($image, public_path().'/images/marcas/' . $filename)) {
			} else {
				return redirect()->route('marcaempleado.index')->with('error', 'Imagen no se pudo guardar');
			}
		} else {
			return redirect()->route('marcaempleado.index')->with('error', 'Problema al machear imagen.');
		}
        if(auth()->user()->fk_empleado_cedula != ''){
        	
        	$rango_max = ajuste('rango_gps');
        	$rango_max = $rango_max/1000; //paso a km 
        	$latitud = $request->get('latitudNow');
        	$longitud = $request->get('longitudNow');
        	$oficinas = Oficina::all();
        	$hay_rango_oficina = 'N';
        	foreach($oficinas as $oficina){
        		$oficina_latitud = $oficina->oficina_latitud;
        		$oficina_longitud = $oficina->oficina_longitud;
        		
        		if($oficina_latitud != ''){
        			$distancia = distanceCalculation($latitud, $longitud, $oficina_latitud, $oficina_longitud);
        			if($distancia<=$rango_max){
        				$hay_rango_oficina = 'S';
        			}
        		}
        		
        	}
        	
        
        	if($hay_rango_oficina = 'S'){
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
				$registro->registro_comentarios = "Cargado desde Mobile - Imagen ".$filename;
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
					$registro->registro_comentarios = "Cargado desde Mobile - Imagen ".$filename;
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
					$registro->registro_comentarios = "Cargado desde Mobile - Imagen ".$filename;
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
