<?php

namespace App\Http\Controllers;

use App\Models\TipoEmpleado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TipoEmpleadoRequest;

class TipoEmpleadosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.lock');
        /*if (ajuste('audit') != 'S'){
    		TipoEmpleado::disableAuditing();
        }else{
        	TipoEmpleado::enableAuditing();
        }*/
    }

	public function index()
	{
		$this->authorize('show', TipoEmpleado::class);	
		$tipo_empleados = TipoEmpleado::get();
		return view('tipo_empleados.index', compact('tipo_empleados'));
	}

    public function show(TipoEmpleado $tipo_empleado)
    {
    	$this->authorize('show', $tipo_empleado);
        return view('tipo_empleados.show', compact('tipo_empleado'));
    }

	public function create(TipoEmpleado $tipo_empleado)
	{
		$this->authorize('create', $tipo_empleado);
		return view('tipo_empleados.create_and_edit', compact('tipo_empleado'));
	}

	public function store(TipoEmpleadoRequest $request)
	{
		$this->authorize('store', TipoEmpleado::class);
		$tipo_empleado = TipoEmpleado::create($request->all());
		return redirect()->route('tipo_empleados.show', $tipo_empleado->id)->with('info', 'Creado exitosamente.');
	}

	public function edit(TipoEmpleado $tipo_empleado)
	{
        $this->authorize('edit', $tipo_empleado);
		return view('tipo_empleados.create_and_edit', compact('tipo_empleado'));
	}

	public function update(TipoEmpleadoRequest $request, TipoEmpleado $tipo_empleado)
	{
		$this->authorize('update', $tipo_empleado);
		$tipo_empleado->update($request->all());
		return redirect()->route('tipo_empleados.show', $tipo_empleado->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(TipoEmpleado $tipo_empleado)
	{
		$this->authorize('destroy', $tipo_empleado);
		$tipo_empleado->delete();
		return redirect()->route('tipo_empleados.index')->with('info', 'Eliminado exitosamente.');
	}
}