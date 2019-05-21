<?php

namespace App\Http\Controllers;

use App\Models\TipoHorario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TipoHorarioRequest;

class TipoHorariosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.lock');
        /*if (ajuste('audit') != 'S'){
    		TipoHorario::disableAuditing();
        }else{
        	TipoHorario::enableAuditing();
        }*/
    }

	public function index()
	{
		$this->authorize('show', TipoHorario::class);
		$tipo_horarios = TipoHorario::get();
		return view('tipo_horarios.index', compact('tipo_horarios'));
	}

    public function show(TipoHorario $tipo_horario)
    {
    	$this->authorize('show', $tipo_horario);
        return view('tipo_horarios.show', compact('tipo_horario'));
    }

	public function create(TipoHorario $tipo_horario)
	{
		$this->authorize('create', $tipo_horario);
		return view('tipo_horarios.create_and_edit', compact('tipo_horario'));
	}

	public function store(TipoHorarioRequest $request)
	{
		$this->authorize('store', TipoHorario::class);	
		$tipo_horario = TipoHorario::create($request->all());
		return redirect()->route('tipo_horarios.show', $tipo_horario->id)->with('info', 'Creado exitosamente.');
	}

	public function edit(TipoHorario $tipo_horario)
	{
        $this->authorize('edit', $tipo_horario);
		return view('tipo_horarios.create_and_edit', compact('tipo_horario'));
	}

	public function update(TipoHorarioRequest $request, TipoHorario $tipo_horario)
	{
		$this->authorize('update', $tipo_horario);
		$tipo_horario->update($request->all());

		return redirect()->route('tipo_horarios.show', $tipo_horario->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(TipoHorario $tipo_horario)
	{
		$this->authorize('destroy', $tipo_horario);
		$cascade_del = ajuste('cascade_delete');
		
		if($cascade_del != 'S'){
			
			if($tipo_horario->TipoEmpleado->count() > 0){
				return redirect()->back()->with('error', 'Existe referencia al registro en la tabla Tipo Empleados. No es posible eliminar.');
			}else{
				$tipo_horario->delete();
			}
		}else{
			//Lo hago de esta forma para que se registre en la tabla AUDIT
			$tipo_horario->eliminar(); //funcion del modelo 
		}

		return redirect()->route('tipo_horarios.index')->with('info', 'Eliminado exitosamente.');
	}
}