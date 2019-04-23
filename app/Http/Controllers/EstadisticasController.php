<?php

namespace App\Http\Controllers;

use App\Models\Estadistica;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EstadisticaRequest;

class EstadisticasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index()
	{
		$estadisticas = Estadistica::paginate();
		return view('estadisticas.index', compact('estadisticas'));
	}

    public function show(Estadistica $estadistica)
    {
        return view('estadisticas.show', compact('estadistica'));
    }

	public function create(Estadistica $estadistica)
	{
		return view('estadisticas.create_and_edit', compact('estadistica'));
	}

	public function store(EstadisticaRequest $request)
	{
		$estadistica = Estadistica::create($request->all());
		return redirect()->route('estadisticas.show', $estadistica->id)->with('message', 'Created successfully.');
	}

	public function edit(Estadistica $estadistica)
	{
        $this->authorize('update', $estadistica);
		return view('estadisticas.create_and_edit', compact('estadistica'));
	}

	public function update(EstadisticaRequest $request, Estadistica $estadistica)
	{
		$this->authorize('update', $estadistica);
		$estadistica->update($request->all());

		return redirect()->route('estadisticas.show', $estadistica->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Estadistica $estadistica)
	{
		$this->authorize('destroy', $estadistica);
		$estadistica->delete();

		return redirect()->route('estadisticas.index')->with('message', 'Deleted successfully.');
	}
}