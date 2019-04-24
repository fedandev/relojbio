<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use App\Models\Empleado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistroRequest;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class RegistrosController extends Controller
{
	protected $error;
		
    public function __construct(){
        $this->middleware('auth');
        $this->error = 'N';
        /*if (ajuste('audit') != 'S'){
    		Registro::disableAuditing();
        }else{
        	Registro::enableAuditing();
        }*/
    }

	public function index(){
		$this->authorize('show', Registro::class);	
		$empleado_cedula= '';
		$fdesde= date("Y-m-d");
		$fhasta= date("Y-m-d");
		$registros = Registro::where('fk_empleado_cedula', '=', $empleado_cedula)->orderby('registro_hora')->get();
		return view('registros.index', compact('registros', 'empleado_cedula', 'fdesde' , 'fhasta'));
	}
	
	public function search(Request $request){
		$empleado_cedula= $request->input('ci');
		$fdesde= $request->input('fdesde');
		$fhasta= $request->input('fhasta');
		

		if($empleado_cedula != 'ALL' and !$fdesde and !$fhasta){  
			
			$registros = Registro::where('fk_empleado_cedula', '=', $empleado_cedula)->orderby('registro_hora','asc')->orderby('fk_empleado_cedula')->get();
			
		}elseif($empleado_cedula != 'ALL' and $fdesde and !$fhasta){
		
			$registros = Registro::where('fk_empleado_cedula', '=', $empleado_cedula)->where('registro_fecha', '>=', $fdesde)->orderby('registro_hora', 'ASC')->orderby('fk_empleado_cedula')->get();
			
		}elseif($empleado_cedula != 'ALL' and !$fdesde and $fhasta){
		
			$registros = Registro::where('fk_empleado_cedula', '=', $empleado_cedula)->where('registro_fecha', '<=', $fhasta)->orderby('registro_hora', 'ASC')->orderby('fk_empleado_cedula')->get();
			
		}elseif($empleado_cedula != 'ALL' and $fdesde and $fhasta){
			
			$registros = Registro::where('fk_empleado_cedula', '=', $empleado_cedula)->whereBetween('registro_fecha', array($fdesde,$fhasta))->orderby('registro_hora', 'ASC')->orderby('fk_empleado_cedula')->get();
			
		}elseif($empleado_cedula == 'ALL' and $fdesde and $fhasta){
		
			$registros = Registro::whereBetween('registro_fecha', array($fdesde,$fhasta))->orderby('registro_hora', 'ASC')->orderby('fk_empleado_cedula')->get();
			
		}else{
		
			$registros = Registro::where('fk_empleado_cedula', '=', $empleado_cedula)->orderby('registro_hora', 'ASC')->orderby('fk_empleado_cedula')->get();
		}
		
        return view('registros.index', compact('registros', 'empleado_cedula', 'fdesde' , 'fhasta'));
	}

    public function show(Registro $registro){
    	$this->authorize('show', $registro);
        return view('registros.show', compact('registro'));
    }

	public function create(Registro $registro){
		$this->authorize('create', $registro);	
		return view('registros.create_and_edit', compact('registro'));
	}

	public function store(RegistroRequest $request){

		$this->authorize('store', Registro::class);	
		
		$hora = $request->input('registro_hora');
		$fecha = $request->input('registro_fecha');
		$t = $fecha. ' '. $hora;
		
		$datetime = new \DateTime($t);
		$request['registro_hora'] = $datetime;
		$request['registro_tipomarca'] = 'Fingerpint';
		
		
		$this->validate($request, [
            'registro_hora' => 'required',
            'registro_fecha' => 'required',
            'registro_tipo' => 'required',
            'fk_empleado_cedula' => 'required',
            
        ]);
		$registro = Registro::create($request->all());
		return redirect()->route('registros.show', $registro->id)->with('info', 'Creado exitosamente.');
	}

	public function edit(Registro $registro){
        $this->authorize('edit', $registro);
		return view('registros.create_and_edit', compact('registro'));
	}

	public function update(RegistroRequest $request, Registro $registro){
		$this->authorize('update', $registro);
		
		$hora = $request->input('registro_hora');
		$fecha = $request->input('registro_fecha');
		$t = $fecha. ' '. $hora;
		
		$datetime = new \DateTime($t);
		$request['registro_hora'] = $datetime;
		$request['registro_tipomarca'] = 'Fingerpint';
		
		$this->validate($request, [
            'registro_hora' => 'required',
            'registro_fecha' => 'required',
            'registro_tipo' => 'required',
            'fk_empleado_cedula' => 'required',
            
        ]);
		$registro->update($request->all());
		return redirect()->route('registros.show', $registro->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(Registro $registro){
		$this->authorize('destroy', $registro);
		$registro->delete();
		return redirect()->route('registros.index')->with('info', 'Eliminado exitosamente.');
	}
	
	public function del(Request $request){
		$this->validate($request, [
            'delid' => 'required',
        ]);
		$delid = $request->input('delid');
		Registro::whereIn('id', $delid)->delete();
		return back()->with('info', 'Registros seleccionados eliminados exitosamente.');
	}
	
	public function Excel(Request $request){
		$this->authorize('create', Registro::class);
		return view('registros.load', compact('registro'));
	}

	public function loadExcel(Request $request)	{
		$this->authorize('store', Registro::class);	
		Excel::selectSheetsByIndex(0)->load($request->archivo, function($reader) {
            $excel = $reader->get();
           	
            //Validar
            $excel->each(function($row) {
				
				if($row->ac_no){
					$empleado = Empleado::where('empleado_cedula','=',$row->ac_no)->first();	
				
					if ($empleado){
					
	            	}else{
	            		$this->error = 'S';
	            	}
				}
            });
            
            if($this->error == 'S'){
            	return redirect()->back()->with('error', 'El archivo no se pudo cargar, algunos datos son incorrectos.');
            }else{
            	//Cargar
	            $excel->each(function($row) {
					if($row->ac_no){
						$registro = new Registro();
						$registro->registro_hora = $row->stime;
						$registro->registro_fecha = $row->sdate;
						$registro->registro_tipomarca = $row->checktype;
						$registro->registro_comentarios = "Cargado desde archivo";
						$registro->registro_tipo = $row->verify_mode;
						$registro->registro_registrado = "NO";
						$registro->fk_empleado_cedula = $row->ac_no;
						$registro->save();
					}
	            });
            	return redirect()->back()->with('info', 'El archivo se ingresó con éxito.');
            }
        });
		if($this->error == 'S'){
		 	return redirect()->back()->with('error', 'El archivo no se pudo cargar, algunos datos son incorrectos.');
		}
		return redirect()->route('registros.load')->with('info', 'Registros cargado correctamente.');
	}
	
	public function showModal($registro_id){
    	$registro = Registro::find($registro_id);
        return response()->json($registro);
    }
    
    public function updateModal(Request $request, $registro_id)
    {
    	$registro = Registro::find($registro_id);
    	
    	$hora = $request->input('registro_hora');
		$fecha = $request->input('registro_fecha');
		$t = $fecha. ' '. $hora;
		
		$datetime = new \DateTime($t);
	
        $registro->registro_hora = $datetime;
        $registro->registro_fecha = $request->registro_fecha;
        $registro->registro_tipo = $request->registro_tipo;
        $registro->registro_comentarios = $request->registro_comentarios;
        $registro->fk_empleado_cedula = $request->fk_empleado_cedula;
        $registro->fk_dispositivo_id = $request->fk_dispositivo_id;
     
        $registro->save();
        Session::flash('info', 'Registro modificado correctamente');
        return response()->json($registro);
        
        
    }
}