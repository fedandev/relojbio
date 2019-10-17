<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

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
use Log;
class ReportesRESTController extends Controller
{
    

    public function empleadosMarcasAyer($key){
				Log::info("Se ejecuto empleadosMarcasAyer");
				$key_app = 'eQXSUoh4RkX5DvTktmlT7+SVueSChf5mrqlJscwK8KU=';
			
				if($key_app != $key){
					return response()->json("{'error': 'no autorizado'}",401);
				}
			
        $Rpdf = Ajuste::where('ajuste_nombre','reporte_pdf')->first();
        $ayer = date('Y-m-d', strtotime('yesterday'));   
      
                
				$empleados = Empleado::all();    
     
				$fechainicio = $ayer;
        $fechafin = $ayer;
        $registros = [];
        // $registros = [1][1]; Cedula
        // $registros = [1][2]; fecha
        // $registros = [1][3]; horas a trabajar
        // $registros = [1][4]; horas trabajadas
        // $registros = [1][5]; horas diff
     
        $minimo_extras = ajuste('minimo_extras');
        $max_extras = ajuste('max_hours_ext_per_day');
        $i=0;
        $empleado_cedula = "";
        $fecha = "";
        $Empleado_Anterior = new Empleado();
        $primero = 0;
        $entro = 0;
        
        //Cosas a tener en cuenta:
        // 1- Minimo extras.
        // 2- Maximo extras.
        // 3- Formato de extras.
        // 4- Autorizaciones de extras.
        // 5- Como se restan las extras con las horas comunes.
        // 6- Horario cortado.
        // 7- Si las extras estan autorizadas para ese día (lunes, martes, etc) o no.
               
        foreach($empleados as $empleado){
            
            $registros_inout =  v_inout($fechainicio,$fechafin,$empleado->empleado_cedula);
            $registros_sql = collect($registros_inout);
            
            $horas_debe_trabajar_sum = new SumaTiempos();
            $horas_trabajadas = new SumaTiempos();
            $horas_dia = new SumaTiempos();
            $extras_sinDesc = new SumaTiempos();
            $horas_libre_feriado = new SumaTiempos();
            
            foreach($registros_sql as $registro){
                              
                if(array_first($registros_sql) == $registro){                   //Si es el primer registro del array
                    $fecha = $registro->r_fecha;
                    $horarioCompleto = horarioAfecha($empleado->id, $fecha);    //Busco los horarios de entrada/salida del empleado en una fecha especifica
                    $horario = totalHorasAfecha($horarioCompleto);              //Busco el total de horas que debe hacer en el día de la fecha
                    
                    if($registro->r_total_horas != null){
                        if($horario[0] == "00:00:00" && $horario[3] == "00:00:00"){                         //Sino tiene horario asignado quiere decir que no tenia que trabajar ese día
                            $horas_libre_feriado->sumaTiempo(new SumaTiempos($registro->r_total_horas));  
                        }else{
                            $feriado = Feriado::where('feriado_fecha','=',$fecha)->first();             //Busco si esa fecha que trabajo es feriado
                            if($feriado == null){
                                $totalHoras = HorasTrabajadas($empleado, $registro->r_entrada, $registro->r_salida, $fecha);    //Sino es feriado ve si esta autorizado a hacer extras
                                if($totalHoras != null){
                                    $horas_dia->sumaTiempo(new SumaTiempos($totalHoras));
                                }
                            }else{
                                if($feriado->feriado_laborable == 1){           //Si es feriado laborable lo agrega a horas comunes sino a horas trabajadas en libre o feriado
                                    $totalHoras = HorasTrabajadas($empleado, $registro->r_entrada, $registro->r_salida, $fecha);
                                    if($totalHoras != null){
                                        $horas_dia->sumaTiempo(new SumaTiempos($totalHoras));
                                    }
                                }else{
                                    $horas_libre_feriado->sumaTiempo(new SumaTiempos($registro->r_total_horas));   
                                }
    	                    }                        
                        }
                    }
                    continue;
                }
                
                if($fecha == $registro->r_fecha){
                    $horarioCompleto = horarioAfecha($empleado->id, $fecha);    //Busco los horarios de entrada/salida del empleado en una fecha especifica
                    $horario = totalHorasAfecha($horarioCompleto);              //Busco el total de horas que debe hacer en el día de la fecha
                    
                    if($registro->r_total_horas != null){
                        if($horario[0] == "00:00:00" && $horario[3] == "00:00:00"){                         //Sino tiene horario asignado quiere decir que no tenia que trabajar ese día
                            $horas_libre_feriado->sumaTiempo(new SumaTiempos($registro->r_total_horas));  
                        }else{
                            $feriado = Feriado::where('feriado_fecha','=',$fecha)->first();             //Busco si esa fecha que trabajo es feriado
                            if($feriado == null){
                                $totalHoras = HorasTrabajadas($empleado, $registro->r_entrada, $registro->r_salida, $fecha);    //Sino es feriado ve si esta autorizado a hacer extras
                                if($totalHoras != null){
                                    $horas_dia->sumaTiempo(new SumaTiempos($totalHoras));
                                }
                            }else{
                                if($feriado->feriado_laborable == 1){           //Si es feriado laborable lo agrega a horas comunes sino a horas trabajadas en libre o feriado
                                    $totalHoras = HorasTrabajadas($empleado, $registro->r_entrada, $registro->r_salida, $fecha);
                                    if($totalHoras != null){
                                        $horas_dia->sumaTiempo(new SumaTiempos($totalHoras));
                                    }
                                }else{
                                    $horas_libre_feriado->sumaTiempo(new SumaTiempos($registro->r_total_horas));   
                                }
    	                    }                        
                        }
                    }
                    
                    if($registros_sql[(count($registros_sql)-1)] == $registro){     //ULTIMO REGISTRO DEL ARRAY
                        $horas_extras = "00:00:00";
                        
                        $horasXdia = horarioAfecha($empleado->id, $fecha);
                        $horas = totalHorasAfecha($horasXdia);

                        $ResultadoHoras = new SumaTiempos();
                        $ResultadoHoras->sumaTiempo(new SumaTiempos($horas));
                        $ResultadoHoras->restaTiempo(new SumaTiempos($horas_dia->verTiempoFinal()));
                        $totalextras = $ResultadoHoras->verTiempoFinal();

                        if($totalextras > $minimo_extras){
                            $extras_sinDesc->sumaTiempo(new SumaTiempos($totalextras));
                        }

                        $horas_trabajadas->sumaTiempo(new SumaTiempos($horas_dia->verTiempoFinal()));

                        $horasAux = new SumaTiempos();
                        $horasAux->sumaTiempo(new SumaTiempos($horas_trabajadas->verTiempoFinal()));
                        
                        $totalextras = $horasAux->restaTiempo(new SumaTiempos($horas));
                        if($totalextras > $minimo_extras){
                            $horas_extras->sumaTiempo(new SumaTiempos($totalextras->verTiempoFinal()));
                        }
    	                
                        $inicio = strtotime($fechainicio);
                        $fin = strtotime($fechafin);
                        
                        for($z=$inicio; $z<=$fin; $z+=86400){
                            $fecha = date("Y-m-d", $z);
                            $horario_Fecha = horarioAfecha($empleado->id, $fecha);
                            $horas = totalHorasAfecha($horario_Fecha);
                            $horas_debe_trabajar_sum->sumaTiempo(new SumaTiempos($horas));
                        }
                       	
                        if($horas_trabajadas->verTiempoFinal() == '00:00:00'){
                            $horas_diff =	$horas_debe_trabajar_sum->verTiempoFinal();
                        }else{													
                            $horas_diff = date('H:i:s', strtotime($horas_debe_trabajar_sum->verTiempoFinal()) - strtotime($horas_trabajadas->verTiempoFinal()));
                        }
                        if($horas_diff>='12:00:00'){
                            $horas_diff = '00:00:00';
                        }
											
                        $r = [];

                        $r['fk_empleado_cedula'] = $empleado->empleado_cedula;
                        $r['registro_fecha'] = $registro->r_fecha;
                        if($horas_debe_trabajar_sum->verTiempoFinal() == '00:00:00'){
                            $r['horas_debe_trabajar']='No tiene horario asignado';
                        }else{
                            $r['horas_debe_trabajar'] = $horas_debe_trabajar_sum->verTiempoFinal();
                        }
                        $r['horas_trabajadas'] = $horas_trabajadas->verTiempoFinal();
                        if($horas_extras == '00:00:00'){
                            $r['horas_extras'] = '00:00:00';
                        }elseif($horas_extras < '00:00:00'){
                            $r['horas_extras'] = '00:00:00';
                        }else{
                            $r['horas_extras'] = $extras_sinDesc->verTiempoFinal();
                        }
						$r['horas_diff'] = $horas_diff;
                        $r['empleado'] = $empleado->empleado_nombre.' '.$empleado->empleado_apellido;
                        $r['horas_libre_feriado'] = $horas_libre_feriado->verTiempoFinal();
                        
                        $registros[$i] = $r;
                        $i++;
                    }
                }else{
                    $horasXdia = horarioAfecha($empleado->id, $fecha);
                    $horas = totalHorasAfecha($horasXdia);
                    
                    $ResultadoHoras = new SumaTiempos();
                    $ResultadoHoras->sumaTiempo(new SumaTiempos($horas));
                    $ResultadoHoras->restaTiempo(new SumaTiempos($horas_dia->verTiempoFinal()));
                    $totalextras = $ResultadoHoras->verTiempoFinal();
                    
                    if($totalextras > $minimo_extras){
                        $extras_sinDesc->sumaTiempo(new SumaTiempos($totalextras));
                    }
                    
                    $horas_trabajadas->sumaTiempo(new SumaTiempos($horas_dia->verTiempoFinal()));
                    $horas_dia = new SumaTiempos();
                    
                    $fecha = $registro->r_fecha;
                    $horarioCompleto = horarioAfecha($empleado->id, $fecha);    //Busco los horarios de entrada/salida del empleado en una fecha especifica
                    $horario = totalHorasAfecha($horarioCompleto);              //Busco el total de horas que debe hacer en el día de la fecha
                    
                    if($registro->r_total_horas != null){
                        if($horario[0] == "00:00:00" && $horario[3] == "00:00:00"){                         //Sino tiene horario asignado quiere decir que no tenia que trabajar ese día
                            $horas_libre_feriado->sumaTiempo(new SumaTiempos($registro->r_total_horas));  
                        }else{
                            $feriado = Feriado::where('feriado_fecha','=',$fecha)->first();             //Busco si esa fecha que trabajo es feriado
                            if($feriado == null){
                                $totalHoras = HorasTrabajadas($empleado, $registro->r_entrada, $registro->r_salida, $fecha);    //Sino es feriado ve si esta autorizado a hacer extras
                                if($totalHoras != null){
                                    $horas_dia->sumaTiempo(new SumaTiempos($totalHoras));
                                }
                            }else{
                                if($feriado->feriado_laborable == 1){           //Si es feriado laborable lo agrega a horas comunes sino a horas trabajadas en libre o feriado
                                    $totalHoras = HorasTrabajadas($empleado, $registro->r_entrada, $registro->r_salida, $fecha);
                                    if($totalHoras != null){
                                        $horas_dia->sumaTiempo(new SumaTiempos($totalHoras));
                                    }
                                }else{
                                    $horas_libre_feriado->sumaTiempo(new SumaTiempos($registro->r_total_horas));   
                                }
    	                    }                        
                        }
                    }
                    
                    if($registros_sql[(count($registros_sql)-1)] == $registro){ //ULTIMO REGISTRO DEL ARRAY
                        $horas_extras = "00:00:00";
                        
                        $horasXdia = horarioAfecha($empleado->id, $fecha);
                        $horas = totalHorasAfecha($horasXdia);

                        $ResultadoHoras = new SumaTiempos();
                        $ResultadoHoras->sumaTiempo(new SumaTiempos($horas));
                        $ResultadoHoras->restaTiempo(new SumaTiempos($horas_dia->verTiempoFinal()));
                        $totalextras = $ResultadoHoras->verTiempoFinal();

                        if($totalextras > $minimo_extras){
                            $extras_sinDesc->sumaTiempo(new SumaTiempos($totalextras));
                        }
                        
                        $horas_trabajadas->sumaTiempo(new SumaTiempos($horas_dia->verTiempoFinal()));

                        $horasAux = new SumaTiempos();
                        $horasAux->sumaTiempo(new SumaTiempos($horas_trabajadas->verTiempoFinal()));
                        
                        $totalextras = $horasAux->restaTiempo(new SumaTiempos($horas));
                        if($totalextras > $minimo_extras){
                            $horas_extras->sumaTiempo(new SumaTiempos($totalextras->verTiempoFinal()));
                        }
    	                
                        $inicio = strtotime($fechainicio);
                        $fin = strtotime($fechafin);
                        
                        for($z=$inicio; $z<=$fin; $z+=86400){
                            $fecha = date("Y-m-d", $z);
                            $horario_Fecha = horarioAfecha($empleado->id, $fecha);
                            $horas = totalHorasAfecha($horario_Fecha);
                            $horas_debe_trabajar_sum->sumaTiempo(new SumaTiempos($horas));
                        }
											
                        if($horas_trabajadas->verTiempoFinal() == '00:00:00'){
                            $horas_diff =	$horas_debe_trabajar_sum->verTiempoFinal();
                        }else{													
                            $horas_diff = date('H:i:s', strtotime($horas_debe_trabajar_sum->verTiempoFinal()) - strtotime($horas_trabajadas->verTiempoFinal()));
                        }
                        if($horas_diff>='12:00:00'){
                            $horas_diff = '00:00:00';
                        }
                        
                        $r = [];

                        $r['fk_empleado_cedula'] = $empleado->empleado_cedula;
                        $r['registro_fecha'] = $registro->r_fecha;
                        if($horas_debe_trabajar_sum->verTiempoFinal() == '00:00:00'){
                            $r['horas_debe_trabajar']='No tiene horario asignado';
                        }else{
                            $r['horas_debe_trabajar'] = $horas_debe_trabajar_sum->verTiempoFinal();
                        }
                        $r['horas_trabajadas'] = $horas_trabajadas->verTiempoFinal();
                        if($extras_sinDesc == '00:00:00'){
                            $r['horas_extras'] = '00:00:00';
                        }elseif($extras_sinDesc < '00:00:00'){
                            $r['horas_extras'] = '00:00:00';
                        }else{
                            $r['horas_extras'] = $extras_sinDesc->verTiempoFinal();
                        }
												$r['horas_diff'] = $horas_diff;
                        $r['empleado'] = $empleado->empleado_nombre.' '.$empleado->empleado_apellido;
                        $r['horas_libre_feriado'] = $horas_libre_feriado->verTiempoFinal();

                        $registros[$i] = $r;
                        $i++;
                    }
                }
            }
						
						if ($registros_sql->count() == 0){
							$horario_Fecha = horarioAfecha($empleado->id, $ayer);
							$horas = totalHorasAfecha($horario_Fecha);
							$horas_debe_trabajar_sum->sumaTiempo(new SumaTiempos($horas));
							
							if($horas_trabajadas->verTiempoFinal() == '00:00:00'){
									$horas_diff =	$horas_debe_trabajar_sum->verTiempoFinal();
							}else{													
									$horas_diff = date('H:i:s', strtotime($horas_debe_trabajar_sum->verTiempoFinal()) - strtotime($horas_trabajadas->verTiempoFinal()));
							}
							if($horas_diff>='12:00:00'){
									$horas_diff = '00:00:00';
							}
							
							$r['fk_empleado_cedula'] = $empleado->empleado_cedula;
							$r['registro_fecha'] = $ayer;
							if($horas_debe_trabajar_sum->verTiempoFinal() == '00:00:00'){
									$r['horas_debe_trabajar']='No tiene horario asignado';
							}else{
									$r['horas_debe_trabajar'] = $horas_debe_trabajar_sum->verTiempoFinal();
							}
							$r['horas_trabajadas'] = $horas_trabajadas->verTiempoFinal();
							if($extras_sinDesc == '00:00:00'){
									$r['horas_extras'] = '00:00:00';
							}elseif($extras_sinDesc < '00:00:00'){
									$r['horas_extras'] = '00:00:00';
							}else{
									$r['horas_extras'] = $extras_sinDesc->verTiempoFinal();
							}
							$r['horas_diff'] = $horas_diff;
							$r['empleado'] = $empleado->empleado_nombre.' '.$empleado->empleado_apellido;
							$r['horas_libre_feriado'] = $horas_libre_feriado->verTiempoFinal();	
							$registros[$i] = $r;
							$i++;
					  }
					
					
        }
        
        $registros_ok = collect($registros);
			
				
        if($registros_ok->count() > 0){
						Log::info("Hay registros");
						$path = public_path().'/storage/empleadosMarcasAyer_'.$ayer.'.pdf';
					 
            $pdf = PDF::loadView('pdf.empleadosMarcasAyer', compact('registros_ok','fechainicio','fechafin','oficina'))->save($path);
					
           	$data = array(); 			
					
						$empresa = Empresa::where('empresa_estado','1')->first();
						Mail::send('common.mail_marcas_ayer', $data, function($message) use ($empresa,$path){
              if($empresa->empresa_email2 == null){
                  if($empresa->empresa_email != null){
                      $message->to($empresa->empresa_email)->subject('Reporte de marcas en el dia de ayer')->attach($path);
                  }
              }else{
                  $message->to($empresa->empresa_email)->cc($empresa->empresa_email2)->subject('Reporte de marcas en el dia de ayer')->attach($path);
              }
           });
					return response()->json("{'ok': 'reporte ejecutado con exito'}",200);
        }
			
	  }
}