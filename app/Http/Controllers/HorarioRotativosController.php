<?php

namespace App\Http\Controllers;

use App\Models\HorarioRotativo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\HorarioRotativoRequest;

class HorarioRotativosController extends Controller
{
	protected $diastrabajo;
	
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.lock');
        if (ajuste('audit') != 'S'){
    		HorarioRotativo::disableAuditing();
        }else{
        	HorarioRotativo::enableAuditing();
        }
    }

	public function index()
	{
		$this->authorize('show', HorarioRotativo::class);		
		$horario_rotativos = HorarioRotativo::get();
		return view('horario_rotativos.index', compact('horario_rotativos'));
	}

    public function show(HorarioRotativo $horario_rotativo)
    {
    	$this->authorize('show', $horario_rotativo);	
        return view('horario_rotativos.show', compact('horario_rotativo'));
    }

	public function create(HorarioRotativo $horario_rotativo)
	{
		$this->authorize('create', $horario_rotativo);	
		return view('horario_rotativos.create_and_edit', compact('horario_rotativo'));
	}

	public function store(HorarioRotativoRequest $request)
	{
		$this->authorize('store', HorarioRotativo::class);
		$this->diastrabajo = intval($request->input('horariorotativo_diastrabajo'));
		$this->validate($request, [
            'horariorotativo_nombre' => 'required|string|max:191',
            'horariorotativo_diacomienzo' => 'required|string|max:191',
            'horariorotativo_diastrabajo' => 'required|integer|max:31',
            'horariorotativo_diaslibres' => 
            	function($attribute, $value, $fail) {
            		$suma = $value + $this->diastrabajo;
		            if ( $suma > 31) {
		                return $fail('La suma entre Días de trabajo y Días libres no debe superar los 31 días.');
		            }
		        },
            'fk_horario_id' => 'required|integer',
        ]);
        
		$horario_rotativo = HorarioRotativo::create($request->all());
		return redirect()->route('horario_rotativos.show', $horario_rotativo->id)->with('info', 'Creado exitosamente.');
	}

	public function edit(HorarioRotativo $horario_rotativo)
	{
        $this->authorize('edit', $horario_rotativo);
		return view('horario_rotativos.create_and_edit', compact('horario_rotativo'));
	}

	public function update(HorarioRotativoRequest $request, HorarioRotativo $horario_rotativo)
	{
		$this->authorize('update', $horario_rotativo);
		$this->diastrabajo = intval($horario_rotativo->horariorotativo_diastrabajo);
		$this->validate($request, [
            'horariorotativo_nombre' => 'required|string|max:191',
            'horariorotativo_diacomienzo' => 'required|string|max:191',
            'horariorotativo_diastrabajo' => 'required|integer|max:31',
            'horariorotativo_diaslibres' => 
            	function($attribute, $value, $fail) {
            		$suma = $value + $this->diastrabajo;
		            if ( $suma > 31) {
		                return $fail('La suma entre Días de trabajo y Días libres no debe superar los 31 días.');
		            }
		        },
            'fk_horario_id' => 'required|integer',
        ]);
        
		$horario_rotativo->update($request->all());
	
		return redirect()->route('horario_rotativos.show', $horario_rotativo->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(HorarioRotativo $horario_rotativo)
	{
		$this->authorize('destroy', $horario_rotativo);
		
		$cascade_del = ajuste('cascade_delete');
		
		if($cascade_del != 'S'){
			
			if($horario_rotativo->trabaja->count() > 0){
				return redirect()->back()->with('error', 'Existe referencia al registro en la tabla Trabajas. No es posible eliminar.');
			}else{
				$horario_rotativo->delete();
			}
		}else{
			//Lo hago de esta forma para que se registre en la tabla AUDIT
			$horario_rotativo->eliminar(); //funcion del modelo 
		}
		return redirect()->route('horario_rotativos.index')->with('info', 'Eliminado exitosamente.');
	}
}