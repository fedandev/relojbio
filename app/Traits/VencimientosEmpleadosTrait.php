<?php

namespace App\Traits;

use App\Models\Empleado;
use App\Models\Empresa;
use Log;
use Barryvdh\DomPDF\Facade as PDF;
use Mail;
trait VencimientosEmpleadosTrait
{
      
    public function VencimientosEmpleados()
    {      
      
      $hoy = date('Y-m-d', strtotime('now'));      
      $dias = (int) ajuste('dias_avisa_venc_docs');    
      if($dias==0){
        $dias = 7;
      }

      $fecha_tope = date( "Y-m-d", strtotime( "+".$dias." day", strtotime( $hoy ) ) );
      
      Log::info("   VencimientosEmpleados: hoy: ". $hoy);
      Log::info("   VencimientosEmpleados: fecha_tope: ". $fecha_tope);
      
      $empleados = Empleado::where('empleado_estado','Activo')->get();
      
      $i  = 0;
      $arrayEmpleados = [];
      foreach($empleados as $empleado){
          $informarCed = 'N';
          $informarLic = 'N';
          $informarSal = 'N';
          if($empleado->empleado_fec_venc_cedula){
            if($empleado->empleado_fec_venc_cedula <= $fecha_tope ){
              $informarCed = 'S';
            }
          }
          if($empleado->empleado_fec_venc_lic_cond){
            if($empleado->empleado_fec_venc_lic_cond <= $fecha_tope ){
              $informarLic = 'S';
            }
          }  
          
          if($empleado->empleado_fec_venc_salud){
            if($empleado->empleado_fec_venc_salud <= $fecha_tope ){
              $informarSal = 'S';
            }
          } 
        
          
          if($informarLic=='S' Or $informarCed == 'S'){
             $e = [];
             $e['cedula'] = $empleado->empleado_cedula;
             $e['nombre'] = $empleado->empleado_nombre.' '.$empleado->empleado_apellido;
             $e['fec_venc_ced'] = $empleado->empleado_fec_venc_cedula; 
             $e['fec_venc_lic'] = $empleado->empleado_fec_venc_lic_cond; 
             $e['fec_venc_sal'] = $empleado->empleado_fec_venc_salud;
             $e['venc_ced'] = $informarCed; 
             $e['venc_lic'] = $informarLic;
             $e['venc_sal'] = $informarSal;
            
             $arrayEmpleados[$i] = $e;
             $i++;
          }
        
      }
      $arrayEmpleados =  collect($arrayEmpleados);
      if($arrayEmpleados->count() > 0){
            Log::info("Hay registros en arrayEmpleados");
            $path = public_path().'/storage/empleadosVencimientosDocs_'.$hoy.'.pdf';

            $pdf = PDF::loadView('pdf.empleadosVencimientosDocs', compact('arrayEmpleados','hoy'))->save($path);

            $data = array();

            $empresa = Empresa::where('empresa_estado','1')->first();
            Mail::send('common.mail_docs_vencidos', $data, function($message) use ($empresa,$path){
                if($empresa->empresa_email2 == null){
                    if($empresa->empresa_email != null){
                        $message->to($empresa->empresa_email)->bcc('info@sysclock.com')->subject('Documentos por vencer - Empleados')->attach($path);                      
                    }
                }else{
                    $message->to($empresa->empresa_email)->cc($empresa->empresa_email2)->cc('sergiodanielarmandugon@hotmail.com')->bcc('info@sysclock.com')->subject('Documentos por vencer - Empleados')->attach($path);
                }
            });
            return response()->json("{'ok': 'reporte ejecutado con exito'}",200);
        }else{
          Log::info("NO Hay registros en arrayEmpleados");
        }
      
      
      
    }// fin VencimientosEmpleados

}//fin class