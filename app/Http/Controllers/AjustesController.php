<?php

namespace App\Http\Controllers;

use App\Models\Ajuste;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AjusteRequest;

class AjustesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.lock');
        
        if (ajuste('audit') != 'S'){
    		Ajuste::disableAuditing();
        }else{
        	Ajuste::enableAuditing();
        }
    }

	public function index()
	{
		$this->authorize('show', Ajuste::class);
		$ajustes = Ajuste::get();
		return view('ajustes.index', compact('ajustes'));
	}

    public function show(Ajuste $ajuste)
    {
    	$this->authorize('show', $ajuste);		
        return view('ajustes.show', compact('ajuste'));
    }

	public function create(Ajuste $ajuste)
	{
		$this->authorize('create', $ajuste);
		return view('ajustes.create_and_edit', compact('ajuste'));
	}

	public function store(AjusteRequest $request)
	{
		$this->authorize('store', Ajuste::class);
		$this->validate($request, [
            'ajuste_nombre' => 'required|string|unique:ajustes|max:191',
            'ajuste_valor' => 'required|string|max:191',
        ]);
		$ajuste = Ajuste::create($request->all());
		return redirect()->route('ajustes.show', $ajuste->id)->with('info', 'Creado exitosamente.');
	}

	public function edit(Ajuste $ajuste)
	{
        $this->authorize('edit', $ajuste);
		return view('ajustes.create_and_edit', compact('ajuste'));
	}

	public function update(AjusteRequest $request, Ajuste $ajuste)
	{
		$this->authorize('update', $ajuste);
		$this->validate($request, [
            'ajuste_nombre' => 'required|string|max:255',
            'ajuste_valor' => 'required|string|max:255',
        ]);
		$ajuste->update($request->all());
		return redirect()->route('ajustes.show', $ajuste->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(Ajuste $ajuste)
	{
		$this->authorize('destroy', $ajuste);
		$ajuste->delete();
		return redirect()->route('ajustes.index')->with('info', 'Eliminado exitosamente.');
	}
}