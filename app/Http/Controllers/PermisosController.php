<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermisoRequest;

class PermisosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function index()
	{
		$this->authorize('show', Permiso::class);
		$permisos = Permiso::get();
		return view('permisos.index', compact('permisos'));
	}

    public function show(Permiso $permiso)
    {
    	$this->authorize('show', $permiso);	
        return view('permisos.show', compact('permiso'));
    }

	public function create(Permiso $permiso)
	{
		$this->authorize('create', $permiso);
		return view('permisos.create_and_edit', compact('permiso'));
	}

	public function store(PermisoRequest $request)
	{
		$this->authorize('store', Permiso::class);
		$this->validate($request, [
            'permiso_nombre' => 'required|string|max:191',
            'permiso_habilita' => 'required|integer',
        ]);
		$permiso = Permiso::create($request->all());
		return redirect()->route('permisos.show', $permiso->id)->with('info', 'Creado exitosamente.');
	}

	public function edit(Permiso $permiso)
	{
        $this->authorize('edit', $permiso);
		return view('permisos.create_and_edit', compact('permiso'));
	}

	public function update(PermisoRequest $request, Permiso $permiso)
	{
		$this->authorize('update', $permiso);
		$this->validate($request, [
            'permiso_nombre' => 'required|string|max:191',
            'permiso_habilita' => 'required|integer',
        ]);
		$permiso->update($request->all());

		return redirect()->route('permisos.show', $permiso->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(Permiso $permiso)
	{
		$this->authorize('destroy', $permiso);
		$permiso->delete();
		return redirect()->route('permisos.index')->with('info', 'Eliminado exitosamente.');
	}
}