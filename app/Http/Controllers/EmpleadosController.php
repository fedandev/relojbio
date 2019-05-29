<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmpleadoRequest;

class EmpleadosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.lock');
        if (ajuste('audit') != 'S'){
    		Empleado::disableAuditing();
        }else{
        	Empleado::enableAuditing();
        }
    }

	public function index()
	{
		$this->authorize('show', Empleado::class);	
		$empleados = Empleado::get();
		return view('empleados.index', compact('empleados'));
	}

    public function show(Empleado $empleado)
    {
    	$this->authorize('show', $empleado);		
        return view('empleados.show', compact('empleado'));
    }

	public function create(Empleado $empleado)
	{
		$this->authorize('create', $empleado);	
		return view('empleados.create_and_edit', compact('empleado'));
	}

	public function store(EmpleadoRequest $request)
	{
		$this->authorize('store', Empleado::class);
		$this->validate($request, [
            'empleado_cedula' => 'required|string|max:191',
            'empleado_nombre' => 'required|string|max:191',
            'fk_tipoempleado_id' => 'required|integer',
            'fk_oficina_id' => 'required|integer',
        ]);
		$empleado = Empleado::create($request->all());
		return redirect()->route('empleados.show', $empleado->id)->with('info', 'Creado exitosamente.');
	}

	public function edit(Empleado $empleado)
	{
        $this->authorize('edit', $empleado);
		return view('empleados.create_and_edit', compact('empleado'));
	}

	public function update(EmpleadoRequest $request, Empleado $empleado)
	{
		$this->authorize('update', $empleado);
		$this->validate($request, [
            'empleado_cedula' => 'required|string|max:191',
            'empleado_nombre' => 'required|string|max:191',
            'fk_tipoempleado_id' => 'required|integer',
            'fk_oficina_id' => 'required|integer',
        ]);
		$empleado->update($request->all());
		return redirect()->route('empleados.show', $empleado->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(Empleado $empleado)
	{
		$this->authorize('destroy',$empleado);
		$cascade_del = ajuste('cascade_delete');
		
		if($cascade_del != 'S'){
			
			if($empleado->trabaja->count() > 0){
				return redirect()->back()->with('error', 'Existe referencia al registro en la tabla Trabajas. No es posible eliminar.');
			}elseif($empleado->registros->count() > 0){
				return redirect()->back()->with('error', 'Existe referencia al registro en la tabla Registros. No es posible eliminar.');
			}elseif($empleado->licencias->count() > 0){
				return redirect()->back()->with('error', 'Existe referencia al registro en la tabla Licencias. No es posible eliminar.');
			}elseif($empleado->libres->count() > 0){
				return redirect()->back()->with('error', 'Existe referencia al registro en la tabla Libres Detalle. No es posible eliminar.');	
			}else{
				$empleado->delete();
			}
		}else{
			
			//$empleado->registros()->delete();
			//Lo hago de esta forma para que se registre en la tabla AUDIT
			$empleado->eliminar(); //funcion del modelo 
		}
		
		
		return redirect()->route('empleados.index')->with('info', 'Eliminado exitosamente.');
	}
}