<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmpresaRequest;

class EmpresasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        
        if (ajuste('audit') != 'S'){
    		Empresa::disableAuditing();
        }else{
        	Empresa::enableAuditing();
        }
    }

	public function index()
	{
		$this->authorize('show', Empresa::class);		
		$empresas = Empresa::get();
		return view('empresas.index', compact('empresas'));
	}

    public function show(Empresa $empresa)
    {
    	$this->authorize('show', $empresa);	
        return view('empresas.show', compact('empresa'));
    }

	public function create(Empresa $empresa)
	{
		$this->authorize('create', $empresa);		
		return view('empresas.create_and_edit', compact('empresa'));
	}

	public function store(EmpresaRequest $request)
	{
		$this->authorize('store', Empresa::class);	
		$this->validate($request, [
            'empresa_nombre' => 'required|string|max:191',
        ]);
		$empresa = Empresa::create($request->all());
		return redirect()->route('empresas.show', $empresa->id)->with('info', 'Creado exitosamente.');
	}

	public function edit(Empresa $empresa)
	{
		$this->authorize('edit', $empresa);
		return view('empresas.create_and_edit', compact('empresa'));
	}

	public function update(EmpresaRequest $request, Empresa $empresa)
	{
		$this->authorize('update', $empresa);
		$this->validate($request, [
            'empresa_nombre' => 'required|string|max:191',
        ]);
		$empresa->update($request->all());

		return redirect()->route('empresas.show', $empresa->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(Empresa $empresa)
	{
		$this->authorize('destroy', $empresa);
		
		$cascade_del = ajuste('cascade_delete');
		
		if($cascade_del != 'S'){
			
			if($empresa->dispositivos->count() > 0){
				return redirect()->back()->with('error', 'Existe referencia al registro en la tabla Dispositivos. No es posible eliminar.');
			}elseif($empresa->sucursales->count() > 0){
				return redirect()->back()->with('error', 'Existe referencia al registro en la tabla Sucursales. No es posible eliminar.');
			}else{
				$empresa->delete();
			}
		}else{
			//Lo hago de esta forma para que se registre en la tabla AUDIT
			$empresa->eliminar(); //funcion del modelo 
		}
		return redirect()->route('empresas.index')->with('message', 'Eliminado exitosamente.');
	}
}