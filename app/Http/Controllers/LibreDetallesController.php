<?php

namespace App\Http\Controllers;

use App\Models\LibreDetalle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LibreDetalleRequest;
use Carbon\Carbon;
use App\Models\Turno;
use App\Models\Trabaja;
use App\Models\Feriado;
use App\Models\TipoLibre;
use App\Models\Empleado;
use App\Models\Registro;

class LibreDetallesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.lock');
        /*if (ajuste('audit') != 'S'){
    		LibreDetalle::disableAuditing();
        }else{
        	LibreDetalle::enableAuditing();
        }*/
    }

	public function index()
	{
		//$this->authorize('show', LibreDetalle::class);	
		$libre_detalles = LibreDetalle::get();
		return view('libre_detalles.index', compact('libre_detalles'));
	}

    public function show(LibreDetalle $libre_detalle)
    {
    	//$this->authorize('show', $libre_detalle);			
        return view('libre_detalles.show', compact('libre_detalle'));
    }

	public function create(LibreDetalle $libre_detalle)
	{
		//$this->authorize('create', $libre_detalle);	
		return view('libre_detalles.create_and_edit', compact('libre_detalle'));
	}

	public function store(LibreDetalleRequest $request)
	{
		//$this->authorize('store', LibreDetalle::class);	
		 $this->validate($request, [
            'fecha_desde' => 'required',
            'fecha_hasta' => 'required',
            'fk_tipo_libre_id' => 'required',
            'fk_empleado_id' => 'required',
        ]);
		//CREO LOS REGISTROS DEL DÍA LIBRE
		$retorno = $this->countDiasLibres($request);
        if($retorno[0] != "Error"){
			$libre_detalle = LibreDetalle::create($request->all());
			return redirect()->route('libre_detalles.show', $libre_detalle->id)->with('info', 'Creado exitosamente.');
        }else{
        	if($retorno[1] == "Primer Nivel"){
        		return Redirect()->back()->withErrors(['El empleado seleccionado no tiene un turno asignado entre estas fechas.']);
        	}elseif($retorno[1] == "Segundo Nivel"){
        		return Redirect()->back()->withErrors(['Días de licencias insuficientes para el periodo de fecha seleccionado.']);
        	}else{
        		return Redirect()->back()->withErrors(['Error desconocido, por favor pongase en contacto con el administrador.']);
        	}
        }
		
		$libre_detalle = LibreDetalle::create($request->all());
		return redirect()->route('libre_detalles.show', $libre_detalle->id)->with('info', 'Creado exitosamente.');
	}

	/*public function edit(LibreDetalle $libre_detalle)
	{
        //$this->authorize('edit', $libre_detalle);
		return view('libre_detalles.create_and_edit', compact('libre_detalle'));
	}*/

	public function update(LibreDetalleRequest $request, LibreDetalle $libre_detalle)
	{
		//$this->authorize('update', $libre_detalle);
				// $this->validate($request, [
  //          'horario_nombre' => 'required|string|max:191',
  //          'horario_entrada' => 'required',
  //      ]);
		$libre_detalle->update($request->all());
		return redirect()->route('libre_detalles.show', $libre_detalle->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(LibreDetalle $libre_detalle)
	{
		//$this->authorize('destroy', $libre_detalle);
		//Elimino registros creados al aplicar libre
		$empleado = Empleado::where('id','=',$libre_detalle->fk_empleado_id)->first();
		$registros = Registro::whereBetween('registro_fecha',[$libre_detalle->fecha_desde, $libre_detalle->fecha_hasta])->where('fk_empleado_cedula', '=', $empleado->empleado_cedula)->get();
		foreach($registros as $registro){
			Registro::where('id','=',$registro->id)->delete();
		}
		$libre_detalle->delete();

		return redirect()->route('libre_detalles.index')->with('info', 'Eliminado exitosamente.');
	}
	
	public function countDiasLibres(Request $request){
		$fechaInicio = $request['fecha_desde'];
		$fechaFin = $request['fecha_hasta'];
		$contador = 0;
		$trabaja = Trabaja::where('fk_empleado_id','=',$request['fk_empleado_id'])->where('trabaja_fechainicio','<=', $fechaInicio)->where('trabaja_fechafin','>=',$fechaFin)->first();
		$tipoLibre = TipoLibre::where('id', '=', $request['fk_tipo_libre_id'])->first();

		if($trabaja != null){
			$diasLibres = $this->diasLibresTurnoFijo($request);
			$trabaja = Trabaja::where('fk_empleado_id','=',$request['fk_empleado_id'])->first();
			if($trabaja['fk_turno_id'] != null){
				$entrada = $trabaja->turno->horario->horario_entrada;
				$salida = $trabaja->turno->horario->horario_salida;
			}elseif($trabaja['fk_horariorotativo_id'] != null){
				$entrada = $trabaja->HorarioRotativo->horario->horario_entrada;
				$salida = $trabaja->HorarioRotativo->horario->horario_salida;
			}
			$retorno = RegistrosLibres($diasLibres, $trabaja->empleado->empleado_cedula, $tipoLibre->nombre, $entrada, $salida);
		}else{
			$devuelvo[0] = "Error";
			$devuelvo[1] = "Primer Nivel";
			return $devuelvo;
		}
	}
	
	public function diasLibresTurnoFijo(Request $request){
		$empleadoId = $request['fk_empleado_id'];
		$fechaInicio = $request['fecha_desde'];
		$fechaFin = $request['fecha_hasta'];
		$mes_anio = explode("-", $fechaInicio);
		$month = $mes_anio[1];
		$year = $mes_anio[0];
		$x = 0;

		$diaSemana = date("w", mktime(0,0,0,$month,1,$year))+7;
		$ultimoDiaMes = date("d", (mktime(0,0,0,$month+1,1,$year)-1));
		$last_cell = $diaSemana + $ultimoDiaMes;
		$diasTrab = array();
		
		for($i=1; $i<=42; $i++){
			if($i==$diaSemana){
				//Dia que empieza
				$day=1;
			}
			if($i<$diaSemana || $i >= $last_cell){
				//vacio
			}
			else{
				if($day<10){
					$day='0'.$day;
				}
				$numero = $day;
				$numero .= "-";
				$numero .= $month;
				$numero .= "-";
				$numero .= $year;
				
				$agregar = $year;
				$agregar .= "-";
				$agregar .= $month;
				$agregar .= "-";
				$agregar .= $day;

				if($agregar>=$fechaInicio && $agregar<=$fechaFin){
					$feriados = Feriado::all();
					$esFeriado = "NO";
					foreach($feriados as $feriado){
						if($agregar == $feriado->feriado_fecha){
							$esFeriado = "SI";
						}
					}
					if($esFeriado == "NO"){
						$diaSem = date("N", strtotime($agregar));
						$diasTrab[$x][0]=$agregar;
						$x++;
					}
				}
				$day++;
			}
		}
		return $diasTrab;
	}
}