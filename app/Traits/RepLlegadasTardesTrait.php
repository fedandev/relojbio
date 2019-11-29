<?php

namespace App\Traits;
use Illuminate\Support\Facades\DB;
use DateTime;
use App\Models\Registro;


trait RepLlegadasTardesTrait
{
    
    public function repLlegadasTardes($fechainicio,$fechafin, $cedula,$oficina_id = 0)
    {
        
        $sql= "SELECT * FROM registros WHERE registro_fecha between '".$fechainicio."' and  '".$fechafin."'  AND registro_tipo='I' " ;

        if($cedula !='' && $cedula != 'ALL'){
            $sql = $sql. " AND fk_empleado_cedula = '".$cedula."'";            
        }elseif($oficina_id > 0 && $cedula == 'ALL' ){
            $sql = $sql. " AND fk_empleado_cedula IN (SELECT empleado_cedula FROM empleados WHERE fk_oficina_id = ".$oficina_id.")";            
        }elseif($oficina_id == 'ALL' && $cedula == 'ALL'){
            $sql = $sql. " AND fk_empleado_cedula IN (SELECT empleado_cedula FROM empleados)";     
        }
        
        $sql = $sql." order by fk_empleado_cedula, registro_hora asc , registro_tipo ";
        
        $registros_sql = DB::select($sql);        
        $registros = Registro::hydrate($registros_sql); // paso a collection de registros       
 
        $iRegistros = 0;
        $registros_ok = [];
       
        
        //busco el horario a la fecha porque en un periodo de fechas pueden existir horarios distintos
        foreach($registros as $registro){
            $registro_fecha = $registro->registro_fecha;
            $registro_hora_d = new DateTime($registro->registro_hora);
            $registro_hora = $registro_hora_d->format('H:i:s');
            
            $empleado = $registro->Empleado;
            $horario = horarioAfecha($empleado->id,$registro_fecha);
           
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
                    $reg_sql =  DB::select($sql);
                    
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
                            $reg_sql =  DB::select($sql);
                            
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
      
        return  $registros_ok;
      
    } // fin repLlegadasTardes

    
}