<?php

namespace App\Http\Controllers;

use App\Models\HorarioSemanal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\HorarioSemanalRequest;

class HorarioSemanalsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.lock');
        /*if (ajuste('audit') != 'S'){
    		HorarioSemanal::disableAuditing();
        }else{
        	HorarioSemanal::enableAuditing();
        }*/
    }

	public function index()
	{
		$this->authorize('show', HorarioSemanal::class);	
		$horario_semanals = HorarioSemanal::get();
		return view('horario_semanals.index', compact('horario_semanals'));
	}

    public function show(HorarioSemanal $horario_semanal)
    {
    	$this->authorize('show', $horario_semanal);	
        return view('horario_semanals.show', compact('horario_semanal'));
    }

	public function create(HorarioSemanal $horario_semanal)
	{
		$this->authorize('create', $horario_semanal);	
		return view('horario_semanals.create_and_edit', compact('horario_semanal'));
	}

	public function store(HorarioSemanalRequest $request)
	{
		$this->authorize('store', HorarioSemanal::class);	
		$this->validate($request, [
            'horariosemanal_nombre' => 'required|string|max:191',
            'horariosemanal_horas' => 'required',
        ]);
		$horario_semanal = HorarioSemanal::create($request->all());
		return redirect()->route('horario_semanals.show', $horario_semanal->id)->with('info', 'Creado exitosamente.');
	}

	public function edit(HorarioSemanal $horario_semanal)
	{
	    $this->authorize('edit', $horario_semanal);
		return view('horario_semanals.create_and_edit', compact('horario_semanal'));
	}

	public function update(HorarioSemanalRequest $request, HorarioSemanal $horario_semanal)
	{
		$this->authorize('update', $horario_semanal);
		$this->validate($request, [
            'horariosemanal_nombre' => 'required|string|max:191',
            'horariosemanal_horas' => 'required',
        ]);
		$horario_semanal->update($request->all());

		return redirect()->route('horario_semanals.show', $horario_semanal->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(HorarioSemanal $horario_semanal)
	{
		//return $horario_semanal;	
		$this->authorize('destroy', $horario_semanal);
		$cascade_del = ajuste('cascade_delete');
		
		if($cascade_del != 'S'){
			
			if($horario_semanal->trabaja->count() > 0){
				return redirect()->back()->with('error', 'Existe referencia al registro en la tabla Trabajas. No es posible eliminar.');
			}else{
				$horario_semanal->delete();
			}
		}else{
			//Lo hago de esta forma para que se registre en la tabla AUDIT
			$horario_semanal->eliminar(); //funcion del modelo 
		}
		return redirect()->route('horario_semanals.index')->with('info', 'Eliminado exitosamente.');
	}
	
	public function delete($id)
	{
		$horario_semanal = HorarioSemanal::find($id) ;	
		$this->authorize('destroy', $horario_semanal);
		$cascade_del = ajuste('cascade_delete');
		
		if($cascade_del != 'S'){
			
			if($horario_semanal->trabaja->count() > 0){
				return redirect()->back()->with('error', 'Existe referencia al registro en la tabla Trabajas. No es posible eliminar.');
			}else{
				$horario_semanal->delete();
			}
		}else{
			//Lo hago de esta forma para que se registre en la tabla AUDIT
			$horario_semanal->eliminar(); //funcion del modelo 
		}
		return redirect()->route('horario_semanals.index')->with('info', 'Eliminado exitosamente.');
	}
}