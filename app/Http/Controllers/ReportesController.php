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
use DateTime;
use Barryvdh\DomPDF\Facade as PDF;
use Dompdf\Options;
use Dompdf\Dompdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use App\SumaTiempos;

class ReportesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(){
	    $controller = 'reportes';
		if (Gate::allows('view-report', $controller)) {
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
            $registros = DB::table('v_inout')->whereBetween('registro_fecha', array($fechainicio,$fechafin))->where('fk_empleado_cedula',$cedula)->get();
        }elseif($for == 'S'){
            $registros = DB::table('v_inout')->whereBetween('registro_fecha', array($fechainicio,$fechafin))->get();
        }
        
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
        
        $sql= "SELECT * FROM registros WHERE registro_fecha between '".$fechainicio."' and  '".$fechafin."'  AND registro_tipo='I' " ;

        if($cedula !='' && $cedula != 'ALL'){
            $sql = $sql. " AND fk_empleado_cedula = '".$cedula."'";
            $oficina = Oficina::find($fk_oficina_id);
        }elseif($fk_oficina_id > 0 && $cedula == 'ALL' ){
            $sql = $sql. " AND fk_empleado_cedula IN (SELECT empleado_cedula FROM empleados WHERE fk_oficina_id = ".$fk_oficina_id.")";
            $oficina = Oficina::find($fk_oficina_id);
        }elseif($fk_oficina_id == 'ALL' && $cedula == 'ALL'){
            $sql = $sql. " AND fk_empleado_cedula IN (SELECT empleado_cedula FROM empleados)";     
        }
        
        $sql = $sql." order by fk_empleado_cedula, registro_hora asc , registro_tipo ";
        
        $registros_sql =  DB::select($sql);
        
        $registros = Registro::hydrate($registros_sql); // paso a collection de registros
 
        $tiempo = Ajuste::where('ajuste_nombre','leave_earn' )->first();

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
        $fechainicio = $request->input('fechainicio');
        $fechafin = $request->input('fechafin');
        $cedula = $request->input('fk_empleado_cedula');
        $empleado = Empleado::where('empleado_cedula',$cedula)->first();
        $inicioNoche = ajuste('nocturnal_start');
        $finNoche = ajuste('nocturnal_end');
        
        $fk_oficina_id = $request->input('fk_oficina_id');
        
        $sql= "SELECT * FROM v_inout WHERE registro_fecha between '".$fechainicio."' and  '".$fechafin."' " ;
        $sql= $sql. "AND ((TIME( registro_entrada ) >= '".$inicioNoche."' AND TIME( registro_entrada ) <=  '23:59:59') OR  (TIME( registro_salida ) >=  '00:00:00' AND TIME( registro_salida ) <=  '".$finNoche."'))";
        
        if($cedula !='' && $cedula != 'ALL'){
            $sql = $sql. " AND fk_empleado_cedula = '".$cedula."'";
            $fk_oficina_id = $empleado->fk_oficina_id;
            $oficina = Oficina::find($fk_oficina_id);
            $empleados = 0;
        }elseif($fk_oficina_id > 0 && $cedula == 'ALL' ){
            $sql = $sql. " AND fk_empleado_cedula IN (SELECT empleado_cedula FROM empleados WHERE fk_oficina_id = ".$fk_oficina_id.")";
            $oficina = Oficina::find($fk_oficina_id);
            $empleados = 0;
        }elseif($fk_oficina_id == 'ALL' && $cedula == 'ALL'){
            $empleados = 2;
            $sql = $sql. " AND fk_empleado_cedula IN (SELECT empleado_cedula FROM empleados)";
        }
        
        $sql = $sql." order by registro_fecha asc ";
        
        $registros = DB::select($sql);

        $registros = collect( $registros);
     
        foreach($registros as $registro){
            $entrada = new DateTime($registro->registro_entrada);
            $entrada = $entrada->format('H:i:s');
            $salida = new DateTime($registro->registro_salida);
            $salida = $salida->format('H:i:s');

            if($entrada < $inicioNoche && $entrada > $salida && $salida <= $finNoche){
                $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($salida) - strtotime($inicioNoche));
                $registro->registro_totalHoras = $nocturnidad;
            }elseif($entrada >= $inicioNoche && $entrada > $salida && $salida > $finNoche){
                $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($finNoche) - strtotime($entrada));
                $registro->registro_totalHoras = $nocturnidad;
            }elseif($entrada >= $inicioNoche && $entrada < $salida && $salida <= $finNoche){
                $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($salida) - strtotime($entrada));
                $registro->registro_totalHoras = $nocturnidad;
            }
        }
        
        $pdf = PDF::loadView('pdf.horasNocturnas', compact('registros','fechainicio','fechafin','oficina','empleado','empleados'));
    	
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
   
                
        // $registros = DB::table('v_inout')->whereBetween('registro_fecha', array($fechainicio,$fechafin))->where('fk_empleado_cedula',$cedula)->orderBy('registro_entrada', 'asc')->get();
        // $registros = "SELECT fk_empleado_cedula, registro_fecha, SUM(registro_totalHoras) FROM v_inout WHERE registro_fecha between '".$fechainicio."' and  '".$fechafin."'";
        
          
        $fechainicio = $request->input('fechainicio');
        $fechafin = $request->input('fechafin');
        $cedula = $request->input('fk_empleado_cedula');
        
        $fk_oficina_id = $request->input('fk_oficina_id');
        
        $sql= "SELECT fk_empleado_cedula, registro_fecha, SEC_TO_TIME( SUM( TIME_TO_SEC( registro_totalHoras ) ) ) as sum_horas FROM v_inout WHERE registro_fecha between '".$fechainicio."' and  '".$fechafin."' " ;
        
        if($cedula !='' && $cedula != 'ALL'){
            $sql = $sql. " AND fk_empleado_cedula = '".$cedula."'";
            $oficina = Oficina::find($fk_oficina_id);
        
        }
        
        if($fk_oficina_id > 0 && $cedula == 'ALL' ){
            $sql = $sql. " AND fk_empleado_cedula IN (SELECT empleado_cedula FROM empleados WHERE fk_oficina_id = ".$fk_oficina_id.")";
            $oficina = Oficina::find($fk_oficina_id);
           
        }
        
        $sql = $sql." group by fk_empleado_cedula, registro_fecha ";
        
        $registros_sql =  DB::select($sql);
        
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
        
            $Empleado = Empleado::where('empleado_cedula', '=',$registro->fk_empleado_cedula)->first();
            
            if($Empleado == null){
                continue;
            }
    		$horario = horarioAfecha( $Empleado->id, $registro->registro_fecha);
    
    		$horas_debe_trabajar = totalHorasAfecha($horario);
    		$horas_trabajadas =  $registro->sum_horas;
    		$horas_extras = date('H:i:s', strtotime($horas_trabajadas) - strtotime($horas_debe_trabajar));
    	    
    	
            if($horas_extras >= $minimo_extras && $horas_debe_trabajar<> '00:00:00' && $horas_extras <='12:59:59' ){
                $r = [];
                
                $r['fk_empleado_cedula']=$registro->fk_empleado_cedula;
                $r['registro_fecha']=$registro->registro_fecha;
                $r['horas_debe_trabajar']=$horas_debe_trabajar;
                $r['horas_trabajadas']=$horas_trabajadas;
                $r['horas_extras']=$horas_extras;
                $r['empleado']=$Empleado->empleado_nombre.' '.$Empleado->empleado_apellido;
                
                $registros[$i] = $r;
                $i++;
            }
    		
        }
        
        $registros_ok = collect($registros);
        
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
}