<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ModuloRequest;

class ModulosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        /*if (ajuste('audit') != 'S'){
    		Modulo::disableAuditing();
        }else{
        	Modulo::enableAuditing();
        }*/
    }

	public function index()
	{
		$this->authorize('show', Modulo::class);	
		$modulos = Modulo::get();
		return view('modulos.index', compact('modulos'));
	}

    public function show(Modulo $modulo)
    {
    	$this->authorize('show', $modulo);
        return view('modulos.show', compact('modulo'));
    }

	public function create(Modulo $modulo)
	{
		$this->authorize('create', $modulo);
		$g_menus = Menu::orderBy('menu_descripcion')->get();
		return view('modulos.create_and_edit', compact('modulo', 'g_menus'));
	}

	public function store(ModuloRequest $request)
	{
		//dd($request);
		$this->authorize('store', Modulo::class);	
		$this->validate($request, [
            'modulo_nombre' => 'required|string|max:191',
            'modulo_descripcion' => 'required|string|max:191',
            'v_menus' => 'required',
        ]);
		$modulo = Modulo::create($request->all());
		$modulo->Menus()->sync($request->v_menus);
		return redirect()->route('modulos.show', $modulo->id)->with('info', 'Creado exitosamente.');
	}

	public function edit(Modulo $modulo)
	{
        $this->authorize('edit', $modulo);
        $g_menus = Menu::orderBy('menu_descripcion')->get();
		return view('modulos.create_and_edit', compact('modulo','g_menus'));
	}

	public function update(ModuloRequest $request, Modulo $modulo)
	{
		
		$this->authorize('update', $modulo);
		$this->validate($request, [
            'modulo_nombre' => 'required|string|max:191',
            'modulo_descripcion' => 'required|string|max:191',
            'v_menus' => 'required',
        ]);
		$modulo->update($request->all());
		$modulo->Menus()->sync($request->v_menus);
		return redirect()->route('modulos.show', $modulo->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(Modulo $modulo)
	{
		$this->authorize('destroy', $modulo);
		$modulo->Menus()->sync([]);
		$modulo->delete();
		return redirect()->route('modulos.index')->with('info', 'Eliminado exitosamente.');
	}
}