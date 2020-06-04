<?php

namespace App\Traits;
use App\Models\Empleado;
use App\SumaTiempos;
use App\Models\Feriado;
use Log;
use DateTime;
trait RepHorasExtrasResumidasTrait
{
    
    public function repHorasExtrasResumidas($fechainicio,$fechafin, $cedula,$oficina_id = 0){
    
        $for = "N";
         
        if($cedula !='' && $cedula != 'ALL'){
            $empleados = Empleado::where('empleado_cedula',$cedula)->where('empleado_estado','Activo')->get();
        }elseif($oficina_id > 0 && $cedula == 'ALL'){
            if($oficina_id != NULL){
                $empleados = Empleado::where('fk_oficina_id',$oficina_id)->where('empleado_estado','Activo')->get();
            }
        }elseif($oficina_id == 'ALL' && $cedula == 'ALL'){
            $for = "S";
        }
        
        $registros = [];
        
        $minimo_extras = ajuste('minimo_extras');
        $max_extras = ajuste('max_hours_ext_per_day');
        $i=0;
        $empleado_cedula = "";
        $fecha = "";
        
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
        
        if($for == 'S'){
            $empleados = Empleado::where('empleado_estado','Activo')->get();
        }
        
        
        foreach($empleados as $empleado){
            $registros_inout = v_inout($fechainicio,$fechafin,$empleado->empleado_cedula);
            $registros_sql = collect($registros_inout);
            
            $horas_debe_trabajar_sum = new SumaTiempos();
            $horas_trabajadas = new SumaTiempos();
            $horas_dia = new SumaTiempos();
            $extras_sinDesc = new SumaTiempos();
            $horas_libre_feriado = new SumaTiempos();
          
            //Log::info('+empleado: '. $empleado->empleado_cedula);
          
            foreach($registros_sql as $registro){

               // Log::info('+registro: '. $registro->r_fecha);      
              
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
                    if(count($registros_sql) == 1){
                        $horas_extras = "00:00:00";

                        $horasXdia = horarioAfecha($empleado->id, $fecha);
                        $horas = totalHorasAfecha($horasXdia);
                        //Log::info('horasXdia: '. implode(" ",$horasXdia));  
                        //Log::info('horas: '. $horas ); 
                      
                        /*$ResultadoHoras = new SumaTiempos();
                        $ResultadoHoras->sumaTiempo(new SumaTiempos($horas));
                        $ResultadoHoras->restaTiempo(new SumaTiempos($horas_dia->verTiempoFinal()));*/
                      
                        //Log::info('horas_dia: '. $horas_dia->verTiempoFinal()); 
                      
                        $fechaA = "1970-01-01 " . $horas_dia->verTiempoFinal();  //horas que trabajo en el dia
                        $fechaB = "1970-01-01 " . $horas;                        //horas que debe trabajar 
                        
                        if($fechaA <= $fechaB ){
                            $totalextras = '00:00:00';
                        }else{
                            $totalextras = date("H:i:s", strtotime($fechaA)-strtotime($fechaB));
                        }
                        
                      
                        //Log::info('totalextras: '. $totalextras); 
                        //$totalextras = $ResultadoHoras->verTiempoFinal();
                        
                        if($totalextras > $minimo_extras){
                            $extras_sinDesc->sumaTiempo(new SumaTiempos($totalextras));
                            //Log::info('extras_sinDesc: '. $extras_sinDesc->verTiempoFinal()); 
                        }
                      
                        
                      
                        $horas_trabajadas->sumaTiempo(new SumaTiempos($horas_dia->verTiempoFinal()));
                      
                        //Log::info('horas_trabajadas: '. $horas_trabajadas->verTiempoFinal()); 
                      
                        $horasAux = new SumaTiempos();
                        $horasAux->sumaTiempo(new SumaTiempos($horas_trabajadas->verTiempoFinal()));
                        
                        //Log::info('horasAux: '. $horasAux->verTiempoFinal()); 
                        
                        //Log::info('horas: '. $horas); 
                      
                        $totalextras = $horasAux->restaTiempo(new SumaTiempos($horas));
                      
                        //Log::info('totalextras: '. $totalextras); 
                      
                        if($totalextras > $minimo_extras){
                            $horas_extras->sumaTiempo(new SumaTiempos($totalextras->verTiempoFinal()));
                            //Log::info('horas_extras: '. $horas_extras->verTiempoFinal()); 
                        }

                        $inicio = strtotime($fechainicio);
                        $fin = strtotime($fechafin);

                        for($z=$inicio; $z<=$fin; $z+=86400){
                            $fecha = date("Y-m-d", $z);
                            $horario_Fecha = horarioAfecha($empleado->id, $fecha);
                            $horas = totalHorasAfecha($horario_Fecha);
                            //Log::info('sum1: '. $fecha. ' ; ' .$horas); 
                            $horas_debe_trabajar_sum->sumaTiempo(new SumaTiempos($horas));
                        }
                        
                        //Log::info('horas_debe_trabajar_sum: '. $horas_debe_trabajar_sum->verTiempoFinal()); 
                        //Log::info('horas_trabajadas: '. $horas_trabajadas->verTiempoFinal()); 
                      
                        if($horas_trabajadas->verTiempoFinal() == '00:00:00'){
                          $horas_diff =	$horas_debe_trabajar_sum->verTiempoFinal();
                          //Log::info('horas_diff 1: '. $horas_diff); 
                        }else{													
                          $horas_diff = date('H:i:s', strtotime($horas_debe_trabajar_sum->verTiempoFinal()) - strtotime($horas_trabajadas->verTiempoFinal()));
                          //Log::info('horas_diff 2: '. $horas_diff); 
                        }
                        if($horas_diff>='12:00:00'){
                          $horas_diff = '00:00:00';
                        }
                        //Log::info('horas_diff fin: '. $horas_diff); 

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
                    } // FIN ULTIMO REGISTRO DEL ARRAY
                  
                }else{ /// $fecha == $registro->r_fecha
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
                    }// fin  ULTIMO REGISTRO DEL ARRAY
                } // fin ($fecha == $registro->r_fecha)
            } // foreach($registros_sql as $registro)
              
            if ($registros_sql->count() == 0){
                $ayer = $fechainicio;
                $horario_Fecha = horarioAfecha($empleado->id, $ayer);
                $horas = totalHorasAfecha($horario_Fecha);
                $horas_debe_trabajar_sum->sumaTiempo(new SumaTiempos($horas));
                if ($horario_Fecha != '00:00:00'){ 
                    if($horas_trabajadas->verTiempoFinal() == '00:00:00'){
                            $horas_diff =	$horas_debe_trabajar_sum->verTiempoFinal();
                    }else{													
                            $horas_diff = date('H:i:s', strtotime($horas_debe_trabajar_sum->verTiempoFinal()) - strtotime($horas_trabajadas->verTiempoFinal()));
                    }
                    if($horas_diff>='12:00:00'){
                            $horas_diff = '00:00:00';
                    }
              }else{
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
            } // fin  ($registros_sql->count() == 0){
          
          
        } // foreach($empleados as $empleado)
        
        $registros_ok = collect($registros);
        return $registros_ok;
        
    } //Fin horasExtrasResumidas

    
} //Fin clase