<?php

namespace App\Http\Controllers;

use App\Models\TipoLicencia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TipoLicenciaRequest;

class TipoLicenciasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        if (ajuste('audit') != 'S'){
    		TipoLicencia::disableAuditing();
        }else{
        	TipoLicencia::enableAuditing();
        }
    }

	public function index()
	{
		$this->authorize('show', TipoLicencia::class);
		$tipo_licencias = TipoLicencia::get();
		return view('tipo_licencias.index', compact('tipo_licencias'));
	}

    public function show(TipoLicencia $tipo_licencia)
    {
    	$this->authorize('show', $tipo_licencia);
        return view('tipo_licencias.show', compact('tipo_licencia'));
    }

	public function create(TipoLicencia $tipo_licencia)
	{
		$this->authorize('create', $tipo_licencia);
		return view('tipo_licencias.create_and_edit', compact('tipo_licencia'));
	}

	public function store(TipoLicenciaRequest $request)
	{
		$this->authorize('store', TipoLicencia::class);	
		$tipo_licencia = TipoLicencia::create($request->all());
		return redirect()->route('tipo_licencias.show', $tipo_licencia->id)->with('info', 'Creado exitosamente.');
	}

	public function edit(TipoLicencia $tipo_licencia)
	{
        $this->authorize('edit', $tipo_licencia);
		return view('tipo_licencias.create_and_edit', compact('tipo_licencia'));
	}

	public function update(TipoLicenciaRequest $request, TipoLicencia $tipo_licencia)
	{
		$this->authorize('update', $tipo_licencia);
		$tipo_licencia->update($request->all());

		return redirect()->route('tipo_licencias.show', $tipo_licencia->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(TipoLicencia $tipo_licencia)
	{
		$this->authorize('destroy', $tipo_licencia);
		$cascade_del = ajuste('cascade_delete');
		
		if($cascade_del != 'S'){
			
			if($tipo_licencia->Licencias->count() > 0){
				return redirect()->back()->with('error', 'Existe referencia al registro en la tabla Licencias. No es posible eliminar.');
			}else{
				$tipo_licencia->delete();
			}
		}else{
			//Lo hago de esta forma para que se registre en la tabla AUDIT
			$tipo_licencia->eliminar(); //funcion del modelo 
		}

		return redirect()->route('tipo_licencias.index')->with('info', 'Eliminado exitosamente.');
	}
}