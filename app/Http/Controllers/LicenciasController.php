<?php

namespace App\Http\Controllers;

use App\Models\Licencia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LicenciaRequest;
use Illuminate\Support\Facades\DB;

class LicenciasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        /*if (ajuste('audit') != 'S'){
    		Licencia::disableAuditing();
        }else{
        	Licencia::enableAuditing();
        }*/
    }

	public function index(){
		$this->authorize('show', Licencia::class);
		$licencias = Licencia::with('LicenciaDetalles')->get();
		
		return view('licencias.index', compact('licencias'));
	}

    public function show(Licencia $licencia){
    	$this->authorize('show', $licencia);
        return view('licencias.show', compact('licencia'));
    }

	public function create(Licencia $licencia){
		$this->authorize('create', $licencia);
		return view('licencias.create_and_edit', compact('licencia'));
	}

	public function store(LicenciaRequest $request){
		$this->authorize('store', Licencia::class);	
		$this->validate($request, [
            'licencia_anio' => 'required|integer|max:2060',
            'licencia_cantidad' => 'required|integer|max:60',
            'fk_tipolicencia_id' => 'required|integer',
            'fk_empleado_id' => 'required|integer',
        ]);
        
		$licencia = Licencia::create($request->all());
		return redirect()->route('licencias.show', $licencia->id)->with('info', 'Creado exitosamente.');
	}

	public function edit(Licencia $licencia){
        $this->authorize('edit', $licencia);
		return view('licencias.create_and_edit', compact('licencia'));
	}

	public function update(LicenciaRequest $request, Licencia $licencia){
		$this->authorize('update', $licencia);
		$this->validate($request, [
            'licencia_anio' => 'required|integer|max:2060',
            'licencia_cantidad' => 'required|integer|max:60',
            'fk_tipolicencia_id' => 'required|integer',
            'fk_empleado_id' => 'required|integer',
        ]);
		$licencia->update($request->all());

		return redirect()->route('licencias.show', $licencia->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(Licencia $licencia){
		$this->authorize('destroy', $licencia);
		$cascade_del = ajuste('cascade_delete');
		
		if($cascade_del != 'S'){
			
			if($licencia->LicenciaDetalles->count() > 0){
				return redirect()->back()->with('error', 'Existe referencia al registro en la tabla Licencias Detalle. No es posible eliminar.');
			}else{
				$licencia->delete();
			}
		}else{
			//Lo hago de esta forma para que se registre en la tabla AUDIT
			$licencia->eliminar(); //funcion del modelo 
		}
		
		return redirect()->route('licencias.index')->with('info', 'Eliminado exitosamente.');
	}
	
	public function getDiasLicencia($id){
		return Licencia::where('id','=',$id)->get();
	}
	
	public function getTiposLicencia(Request $request, $id){
		if($request->ajax()){
			$tipos = DB::table('tipo_licencias')
					->join('licencias', 'tipo_licencias.id', '=', 'licencias.fk_tipolicencia_id')
					->join('empleados', 'empleados.id', '=', 'licencias.fk_empleado_id')
					->where('empleados.id', '=', $id)
					->where('licencias.licencia_cantidad','>', "0")
					->select('tipo_licencias.*','licencias.*')
					->get();
			return response()->json($tipos);
		}
	}
}