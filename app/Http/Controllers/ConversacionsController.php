<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Conversacion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConversacionRequest;

class ConversacionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.lock');
        /*if (ajuste('audit') != 'S'){
    		Conversacion::disableAuditing();
        }else{
        	Conversacion::enableAuditing();
        }*/
    }

	public function index()
	{
		//$this->authorize('show', Conversacion::class);
		$id_user = auth()->user()->id;
		$conversacions = DB::table('conversacions')->where('conversacion_usuario_envia',$id_user)->orWhere('conversacion_usuario_recibe', $id_user)->get();
		return view('conversacions.index', compact('conversacions'));
	}

    public function show(Conversacion $conversacion)
    {
    	//$this->authorize('show', $conversacion);		
        return view('conversacions.show', compact('conversacion'));
    }

	public function create(Conversacion $conversacion)
	{
		//$this->authorize('create', $conversacion);	
		return view('conversacions.create_and_edit', compact('conversacion'));
	}

	public function store(ConversacionRequest $request)
	{
		//$this->authorize('store', $conversacion);		
		$conversacion = Conversacion::create($request->all());
		return redirect()->route('conversacions.show', $conversacion->id)->with('message', 'Created successfully.');
	}

	public function edit(Conversacion $conversacion)
	{
        //$this->authorize('edit', $conversacion);
		return view('conversacions.create_and_edit', compact('conversacion'));
	}

	public function update(ConversacionRequest $request, Conversacion $conversacion)
	{
		//$this->authorize('update', $conversacion);
		$conversacion->update($request->all());
		return redirect()->route('conversacions.show', $conversacion->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Conversacion $conversacion)
	{
		//$this->authorize('destroy', $conversacion);
		$conversacion->eliminar();
		return redirect()->route('conversacions.index')->with('message', 'Deleted successfully.');
	}
}