<?php

namespace App\Http\Controllers;

use App\Models\Turno;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TurnoRequest;

class TurnosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.lock');
        /*if (ajuste('audit') != 'S'){
    		Turno::disableAuditing();
        }else{
        	Turno::enableAuditing();
        }*/
    }

	public function index()
	{
		$this->authorize('show', Turno::class);	
		$turnos = Turno::get();
		return view('turnos.index', compact('turnos'));
	}

    public function show(Turno $turno)
    {
    	$this->authorize('show', $turno);	
        return view('turnos.show', compact('turno'));
    }

	public function create(Turno $turno)
	{
		$this->authorize('create', $turno);
		return view('turnos.create_and_edit', compact('turno'));
	}

	public function store(TurnoRequest $request)
	{
		$this->authorize('store', Turno::class);
		$this->validate($request, [
			'turno_nombre' => 'required',
			'fk_horario_id' => 'required',
        ]);
		$turno = Turno::create($request->all());
		return redirect()->route('turnos.show', $turno->id)->with('info', 'Creado exitosamente.');
	}

	public function edit(Turno $turno)
	{
        $this->authorize('edit', $turno);
		return view('turnos.create_and_edit', compact('turno'));
	}

	public function update(TurnoRequest $request, Turno $turno)
	{
		$this->authorize('update', $turno);
		$turno->update($request->all());
	
		return redirect()->route('turnos.show', $turno->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(Turno $turno)
	{
		$this->authorize('destroy', $turno);
		$cascade_del = ajuste('cascade_delete');
		
		if($cascade_del != 'S'){
			
			if($turno->Horario->count() > 0){
				return redirect()->back()->with('error', 'Existe referencia al registro en la tabla Horario. No es posible eliminar.');
			}elseif($turno->Trabaja->count() > 0){
				return redirect()->back()->with('error', 'Existe referencia al registro en la tabla Trabaja. No es posible eliminar.');
			}else{
				$turno->delete();
			}
		}else{
			//Lo hago de esta forma para que se registre en la tabla AUDIT
			$turno->eliminar(); //funcion del modelo 
		}
		return redirect()->route('turnos.index')->with('info', 'Eliminado exitosamente.');
	}
}