<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Dispositivo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DispositivoRequest;
use Ping;

use App\Classes\ZKLib;


class DispositivosController extends Controller{
	
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('auth.lock');
        /*if (ajuste('audit') != 'S'){
    		Dispositivo::disableAuditing();
        }else{
        	Dispositivo::enableAuditing();
        }*/
    }

	public function index(){
		$this->authorize('show', Dispositivo::class);
	//	$dispositivos = DB::table('dispositivos')->get();
		$dispositivos = Dispositivo::with('empresa')->get();
		return view('dispositivos.index', compact('dispositivos'));
	}

    public function show(Dispositivo $dispositivo){
    	$this->authorize('show', $dispositivo);
        return view('dispositivos.show', compact('dispositivo'));
    }

	public function download(Dispositivo $dispositivo){
    	$this->authorize('show', $dispositivo);	
    	include(app_path().'/Libs/zklib.php');
    	
    	$health = Ping::check($dispositivo->dispositivo_ip);
    	
    	if($health == 200) {
            $zk = new ZKLib($dispositivo->dispositivo_ip, $dispositivo->dispositivo_puerto);
	    	$ret = $zk->connect();
	    	
	    	if($ret){
	    		$marcas = $zk->getAttendance();	
	    	}
	        return view('dispositivos.download', compact('dispositivo', 'ret', 'marcas'));
        } else {
            return redirect()->route('dispositivos.index')->with('error', 'Error al conectarse.');
        }
    }
    
	public function create(Dispositivo $dispositivo){
		$this->authorize('create', $dispositivo);	
		return view('dispositivos.create_and_edit', compact('dispositivo'));
	}

	public function store(DispositivoRequest $request){
		$this->authorize('store', Dispositivo::class);
		
		$this->validate($request, [
            'dispositivo_nombre' => 'required|string|max:255',
            'dispositivo_serial' => 'required|string|max:255',
            'dispositivo_modelo' => 'required|string|max:255',
            'dispositivo_ip' => 'required|string|max:255',
            'dispositivo_puerto' => 'required|string|max:255',
            'dispositivo_usuario' => 'required|string|max:255',
            'dispositivo_password' => 'required|string|max:255',
            'fk_empresa_id' => 'required|integer',
        ]);
        
		$dispositivo = Dispositivo::create($request->all());

		return redirect()->route('dispositivos.show', $dispositivo->id)->with('info', 'Creado exitosamente.');
	}

	public function edit(Dispositivo $dispositivo){
        $this->authorize('edit', $dispositivo);
		return view('dispositivos.create_and_edit', compact('dispositivo'));
	}

	public function update(DispositivoRequest $request, Dispositivo $dispositivo){
		$this->authorize('update', $dispositivo);
		
		$this->validate($request, [
            'dispositivo_nombre' => 'required|string|max:255',
            'dispositivo_serial' => 'required|string|max:255',
            'dispositivo_modelo' => 'required|string|max:255',
            'dispositivo_ip' => 'required|string|max:255',
            'dispositivo_puerto' => 'required|string|max:255',
            'dispositivo_usuario' => 'required|string|max:255',
            'dispositivo_password' => 'required|string|max:255',
            'fk_empresa_id' => 'required|integer',
        ]);
        
		$dispositivo->update($request->all());

		return redirect()->route('dispositivos.show', $dispositivo->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(Dispositivo $dispositivo){
		$this->authorize('destroy', $dispositivo);
		
		$cascade_del = ajuste('cascade_delete');
		
		if($cascade_del != 'S'){
			
			if($dispositivo->registros->count() > 0){
				return redirect()->back()->with('error', 'Existe referencia al registro en la tabla Registros. No es posible eliminar.');
			}elseif($dispositivo->oficinas->count() > 0){
				return redirect()->back()->with('error', 'Existe referencia al registro en la tabla Oficinas. No es posible eliminar.');
			}else{
				$dispositivo->delete();
			}
		}else{
			//$dispositivo->registros()->delete();
			//Lo hago de esta forma para que se registre en la tabla AUDIT
			$dispositivo->eliminar();
		}

		return redirect()->route('dispositivos.index')->with('info', 'Eliminado exitosamente.');
	}
}