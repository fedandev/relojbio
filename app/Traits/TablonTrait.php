<?php

namespace App\Traits;
use App\Models\Tablon;
use App\Models\Empleado;
use App\Models\Licencia;
use App\Models\Feriado;
use App\Models\Autorizacion;
use App\Traits\RepHorasExtrasResumidasTrait;
use App\Traits\RepLlegadasTardesTrait;
use Log;
trait TablonTrait
{
    use RepHorasExtrasResumidasTrait, RepLlegadasTardesTrait;
  
    public function Tablon()
    {      
      $hora_nocturna = ajuste('nocturnal_start'); 
      $hoy = date('Y-m-d', strtotime('now'));      
      $desde = ajuste('tablon_fecha_desde');
      $ayer = date( "Y-m-d", strtotime( "-1 day", strtotime( $hoy ) ) ); 
      if($desde != ''){
        $fechainicio = $desde;  
      }else{
        $fechainicio = $ayer;
      }
    
      $fechafin = $hoy;

      $empleados = Empleado::where('empleado_estado','Activo')->get();
      $fecha = $fechainicio;
      
      Log::info("   TABLON: fecha desde: ". $fechainicio);
      Log::info("   TABLON: fecha fin: ". $fechafin);
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
            if ($h_debe_trabajar == '00:00:00' or $horario_Fecha[0] == ''){
              $debe_trabajar = 'N';
            }
            
            
            $es_dia_licencia = 'N';
            $licencia = Licencia::where('fk_empleado_id', '=',$cedula)->with(['licencia_detalles' => function ($query) {
                $query->where('fecha_desde', '<=', $fecha)->where('fecha_hasta','>=', $fecha);
            }])->first();
            if($licencia != null){
              $es_dia_licencia ='S';
            }
            
            $es_dia_libre = 'N';
            if ($debe_trabajar == 'N'){
              $es_dia_libre = 'S';
            }            
            
            $es_dia_feriado = 'N';
            $feriado = Feriado::where('feriado_fecha', '=',$fecha)->where('feriado_laborable','=',0)->first();
            if($feriado !=null) {
              $es_dia_feriado = 'S';
            }
            
            $es_dia_facturable = 'S';
            $es_medio_horario = $horario_Fecha[7];
        
            $es_nocturno_horario = 'N';
            if($horario_Fecha[0] >=$hora_nocturna){
              $es_nocturno_horario = 'S';
            }
            
            $h_extras_auth = '';
            if ($h_extras !='' and $h_extras!= '00:00:00'){
              $autorizacion = Autorizacion::where('fk_empleado_id','=',$empleado->id)->where('autorizacion_fechadesde','<=',$fecha)->where('autorizacion_fechahasta','>=', $fecha)->first();  
              if($autorizacion != null){                
                $h_extras_auth = 'N';
                if($autorizacion->autorizacion_antesHorario==1 or $autorizacion->autorizacion_despuesHorario==1){
                  $h_extras_auth = 'S';
                }
              }
            }
                     
            
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
             
            

          } //Fin Empleados
          $fecha = date("Y-m-d", strtotime("+1 day", strtotime($fecha)));
        
        
      } //Fin fechas
      
      Log::info("   TABLON FIN: fecha: ". $fecha);
      
      
    }// fin Tablon

}//fin class