<?php

namespace App\Http\Controllers;

use App\Models\TipoLibre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TipoLibreRequest;

class TipoLibresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        /*if (ajuste('audit') != 'S'){
    		TipoLibre::disableAuditing();
        }else{
        	TipoLibre::enableAuditing();
        }*/
    }

	public function index()
	{
		$tipo_libres = TipoLibre::paginate();
		return view('tipo_libres.index', compact('tipo_libres'));
	}

    public function show(TipoLibre $tipo_libre)
    {
        return view('tipo_libres.show', compact('tipo_libre'));
    }

	public function create(TipoLibre $tipo_libre)
	{
		return view('tipo_libres.create_and_edit', compact('tipo_libre'));
	}

	public function store(TipoLibreRequest $request)
	{
		$tipo_libre = TipoLibre::create($request->all());
		return redirect()->route('tipo_libres.show', $tipo_libre->id)->with('info', 'Creado exitosamente.');
	}

	public function edit(TipoLibre $tipo_libre)
	{
        //$this->authorize('update', $tipo_libre);
		return view('tipo_libres.create_and_edit', compact('tipo_libre'));
	}

	public function update(TipoLibreRequest $request, TipoLibre $tipo_libre)
	{
		//$this->authorize('update', $tipo_libre);
		$tipo_libre->update($request->all());

		return redirect()->route('tipo_libres.show', $tipo_libre->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(TipoLibre $tipo_libre)
	{
		//$this->authorize('destroy', $tipo_libre);
		$cascade_del = ajuste('cascade_delete');
		
		if($cascade_del != 'S'){
			
			if($tipo_libre->Libres->count() > 0){
				return redirect()->back()->with('error', 'Existe referencia al registro en la tabla Libres Detalle. No es posible eliminar.');
			}else{
				$tipo_libre->delete();
			}
		}else{
			//Lo hago de esta forma para que se registre en la tabla AUDIT
			$tipo_libre->eliminar(); //funcion del modelo 
		}
		return redirect()->route('tipo_libres.index')->with('info', 'Eliminado exitosamente.');
	}
}