<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SucursalRequest;

class SucursalsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        /*if (ajuste('audit') != 'S'){
    		Sucursal::disableAuditing();
        }else{
        	Sucursal::enableAuditing();
        }*/
    }

	public function index()
	{
		$this->authorize('show', Sucursal::class);
		$sucursals = Sucursal::get();
		return view('sucursals.index', compact('sucursals'));
	}

    public function show(Sucursal $sucursal)
    {
    	$this->authorize('show', $sucursal);	
        return view('sucursals.show', compact('sucursal'));
    }

	public function create(Sucursal $sucursal)
	{
		$this->authorize('create', $sucursal);
		return view('sucursals.create_and_edit', compact('sucursal'));
	}

	public function store(SucursalRequest $request)
	{
		$this->authorize('store', Sucursal::class);	
		$sucursal = Sucursal::create($request->all());
		return redirect()->route('sucursals.show', $sucursal->id)->with('info', 'Creado exitosamente.');
	}

	public function edit(Sucursal $sucursal)
	{
        $this->authorize('edit', $sucursal);
		return view('sucursals.create_and_edit', compact('sucursal'));
	}

	public function update(SucursalRequest $request, Sucursal $sucursal)
	{
		$this->authorize('update', $sucursal);
		$sucursal->update($request->all());

		return redirect()->route('sucursals.show', $sucursal->id)->with('info', 'Creado exitosamente.');
	}

	public function destroy(Sucursal $sucursal)
	{
		$this->authorize('destroy', $sucursal);
		$cascade_del = ajuste('cascade_delete');
		
		if($cascade_del != 'S'){
			
			if($sucursal->Oficinas->count() > 0){
				return redirect()->back()->with('error', 'Existe referencia al registro en la tabla Oficinas. No es posible eliminar.');
			}else{
				$sucursal->delete();
			}
		}else{
			//Lo hago de esta forma para que se registre en la tabla AUDIT
			$sucursal->eliminar(); //funcion del modelo 
		}

		return redirect()->route('sucursals.index')->with('info', 'Eliminado exitosamente.');
	}
}