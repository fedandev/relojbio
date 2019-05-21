<?php

namespace App\Http\Controllers;

use App\Models\Trabaja;
use App\Models\Empleado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TrabajaRequest;
use Illuminate\Support\Facades\DB;

class TrabajasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.lock');
        /*if (ajuste('audit') != 'S'){
    		Trabaja::disableAuditing();
        }else{
        	Trabaja::enableAuditing();
        }*/
    }

	public function index()
	{
		$this->authorize('show', Trabaja::class);	
		$trabajas = Trabaja::orderBy('fk_empleado_id')->orderBy('trabaja_fechainicio')->get();
		return view('trabajas.index', compact('trabajas'));
	}

    public function show(Trabaja $trabaja)
    {
    	$this->authorize('show', $trabaja);
        return view('trabajas.show', compact('trabaja'));
    }

	public function create(Trabaja $trabaja)	{
		
		
		$this->authorize('create', $trabaja);
		$empleados = Empleado::get();
		return view('trabajas.create_and_edit', compact('trabaja', 'empleados'));
	}

	public function store(TrabajaRequest $request)
	{
		
		$this->authorize('store', Trabaja::class);	
		$this->validate($request, [
            'fk_empleado_id' => 'required|integer',
            'trabaja_fechainicio' => 'required|date',
            'trabaja_fechafin' => 'required|date',
            'tipohorario' => 'required|string',
        ]);
		$trabaja = Trabaja::create($request->all());
		return redirect()->route('trabajas.show', $trabaja->id)->with('info', 'Creado exitosamente.');
	}

	public function edit(Trabaja $trabaja)
	{
        $this->authorize('edit', $trabaja);
        $empleados = Empleado::get();
		return view('trabajas.create_and_edit', compact('trabaja', 'empleados'));
	}

	public function update(TrabajaRequest $request, Trabaja $trabaja)
	{
		$this->authorize('update', $trabaja);
		$this->validate($request, [
            'fk_empleado_id' => 'required|integer',
            'trabaja_fechainicio' => 'required|date',
            'trabaja_fechafin' => 'required|date',
            'tipohorario' => 'required|string',
        ]);
		$tipohorario= $request->input('tipohorario');
		
		if($tipohorario == "Fijo"){
			$trabaja->fk_horariorotativo_id = null;
			$trabaja->fk_horariosemanal_id = null;
			
		}elseif($tipohorario == "Rotativo"){
			$trabaja->fk_turno_id = null;
			$trabaja->fk_horariosemanal_id = null;
			
		}elseif($tipohorario == "Semanal"){
			$trabaja->fk_turno_id = null;
			$trabaja->fk_horariorotativo_id = null;
		}
		
		$trabaja->update($request->all());

		return redirect()->route('trabajas.show', $trabaja->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(Trabaja $trabaja)
	{
		$this->authorize('destroy', $trabaja);
		$trabaja->delete();

		return redirect()->route('trabajas.index')->with('info', 'Eliminado exitosamente.');
	}
	
	public function getHorarios(Request $request, $id){
		
		if($request->ajax()){
			if($id == "Fijo"){
				$horarios = DB::table('turnos')->orderBy('id')->get();
			}elseif($id == "Rotativo"){
				$horarios = DB::table('horario_rotativos')->orderBy('id')->get();
			}elseif($id == "Semanal"){
				$horarios = DB::table('horario_semanals')->orderBy('id')->get();
			}
			return response()->json($horarios);
		}
	}
}