<?php

namespace App\Traits;
use App\Models\Tablon;
use App\Models\Empleado;
use App\Traits\RepHorasExtrasResumidasTrait;
use App\Traits\RepLlegadasTardesTrait;
trait TablonTrait
{
    use RepHorasExtrasResumidasTrait, RepLlegadasTardesTrait;
  
    public function Tablon()
    {
       
      $fechainicio = '2019-11-23';
      $fechafin = '2019-11-23';
      
      $empleados = Empleado::all();
      $fecha = $fechainicio;
      while (strtotime($fecha) <= strtotime($fechafin)) {         
   
        
          foreach($empleados as $empleado){
            $cedula = $empleado->empleado_cedula;           
        
            
            $horario_Fecha = horarioAfecha($empleado->id, $fecha);    
            
            $h_debe_trabajar = '00:00:00';
            $h_trabajadas = '00:00:00';
            $h_extras = '00:00:00' ;            
            $h_llegadas_tardes = '00:00:00';
            
            /// OBTENGO HORAS QUE DEBE TRABAJAR, HORAS TRABAJADAS, HORAS_EXTRAS
            $rHER = $this->repHorasExtrasResumidas($fecha,$fecha, $cedula);
            if (count($rHER)>0){                           
              if ($rHER[0]['horas_debe_trabajar'] == 'No tiene horario asignado'){
                $h_debe_trabajar = '00:00:00';   
              }else{
                $h_debe_trabajar = $rHER[0]['horas_debe_trabajar'];
              }
              $h_trabajadas = $rHER[0]['horas_trabajadas'];
              $h_extras = $rHER[0]['horas_extras'] ;
              
            }
            
            //OBTENGO LLEGADAS TARDES
            $rHLT = $this->repLlegadasTardes($fecha,$fecha, $cedula);            
            if (count($rHLT)>0){              
              $h_llegadas_tardes = $rHLT[0]['diferencia'];
            }
            
           
            
            $debe_trabajar = 'S';
            if ($h_debe_trabajar == '00:00:00'){
              $debe_trabajar = 'N';
            }
            
            
            $es_dia_licencia = 'N';
            $es_dia_libre = 'N';
            $es_dia_feriado = 'N';
            $es_dia_facturable = 'N';
            $es_medio_horario = 'N';
            $es_nocturno_horario = 'N';
            $h_extras_auth = 'N';
            //CONTROLAR QUE NO EXISTE PARA FECHA CEDULA REGISTRO, SI EXISTE ACTUALIZAR DATOS.
            $tablon = Tablon::where('tablon_fk_empleado_cedula','=', $cedula)->where('tablon_fecha','=',$fecha)->first();
           
            $modo = 'INS';
            if($tablon){
              $modo = 'UPD';
            }else{
              $tablon = new Tablon();
            }
            
            $tablon->tablon_fk_empleado_cedula = $cedula;
            $tablon->tablon_fecha = $fecha;
            $tablon->tablon_h_entrada = $horario_Fecha[0];
            $tablon->tablon_h_ini_brake = $horario_Fecha[1];
            $tablon->tablon_h_fin_brake = $horario_Fecha[2];
            $tablon->tablon_h_salida = $horario_Fecha[3];            
            $tablon->tablon_h_debe_trabajar = $h_debe_trabajar;    
            $tablon->tablon_h_trabajadas = $h_trabajadas;
            $tablon->tablon_h_extras = $h_extras;            
            $tablon->tablon_h_llegadas_tardes = $h_llegadas_tardes;            
            $tablon->tablon_es_dia_licencia = $es_dia_licencia;
            $tablon->tablon_es_dia_libre = $es_dia_libre;
            $tablon->tablon_es_dia_feriado = $es_dia_feriado;
            $tablon->tablon_es_dia_facturable = $es_dia_facturable;
            $tablon->tablon_es_medio_horario = $es_medio_horario;
            $tablon->tablon_es_nocturno_horario = $es_nocturno_horario;
            $tablon->tablon_h_extras_auth = $h_extras_auth;
            $tablon->tablon_debe_trabajar = $debe_trabajar;       
            
            if($modo == 'INS'){
              $tablon->save();  
            }else{
              $tablon->update();  
            }
             
            

          }//Fin Empleados
          $fecha = date("Y-m-d", strtotime("+1 day", strtotime($fecha)));
        
        
      } //Fin fechas
      
    }// fin Tablon

}//fin class