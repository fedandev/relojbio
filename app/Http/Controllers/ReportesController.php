<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Registro;
use App\Models\Ajuste;
use App\Models\Oficina;
use App\Models\Trabaja;
use App\Models\Feriado;
use App\Models\Empresa;
use DateTime;
use Barryvdh\DomPDF\Facade as PDF;
use Dompdf\Options;
use Dompdf\Dompdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use App\SumaTiempos;
use Mail;
use App\Traits\RepLlegadasTardesTrait;
use App\Traits\RepHorasExtrasResumidasTrait;


class ReportesController extends Controller
{
		use RepLlegadasTardesTrait, RepHorasExtrasResumidasTrait;
	
    public function __construct(){
        //$this->middleware('auth');
        //$this->middleware('auth.lock');
    }
    
    public function index(){
	    $controller = 'reportes';
		if (Gate::allows('view-report', $controller)) {  //Esta en app/Providers/AuthServiceProvider.php
           return view('reportes.index');
        }else{
           return redirect()->route('main')->with('error', 'No esta autorizado a ejecutar la acción.'); 
        }
	}
    
    public function horasTrabajadasEmpleado(Request $request, Empleado $empleados){
        $controller = 'reportes';
        $Rpdf = Ajuste::where('ajuste_nombre','reporte_pdf')->first();
		    if (!Gate::allows('view-report', $controller)) {
           return redirect()->route('main')->with('error', 'No esta autorizado a ejecutar la acción.');
        }
        
        $for = "N";
        $fechainicio = $request->input('fechainicio');
        $fechafin = $request->input('fechafin');
        $cedula = $request->input('fk_empleado_cedula');
        $empleados = Empleado::where('empleado_cedula',$cedula)->get();
        $fk_oficina_id = $request->input('fk_oficina_id');
        
        if($cedula !='' && $cedula != 'ALL'){
            $empleados = Empleado::where('empleado_cedula',$cedula)->get();
        }elseif($fk_oficina_id > 0 && $cedula == 'ALL'){
            if($fk_oficina_id != NULL){
                $empleados = Empleado::where('fk_oficina_id',$fk_oficina_id)->get();
            }
        }elseif($fk_oficina_id == 'ALL' && $cedula == 'ALL'){
            $empleados = Empleado::all();    
            $for = "S";
        }
        
        if($for == 'N'){
            //$registros = DB::table('v_inout')->whereBetween('registro_fecha', array($fechainicio,$fechafin))->where('fk_empleado_cedula',$cedula)->get();
            $registros =  v_inout($fechainicio,$fechafin,$empleados[0]->empleado_cedula );
            
        }elseif($for == 'S'){
            //$registros = DB::table('v_inout')->whereBetween('registro_fecha', array($fechainicio,$fechafin))->get();
            $registros =  v_inout($fechainicio,$fechafin);
        }
        $registros = collect($registros);
        $tiposRegistros = array(
            array("Nombre" => "Manual",
                  "Color" => "#62FF00",
            ),
            array("Nombre" => "Falta Justificada",
                  "Color" => "#FFB500",
            ),
            array("Nombre" => "Medica",
                  "Color" => "#00ACFF",
            ),
            array("Nombre" => "Licencia",
                  "Color" => "#00FFD1",
            ),
            array("Nombre" => "Fingerpint",
                  "Color" => "",
            ),
        );
        
        $pdf = PDF::loadView('pdf.horasTrabajadas', compact('registros','fechainicio','fechafin','empleados','tiposRegistros','suma'));

    	if($Rpdf->ajuste_valor == 'stream'){
            return $pdf->stream('listado.pdf');             //Ver PDF sin descargar    
        }elseif($Rpdf->ajuste_valor == 'download'){
            return $pdf->download('listado.pdf');             //Forzar descarga de PDF
        }
    }
    
    public function entradasYsalidas(Request $request){
        $controller = 'reportes';
        $Rpdf = Ajuste::where('ajuste_nombre','reporte_pdf')->first();
		    if (!Gate::allows('view-report', $controller)) {
           return redirect()->route('main')->with('error', 'No esta autorizado a ejecutar la acción.'); 
        }
        $for = 'N';
    	$fechainicio = $request->input('fechainicio');
        $fechafin = $request->input('fechafin');
        $cedula = $request->input('fk_empleado_cedula');
        $fk_oficina_id = $request->input('fk_oficina_id');
        $empleados = Empleado::where('empleado_cedula',$cedula)->get();
        
        if($cedula !='' && $cedula != 'ALL'){
            $empleados = Empleado::where('empleado_cedula',$cedula)->get();
        }elseif($fk_oficina_id != 'ALL' && $cedula == 'ALL'){
            if($fk_oficina_id != NULL){
                $empleados = Empleado::where('fk_oficina_id',$fk_oficina_id)->get();
            }
        }elseif($fk_oficina_id == 'ALL' && $cedula == 'ALL'){
            $empleados = Empleado::all();    
            $for = "S";
        }
        
        if($for == 'N'){
            $registros = Registro::whereBetween('registro_fecha', array($fechainicio,$fechafin))->where('fk_empleado_cedula',$cedula)->orderBy('registro_fecha')->get();
        }elseif($for == 'S'){
            $registros = Registro::whereBetween('registro_fecha', array($fechainicio,$fechafin))->orderBy('registro_fecha')->get();
        }
        
    	$pdf = PDF::loadView('pdf.entradasYsalidas', compact('registros','fechainicio','fechafin','empleados'));
    	
    	if($Rpdf->ajuste_valor == 'stream'){
            return $pdf->stream('listado.pdf');             //Ver PDF sin descargar    
        }elseif($Rpdf->ajuste_valor == 'download'){
            return $pdf->download('listado.pdf');             //Forzar descarga de PDF
        }
    }
    
    public function llegadasTarde(Request $request){
        $Rpdf = Ajuste::where('ajuste_nombre','reporte_pdf')->first();
        $controller = 'reportes';
		    if (!Gate::allows('view-report', $controller)) {
           return redirect()->route('main')->with('error', 'No esta autorizado a ejecutar la acción.');
        }
        $fechainicio = $request->input('fechainicio');
        $fechafin = $request->input('fechafin');
        $cedula = $request->input('fk_empleado_cedula');
        $fk_oficina_id = $request->input('fk_oficina_id');        
			
				$registros_ok = $this->repLlegadasTardes($fechainicio,$fechafin, $cedula, $fk_oficina_id);    
			
        if($registros_ok->count() > 0){
            $pdf = PDF::loadView('pdf.llegadasTardes', compact('registros_ok','fechainicio','fechafin','oficina'));
    	    if($Rpdf->ajuste_valor == 'stream'){
                return $pdf->stream('listado.pdf');             //Ver PDF sin descargar    
            }elseif($Rpdf->ajuste_valor == 'download'){
                return $pdf->download('listado.pdf');             //Forzar descarga de PDF
            }
        }else{
            return back()->with('warning', "No se encontraron datos.")->withInput();
        }
    }
    
    public function salidasAntes(Request $request){
        $Rpdf = Ajuste::where('ajuste_nombre','reporte_pdf')->first();
        $controller = 'reportes';
		    if (!Gate::allows('view-report', $controller)) {
           return redirect()->route('main')->with('error', 'No esta autorizado a ejecutar la acción.');
        }
        
        $fechainicio = $request->input('fechainicio');
        $fechafin = $request->input('fechafin');
        $cedula = $request->input('fk_empleado_cedula');
        
        $fk_oficina_id = $request->input('fk_oficina_id');
        
        $sql= "SELECT * FROM registros WHERE registro_fecha between '".$fechainicio."' and  '".$fechafin."'  AND registro_tipo='O' " ;
        
        if($cedula !='' && $cedula != 'ALL'){
            $sql = $sql. " AND fk_empleado_cedula = '".$cedula."'";
            $oficina = Oficina::find($fk_oficina_id);
        
        }
        
        if($fk_oficina_id > 0 && $cedula == 'ALL' ){
            $sql = $sql. " AND fk_empleado_cedula IN (SELECT empleado_cedula FROM empleados WHERE fk_oficina_id = ".$fk_oficina_id.")";
            $oficina = Oficina::find($fk_oficina_id);
           
        }
        
        $sql = $sql." order by fk_empleado_cedula, registro_hora asc , registro_tipo ";
        
        $registros_sql =  DB::select($sql);
        
        $registros = Registro::hydrate($registros_sql); // paso a collecion de registros

        $iRegistros = 0;
        $registros_ok = [];
        
        //busco el horario a la fecha porque en un periodo de fechas pueden existir horarios distintos
        foreach($registros as $registro){
            $registro_fecha = $registro->registro_fecha;
            $registro_hora_d = new DateTime($registro->registro_hora);
            
            $empleado = $registro->Empleado;
            
            if(!isset($empleado->id)){
                continue;
            }
            
            $horario = horarioAfecha($empleado->id,$registro_fecha);
            if($horario[0] != ''){
                
                $horario_entrada = new DateTime($registro_fecha.' '.$horario[0]); 
                $horario_entrada_calc = new DateTime($registro_fecha.' '.$horario[0]); 
                $horario_salida = new DateTime($registro_fecha.' '.$horario[3]); 
                $horario_finbrake = new DateTime($registro_fecha.' '.$horario[2]); 
                $horario_finbrake_3 = new DateTime($registro_fecha.' '.$horario[2]);
                $hay_brake = $horario[6];
                
                
                if($registro_hora_d > $horario_salida){         //hora nocturna aumento un dia
                    $diff = date_diff($registro_hora_d, $horario_salida);
                    $horas = intval($diff->format('%h'));
                    if ($diff->format('%r') =='-' && $horas > 6){
                        $horario_salida= $horario_salida->modify('+ 1 day');
                    }
                }else{
                    //se parte de la base que la hora de entrada siempre tiene menor a el registro. Si es mayor y hay mas de 12 horas de diferencia, atraso un dia
                    if($horario_entrada > $registro_hora_d){           
                        $diff = date_diff($horario_entrada,$registro_hora_d);
                        $horas = intval($diff->format('%h'));
                       
                        if ($diff->format('%r') =='-' && $horas > 0){
                            $horario_entrada= $horario_entrada->modify('- 1 day');
                        }
                        
                    }
                }
                
                $horario_tope = $horario_entrada;
                $horario_salida_calc = new DateTime($horario_salida->format('Y-m-d H:i:s')); 
                
                $tolerencia_antes = $horario[5];
                $date_tol = new DateTime($registro_fecha.' '.$tolerencia_antes); 
                $minutes_antes = $date_tol->format('i');
                
                $horario_salida_men_antes = $horario_salida;
                $horario_salida_men_antes= $horario_salida_men_antes->modify('-'.$minutes_antes.' minutes');
               
                if($registro_hora_d < $horario_salida_men_antes && $registro_hora_d  > $horario_tope){
                    //siempre comparo entre formato dd/mm/aaaa hh:mm:ss
                    $ok = 'S';
                    
                    
                    
                    if($hay_brake =='S'){
                        $horario_comienzobrake = new DateTime($registro_fecha.' '.$horario[1]); 
                        $horario_entrada_2 = new DateTime($registro_fecha.' '.$horario[0]);
                        
                        if($horario_entrada_2 > $horario_comienzobrake){
                            $horario_comienzobrake= $horario_comienzobrake->modify('+ 1 day');
                        }
                        
                        $horario_comienzobrake= $horario_comienzobrake->modify('-'.$minutes_antes.' minutes');
                        
                        $horario_finbrake = new DateTime($registro_fecha.' '.$horario[2]); 
                        $horario_salida_2 = new DateTime($registro_fecha.' '.$horario[3]); 
                        
                        if($horario_finbrake > $horario_salida_2){
                            $horario_finbrake= $horario_finbrake->modify('- 1 day');
                        }
                        
                        if($registro_hora_d >= $horario_comienzobrake &&  $registro_hora_d < $horario_finbrake){    //Si salio dentro de la hora del descanso no es salida antes
                            $ok = 'N';   
                        }
                        // if($registro_hora_d>=$horario_finbrake && $registro_hora_d<$horario_salida_men_antes){
                        //     $ok = 'N';       
                        // }
                    }
                    if($ok == 'S'){
                        
                        $r = [];
                
                        $r['fk_empleado_cedula']=$registro->fk_empleado_cedula;
                        $r['empleado']=$empleado->empleado_nombre.' '.$empleado->empleado_apellido;
                        $r['hora_salida']=$horario[3];
                        $r['registro_fecha']= $registro_hora_d->format('d-m-Y H:i:s');
                        $r['inicio_brake']= $horario[1];
                        $r['fin_brake']= $horario[2];
                        
                        
                        $registros_ok[$iRegistros] = $r;
                        $iRegistros = $iRegistros + 1;
                    }
                }
            }
            
            
        }
        
        $registros_ok = collect($registros_ok);
        
        if($registros_ok->count() > 0){
            $pdf = PDF::loadView('pdf.salidasAntes', compact('registros_ok','fechainicio','fechafin', 'oficina'));
    	    if($Rpdf->ajuste_valor == 'stream'){
                return $pdf->stream('listado.pdf');             //Ver PDF sin descargar    
            }elseif($Rpdf->ajuste_valor == 'download'){
                return $pdf->download('listado.pdf');             //Forzar descarga de PDF
            }
        }else{
            return back()->with('warning', 'No se encontraron datos.')->withInput();
        }
        
        
        
    }
    
    public function horasNocturnas(Request $request){
        $Rpdf = Ajuste::where('ajuste_nombre','reporte_pdf')->first();
        $controller = 'reportes';
		    if (!Gate::allows('view-report', $controller)) {
           return redirect()->route('main')->with('error', 'No esta autorizado a ejecutar la acción.');
        }
        $for = "N";
        $fechainicio = $request->input('fechainicio');
        $fechafin = $request->input('fechafin');
        $cedula = $request->input('fk_empleado_cedula');
        $inicioNoche = ajuste('nocturnal_start');
        $finNoche = ajuste('nocturnal_end');
        
        $fk_oficina_id = $request->input('fk_oficina_id');
        
        
        if($cedula !='' && $cedula != 'ALL'){
            $empleados = Empleado::where('empleado_cedula',$cedula)->get();
        }elseif($fk_oficina_id > 0 && $cedula == 'ALL'){
            if($fk_oficina_id != NULL){
                $empleados = Empleado::where('fk_oficina_id',$fk_oficina_id)->get();
            }
        }elseif($fk_oficina_id == 'ALL' && $cedula == 'ALL'){
            $for = "S";
        }

        if($for == 'N'){
            $registros_inout =  v_inout($fechainicio,$fechafin,$empleados[0]->empleado_cedula );
        }elseif($for == 'S'){
            $registros_inout =  v_inout($fechainicio,$fechafin);
        }
        
        $registros_sql = collect($registros_inout);
        
        $registros = [];
        $i = 0;
        foreach($registros_sql as $registro){
            $Empleado = Empleado::where('empleado_cedula', '=',$registro->r_cedula)->first();
            $entre = 'N';
            
            if($Empleado == null){
                continue;
            }
            
            $entrada = new DateTime($registro->r_entrada);
            $entrada = $entrada->format('H:i:s');
            $salida = new DateTime($registro->r_salida);
            $salida = $salida->format('H:i:s');

            if($entrada < $inicioNoche && $entrada > $salida && $salida <= $finNoche){
                $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($salida) - strtotime($inicioNoche));
                $registro->r_totalHoras = $nocturnidad;
                $entre = 'S';
            }elseif($entrada >= $inicioNoche && $entrada > $salida && $salida > $finNoche){
                $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($finNoche) - strtotime($entrada));
                $registro->r_totalHoras = $nocturnidad;
                $entre = 'S';
            }elseif($entrada >= $inicioNoche && $entrada < $salida && $salida <= $finNoche){
                $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($salida) - strtotime($entrada));
                $registro->r_totalHoras = $nocturnidad;
                $entre = 'S';
            }
            
            if($entre == 'S'){
                $registros[$i]['empleado'] = $Empleado->empleado_nombre ." ". $Empleado->empleado_apellido;
                $registros[$i]['fk_empleado_cedula'] = $Empleado->empleado_cedula;
                $registros[$i]['entrada'] = $registro->r_entrada;
                $registros[$i]['salida'] = $registro->r_salida;
                $registros[$i]['total'] = $registro->r_totalHoras;
            }
        }
        
        $registros_ok = collect($registros);
        
        $pdf = PDF::loadView('pdf.horasNocturnas', compact('registros_ok','fechainicio','fechafin','oficina','empleado','empleados'));
    	
        if($Rpdf->ajuste_valor == 'stream'){
            return $pdf->stream('listado.pdf');             //Ver PDF sin descargar    
        }elseif($Rpdf->ajuste_valor == 'download'){
            return $pdf->download('listado.pdf');             //Forzar descarga de PDF
        }
    }
    
    public function listadoFaltas(Request $request){
        $Rpdf = Ajuste::where('ajuste_nombre','reporte_pdf')->first();
        $controller = 'reportes';
		    if (!Gate::allows('view-report', $controller)) {
           return redirect()->route('main')->with('error', 'No esta autorizado a ejecutar la acción.');
		    }
        $fechaInicio = $request->input('fechainicio');
        $fechaFin = $request->input('fechafin');
        $cedula = $request->input('fk_empleado_cedula');
        $fk_oficina_id = $request->input('fk_oficina_id');
        
        $x = 0;
        
        if($cedula !='' && $cedula != 'ALL'){
            $empleados = Empleado::where('empleado_cedula',$cedula)->get();
        }elseif($fk_oficina_id > 0 && $cedula == 'ALL' ){
            $empleados = Empleado::where('fk_oficina_id',$fk_oficina_id)->get();
        }elseif($fk_oficina_id == 'ALL' && $cedula == 'ALL'){
            $empleados = Empleado::all();
        }
        foreach($empleados as $empleado){
            $registros_array = array();
            $registros_diff = array();
            
            $trabajas = Trabaja::where('trabaja_fechainicio','<=',$fechaInicio)->where('trabaja_fechafin','>=',$fechaFin)->where('fk_empleado_id',$empleado->id)->orwhere('trabaja_fechainicio','<=',$fechaInicio)->where('trabaja_fechafin','<=',$fechaFin)->where('fk_empleado_id',$empleado->id)->orwhere('trabaja_fechainicio','>=',$fechaInicio)->where('trabaja_fechafin','<=',$fechaFin)->where('fk_empleado_id',$empleado->id)->get();
            foreach($trabajas as $trabaja){
                if($trabaja->fk_horariorotativo_id != null){
                    $trabajo = $trabaja->HorarioRotativo->horariorotativo_diastrabajo;
                    $libre = $trabaja->HorarioRotativo->horariorotativo_diaslibres;
                    $comienza = $trabaja->HorarioRotativo->horariorotativo_diacomienzo;
                    
                    $diasQueTrabaja = $this->Diasquetrabajarotativo($trabajo, $libre, $comienza, $fechaInicio);
                    
                    $registros = Registro::select('registro_fecha')->where('fk_empleado_cedula', '=', $empleado->empleado_cedula)->whereBetween('registro_fecha', [$fechaInicio,$fechaFin])->get();
                    
                    foreach($registros as $registro){
                        array_push($registros_array, $registro->registro_fecha);
                    }
                    
                    $registros_diff = array_diff($diasQueTrabaja,$registros_array);
                }elseif($trabaja->fk_turno_id != null){
                    $diasQueTrabaja = $this->Diasquetrabaja($fechaInicio, $fechaFin, $trabaja);
                    $registros = Registro::select('registro_fecha')->where('fk_empleado_cedula', '=', $empleado->empleado_cedula)->whereBetween('registro_fecha', [$fechaInicio,$fechaFin])->get();

                    foreach($registros as $registro){
                        array_push($registros_array, $registro->registro_fecha);
                    }
                    
                    
                    $registros_diff = array_diff($diasQueTrabaja,$registros_array);
                }
                $nombres = $trabaja->empleado->empleado_nombre ." ". $trabaja->empleado->empleado_apellido;
                $cedula = $trabaja->empleado->empleado_cedula;
                
                foreach($registros_diff as $reg){
                    $registros_ok[$x][0] = $cedula;
                    $registros_ok[$x][1] = $nombres;
                    $registros_ok[$x][2] = $reg;
                    $x++;
                }
            }
        }
        
        $registros_ok = collect($registros_ok);
        
        if($registros_ok->count() > 0){
            $pdf = PDF::loadView('pdf.listadoFaltas', compact('registros_ok','fechaInicio','fechaFin','oficina','empleados'));
    	    if($Rpdf->ajuste_valor == 'stream'){
                return $pdf->stream('listado.pdf');             //Ver PDF sin descargar    
            }elseif($Rpdf->ajuste_valor == 'download'){
                return $pdf->download('listado.pdf');             //Forzar descarga de PDF
            }
        }else{
            return back()->with('warning', "No hay llegadas tardes para el empleado $empleado->empleado_nombre $empleado->empleado_apellido o no se encontraron datos.")->withInput();
        }
    }
    
    function Diasquetrabajarotativo($trabajoingresado,$libresingresado,$empezamos,$mes){
        $Rpdf = Ajuste::where('ajuste_nombre','reporte_pdf')->first();
        $controller = 'reportes';
        $now = new DateTime();
		    if (!Gate::allows('view-report', $controller)) {
           echo '<script> localStorage.setItem("alertaroja", "No esta autorizado a ejecutar la acción"); </script>'; 
           return redirect()->route('main'); 
        }
    	$datos3 = explode("-",$mes);
    	$month=$datos3[1];
    	$year=$datos3[0];
    	$diaSemana=date("w",mktime(0,0,0,$month,1,$year))+7;	
    	$ultimoDiaMes=date("d",(mktime(0,0,0,$month+1,1,$year)-1));
    	$last_cell=$diaSemana+$ultimoDiaMes;
    	$x=0;
    	$diastrab = array();
    	$primerdia = 0;
    	$contador=0;
    	$contador2=0;
    	$dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
    	for($i=1;$i<=44;$i++){
    		if($i==$diaSemana){
    			$day=1;
    		}
    		if($i<$diaSemana || $i>=$last_cell){
    		}else{
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
    			$fecha = date('N', strtotime($numero));
    			$contador++;
    			if($contador<=$trabajoingresado){
    				if($primerdia==0){
    				    $NombreDia = $dias[$fecha];
    					if($NombreDia == $empezamos){
    						$diastrab[$x]=$agregar;
    						$x++;
    						$primerdia = 1;
    					}else{
    						$contador--;
    					}
    				}else{
    				    if($agregar < $now->format('Y-m-d')){
        					$diastrab[$x]=$agregar;
        					$x++;
    				    }
    				}
    			}else{
    				$contador2++;
    				if($contador2==$libresingresado){
    					$contador = 0;
    					$contador2=0;
    				}
    			}
    			$day++;
    		}
    		if($i%7==0){
    		}
    	}
    	
    	return $diastrab;
    }
    
    function Diasquetrabaja($diacomienzo,$diafin,$trabaja){
    	$dia_comienzo = explode("-",$diacomienzo);
    	$month=$dia_comienzo[1];
    	$year=$dia_comienzo[0];
    	$diaSemana=date("w",mktime(0,0,0,$month,1,$year))+7; 
    	$ultimoDiaMes=date("d",(mktime(0,0,0,$month+1,1,$year)-1));
    	$last_cell=$diaSemana+$ultimoDiaMes;
    	$x=0;
    	$diastrab = array();
    	for($i=1;$i<=42;$i++){
    		if($i==$diaSemana){
    			// determinamos en que dia empieza
    			$day=1;
    		}
    		if($i<$diaSemana || $i>=$last_cell){
    			// celca vacia
    		}else{
    			// mostramos el dia
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
    			
    			$fecha = date('N', strtotime($numero));
    			$entro="NO";
    			
    			if($fecha==1 AND $trabaja->Turno->turno_lunes=="1"){
    				$entro = "SI";
    			}
    			if($fecha==2 AND $trabaja->Turno->turno_martes=="1"){
    				$entro = "SI";
    			}
    			if($fecha==3 AND $trabaja->Turno->turno_miercoles=="1"){
    				$entro = "SI";
    			}
    			if($fecha==4 AND $trabaja->Turno->turno_jueves=="1"){
    				$entro = "SI";
    			}
    			if($fecha==5 AND $trabaja->Turno->turno_viernes=="1"){
    				$entro = "SI";
    			}
    			if($fecha==6 AND $trabaja->Turno->turno_sabado=="1"){
    				$entro = "SI";
    			}
    			if($fecha==7 AND $trabaja->Turno->turno_domingo=="1"){
    				$entro = "SI";
    			}
    			if($entro=="SI"){
    				if($agregar>=$diacomienzo AND $agregar<=$diafin){
						$diastrab[$x]=$agregar;
						$x++;
    				}
    			}
    			$day++;
    		}
    	}
    	return $diastrab;
    }
    
    public function horasExtras(Request $request){
        $Rpdf = Ajuste::where('ajuste_nombre','reporte_pdf')->first();
        $controller = 'reportes';
		    if (!Gate::allows('view-report', $controller)) {
           return redirect()->route('main')->with('error', 'No esta autorizado a ejecutar la acción.');
        }
        $for = "N";
        $fechainicio = $request->input('fechainicio');
        $fechafin = $request->input('fechafin');
        $cedula = $request->input('fk_empleado_cedula');
        
        $fk_oficina_id = $request->input('fk_oficina_id');
        
        if($cedula !='' && $cedula != 'ALL'){
            $empleados = Empleado::where('empleado_cedula',$cedula)->get();
        }elseif($fk_oficina_id > 0 && $cedula == 'ALL'){
            if($fk_oficina_id != NULL){
                $empleados = Empleado::where('fk_oficina_id',$fk_oficina_id)->get();
            }
        }elseif($fk_oficina_id == 'ALL' && $cedula == 'ALL'){
            $for = "S";
        }

        if($for == 'N'){
            $registros_inout =  v_inout($fechainicio,$fechafin,$empleados[0]->empleado_cedula );
        }elseif($for == 'S'){
            $registros_inout =  v_inout($fechainicio,$fechafin);
        }
        
        $registros_sql = collect($registros_inout);
        
        $registros = [];
        // $registros = [1][1]; Cedula
        // $registros = [1][2]; fecha
        // $registros = [1][3]; horas a trabajar
        // $registros = [1][4]; horas trabajadas
        // $registros = [1][5]; horas extras
        
       // $registros = Registro::hydrate($registros_sql); // paso a collecion de registros
       
        $minimo_extras = ajuste('minimo_extras');
        $max_extras = ajuste('max_hours_ext_per_day');
        $i=0;
        
        foreach($registros_sql as $registro){
            $Empleado = Empleado::where('empleado_cedula', '=',$registro->r_cedula)->first();
            
            if($Empleado == null){
                continue;
            }
            
    		$horario = horarioAfecha( $Empleado->id, $registro->r_fecha);
    		$horas_debe_trabajar = totalHorasAfecha($horario);
    		$horas_trabajadas =  $registro->r_total_horas;
    		$horas_extras = date('H:i:s', strtotime($horas_trabajadas) - strtotime($horas_debe_trabajar));
    	
            if($horas_extras >= $minimo_extras && $horas_debe_trabajar<> '00:00:00' && $horas_extras <= $max_extras ){
                $r = [];
                
                $r['fk_empleado_cedula']=$registro->r_cedula;
                $r['registro_fecha']=$registro->r_fecha;
                $r['horas_debe_trabajar']=$horas_debe_trabajar;
                $r['horas_trabajadas']=$horas_trabajadas;
                $r['horas_extras']=$horas_extras;
                $r['empleado']=$Empleado->empleado_nombre.' '.$Empleado->empleado_apellido;
                
                $registros[$i] = $r;
                $i++;
            }
    		
        }
        
        $registros_ok = collect($registros)->sortBy('fk_empleado_cedula')->sortBy('registro_fecha');
        
        if($registros_ok->count() > 0){
            $pdf = PDF::loadView('pdf.horasExtras', compact('registros_ok','fechainicio','fechafin','oficina'));
            
            if($Rpdf->ajuste_valor == 'stream'){
                return $pdf->stream('listado.pdf');             //Ver PDF sin descargar    
            }elseif($Rpdf->ajuste_valor == 'download'){
                return $pdf->download('listado.pdf');             //Forzar descarga de PDF
            }
        }else{
            return back()->with('warning', 'No se encontraron datos.')->withInput();
        }
        
    }
    
    public function libresConcedidos(Request $request){
        $Rpdf = Ajuste::where('ajuste_nombre','reporte_pdf')->first();
        $controller = 'reportes';
		    if (!Gate::allows('view-report', $controller)) {
           return redirect()->route('main')->with('error', 'No esta autorizado a ejecutar la acción.');
        }    
        $for = "N";
        $fechainicio = $request->input('fechainicio');
        $fechafin = $request->input('fechafin');
        $cedula = $request->input('fk_empleado_cedula');
        $fk_oficina_id = $request->input('fk_oficina_id');
        
        if($cedula !='' && $cedula != 'ALL'){
            $empleados = Empleado::where('empleado_cedula',$cedula)->get();
        }elseif($fk_oficina_id != 'ALL' && $cedula == 'ALL'){
            if($fk_oficina_id != NULL){
                $empleados = Empleado::where('fk_oficina_id',$fk_oficina_id)->get();
            }
        }elseif($fk_oficina_id == 'ALL' && $cedula == 'ALL'){
            $empleados = Empleado::all();    
            $for = "S";
        }
        
        if($for == 'N'){
            $registros = Registro::whereBetween('registro_fecha', array($fechainicio,$fechafin))->where('registro_comentarios', 'like', 'Libre Concedido%')->where('fk_empleado_cedula',$cedula)->orderBy('registro_fecha')->get();
        }elseif($for == 'S'){
            $registros = Registro::whereBetween('registro_fecha', array($fechainicio,$fechafin))->where('registro_comentarios', 'like', 'Libre Concedido%')->orderBy('registro_fecha')->get();
        }
  
        $pdf = PDF::loadView('pdf.libresConcedidos', compact('registros','fechainicio','fechafin','empleados'));
    	
    	if($Rpdf->ajuste_valor == 'stream'){
            return $pdf->stream('listado.pdf');             //Ver PDF sin descargar    
        }elseif($Rpdf->ajuste_valor == 'download'){
            return $pdf->download('listado.pdf');             //Forzar descarga de PDF
        }
    }
    
    public function HorasExtrasResumidas(Request $request){
			
        $Rpdf = Ajuste::where('ajuste_nombre','reporte_pdf')->first();
        $controller = 'reportes';
				if (!Gate::allows('view-report', $controller)) {
           return redirect()->route('main')->with('error', 'No esta autorizado a ejecutar la acción.');
        }
        $for = "N";
        $fechainicio = $request->input('fechainicio');
        $fechafin = $request->input('fechafin');
        $cedula = $request->input('fk_empleado_cedula');
        $fk_oficina_id = $request->input('fk_oficina_id');
        
        
       	$registros_ok = $this->repHorasExtrasResumidas($fechainicio,$fechafin, $cedula, $fk_oficina_id);
        
        if($registros_ok->count() > 0){
            $pdf = PDF::loadView('pdf.horasExtrasResumidas', compact('registros_ok','fechainicio','fechafin','oficina'));
            
            if($Rpdf->ajuste_valor == 'stream'){
                return $pdf->stream('listado.pdf');             //Ver PDF sin descargar    
            }elseif($Rpdf->ajuste_valor == 'download'){
                return $pdf->download('listado.pdf');             //Forzar descarga de PDF
            }
        }else{
            return back()->with('warning', 'No se encontraron datos.')->withInput();
        }
    
    }
 
    public function HorasCreadasManual(Request $request){
        $controller = 'reportes';
        $Rpdf = Ajuste::where('ajuste_nombre','reporte_pdf')->first();
		    if (!Gate::allows('view-report', $controller)) {
           return redirect()->route('main')->with('error', 'No esta autorizado a ejecutar la acción.'); 
        }
        $for = 'N';
    	$fechainicio = $request->input('fechainicio');
        $fechafin = $request->input('fechafin');
        $cedula = $request->input('fk_empleado_cedula');
        $fk_oficina_id = $request->input('fk_oficina_id');
        $empleados = Empleado::where('empleado_cedula',$cedula)->get();
        
        if($cedula !='' && $cedula != 'ALL'){
            $empleados = Empleado::where('empleado_cedula',$cedula)->get();
        }elseif($fk_oficina_id != 'ALL' && $cedula == 'ALL'){
            if($fk_oficina_id != NULL){
                $empleados = Empleado::where('fk_oficina_id',$fk_oficina_id)->get();
            }
        }elseif($fk_oficina_id == 'ALL' && $cedula == 'ALL'){
            $empleados = Empleado::all();    
            $for = "S";
        }
        
        if($for == 'N'){
            $registros = Registro::whereBetween('registro_fecha', array($fechainicio,$fechafin))->where('fk_empleado_cedula',$cedula)->where('registro_tipomarca','Manual')->orderBy('registro_fecha')->get();
        }elseif($for == 'S'){
            $registros = Registro::whereBetween('registro_fecha', array($fechainicio,$fechafin))->where('registro_tipomarca','Manual')->orderBy('registro_fecha')->get();
        }
        
    	$pdf = PDF::loadView('pdf.registrosManual', compact('registros','fechainicio','fechafin','empleados'));
    	
    	if($Rpdf->ajuste_valor == 'stream'){
            return $pdf->stream('listado.pdf');             //Ver PDF sin descargar    
        }elseif($Rpdf->ajuste_valor == 'download'){
            return $pdf->download('listado.pdf');             //Forzar descarga de PDF
        }
    }
    
	
    public function empleadosMarcasAyer(Request $request){
				
        $Rpdf = Ajuste::where('ajuste_nombre','reporte_pdf')->first();
//         $controller = 'reportes';
// 		    if (!Gate::allows('view-report', $controller)) {
//            return redirect()->route('main')->with('error', 'No esta autorizado a ejecutar la acción.');
//         }
        $ayer = date('Y-m-d', strtotime('yesterday'));   
        //$ayer = "2019-02-04";
                
				$fechainicio = $request->input('fechainicio');
        $fechafin = $request->input('fechafin');
        $cedula = $request->input('fk_empleado_cedula');
        
        $fk_oficina_id = $request->input('fk_oficina_id');  
     
			
   
        // $registros = [1][1]; Cedula
        // $registros = [1][2]; fecha
        // $registros = [1][3]; horas a trabajar
        // $registros = [1][4]; horas trabajadas
        // $registros = [1][5]; horas diff
     
    
        
        $registros_ok = $this->repHorasExtrasResumidas($fechainicio,$fechafin, $cedula, $fk_oficina_id);
			
        if($registros_ok->count() > 0){
						
						$path = storage_path().'/app/public/empleadosMarcasAyer_'.$ayer.'.pdf';
					 
            $pdf = PDF::loadView('pdf.empleadosMarcasAyer', compact('registros_ok','fechainicio','fechafin','oficina'))->save($path);
           	$data = array(); 			
// 						$empresa = Empresa::where('empresa_estado','1')->first();
// 						Mail::send('common.mail_marcas_ayer', $data, function($message) use ($empresa,$path){
//               if($empresa->empresa_email2 == null){
//                   if($empresa->empresa_email != null){
//                       $message->to($empresa->empresa_email)->subject('Reporte de marcas en el dia de ayer')->attach($path);
//                   }
//               }else{
//                   $message->to($empresa->empresa_email)->cc($empresa->empresa_email2)->subject('Reporte de marcas en el dia de ayer')->attach($path);
//               }
//            });
						
            if($Rpdf->ajuste_valor == 'stream'){
                return $pdf->stream('listado.pdf');             //Ver PDF sin descargar    
            }elseif($Rpdf->ajuste_valor == 'download'){
                return $pdf->download('listado.pdf');             //Forzar descarga de PDF
            }
        }else{
            return back()->with('warning', 'No se encontraron datos.')->withInput();
        }
			
	  }
}