<?php

namespace App\Http\Controllers;

use App\Models\Oficina;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\OficinaRequest;

class OficinasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        /*if (ajuste('audit') != 'S'){
    		Oficina::disableAuditing();
        }else{
        	Oficina::enableAuditing();
        }*/
    }

	public function index()
	{
		$this->authorize('show', Oficina::class);
		$oficinas = Oficina::get();
		return view('oficinas.index', compact('oficinas'));
	}

    public function show(Oficina $oficina)
    {
    	$this->authorize('show', $oficina);	
        return view('oficinas.show', compact('oficina'));
    }

	public function create(Oficina $oficina)
	{
		$this->authorize('create', $oficina);
		$latitud = ajuste('latitud');
		$longitud = ajuste('longitud');
		return view('oficinas.create_and_edit', compact('oficina', 'latitud', 'longitud'));
	}

	public function store(OficinaRequest $request)
	{
		$this->authorize('store', Oficina::class);	
		$this->validate($request, [
            'oficina_nombre' => 'required|string|max:191',
            'fk_sucursal_id' => 'required|integer',
            'fk_dispositivo_id' => 'required|integer',
        ]);
        
		$oficina = Oficina::create($request->all());
		return redirect()->route('oficinas.show', $oficina->id)->with('info', 'Creado exitosamente.');
	}

	public function edit(Oficina $oficina)
	{
        $this->authorize('edit', $oficina);
        $latitud = ajuste('latitud');
		$longitud = ajuste('longitud');
		return view('oficinas.create_and_edit', compact('oficina','latitud', 'longitud'));
	}

	public function update(OficinaRequest $request, Oficina $oficina)
	{
		$this->authorize('update', $oficina);
		$this->validate($request, [
            'oficina_nombre' => 'required|string|max:191',
            'fk_sucursal_id' => 'required|integer',
            'fk_dispositivo_id' => 'required|integer',
        ]);
		$oficina->update($request->all());
		return redirect()->route('oficinas.show', $oficina->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(Oficina $oficina)
	{
		$this->authorize('destroy', $oficina);
		$cascade_del = ajuste('cascade_delete');
		
		if($cascade_del != 'S'){
			
			if($oficina->Empleados->count() > 0){
				return redirect()->back()->with('error', 'Existe referencia al registro en la tabla Empleados. No es posible eliminar.');
			}else{
				$oficina->delete();
			}
		}else{
			//Lo hago de esta forma para que se registre en la tabla AUDIT
			$oficina->eliminar(); //funcion del modelo 
		}
		return redirect()->route('oficinas.index')->with('info', 'Eliminado exitosamente.');
	}
}