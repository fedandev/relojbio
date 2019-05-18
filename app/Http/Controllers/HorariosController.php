<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\HorarioRequest;

class HorariosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.lock');
        /*if (ajuste('audit') != 'S'){
    		Horario::disableAuditing();
        }else{
        	Horario::enableAuditing();
        }*/
    }

	public function index()
	{
		$this->authorize('show', Horario::class);	
		$horarios = Horario::get();
		return view('horarios.index', compact('horarios'));
	}

    public function show(Horario $horario)
    {
    	$this->authorize('show', $horario);	
        return view('horarios.show', compact('horario'));
    }

	public function create(Horario $horario)
	{
		$this->authorize('create', $horario);	
		return view('horarios.create_and_edit', compact('horario'));
	}

	public function store(HorarioRequest $request)
	{
		$this->authorize('store', Horario::class);		
		$this->validate($request, [
            'horario_nombre' => 'required|string|max:191',
            'horario_entrada' => 'required',
            'horario_salida' => 'required',
            'horario_comienzobrake' => 'required',
            'horario_finbrake' => 'required',
            'horario_tiempotarde' => 'required',
            'horario_salidaantes' => 'required',
        ]);
       
		$horario = Horario::create($request->all());
		return redirect()->route('horarios.show', $horario->id)->with('info', 'Creado exitosamente.');
	}

	public function edit(Horario $horario)
	{
        $this->authorize('edit', $horario);
		return view('horarios.create_and_edit', compact('horario'));
	}

	public function update(HorarioRequest $request, Horario $horario)
	{
		$this->authorize('update', $horario);
		$this->validate($request, [
            'horario_nombre' => 'required|string|max:191',
            'horario_entrada' => 'required',
            'horario_salida' => 'required',
            'horario_comienzobrake' => 'required',
            'horario_finbrake' => 'required',
            'horario_tiempotarde' => 'required',
            'horario_salidaantes' => 'required',
        ]);
        
		$horario->update($request->all());

		return redirect()->route('horarios.show', $horario->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(Horario $horario)
	{
		$this->authorize('destroy', $horario);
		$cascade_del = ajuste('cascade_delete');
		
		if($cascade_del != 'S'){
			
			if($horario->HorariosRotativos->count() > 0){
				return redirect()->back()->with('error', 'Existe referencia al registro en la tabla Horarios Rotativos. No es posible eliminar.');
			}elseif($horario->Turnos->count() > 0){
				return redirect()->back()->with('error', 'Existe referencia al registro en la tabla Turnos. No es posible eliminar.');
			}else{
				$horario->delete();
			}
		}else{
			//Lo hago de esta forma para que se registre en la tabla AUDIT
			$horario->eliminar(); //funcion del modelo 
		}
		
		
		return redirect()->route('horarios.index')->with('info', 'Eliminado exitosamente.');
	}
}