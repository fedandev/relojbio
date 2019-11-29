<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Traits\RepHorasExtrasResumidasTrait;
use App\Models\Empresa;
use Barryvdh\DomPDF\Facade as PDF;
use Mail;
use Log;
class ReportesRESTController extends Controller
{
    use RepHorasExtrasResumidasTrait;

    public function empleadosMarcasAyer(){
				Log::info("Se ejecuto empleadosMarcasAyer");
// 				$key_app = 'eQXSUoh4RkX5DvTktmlT7+SVueSChf5mrqlJscwK8KU=';
			
// 				if($key_app != $key){
// 					//return response()->json("{'error': 'no autorizado'}",401);
// 				}
			      
        $ayer = date('Y-m-d', strtotime('yesterday')); 
				
				$ayer = '2019-11-23';
				$fechainicio = $ayer;
        $fechafin = $ayer;
        $registros = [];
				$cedula = 'ALL';
				$fk_oficina_id = 'ALL';
        // $registros = [1][1]; Cedula
        // $registros = [1][2]; fecha
        // $registros = [1][3]; horas a trabajar
        // $registros = [1][4]; horas trabajadas
        // $registros = [1][5]; horas diff      
			
				$registros_ok = $this->repHorasExtrasResumidas($fechainicio,$fechafin, $cedula, $fk_oficina_id);
		  
				
        if($registros_ok->count() > 0){
						Log::info("Hay registros");
						$path = public_path().'/storage/empleadosMarcasAyer_'.$ayer.'.pdf';
					 
            $pdf = PDF::loadView('pdf.empleadosMarcasAyer', compact('registros_ok','fechainicio','fechafin','oficina'))->save($path);
					
           	$data = array(); 			
					
						$empresa = Empresa::where('empresa_estado','1')->first();
						Mail::send('common.mail_marcas_ayer', $data, function($message) use ($empresa,$path){
              if($empresa->empresa_email2 == null){
                  if($empresa->empresa_email != null){
											$message->to($empresa->empresa_email)->bcc('info@sysclock.com')->subject('Reporte de marcas en el dia de ayer')->attach($path);                      
                  }
              }else{
                  $message->to($empresa->empresa_email)->cc($empresa->empresa_email2)->cc('sergiodanielarmandugon@hotmail.com')->bcc('info@sysclock.com')->subject('Reporte de marcas en el dia de ayer')->attach($path);
              }
           });
					return response()->json("{'ok': 'reporte ejecutado con exito'}",200);
        }
			
	  }
}