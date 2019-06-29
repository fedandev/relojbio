<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use App\Models\Oficina;
use App\Models\Ajuste;
use App\Models\Registro;
use App\Models\Empleado;
use App\Models\Trabaja;
use App\Models\Estadistica;
use DateTime;
use Carbon\Carbon;
use Mail;
use App\Models\Empresa;
use App\SumaTiempos;


class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('auth.lock');
    }

    public function index(){
	    $advertencias = $this->advertencias();
        $this->ChequeoLicencia();
        return view('home', compact('advertencias'));
	
    }
 
    public function advertencias(){
        $trabajas = Trabaja::with(['empleado','Turno'])->get();
        
        $fecha_actual=date("Y-m-d");
        $datos3 = explode("-",$fecha_actual);
    	$month=$datos3[1];
    	$year=$datos3[0];
    	$mesanio = $year."-".$month;
    	$aux = date('Y-m-d', strtotime("{$mesanio} + 1 month"));
        //$ultimoDiaMes = date('Y-m-d', strtotime("{$aux} - 1 day"));
        $ultimoDiaMes = date("Y-m-d", strtotime("-1 day", strtotime($fecha_actual)));  
    	$primerDiaMes = $year."-".$month."-01";
        $registros_ok = array();
        $x=0;
        foreach($trabajas as $trabaja){
            //if($trabaja->trabaja_fechainicio <= "2018-11-12" && $trabaja->trabaja_fechafin >= "2018-11-12"){
            if($trabaja->trabaja_fechainicio <= $fecha_actual && $trabaja->trabaja_fechafin >= $fecha_actual){
                //No se toma el caso de los horarios semanales ya que el empleado lo puede realizar cualquier día
                //a cualquier hora, por lo tanto es imposible marcar una falta.
                if($trabaja->fk_horariorotativo_id != null){
                    
                }elseif($trabaja->fk_turno_id != null){
                    $diasTrabajo = $this->Diasquetrabaja($primerDiaMes, $ultimoDiaMes, $trabaja);
                    
                    //$faltas = $this->diasFaltados($diasTrabajo, $trabaja, '01-11-2018', '31-12-2018');
                    $faltas = $this->diasFaltados($diasTrabajo, $trabaja, $primerDiaMes, $ultimoDiaMes);  //CAMBIAR FECHA PARA QUE SEA PRIMER DIA DEL MES Y ULTIMO
                    $empleado = $trabaja->empleado->empleado_nombre ." ". $trabaja->empleado->empleado_apellido;
                    
                    foreach($faltas as $falta){
                        $registros_ok[$x][0] = $falta;
                        $registros_ok[$x][1] = $empleado;
                        $registros_ok[$x][2] = "Falta";
                        $x++;
                    }
                    
                    //$llegadasTarde = $this->llegadasTarde('2018-11-01', '2018-11-30', $trabaja);
                    $llegadasTarde = $this->llegadasTarde($primerDiaMes, $ultimoDiaMes, $trabaja);
                    
                    foreach($llegadasTarde as $llegadaTarde){
                        $registros_ok[$x][0] = $llegadaTarde->registro_hora;
                        $registros_ok[$x][1] = $empleado;
                        $registros_ok[$x][2] = "Llegada Tarde";
                        $x++;
                    }
                }
            }
        }
        
        $registros_ok = collect($registros_ok)->sortBy(0);
        
        return $registros_ok;
    }
    
    private function diasFaltados($diasQueTrabaja, $trabaja, $fechaInicio, $fechaFin){
        $cedula = $trabaja->empleado->empleado_cedula;
        $registros = Registro::where('fk_empleado_cedula', '=', $cedula)->where('registro_fecha', '>=',$fechaInicio)->where('registro_fecha', '<=',$fechaFin)->get();
        $registros_array = array();
        foreach($registros as $registro){
            array_push($registros_array, $registro->registro_fecha);
        }
        $registros_ok = array_diff($diasQueTrabaja,$registros_array);
       
        return $registros_ok;
    }
    
    private function llegadasTarde($fechaInicio, $fechaFin, $trabaja){
        $cedula = $trabaja->empleado->empleado_cedula;
        
        $sql= "SELECT * FROM registros WHERE registro_fecha between '".$fechaInicio."' and  '".$fechaFin."'  AND registro_tipo='I'" ;
        $sql = $sql. " AND fk_empleado_cedula = '".$cedula."'";
        $sql = $sql." order by registro_fecha asc, fk_empleado_cedula, registro_tipo ";

        $registros_sql =  DB::select($sql);
        $registros = Registro::hydrate($registros_sql); // paso a collection de registros
        
       

        //$tiempo = Ajuste::where('ajuste_nombre','leave_earn' )->first();
        
       
        $iRegistros = 0;
        $registros_ok = [];
        
        //busco el horario a la fecha porque en un periodo de fechas pueden existir horarios distintos
        foreach($registros as $registro){
            
            $registro_fecha = $registro->registro_fecha;
            $registro_hora_d = new DateTime($registro->registro_hora);
            $registro_hora = $registro_hora_d->format('H:i:s');
            
            $empleado = $registro->Empleado;
            $horario = $empleado->HorarioEnFecha($registro_fecha);
            
            if(!is_null($horario)){
                if(!is_null($horario->fk_horariorotativo_id)){
                    $horario_ax = $horario->horariorotativo->horario;
                }elseif(!is_null($horario->fk_turno_id)){
                    $horario_ax = $horario->turno->horario;
                }
            
                if(!is_null($horario_ax)){
                    $horario_entrada = new DateTime($registro_fecha.' '.$horario_ax->horario_entrada); 
                    $horario_salida = new DateTime($registro_fecha.' '.$horario_ax->horario_salida); 
                    $hay_brake = $horario_ax->horario_haybrake;
                    
                    if($registro_hora_d < $horario_entrada){         //hora nocturna aumento un dia
                        $diff = date_diff($horario_entrada, $registro_hora_d);
                        $horas = intval($diff->format('%h'));
                        if ($diff->format('%r') =='-' && $horas > 6){
                            $horario_entrada= $horario_entrada->modify('- 1 day');
                        }
                    }else{
                        if($horario_salida < $registro_hora_d){
                            $diff = date_diff($registro_hora_d,$horario_salida);
                            $horas = intval($diff->format('%h'));
                            if ($diff->format('%r') =='-' && $horas > 6){
                                $horario_salida= $horario_salida->modify('+ 1 day');
                            } 
                        }
                    }
                    
                    $horario_entrada_2 = new DateTime($horario_entrada->format('Y-m-d H:i:s'));
                    
                    $horario_entrada_2 = $horario_entrada_2->modify('- 60 minutes');        //saco una hora por las dudas si entra antes del horario de entrada
                    
                    $date = new DateTime($registro_fecha.' '.$horario_ax->horario_entrada); 
                    
                    $tolerencia_tarde = $horario_ax->horario_tiempotarde;
                    $date_tol = new DateTime($registro_fecha.' '.$tolerencia_tarde); 
                    
                    $minutes_tarde = $date_tol->format('i');
                    $horaTarde= $horario_entrada->modify('+'.$minutes_tarde.' minutes');
                   
                    $horaTope = $horario_salida;
                    
                    if($registro_hora_d > $horaTarde && $registro_hora_d  < $horaTope ){        //siempre comparo entre formato dd/mm/aaaa hh:mm:ss
                        $ok = 'N';
                        //consulto si es la primera entrada del dia;
                        $f_inicio = $horario_entrada_2->format('Y-m-d H:i:s');
                        $f_fin = $horario_salida->format('Y-m-d H:i:s');
                        $sql= "SELECT registro_hora FROM registros WHERE registro_hora between '".$f_inicio."' and  '".$f_fin."'  AND registro_tipo='I' order by registro_hora limit 1" ;
                        $reg_sql =  DB::select($sql);
                        
                        if($reg_sql[0]->registro_hora == $registro_hora_d->format('Y-m-d H:i:s')){
                            $ok='S';
                        }else{
                            if($hay_brake == 'S'){
                                $horario_finbrake = new DateTime($registro_fecha.' '.$horario_ax->horario_finbrake); 
                                $horario_finbrake = $horario_finbrake->modify('+'.$minutes_tarde.' minutes');
                                
                                $horario_entrada_2 = new DateTime($registro_fecha.' '.$horario_ax->horario_entrada); 
                              
                                //verifico si el brake pertenece al mismo dia que el registro, sino lo cambio
                                if($horario_entrada_2 < $horario_finbrake ){
                                    $diff = date_diff($horario_finbrake,$horario_entrada_2);
                                    $horas = intval($diff->format('%h'));
                                    if ($diff->invert == 1 && $horas > 2){
                                        $horario_finbrake= $horario_finbrake->modify('- 1 day');
                                    }
                                }
                              
                                //consulto si es la primera entrada despues del fin del brake y el horario de salida;
                                $f_inicio = $horario_finbrake->format('Y-m-d H:i:s');
                                $f_fin = $horario_salida->format('Y-m-d H:i:s');
                                $sql= "SELECT registro_hora FROM registros WHERE registro_hora between '".$f_inicio."' and  '".$f_fin."'  AND registro_tipo='I' order by registro_hora limit 1" ;
                                $reg_sql =  DB::select($sql);
                                
                                if($reg_sql){
                                    if($reg_sql[0]->registro_hora == $registro_hora_d->format('Y-m-d H:i:s')){
                                        $ok = 'S';
                                    }
                                }
                                
                                
                            }
                            
                        }
                        
                        if($ok=='S'){
                            $registros_ok[$iRegistros] = $registro;
                            $iRegistros = $iRegistros + 1;
                        }
                    }
                }    
            }
        }

        $registros_ok = collect($registros_ok);
        
        return $registros_ok;
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
    
    function ChequeoLicencia(){
        $now = date("d-m-Y");
        $Recordatorio = Ajuste::where('ajuste_nombre','send_mail_license')->first();
        
        if($Recordatorio->ajuste_valor == 'S'){
            $sql = DB::table('pagos')->select('*')->get();
            $registros = collect($sql);
            
            foreach($registros as $registro){
                $vencimiento = date_format(date_create($registro->pago_fvencimiento), 'd-m-Y');
                
                $dif_dias = Carbon::parse($vencimiento)->diffInDays(Carbon::parse($now));
                $empresa = Empresa::where('empresa_estado','1')->first();
                
                if($dif_dias <= 7 && $registro->pago_prox_mail == null){
                    
                    
                    
                    $fecha_det = explode('-', $vencimiento);
                    
                    $data = array('vencimiento_dia' => $fecha_det[0], 'vencimiento_mes' => $fecha_det[1], 'empresa' => $empresa->empresa_nombre); 
                    
                    Mail::send('common.mail', $data, function($message) use ($empresa){
                        if($empresa->empresa_email2 == null){
                            if($empresa->empresa_email != null){
                                $message->to($empresa->empresa_email)->bcc('matiasfiermarin@hotmail.com')->bcc('Fede.santucho@hotmail.com')->subject('Recordatorio de vencimiento');
                            }
                        }else{
                            $message->to($empresa->empresa_email)->cc($empresa->empresa_email2)->bcc('matiasfiermarin@hotmail.com')->bcc('Fede.santucho@hotmail.com')->subject('Recordatorio de vencimiento');
                        }
                    });
                    
                    $fecha_nueva = date("d-m-Y",strtotime($vencimiento."- 1 days")); 

                    $Update = DB::update('UPDATE pagos SET pago_prox_mail = ? WHERE id= ?',[$fecha_nueva, $registro->id]);
                }elseif($dif_dias == 1){
                    $fecha_det = explode('-', $vencimiento);
                    
                    if($registro->pago_prox_mail != '01-01-1999'){
                        $data = array('vencimiento_dia' => $fecha_det[0], 'vencimiento_mes' => $fecha_det[1], 'empresa' => $empresa->empresa_nombre); 
                        
                        Mail::send('common.mail_vencido', $data, function($message) use ($empresa){
                           if($empresa->empresa_email2 == null){
                                if($empresa->empresa_email != null){
                                    $message->to($empresa->empresa_email)->bcc('matiasfiermarin@hotmail.com')->bcc('Fede.santucho@hotmail.com')->subject('Recordatorio de vencimiento');
                                }
                            }else{
                                $message->to($empresa->empresa_email)->cc($empresa->empresa_email2)->bcc('matiasfiermarin@hotmail.com')->bcc('Fede.santucho@hotmail.com')->subject('Recordatorio de vencimiento');
                            }
                        });
                        
                        $fecha_nueva = date("d-m-Y",strtotime($now."+ 6 days")); 
    
                        $Update = DB::update('UPDATE pagos SET pago_prox_mail = ? WHERE id= ?',['01-01-1999', $registro->id]);
                    }
                }
            }
        }
    }
    
    public function dashboard(){
        /*if (auth()->user()->fk_empleado_cedula){
             return redirect()->route('marcaempleado.index');
        }*/
        
        
        $this->ChequeoLicencia();
        $advertencias = $this->advertencias();
        
         
        //DATOS CARDS
        $fechaActual = new DateTime();
        $hoy = $fechaActual->format('Y-m-d');
        
        $fechaActual->modify('first day of this month');
        //$fechaActual->modify('first day of february');
        
        $f_inicio_mes = $fechaActual->format('Y-m-d');
        
        $fechaActual->modify('last day of this month');
        //$fechaActual->modify('last day of february');
        
        $f_fin_mes = $fechaActual->format('Y-m-d');
        
       
        $porcentajeHorasAtrabajar = 0;
        
        $HorasTrabajadas = $this->HorasTrabajadas($f_inicio_mes, $f_fin_mes);
        $LlegadasTardes = $this->LlegadasTardes($f_inicio_mes, $f_fin_mes);
        $HorasExtras = $this->HorasExtras($f_inicio_mes, $f_fin_mes);
        
        $TotalHorasAtrabajar = $this->TotalHorasAtrabajar($f_inicio_mes, $hoy);

        $segHorasTrabajadas = (((int)substr($HorasTrabajadas,0,2)) * 3600)+  (((int)substr($HorasTrabajadas,3,2)) * 60) +  (((int)substr($HorasTrabajadas,6,2)));    
        $segTotalHorasAtrabajar = (((int)substr($TotalHorasAtrabajar,0,2)) * 3600)+  (((int)substr($TotalHorasAtrabajar,3,2)) * 60) +  (((int)substr($TotalHorasAtrabajar,6,2))); 
        if($segHorasTrabajadas != 0 && $segTotalHorasAtrabajar !=0){
           $porcentajeHorasAtrabajar = ($segHorasTrabajadas*100)/$segTotalHorasAtrabajar;
            $porcentajeHorasAtrabajar = round($porcentajeHorasAtrabajar,2); 
        }
        
        //RANKING EMPLEADOS
        $rankingEmpleados = [];
        $rankingEmpleados = $this->rankingEmpleados($f_inicio_mes,$f_fin_mes);


        //DATOS GRAFICA
        $fechaActual = new DateTime();
        $fechaActual2 = new DateTime();
        $hoy = $fechaActual->format('Y-m-d');
        //Horas de todo el año
        $months = array("January", "February", "March","April", "May","June", "July", "August", "September", "October", "November", "December");
        $arrayHorasTrabajadas = array();
        $arrayLlegadasTardes = array();
        $arrayHorasExtras = array();
        $mesAnterior = $fechaActual2->modify('-1 month');
        $mesAnterior = $mesAnterior->format('Y-m-d');
        $tiempoTrabajadoAnual = new SumaTiempos();
        $horasTrabajadasMesAnterior = '00:00';
        $HorasTrabajadasAnual = '00:00';
        
        foreach ($months as $month) {
            $LlegadasTardes2 = '00:00';
            $HorasExtras2 = '00:00';
            $HorasTrabajadas2 = '00:00';
            
            
            $fechaActual->modify('first day of '.$month.' '. date('Y'));
            $f_inicio_mes = $fechaActual->format('Y-m-d');
            
            $fechaActual->modify('last day of '.$month.' '. date('Y'));
            $f_fin_mes = $fechaActual->format('Y-m-d');
            
            
            $Estadistica = Estadistica::where('fecha_desde','>=', $f_inicio_mes)->where('fecha_hasta','<=', $f_fin_mes )->first();
           
           
            if($Estadistica){
                $HorasTrabajadas2 = $Estadistica->total_horas_trabajadas;
                $LlegadasTardes2  = $Estadistica->total_llegadas_tardes;
                $HorasExtras2     = $Estadistica->total_horas_extras;
                
            }else{
                
                if ($f_fin_mes < $hoy){
                    $HorasTrabajadas2 = $this->HorasTrabajadas($f_inicio_mes, $f_fin_mes);
                    $LlegadasTardes2 = $this->LlegadasTardes($f_inicio_mes, $f_fin_mes);
                    $HorasExtras2 = $this->HorasExtras($f_inicio_mes, $f_fin_mes);
                    $TotalHorasAtrabajar = $this->TotalHorasAtrabajar($f_inicio_mes, $f_fin_mes);
                    
                    $Estadistica = new Estadistica();
    				$Estadistica->total_horas_trabajadas = $HorasTrabajadas2;
    				$Estadistica->total_llegadas_tardes = $LlegadasTardes2;
    				$Estadistica->total_horas_extras = $HorasExtras2;
    				$Estadistica->fecha_desde = $f_inicio_mes;
    				$Estadistica->fecha_hasta = $f_fin_mes;		
    				$Estadistica->total_debe_trabajar = $TotalHorasAtrabajar;
    				$Estadistica->save();
                }
            }
            
            $explode = explode(":", $HorasTrabajadas2);
            $HorasNum = $explode[0];
            array_push($arrayHorasTrabajadas, $HorasNum);
            
            $explode = explode(":", $LlegadasTardes2);
            $HorasNum = $explode[0];
            array_push($arrayLlegadasTardes, $HorasNum);
            
            $explode = explode(":", $HorasExtras2);
            $HorasNum = $explode[0];
            array_push($arrayHorasExtras, $HorasNum);
            
            if($mesAnterior >= $f_inicio_mes && $mesAnterior <= $f_fin_mes){
                $horasTrabajadasMesAnterior = $HorasTrabajadas2;
            }
            
            if($HorasTrabajadas2 != '00:00'){
                 $tiempoTrabajadoAnual->sumaTiempo(new SumaTiempos($HorasTrabajadas2));
            }
            
        }
       
        $HorasTrabajadasAnual = $tiempoTrabajadoAnual->verTiempoFinal();
        
        $explode = explode(":", $HorasTrabajadasAnual);
        $HorasTrabajadasAnual = $explode[0];
        
        $explode = explode(":", $horasTrabajadasMesAnterior);
        $horasTrabajadasMesAnterior = $explode[0];
        
        
        return view('dashboard',compact('HorasTrabajadas', 'LlegadasTardes', 'HorasExtras', 'TotalHorasAtrabajar', 'porcentajeHorasAtrabajar','arrayHorasTrabajadas','arrayLlegadasTardes','arrayHorasExtras','horasTrabajadasMesAnterior','HorasTrabajadasAnual','rankingEmpleados', 'advertencias'));
    }
    
    public function HorasTrabajadas($f_inicio_mes, $f_fin_mes){
   
        //dd($f_inicio_mes, $f_fin_mes,$fechaActual );
        
        //Horas trabajadas en lo que va del mes
        //$registros = cacheQuery("select * from v_inout where registro_fecha between '".$f_inicio_mes."' and  '".$f_fin_mes."' order by registro_fecha", 30);
        
        $registros =  v_inout($f_inicio_mes,$f_fin_mes);
        $empleados = Empleado::get();
       
        $tiempoTrabajado = new SumaTiempos();
        foreach($registros as $registro){
            //$empleado = Empleado::where('empleado_cedula','=' ,$registro->r_cedula)->first();
            $empleado = $empleados->whereIn('empleado_cedula', $registro->r_cedula)->first();
            if(!is_null($registro->r_total_horas ) && $empleado){
                $fecha = $registro->r_fecha;
                $fechaSalida = $registro->r_salida;
                
                
                $inconsitencia = inconsistencia_1($registros, $empleado->empleado_cedula , $fecha, $fechaSalida );
                
                if($inconsitencia == 'N'){
                     $tiempoTrabajado->sumaTiempo(new SumaTiempos($registro->r_total_horas));
                }
               
            }
            
        }
        
        $HorasTrabajadas = $tiempoTrabajado->verTiempoFinal();
        return $HorasTrabajadas;
    
    }
    
    public function LlegadasTardes($f_inicio, $f_fin){
        
        
        // $sql= "SELECT * FROM registros WHERE registro_fecha between '".$f_inicio."' and  '".$f_fin."'  AND registro_tipo='I' " ;

        // $sql = $sql." order by registro_hora asc , registro_tipo ";
        
        // $registros_sql =  cacheQuery($sql);
        
        // $registros = Registro::hydrate($registros_sql); // paso a collection de registros

        $registros = Registro::whereBetween('registro_fecha',[$f_inicio, $f_fin])
                                ->where('registro_tipo','I')
                                ->orderBy('registro_hora', 'asc')
                                ->orderBy('registro_tipo')
                                ->with('empleado')->get();

        $iRegistros = 0;
        $registros_ok = [];
        
        //busco el horario a la fecha porque en un periodo de fechas pueden existir horarios distintos
        foreach($registros as $registro){
            $registro_fecha = $registro->registro_fecha;
            $registro_hora_d = new DateTime($registro->registro_hora);
            $registro_hora = $registro_hora_d->format('H:i:s');
            $horario = [];
            if ($registro->empleado){
                 $empleado = $registro->empleado;
                 $horario = horarioAfecha($empleado->id,$registro_fecha);
                
            }else{
                  $horario[0] = '';
            }
           
            
           
           
            if($horario[0] != ''){
                
                $horario_entrada = new DateTime($registro_fecha.' '.$horario[0]); 
                $horario_entrada_calc = new DateTime($registro_fecha.' '.$horario[0]); 
                $horario_salida = new DateTime($registro_fecha.' '.$horario[3]); 
                $horario_finbrake = new DateTime($registro_fecha.' '.$horario[2]); 
                $horario_finbrake_3 = new DateTime($registro_fecha.' '.$horario[2]);
                $hay_brake = $horario[6];
           
                if($registro_hora_d < $horario_entrada){         //hora nocturna aumento un dia
                    $diff = date_diff($horario_entrada, $registro_hora_d);
                    $horas = intval($diff->format('%h'));
                    if ($diff->format('%r') =='-' && $horas > 6){
                        $horario_entrada= $horario_entrada->modify('- 1 day');
                    }
                }else{
                    
                    if($horario_salida < $registro_hora_d){
                        $diff = date_diff($registro_hora_d,$horario_salida);
                        $horas = intval($diff->format('%h'));
                        
                        if ($diff->format('%r') =='-' && $horas > 6){
                            $horario_salida= $horario_salida->modify('+ 1 day');
                        }
                        
                    }
                }
                $horario_entrada_2 = new DateTime($horario_entrada->format('Y-m-d H:i:s'));
                
                $horario_entrada_2 = $horario_entrada_2->modify('- 60 minutes');        //saco una hora por las dudas si entra antes del horario de entrada
                
                $date = new DateTime($registro_fecha.' '.$horario[0]); 
                
                $tolerencia_tarde = $horario[4];
                $date_tol = new DateTime($registro_fecha.' '.$tolerencia_tarde); 
                
                $minutes_tarde = $date_tol->format('i');
                $horaTarde= $horario_entrada->modify('+'.$minutes_tarde.' minutes');
               
                $horaTope = $horario_salida;
                
                if($registro_hora_d > $horaTarde && $registro_hora_d  < $horaTope ){        //siempre comparo entre formato dd/mm/aaaa hh:mm:ss
                    $ok = 'N';
                    //consulto si es la primera entrada del dia;
                    $f_inicio = $horario_entrada_2->format('Y-m-d H:i:s');
                    $f_fin = $horario_salida->format('Y-m-d H:i:s');
                    $sql= "SELECT registro_hora FROM registros WHERE registro_hora between '".$f_inicio."' and  '".$f_fin."'  AND registro_tipo='I'  AND fk_empleado_cedula = '".$empleado->empleado_cedula."' order by registro_hora limit 1" ;
                    $reg_sql =  cacheQuery($sql);
                    
                    if($reg_sql[0]->registro_hora == $registro_hora_d->format('Y-m-d H:i:s')){
                        $ok='S';
                        
                        $diff2 =  date('H:i:s', strtotime($registro_hora_d->format('H:i:s')) - strtotime($horario_entrada_calc->format('H:i:s')));
                        $segDiff = (((int)substr($diff2,0,2)) * 3600)+  (((int)substr($diff2,3,2)) * 60) +  (((int)substr($diff2,6,2))); 
                      
                        if($segDiff>10800){ //si llego tarde mas de 3 horas es una inconsistencia, se compara entrada nocturna con horario normal, arreglar horario
                            $ok='N';
                        }
                        
                    }else{
                        if($hay_brake == 'S'){
                            $horario_finbrake_2 = $horario_finbrake;
                            $horario_finbrake_2 = $horario_finbrake_2->modify('+'.$minutes_tarde.' minutes');
                            
                            $horario_entrada_2 = new DateTime($registro_fecha.' '.$horario[0]); 
                          
                            //verifico si el brake pertenece al mismo dia que el registro, sino lo cambio
                            if($horario_entrada_2 < $horario_finbrake_2 ){
                                $diff = date_diff($horario_finbrake_2,$horario_entrada_2);
                                
                                $horas = intval($diff->format('%h'));
                                if ($diff->invert == 1 && $horas > 2){
                                    $horario_finbrake_2= $horario_finbrake_2->modify('- 1 day');
                                }
                                
                            }
                          
                            //consulto si es la primera entrada despues del fin del brake y el horario de salida;
                            $f_inicio = $horario_finbrake_2->format('Y-m-d H:i:s');
                            $f_fin = $horario_salida->format('Y-m-d H:i:s');
                            $sql= "SELECT registro_hora FROM registros WHERE registro_hora between '".$f_inicio."' and  '".$f_fin."'  AND registro_tipo='I'  AND fk_empleado_cedula = '".$empleado->empleado_cedula."'  order by registro_hora limit 1" ;
                            $reg_sql =  cacheQuery($sql);
                            
                            if($reg_sql){
                                if($reg_sql[0]->registro_hora == $registro_hora_d->format('Y-m-d H:i:s')){
                                    $ok = 'S';
                                    
                                    $diff2 =  date('H:i:s', strtotime($registro_hora_d->format('H:i:s')) - strtotime($horario_finbrake_3->format('H:i:s')));
                                    $segDiff = (((int)substr($diff2,0,2)) * 3600)+  (((int)substr($diff2,3,2)) * 60) +  (((int)substr($diff2,6,2))); 
                                    
                                    if($segDiff>10800){ //si llego tarde mas de 3 horas es una inconsitencia, se compara entrada nocturna con horario normal
                                        $ok='N';
                                    }
                                    
                                }
                            }
                        }
                    }
                    
                    if($ok=='S'){
                        
                       
                        $r = [];
                
                        $r['fk_empleado_cedula']=$registro->fk_empleado_cedula;
                        $r['empleado']=$empleado->empleado_nombre.' '.$empleado->empleado_apellido;
                        $r['hora_entrada']=$horario[0];
                        $r['registro_fecha']= $registro_hora_d->format('d-m-Y H:i:s');
                        $r['diferencia']=$diff2;
                        $r['fin_brake']=$horario_finbrake_3->format('H:i:s');
                      
                        $registros_ok[$iRegistros] = $r;
                        $iRegistros = $iRegistros + 1;
                    }
                }
                   
            }
        }


        $registros_ok = collect($registros_ok);
        
        $tiempoAcumulado = new SumaTiempos();
        foreach($registros_ok as $registro){
            $registro_hora = new DateTime($registro['registro_fecha']); 
            $entrada =  $registro['hora_entrada'];
            $diff = date('H:i:s', strtotime($registro_hora->format('H:i:s')) - strtotime($entrada));
            $tiempoAcumulado->sumaTiempo(new SumaTiempos($diff));
        }
        
        $LlegadasTardes = $tiempoAcumulado->verTiempoFinal();
        return $LlegadasTardes;
        
        
        
    }
    
    public function HorasExtras($f_inicio, $f_fin){
        //$sql= "SELECT fk_empleado_cedula, registro_fecha, SEC_TO_TIME( SUM( TIME_TO_SEC( registro_totalHoras ) ) ) as sum_horas FROM v_inout WHERE registro_fecha between '".$f_inicio."' and  '".$f_fin."'  and fk_empleado_cedula in (select empleado_cedula from empleados)" ;
        
        //$sql = $sql." group by fk_empleado_cedula, registro_fecha ";
        
        $registros_sql = v_inout($f_inicio,$f_fin);
        $registros_sql =  collect($registros_sql);
        
        $minimo_extras = ajuste('minimo_extras');
        $max_extras = ajuste('max_hours_ext_per_day');
        $i=0;
        
        $registros_sql =  $registros_sql->groupBy('r_cedula');
     
        $tiempoAcumulado = new SumaTiempos();
        $empleados = Empleado::get();         
        foreach($registros_sql as $cedula => $fechas){
            $Empleado = $empleados->whereIn('empleado_cedula', $cedula)->first();
            if($Empleado){
                foreach($fechas->groupBy('r_fecha') as $fecha => $regs){
                    $tiempoAcumuladoFecha = new SumaTiempos();
                    $horario = horarioAfecha( $Empleado->id, $fecha);
                    $horas_debe_trabajar = totalHorasAfecha($horario);
                   
                
                    if ($horario[0] !=''){
                        foreach($regs as $reg){
                            $inconsitencia = inconsistencia_1($regs, $cedula , $fecha, $reg->r_salida );
                            if($inconsitencia == 'N' && $reg->r_total_horas){
                                $tiempoAcumuladoFecha->sumaTiempo(new SumaTiempos($reg->r_total_horas));
                            }
                            
                        }
                    		
                		$horas_trabajadas =  $tiempoAcumuladoFecha->verTiempoFinal();
                	
                		$horas_extras = date('H:i:s', strtotime($horas_trabajadas) - strtotime($horas_debe_trabajar));
                    	    
                    	
                        if($horas_extras >= $minimo_extras && $horas_debe_trabajar<> '00:00:00' && $horas_extras <='12:59:59' ){
                            $tiempoAcumulado->sumaTiempo(new SumaTiempos($horas_extras));
                            $i++;
                        }
                    }
                   
                    
                }
                
            }
    		
        }
       
        $HorasExtras = $tiempoAcumulado->verTiempoFinal();
        return $HorasExtras;
    }
    
    public function TotalHorasAtrabajar($f_inicio, $hoy){
        
        $tiempoAcumulado = new SumaTiempos();    
        $start_date = new DateTime($f_inicio);
        $end_date= new DateTime($hoy);
        
        //$Empleados =  Empleado::where('empleado_estado' ,"=", "Activo")->get();
        $Empleados =  cacheQuery("Select * from empleados where empleado_estado = 'Activo' ");
        
        
        for($i = $start_date; $i <= $end_date; $i->modify('+1 day')){
           
            $dia =  $i->format("Y-m-d");
            
            foreach($Empleados as $empleado){
                $horario = horarioAfecha($empleado->id, $dia);
                
                
                $horas_debe_trabajar = totalHorasAfecha($horario);
                
                if($horas_debe_trabajar != '' && $horario[0] != ''){
                    $tiempoAcumulado->sumaTiempo(new SumaTiempos($horas_debe_trabajar));
                
                }
            }
            
        }
        
        
        $TotalHorasAtrabajar = $tiempoAcumulado->verTiempoFinal();
        return $TotalHorasAtrabajar;
        
    }
    
    public function rankingEmpleados($f_inicio, $f_fin){
        $rankingEmpleados =[];
        $Empleados =  cacheQuery("Select * from empleados where empleado_estado = 'Activo' ");
        $iEmpleados = 0;
        $tiempoAcumulado = new SumaTiempos();    
       
        
        foreach($Empleados as $empleado){
            $start_date = new DateTime($f_inicio);
            $end_date= new DateTime($f_fin);
            
            //HORAS TRABAJADAS
            $registros =  v_inout($f_inicio,$f_fin, $empleado->empleado_cedula);
       
            $tiempoTrabajado = new SumaTiempos();
            foreach($registros as $registro){
                
                if(!is_null($registro->r_total_horas ) && $empleado){
                    $fecha = $registro->r_fecha;
                    $fechaSalida = $registro->r_salida;
                    
                    
                    $inconsitencia = inconsistencia_1($registros, $empleado->empleado_cedula , $fecha, $fechaSalida );
                    
                    if($inconsitencia == 'N'){
                         $tiempoTrabajado->sumaTiempo(new SumaTiempos($registro->r_total_horas));
                    }
                    
                    
                   
                }
                
            }
            
            $HorasTrabajadas = $tiempoTrabajado->verTiempoFinal();
            
            //HORAS A TRABAJAR
            $tiempoTrabajado = new SumaTiempos();
            
            for($i = $start_date; $i <= $end_date; $i->modify('+1 day')){
           
                $dia =  $i->format("Y-m-d");
            
                $horario = horarioAfecha($empleado->id, $dia);
                $horas_debe_trabajar = totalHorasAfecha($horario);
                
                if($horas_debe_trabajar != '' && $horario[0] != ''){
                   
                    $tiempoTrabajado->sumaTiempo(new SumaTiempos($horas_debe_trabajar));
                
                }
                
            }
            $TotalHorasAtrabajar = $tiempoTrabajado->verTiempoFinal();
            
            //PORCENTAJE
            $porcentajeHorasAtrabajar = 0;
            $segHorasTrabajadas = (((int)substr($HorasTrabajadas,0,2)) * 3600)+  (((int)substr($HorasTrabajadas,3,2)) * 60) +  (((int)substr($HorasTrabajadas,6,2)));    
            $segTotalHorasAtrabajar = (((int)substr($TotalHorasAtrabajar,0,2)) * 3600)+  (((int)substr($TotalHorasAtrabajar,3,2)) * 60) +  (((int)substr($TotalHorasAtrabajar,6,2))); 
            if($segHorasTrabajadas != 0 && $segTotalHorasAtrabajar !=0){
               $porcentajeHorasAtrabajar = ($segHorasTrabajadas*100)/$segTotalHorasAtrabajar;
                $porcentajeHorasAtrabajar = round($porcentajeHorasAtrabajar,2); 
            }
        
            $R = [];
                
            $r['fk_empleado_cedula']=$empleado->empleado_cedula;
            $r['empleado']=$empleado->empleado_nombre.' '.$empleado->empleado_apellido;
            $r['porcentaje']=$porcentajeHorasAtrabajar;
            //$r['HT']=$HorasTrabajadas;
            //$r['HAT']=$TotalHorasAtrabajar;
            $rankingEmpleados[$iEmpleados] = $r;
            $iEmpleados = $iEmpleados + 1;
        }
        
        
        $sortArray = array();

        foreach($rankingEmpleados as $e){
            foreach($e as $key=>$value){
                if(!isset($sortArray[$key])){
                    $sortArray[$key] = array();
                }
                $sortArray[$key][] = $value;
            }
        }
        
        $orderby = "porcentaje"; //change this to whatever key you want from the array 
        
        array_multisort($sortArray[$orderby],SORT_DESC,$rankingEmpleados); 
       
        return $rankingEmpleados;
    }
    
}