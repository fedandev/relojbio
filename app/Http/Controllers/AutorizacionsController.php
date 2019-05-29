<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Autorizacion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AutorizacionRequest;

class AutorizacionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.lock');
        if (ajuste('audit') != 'S'){
    		Autorizacion::disableAuditing();
        }else{
        	Autorizacion::enableAuditing();
        }
    }

	public function index()
	{
		$this->authorize('show', Autorizacion::class);
		$autorizacions = Autorizacion::get();
		return view('autorizacions.index', compact('autorizacions'));
	}

    public function show(Autorizacion $autorizacion)
    {
    	$this->authorize('show', Autorizacion::class);	
        return view('autorizacions.show', compact('autorizacion'));
    }

	public function create(Autorizacion $autorizacion)
	{
		$this->authorize('create', $autorizacion);
		return view('autorizacions.create_and_edit', compact('autorizacion'));
	}

	public function store(AutorizacionRequest $request)
	{
		$this->authorize('store', Autorizacion::class);
		$autorizacion = Autorizacion::create($request->all());
		return redirect()->route('autorizacions.show', $autorizacion->id)->with('info', 'Creado exitosamente.');
	}

	public function edit(Autorizacion $autorizacion)
	{
        $this->authorize('update', $autorizacion);
		return view('autorizacions.create_and_edit', compact('autorizacion'));
	}

	public function update(AutorizacionRequest $request, Autorizacion $autorizacion)
	{
		$this->authorize('update', $autorizacion);
		$autorizacion->update($request->all());

		return redirect()->route('autorizacions.show', $autorizacion->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(Autorizacion $autorizacion)
	{
		$this->authorize('destroy', $autorizacion);
		$autorizacion->delete();
		return redirect()->route('autorizacions.index')->with('info', 'Eliminado exitosamente.');
	}
}