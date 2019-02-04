<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Oficina;
use App\Models\Ajuste;
use App\Models\Registro;
use App\Models\Empleado;
use App\Models\Trabaja;
use DateTime;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $registrosPieMesAnt = $this->LlegadasTardeMesAnterior();
        $registrosPieMesActual = $this->LlegadasTardeMesActual();
        $registrosHorasNoctAnterior = $this->horasNocturnasMesAnterior();
        $registrosHorasNoctActual = $this->horasNocturnasMesActual();
        $advertencias = $this->advertencias();
        return view('home', compact('registrosPieMesAnterior','registrosPieMesActual','registrosHorasNoctAnterior','registrosHorasNoctActual','advertencias'));
    }
    
    public function LlegadasTardeMesAnterior(){
        $fechaActual = new DateTime();
        $fechaActual->modify('first day of last month');
        $fechainicio = $fechaActual->format('Y/m/d');
        
        $fechaActual->modify('last day of this month');
        $fechafin = $fechaActual->format('Y/m/d');
        
        $sql= "SELECT a1.*, a2.id as IdOficina, a2.oficina_nombre FROM registros a1, oficinas a2, empleados a3 WHERE registro_fecha between '".$fechainicio."' and  '".$fechafin."'  AND registro_tipo='I' AND a1.fk_empleado_cedula = a3.empleado_cedula AND a3.fk_oficina_id = a2.id" ;
        $sql = $sql." order by registro_fecha asc, fk_empleado_cedula, registro_tipo";
        $registros_sql =  DB::select($sql);
        $registros = Registro::hydrate($registros_sql); // paso a collection de registros

        $tiempo = Ajuste::where('ajuste_nombre','leave_earn' )->first();

        $iRegistros = 0;
        $registros_ok = [];
        $i = 0;
        $z = 0;
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
                    $hay_brake = $horario_ax->horario_haybrake;
                    
                    $date = new DateTime($registro_fecha.' '.$horario_ax->horario_entrada); 
                    
                    $tolerencia_tarde = $horario_ax->horario_tiempotarde;
                    $date_tol = new DateTime($registro_fecha.' '.$tolerencia_tarde); 
                    
                    $minutes_tarde = $date_tol->format('i');
                    $date= $date->modify('+'.$minutes_tarde.' minutes');
                    $hora = $date->format('H:i:s');
                    $horaTope = $horario_ax->horario_comienzobrake;
                    
                    if($registro_hora > $hora && $registro_hora  < $horaTope ){
                        if($z == 0){
                            $registros_ok[$iRegistros][0] = $registro->oficina_nombre;
                            $registros_ok[$iRegistros][1] = 0;
                            $iRegistros = $iRegistros + 1;
                            $z=1;
                        }else{
                            $entre = "no";
                            $idRegistro = 0;
                            for($y=0;$y<=count($registros_ok)-1;$y++){
                                if($registros_ok[$y][0] == $registro->oficina_nombre){
                                    $entre = "si";
                                    $idRegistro = $y;
                                }
                            }
                            if($entre == "no"){
                                $registros_ok[$iRegistros][0] = $registro->oficina_nombre;
                                $registros_ok[$iRegistros][1] = 1;
                                $iRegistros = $iRegistros + 1;
                            }else{
                                $registros_ok[$idRegistro][1] = ($registros_ok[$idRegistro][1])+1;
                            }
                        }
                    }
                }
            }
        }
        
        $registros_ok = collect($registros_ok);

        if($registros_ok->count() > 0){
            //Devuelvos los datos para cargarlos en la grafica
            return $registros_ok;
        }else{
            return back()->with('warning', 'No se encontraron datos para la grafica "Llegadas Tarde por oficina (Mes Anterior)".')->withInput();
        }
    }
    
    public function LlegadasTardeMesActual(){
        $fechaActual = new DateTime();
        $fechaActual->modify('first day of this month');
        $fechainicio = $fechaActual->format('Y/m/d');
        
        $fechaActual->modify('last day of this month');
        $fechafin = $fechaActual->format('Y/m/d');
        
        $sql= "SELECT a1.*, a2.id as IdOficina, a2.oficina_nombre FROM registros a1, oficinas a2, empleados a3 WHERE registro_fecha between '".$fechainicio."' and  '".$fechafin."'  AND registro_tipo='I' AND a1.fk_empleado_cedula = a3.empleado_cedula AND a3.fk_oficina_id = a2.id" ;
        $sql = $sql." order by registro_fecha asc, fk_empleado_cedula, registro_tipo";
        $registros_sql =  DB::select($sql);
        $registros = Registro::hydrate($registros_sql); // paso a collection de registros

        $tiempo = Ajuste::where('ajuste_nombre','leave_earn' )->first();

        $iRegistros = 0;
        $registros_ok = [];
        $i = 0;
        $z = 0;
        
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
                    $hay_brake = $horario_ax->horario_haybrake;
                    
                    $date = new DateTime($registro_fecha.' '.$horario_ax->horario_entrada); 
                    
                    $tolerencia_tarde = $horario_ax->horario_tiempotarde;
                    $date_tol = new DateTime($registro_fecha.' '.$tolerencia_tarde); 
                    
                    $minutes_tarde = $date_tol->format('i');
                    $date= $date->modify('+'.$minutes_tarde.' minutes');
                    $hora = $date->format('H:i:s');
                    $horaTope = $horario_ax->horario_comienzobrake;
                    
                    if($registro_hora > $hora && $registro_hora  < $horaTope ){
                        
                        if($z == 0){
                            $registros_ok[$iRegistros][0] = $registro->oficina_nombre;
                            $registros_ok[$iRegistros][1] = 0;
                            $iRegistros = $iRegistros + 1;
                            $z=1;
                        }else{
                            $entre = "no";
                            $idRegistro = 0;
                            for($y=0;$y<=count($registros_ok)-1;$y++){
                                if($registros_ok[$y][0] == $registro->oficina_nombre){
                                    $entre = "si";
                                    $i = $y;
                                }
                            }
                            if($entre == "no"){
                                $registros_ok[$iRegistros][0] = $registro->oficina_nombre;
                                $registros_ok[$iRegistros][1] = 1;
                                $iRegistros = $iRegistros + 1;
                            }else{
                                $registros_ok[$i][1] = $registros_ok[$i][1]+1;
                            }
                        }
                    }
                }    
            }
        }
        
        $registros_ok = collect($registros_ok);
        
        if($registros_ok->count() > 0){
            //Devuelvos los datos para cargarlos en la grafica
            return $registros_ok;
        }
    }
    
    public function horasNocturnasMesAnterior(){
        $fechaActual = new DateTime();
        $fechaActual->modify('first day of last month');
        $fechainicio = $fechaActual->format('Y/m/d');
        
        $fechaActual->modify('last day of this month');
        $fechafin = $fechaActual->format('Y/m/d');
        
        $inicioNoche = ajuste('nocturnal_start');
        $finNoche = ajuste('nocturnal_end');
        
        $sql= "SELECT a1.*, a3.id as IdOficina, a3.oficina_nombre FROM v_inout a1, empleados a2, oficinas a3 WHERE registro_fecha between '".$fechainicio."' and  '".$fechafin."' " ;
        $sql= $sql. "AND ((TIME( registro_entrada ) >= '".$inicioNoche."' AND TIME( registro_entrada ) <=  '23:59:59') OR  (TIME( registro_salida ) >=  '00:00:00' AND TIME( registro_salida ) <=  '".$finNoche."')) ";
        $sql = $sql. " AND a1.fk_empleado_cedula = a2.empleado_cedula AND a2.fk_oficina_id = a3.id";
        $sql = $sql." order by registro_fecha asc ";

        $registros = DB::select($sql);
        $registros = collect($registros);
        
        $registros_ok = [];
        $iRegistros = 0;
        $i = 0;
        $z = 0;
     
        foreach($registros as $registro){
            $entrada = new DateTime($registro->registro_entrada);
            $entrada = $entrada->format('H:i:s');
            $salida = new DateTime($registro->registro_salida);
            $salida = $salida->format('H:i:s');
            
            if($z == 0){
                if($entrada < $inicioNoche && $entrada > $salida && $salida <= $finNoche){
                    $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($salida) - strtotime($inicioNoche));
                    $registros_ok[$iRegistros][0] = $registro->oficina_nombre;
                    $registros_ok[$iRegistros][1] = $nocturnidad;
                    $iRegistros = $iRegistros + 1;
                    $z=1;
                }elseif($entrada >= $inicioNoche && $entrada > $salida && $salida > $finNoche){
                    $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($finNoche) - strtotime($entrada));
                    $registros_ok[$iRegistros][0] = $registro->oficina_nombre;
                    $registros_ok[$iRegistros][1] = $nocturnidad;
                    $iRegistros = $iRegistros + 1;
                    $z=1;
                }elseif($entrada >= $inicioNoche && $entrada < $salida && $salida <= $finNoche){
                    $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($salida) - strtotime($entrada));
                    $registros_ok[$iRegistros][0] = $registro->oficina_nombre;
                    $registros_ok[$iRegistros][1] = $nocturnidad;
                    $iRegistros = $iRegistros + 1;
                    $z=1;
                }elseif($entrada < $inicioNoche && $entrada < $salida && $salida <= $finNoche){
                    $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($salida) - strtotime($inicioNoche));
                    $registros_ok[$iRegistros][0] = $registro->oficina_nombre;
                    $registros_ok[$iRegistros][1] = $nocturnidad;
                    $iRegistros = $iRegistros + 1;
                    $z=1;
                }
            }else{
                $entre = "no";
                $idRegistro = 0;
                for($y=0;$y<=count($registros_ok)-1;$y++){
                    if($registros_ok[$y][0] == $registro->oficina_nombre){
                        $entre = "si";
                        $idRegistro = $y;
                    }
                }
                if($entre == "no"){
                    if($entrada < $inicioNoche && $entrada > $salida && $salida <= $finNoche){
                        $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($salida) - strtotime($inicioNoche));
                        $registros_ok[$iRegistros][0] = $registro->oficina_nombre;
                        $registros_ok[$iRegistros][1] = $nocturnidad;
                        $iRegistros = $iRegistros + 1;
                        $z=1;
                    }elseif($entrada >= $inicioNoche && $entrada > $salida && $salida > $finNoche){
                        $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($finNoche) - strtotime($entrada));
                        $registros_ok[$iRegistros][0] = $registro->oficina_nombre;
                        $registros_ok[$iRegistros][1] = $nocturnidad;
                        $iRegistros = $iRegistros + 1;
                        $z=1;
                    }elseif($entrada >= $inicioNoche && $entrada < $salida && $salida <= $finNoche){
                        $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($salida) - strtotime($entrada));
                        $registros_ok[$iRegistros][0] = $registro->oficina_nombre;
                        $registros_ok[$iRegistros][1] = $nocturnidad;
                        $iRegistros = $iRegistros + 1;
                        $z=1;
                    }elseif($entrada < $inicioNoche && $entrada < $salida && $salida <= $finNoche){
                        $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($salida) - strtotime($inicioNoche));
                        $registros_ok[$iRegistros][0] = $registro->oficina_nombre;
                        $registros_ok[$iRegistros][1] = $nocturnidad;
                        $iRegistros = $iRegistros + 1;
                        $z=1;
                    }
                }else{
                    if($entrada < $inicioNoche && $entrada > $salida && $salida <= $finNoche){
                        $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($salida) - strtotime($inicioNoche));
                        $registros_ok[$i][1] = date('H:i:s', strtotime($registros_ok[$i][1]) + strtotime($nocturnidad));
                        
                        $iRegistros = $iRegistros + 1;
                        $z=1;
                    }elseif($entrada >= $inicioNoche && $entrada > $salida && $salida > $finNoche){
                        $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($finNoche) - strtotime($entrada));
                        $registros_ok[$i][1] = date('H:i:s', strtotime($registros_ok[$i][1]) + strtotime($nocturnidad));
                        
                        $iRegistros = $iRegistros + 1;
                        $z=1;
                    }elseif($entrada >= $inicioNoche && $entrada < $salida && $salida <= $finNoche){
                        $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($salida) - strtotime($entrada));
                        $registros_ok[$i][1] = date('H:i:s', strtotime($registros_ok[$i][1]) + strtotime($nocturnidad));
                        
                        $iRegistros = $iRegistros + 1;
                        $z=1;
                    }elseif($entrada < $inicioNoche && $entrada < $salida && $salida <= $finNoche){
                        $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($salida) - strtotime($inicioNoche));
                        $registros_ok[$i][1] = date('H:i:s', strtotime($registros_ok[$i][1]) + strtotime($nocturnidad));
                        
                        $iRegistros = $iRegistros + 1;
                        $z=1;
                    }
                }
            }
        }
        
        $registros_dev = [];
        $y = 0;
        
        foreach($registros_ok as $registro_ok){
            $registros_dev[$y][0] = $registro_ok[0];
            $horas_cortadas = explode(":", $registro_ok[1]);
            $registros_dev[$y][1] = $horas_cortadas[0] + $horas_cortadas[1] / 100;
            $y++;
        }
        
        $registros_dev = collect($registros_dev);

        return $registros_dev;
    }

    public function horasNocturnasMesActual(){
        $fechaActual = new DateTime();
        $fechaActual->modify('first day of this month');
        $fechainicio = $fechaActual->format('Y/m/d');
        
        $fechaActual->modify('last day of this month');
        $fechafin = $fechaActual->format('Y/m/d');
        
        $inicioNoche = ajuste('nocturnal_start');
        $finNoche = ajuste('nocturnal_end');
        
        $sql= "SELECT a1.*, a3.id as IdOficina, a3.oficina_nombre FROM v_inout a1, empleados a2, oficinas a3 WHERE registro_fecha between '".$fechainicio."' and  '".$fechafin."' " ;
        $sql= $sql. "AND ((TIME( registro_entrada ) >= '".$inicioNoche."' AND TIME( registro_entrada ) <=  '23:59:59') OR  (TIME( registro_salida ) >=  '00:00:00' AND TIME( registro_salida ) <=  '".$finNoche."')) ";
        $sql = $sql. " AND a1.fk_empleado_cedula = a2.empleado_cedula AND a2.fk_oficina_id = a3.id";
        $sql = $sql." order by registro_fecha asc ";

        $registros = DB::select($sql);
        $registros = collect($registros);
        
        $registros_ok = [];
        $iRegistros = 0;
        $i = 0;
        $z = 0;
     
        foreach($registros as $registro){
            $entrada = new DateTime($registro->registro_entrada);
            $entrada = $entrada->format('H:i:s');
            $salida = new DateTime($registro->registro_salida);
            $salida = $salida->format('H:i:s');
            
            if($z == 0){
                if($entrada < $inicioNoche && $entrada > $salida && $salida <= $finNoche){
                    $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($salida) - strtotime($inicioNoche));
                    $registros_ok[$iRegistros][0] = $registro->oficina_nombre;
                    $registros_ok[$iRegistros][1] = $nocturnidad;
                    $iRegistros = $iRegistros + 1;
                    $z=1;
                }elseif($entrada >= $inicioNoche && $entrada > $salida && $salida > $finNoche){
                    $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($finNoche) - strtotime($entrada));
                    $registros_ok[$iRegistros][0] = $registro->oficina_nombre;
                    $registros_ok[$iRegistros][1] = $nocturnidad;
                    $iRegistros = $iRegistros + 1;
                    $z=1;
                }elseif($entrada >= $inicioNoche && $entrada < $salida && $salida <= $finNoche){
                    $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($salida) - strtotime($entrada));
                    $registros_ok[$iRegistros][0] = $registro->oficina_nombre;
                    $registros_ok[$iRegistros][1] = $nocturnidad;
                    $iRegistros = $iRegistros + 1;
                    $z=1;
                }elseif($entrada < $inicioNoche && $entrada < $salida && $salida <= $finNoche){
                    $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($salida) - strtotime($inicioNoche));
                    $registros_ok[$iRegistros][0] = $registro->oficina_nombre;
                    $registros_ok[$iRegistros][1] = $nocturnidad;
                    $iRegistros = $iRegistros + 1;
                    $z=1;
                }
            }else{
                $entre = "no";
                $idRegistro = 0;
                for($y=0;$y<=count($registros_ok)-1;$y++){
                    if($registros_ok[$y][0] == $registro->oficina_nombre){
                        $entre = "si";
                        $idRegistro = $y;
                    }
                }
                if($entre == "no"){
                    if($entrada < $inicioNoche && $entrada > $salida && $salida <= $finNoche){
                        $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($salida) - strtotime($inicioNoche));
                        $registros_ok[$iRegistros][0] = $registro->oficina_nombre;
                        $registros_ok[$iRegistros][1] = $nocturnidad;
                        $iRegistros = $iRegistros + 1;
                        $z=1;
                    }elseif($entrada >= $inicioNoche && $entrada > $salida && $salida > $finNoche){
                        $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($finNoche) - strtotime($entrada));
                        $registros_ok[$iRegistros][0] = $registro->oficina_nombre;
                        $registros_ok[$iRegistros][1] = $nocturnidad;
                        $iRegistros = $iRegistros + 1;
                        $z=1;
                    }elseif($entrada >= $inicioNoche && $entrada < $salida && $salida <= $finNoche){
                        $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($salida) - strtotime($entrada));
                        $registros_ok[$iRegistros][0] = $registro->oficina_nombre;
                        $registros_ok[$iRegistros][1] = $nocturnidad;
                        $iRegistros = $iRegistros + 1;
                        $z=1;
                    }elseif($entrada < $inicioNoche && $entrada < $salida && $salida <= $finNoche){
                        $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($salida) - strtotime($inicioNoche));
                        $registros_ok[$iRegistros][0] = $registro->oficina_nombre;
                        $registros_ok[$iRegistros][1] = $nocturnidad;
                        $iRegistros = $iRegistros + 1;
                        $z=1;
                    }
                }else{
                    if($entrada < $inicioNoche && $entrada > $salida && $salida <= $finNoche){
                        $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($salida) - strtotime($inicioNoche));
                        $registros_ok[$i][1] = date('H:i:s', strtotime($registros_ok[$i][1]) + strtotime($nocturnidad));
                        
                        $iRegistros = $iRegistros + 1;
                        $z=1;
                    }elseif($entrada >= $inicioNoche && $entrada > $salida && $salida > $finNoche){
                        $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($finNoche) - strtotime($entrada));
                        $registros_ok[$i][1] = date('H:i:s', strtotime($registros_ok[$i][1]) + strtotime($nocturnidad));
                        
                        $iRegistros = $iRegistros + 1;
                        $z=1;
                    }elseif($entrada >= $inicioNoche && $entrada < $salida && $salida <= $finNoche){
                        $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($salida) - strtotime($entrada));
                        $registros_ok[$i][1] = date('H:i:s', strtotime($registros_ok[$i][1]) + strtotime($nocturnidad));
                        
                        $iRegistros = $iRegistros + 1;
                        $z=1;
                    }elseif($entrada < $inicioNoche && $entrada < $salida && $salida <= $finNoche){
                        $nocturnidad = date('H:i:s', strtotime("00:00:00") + strtotime($salida) - strtotime($inicioNoche));
                        $registros_ok[$i][1] = date('H:i:s', strtotime($registros_ok[$i][1]) + strtotime($nocturnidad));
                        
                        $iRegistros = $iRegistros + 1;
                        $z=1;
                    }
                }
            }
        }
        
        $registros_dev = [];
        $y = 0;
        
        foreach($registros_ok as $registro_ok){
            $registros_dev[$y][0] = $registro_ok[0];
            $horas_cortadas = explode(":", $registro_ok[1]);
            $registros_dev[$y][1] = $horas_cortadas[0] + $horas_cortadas[1] / 100;
            $y++;
        }
        
        $registros_dev = collect($registros_dev);

        return $registros_dev;
    }
    
    public function advertencias(){
        $trabajas = Trabaja::all();
        $fecha_actual=date("Y-m-d");
        $datos3 = explode("-",$fecha_actual);
    	$month=$datos3[1];
    	$year=$datos3[0];
    	$mesanio = $year."-".$month;
    	$aux = date('Y-m-d', strtotime("{$mesanio} + 1 month"));
        $ultimoDiaMes = date('Y-m-d', strtotime("{$aux} - 1 day"));
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
                    //$diasTrabajo = $this->Diasquetrabaja('2018-11-01', '2018-11-30', $trabaja);
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
        $registros = Registro::select('registro_fecha')->where('fk_empleado_cedula', '=', $cedula)->where('registro_fecha', '>=',$fechaInicio)->where('registro_fecha', '<=',$fechaFin)->get();
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

        $tiempo = Ajuste::where('ajuste_nombre','leave_earn' )->first();

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
    
}