<?php

namespace App\Http\Controllers;

use App\Models\LicenciaDetalle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LicenciaDetalleRequest;
use App\Models\Turno;
use App\Models\Trabaja;
use App\Models\Feriado;
use App\Models\Licencia;
use App\Models\Empleado;
use App\Models\Registro;

class LicenciaDetallesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('auth.lock');
        /*if (ajuste('audit') != 'S'){
    		LicenciaDetalle::disableAuditing();
        }else{
        	LicenciaDetalle::enableAuditing();
        }*/
    }

	public function index(){
		$licencia_detalles = LicenciaDetalle::paginate();
		return view('licencia_detalles.index', compact('licencia_detalles'));
	}

    public function show(LicenciaDetalle $licencia_detalle){
        return view('licencia_detalles.show', compact('licencia_detalle'));
    }

	public function create(LicenciaDetalle $licencia_detalle){
		$licencia_detalle->aplica_sabado='N';
		$licencia_detalle->aplica_domingo='N';
		$licencia_detalle->aplica_libre='N';
		return view('licencia_detalles.create_and_edit', compact('licencia_detalle'));
	}

	public function store(LicenciaDetalleRequest $request){
		
		$this->validate($request, [
			'fk_empleado_id' => 'required',
        	'fecha_desde' => 'required|date|before_or_equal:fecha_hasta',
        	'fecha_hasta' => 'required|date|after_or_equal:fecha_desde',
        ]);
        
        $fechaInicio = $request['fecha_desde'];
		$fechaFin = $request['fecha_hasta'];
		$fk_licencia_id = $request['fk_licencia_id'];
        existeLicencia($fechaInicio,$fechaFin,$fk_licencia_id);
        
        $retorno = $this->countDiasLicencia($request);
        
        if($retorno[0] != "Error"){
			$licencia_detalle = LicenciaDetalle::create($request->all());
			return redirect()->route('licencia_detalles.show', $licencia_detalle)->with('info', 'Creado exitosamente.');
        }else{
        	if($retorno[1] == "Primer Nivel"){
        		return Redirect()->back()->withErrors(['El empleado seleccionado no tiene un turno asignado entre estas fechas.']);
        	}elseif($retorno[1] == "Segundo Nivel"){
        		return Redirect()->back()->withErrors(['Días de licencias insuficientes para el periodo de fecha seleccionado.']);
        	}else{
        		return Redirect()->back()->withErrors(['Error desconocido, por favor pongase en contacto con el administrador.']);
        	}
        }
	}

	public function edit(LicenciaDetalle $licencia_detalle){
        $this->authorize('update', $licencia_detalle);
		return view('licencia_detalles.create_and_edit', compact('licencia_detalle'));
	}

	public function update(LicenciaDetalleRequest $request, LicenciaDetalle $licencia_detalle){
		$this->authorize('update', $licencia_detalle);
		$licencia_detalle->update($request->all());

		return redirect()->route('licencia_detalles.show', $licencia_detalle->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(LicenciaDetalle $licencia_detalle){
		$this->authorize('destroy', $licencia_detalle);
		$empleado = Empleado::where('id','=',$licencia_detalle->licencia->fk_empleado_id)->first();
		$registros = Registro::whereBetween('registro_fecha',[$licencia_detalle->fecha_desde, $licencia_detalle->fecha_hasta])->where('fk_empleado_cedula', '=', $empleado->empleado_cedula)->where('registro_comentarios','=','Licencia aplicada.')->get();
		foreach($registros as $registro){
			Registro::where('id','=',$registro->id)->delete();
		}
		$licencia_detalle->delete();

		return redirect()->route('licencia_detalles.index')->with('info', 'Eliminado exitosamente.');
	}
	
	public function countDiasLicencia(Request $request){
		$fechaInicio = $request['fecha_desde'];
		$fechaFin = $request['fecha_hasta'];
		$contador = 0;
		$trabaja = Trabaja::where('fk_empleado_id','=',$request['fk_empleado_id'])->where('trabaja_fechainicio','<=', $fechaInicio)->where('trabaja_fechafin','>=',$fechaFin)->first();

		if($trabaja != null){
			$diasLibres = $this->diasLibresTurnoFijo($request);
			if($request['licencia_cantidad'] >= count($diasLibres)){
				$trabaja = Trabaja::where('fk_empleado_id','=',$request['fk_empleado_id'])->first();
				if($trabaja['fk_turno_id'] != null){
					$entrada = $trabaja->turno->horario->horario_entrada;
					$salida = $trabaja->turno->horario->horario_salida;
				}elseif($trabaja['fk_horariorotativo_id'] != null){
					$entrada = $trabaja->HorarioRotativo->horario->horario_entrada;
					$salida = $trabaja->HorarioRotativo->horario->horario_salida;
				}
				$retorno = RegistrosLicencia($diasLibres, $trabaja->empleado->empleado_cedula, $entrada, $salida);
				Licencia::find($request['fk_licencia_id'])->decrement('licencia_cantidad', count($diasLibres));
			}else{
				$devuelvo[0] = "Error";
				$devuelvo[1] = "Segundo Nivel";
				return $devuelvo;
			}
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
						$checksS = $request['aplica_sabado'];
						$checksD = $request['aplica_domingo'];
						$checksL = $request['aplica_libre'];
						
						$trabaja = Trabaja::where('fk_empleado_id','=',$request['fk_empleado_id'])->where('trabaja_fechainicio','>',$agregar)->where('trabaja_fechafin','<',$agregar)->first();
						
						if($diaSem == 1){
							
						}
						
						$trabaja->turno->
						
						if($checksS != null || $checksD != null || $checksS != null){
							if($diaSem == 6 && $checksS == "S"){
								$diasTrab[$x][0]=$agregar;
								$x++;
							}elseif($diaSem == 7 && $checksD == "S"){
								$diasTrab[$x][0]=$agregar;
								$x++;
							}elseif($diaSem != 6 && $diaSem != 7){
								$diasTrab[$x][0]=$agregar;
								$x++;
							}
							
						}else{
							$diasTrab[$x][0]=$agregar;
							$x++;
						}
					}
				}
				$day++;
			}
		}
		dd($diasTrab);
		return $diasTrab;
	}
}