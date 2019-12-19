<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

use App\Models\Ajuste;
use App\Models\Registro;
use App\Models\Empleado;
use App\Models\Trabaja;
use App\Models\Perfil;
use App\Models\Estadistica;
use App\Models\Tablon;
use App\User;
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
	
	  public function dashboard(){
        $empleado_cedula = auth()->user()->fk_empleado_cedula;
        $User = User::where('fk_empleado_cedula',$empleado_cedula)->first();
        
        $sql= "SELECT * FROM perfiles_usuarios WHERE fk_user_id='".$User->id."'" ;

        $perfil_user =  DB::select($sql);
        
        $perfil = Perfil::where('id', $perfil_user[0]->fk_perfil_id)->first();
        
        if ($perfil->id == 6){
             return $this->dashboardempleado();
        }
        
        $this->ChequeoLicencia();
       
        
         
        //DATOS CARDS (DATOS DEL MES ACTUAL)
        $fechaActual = new DateTime();
				//$fechaActual = DateTime::createFromFormat('Y-m-d', '2019-10-31');
				
        $hoy = $fechaActual->format('Y-m-d');
        
        $fechaActual->modify('first day of this month');
        //$fechaActual->modify('first day of february');
        
        $f_inicio_mes = $fechaActual->format('Y-m-d');
        
        $fechaActual->modify('last day of this month');
        //$fechaActual->modify('last day of february');
        
        $f_fin_mes = $fechaActual->format('Y-m-d');      
			
				$horas = $this->RecorroTablon($f_inicio_mes, $f_fin_mes);
        $HorasTrabajadas = $horas[0];
        $LlegadasTardes = $horas[1];
        $HorasExtras = $horas[2];      
        $TotalHorasAtrabajar = $horas[3];			
				$rankingEmpleados = $horas[4];			
			 	$advertencias = $horas[5];
		
				//PORCENTAJE
				$porcentajeHorasAtrabajar = 0; 
				$explode = explode(":", $HorasTrabajadas);	
				$segHorasTrabajadas     = (((int)$explode[0]) * 3600)      +  (((int)$explode[1]) * 60)     +  (((int)$explode[2]));

				$explode = explode(":", $TotalHorasAtrabajar);
				$segTotalHorasAtrabajar = (((int)$explode[0]) * 3600)      +  (((int)$explode[1]) * 60)     +  (((int)$explode[2]));

				if($segHorasTrabajadas != 0 && $segTotalHorasAtrabajar !=0){
					 $porcentajeHorasAtrabajar = ($segHorasTrabajadas*100)/$segTotalHorasAtrabajar;
						$porcentajeHorasAtrabajar = round($porcentajeHorasAtrabajar,2); 
				}
        
      

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
									
										$horas2 = $this->RecorroTablon($f_inicio_mes, $f_fin_mes);
										$HorasTrabajadas2 = $horas2[0];
										$LlegadasTardes2 = $horas2[1];
										$HorasExtras2 = $horas2[2];      
										$TotalHorasAtrabajar2 = $horas2[3];									
								
                    $Estadistica = new Estadistica();
										$Estadistica->total_horas_trabajadas = $HorasTrabajadas2;
										$Estadistica->total_llegadas_tardes = $LlegadasTardes2;
										$Estadistica->total_horas_extras = $HorasExtras2;
										$Estadistica->fecha_desde = $f_inicio_mes;
										$Estadistica->fecha_hasta = $f_fin_mes;		
										$Estadistica->total_debe_trabajar = $TotalHorasAtrabajar2;
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
 
    public function dashboardempleado(){
        $empleado_cedula = auth()->user()->fk_empleado_cedula;
        
        //DATOS CARDS
        $fechaActual = new DateTime();
        $hoy = $fechaActual->format('Y-m-d');
        
        $fechaActual->modify('first day of this month');
        
        $f_inicio_mes = $fechaActual->format('Y-m-d');
        
        $fechaActual->modify('last day of this month');
        
        $f_fin_mes = $fechaActual->format('Y-m-d');
        
        $horasTrabajadas = v_inout($f_inicio_mes, $f_fin_mes, $empleado_cedula);
        $tiempoTrabajado = new SumaTiempos();
        foreach($horasTrabajadas as $registro){
            if(!is_null($registro->r_total_horas )){
                $fecha = $registro->r_fecha;
                $fechaSalida = $registro->r_salida;
                
                $inconsitencia = inconsistencia_1($horasTrabajadas, $empleado_cedula , $fecha, $fechaSalida );
                
                if($inconsitencia == 'N'){
                     $tiempoTrabajado->sumaTiempo(new SumaTiempos($registro->r_total_horas));
                }
               
            }
            
        }
        $horas = $tiempoTrabajado->verTiempoFinal();
        $registros = Registro::where('fk_empleado_cedula', '=', $empleado_cedula)->whereBetween('registro_fecha', [$f_inicio_mes, $f_fin_mes])->orderby('registro_fecha')->orderby('registro_hora')->get();
    
        return view('dashboard-empleado', compact('registros','horas'));
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
    
  
    
		public function RecorroTablon($f_inicio_mes, $f_fin_mes){
			$horas[0] = '00:00:00';  //HorasTrabajadas
			$horas[1] = '00:00:00';  //LlegadasTardes
			$horas[2] = '00:00:00';  //HorasExtras
			$horas[3] = '00:00:00';  //TotalHorasAtrabajar
			$horas[4] = []; 	//ranking
			$horas[5] = []; 	//advertencias
			
			$advertencias = [];
			$registrosTablon = Tablon::where('tablon_fecha','>=',$f_inicio_mes)->where('tablon_fecha','<=',$f_fin_mes)->get();
			$x= 0;
			if($registrosTablon->count() > 0 ){
				$HorasTrabajadas = new SumaTiempos();  
				$LlegadasTardes = new SumaTiempos();  
				$HorasExtras = new SumaTiempos();  
				$TotalHorasAtrabajar = new SumaTiempos();  
				$iEmpleados = 0;
				foreach($registrosTablon->groupBy('tablon_fk_empleado_cedula') as $registrosPorCedula){					
					$HorasTrabajadasXEmpleado = new SumaTiempos(); 
					$TotalHorasAtrabajarXEmpleado = new SumaTiempos(); 
					$empleado = Empleado::where('empleado_cedula','=',$registrosPorCedula[0]->tablon_fk_empleado_cedula)->first();
					
					foreach($registrosPorCedula as $registroT){
						$cedula = $registroT->tablon_fk_empleado_cedula;
						
						$HorasTrabajadas->sumaTiempo(new SumaTiempos($registroT->tablon_h_trabajadas));
						$LlegadasTardes->sumaTiempo(new SumaTiempos($registroT->tablon_h_llegadas_tardes));
						$HorasExtras->sumaTiempo(new SumaTiempos($registroT->tablon_h_extras));
						$TotalHorasAtrabajar->sumaTiempo(new SumaTiempos($registroT->tablon_h_debe_trabajar));
						
						$HorasTrabajadasXEmpleado->sumaTiempo(new SumaTiempos($registroT->tablon_h_trabajadas));
						$TotalHorasAtrabajarXEmpleado->sumaTiempo(new SumaTiempos($registroT->tablon_h_debe_trabajar));
						
						
						if($registroT->tablon_debe_trabajar == 'S' and $registroT->tablon_h_trabajadas == '00:00:00' ){
							$advertencias[$x][0] = $registroT->tablon_fecha;
							$advertencias[$x][1] = $empleado->empleado_nombre.' '.$empleado->empleado_apellido;
							$advertencias[$x][2] = "Falta";
							$x++;
						}
								

						if($registroT->tablon_debe_trabajar == 'S' and $registroT->tablon_h_llegadas_tardes > '00:00:00' ){
							$advertencias[$x][0] = $registroT->tablon_fecha.' ('.$registroT->tablon_h_llegadas_tardes.')';
							$advertencias[$x][1] = $empleado->empleado_nombre.' '.$empleado->empleado_apellido;
							$advertencias[$x][2] = "Llegada Tarde";
							$x++;
						}

					
								
			
					}
					
					$HorasTrabajadasRank = $HorasTrabajadasXEmpleado->verTiempoFinal();
					$TotalHorasAtrabajarRank = $TotalHorasAtrabajarXEmpleado->verTiempoFinal();
					
					//PORCENTAJE
					$explode = explode(":", $HorasTrabajadasRank);
			
					$porcentajeHorasAtrabajar = 0;
					$segHorasTrabajadas     = (((int)$explode[0]) * 3600)      +  (((int)$explode[1]) * 60)     +  (((int)$explode[2]));
					
					$explode = explode(":", $TotalHorasAtrabajarRank);
					$segTotalHorasAtrabajar = (((int)$explode[0]) * 3600)      +  (((int)$explode[1]) * 60)     +  (((int)$explode[2]));
					
					if($segHorasTrabajadas != 0 && $segTotalHorasAtrabajar !=0){
						 $porcentajeHorasAtrabajar = ($segHorasTrabajadas*100)/$segTotalHorasAtrabajar;
							$porcentajeHorasAtrabajar = round($porcentajeHorasAtrabajar,2); 
					}
					
					
					$R = [];
					$r['fk_empleado_cedula']=$cedula;
					$r['empleado']=$empleado->empleado_nombre.' '.$empleado->empleado_apellido;
					$r['porcentaje']=$porcentajeHorasAtrabajar;
					$r['HT']=$HorasTrabajadasRank;
          $r['HAT']=$TotalHorasAtrabajarRank;
					$rankingEmpleados[$iEmpleados] = $r;
					$iEmpleados = $iEmpleados + 1;
					
				}
						
				
				//ORDENO RANKING POR PORCENTAJE
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
				$advertencias = collect($advertencias)->sortBy(0);
				
				$horas[0] = $HorasTrabajadas->verTiempoFinal();  //HorasTrabajadas
				$horas[1] = $LlegadasTardes->verTiempoFinal();  //LlegadasTardes
				$horas[2] = $HorasExtras->verTiempoFinal();  //HorasExtras
				$horas[3] = $TotalHorasAtrabajar->verTiempoFinal();  //TotalHorasAtrabajar
				$horas[4] = $rankingEmpleados;  //Array ranking
				$horas[5] = $advertencias;  //Array ranking
			}		

			return $horas;
		}
	
    
    
    
    
    
       
    
    
}