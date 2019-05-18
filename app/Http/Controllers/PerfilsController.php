<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\Permiso;
use App\Models\Modulo;
use App\Http\Controllers\PermisosController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PerfilRequest;

class PerfilsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.lock');
        /*if (ajuste('audit') != 'S'){
    		Perfil::disableAuditing();
        }else{
        	Perfil::enableAuditing();
        }*/
    }

	public function index()
	{
		$this->authorize('show', Perfil::class);
		$perfils = Perfil::get();
		return view('perfils.index', compact('perfils'));
	}

    public function show(Perfil $perfil)
    {
    	$this->authorize('show', $perfil);	
        return view('perfils.show', compact('perfil'));
    }

	public function create(Perfil $perfil)
	{
		$this->authorize('create', $perfil);
		$g_permisos = Permiso::all();	
		$g_modulos = Modulo::all();	
		return view('perfils.create_and_edit', compact('perfil','g_permisos','g_modulos'));
	}

	public function store(PerfilRequest $request)
	{
		$this->authorize('store', Perfil::class);
		$this->validate($request, [
            'perfil_nombre' => 'required|string|max:191',
            'perfil_descripcion' => 'required|string|max:191',
            'v_modulos' => 'required',
            'v_permisos' => 'required',
        ]);
		
		$perfil = Perfil::create($request->all());
		$perfil->permisos()->sync($request->v_permisos);
		$perfil->Modulos()->sync($request->v_modulos);
		return redirect()->route('perfils.show', $perfil->id)->with('info', 'Creado exitosamente.');
	}

	public function edit(Perfil $perfil)
	{
        $this->authorize('edit', $perfil);
        $g_permisos = Permiso::all();	
        $g_modulos = Modulo::all();	
		return view('perfils.create_and_edit', compact('perfil','g_permisos','g_modulos'));
	}

	public function update(PerfilRequest $request, Perfil $perfil)
	{
		$this->authorize('update', $perfil);
		$this->validate($request, [
            'perfil_nombre' => 'required|string|max:191',
            'perfil_descripcion' => 'required|string|max:191',
            'v_modulos' => 'required',
            'v_permisos' => 'required',
        ]);
		$perfil->update($request->all());
		$perfil->permisos()->sync($request->v_permisos);
		$perfil->Modulos()->sync($request->v_modulos);
		return redirect()->route('perfils.show', $perfil->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(Perfil $perfil)
	{
		$this->authorize('destroy', $perfil);
		$perfil->permisos()->sync([]);
		$perfil->Modulos()->sync([]);
		$perfil->delete();
		return redirect()->route('perfils.index')->with('info', 'Eliminado exitosamente.');
	}
}