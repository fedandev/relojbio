<?php

namespace App\Http\Controllers;

use App\Models\Feriado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeriadoRequest;

class FeriadosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.lock');
        /*if (ajuste('audit') != 'S'){
    		Feriado::disableAuditing();
        }else{
        	Feriado::enableAuditing();
        }*/
    }

	public function index()
	{
		$this->authorize('show', Feriado::class);
		$feriados = Feriado::get();
		return view('feriados.index', compact('feriados'));
	}

    public function show(Feriado $feriado)
    {
    	$this->authorize('show', $feriado);		
        return view('feriados.show', compact('feriado'));
    }

	public function create(Feriado $feriado)
	{
		$this->authorize('create', $feriado);		
		return view('feriados.create_and_edit', compact('feriado'));
	}

	public function store(FeriadoRequest $request)
	{
		$this->authorize('store', Feriado::class);
		$this->validate($request, [
            'feriado_nombre' => 'required|string|max:191',
            'feriado_coeficiente' => 'required|string|max:191',
            'feriado_minimo' => 'required',
            'feriado_fecha' => 'required|date',
        ]);
		$feriado = Feriado::create($request->all());
		return redirect()->route('feriados.show', $feriado->id)->with('info', 'Creado exitosamente.');
	}

	public function edit(Feriado $feriado)
	{
        $this->authorize('edit', $feriado);
		return view('feriados.create_and_edit', compact('feriado'));
	}

	public function update(FeriadoRequest $request, Feriado $feriado)
	{
		$this->authorize('update', $feriado);
		$this->validate($request, [
            'feriado_nombre' => 'required|string|max:191',
            'feriado_coeficiente' => 'required|string|max:191',
            'feriado_minimo' => 'required',
            'feriado_fecha' => 'required|date',
        ]);
		$feriado->update($request->all());

		return redirect()->route('feriados.show', $feriado->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(Feriado $feriado)
	{
		$this->authorize('destroy',$feriado);
		$feriado->delete();
		return redirect()->route('feriados.index')->with('info', 'Eliminado exitosamente.');
	}
}