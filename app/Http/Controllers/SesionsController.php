<?php

namespace App\Http\Controllers;

use App\Models\Sesion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SesionRequest;

class SesionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.lock');
        if (ajuste('audit') != 'S'){
    		Sesion::disableAuditing();
        }else{
        	Sesion::enableAuditing();
        }
    }

	public function index()
	{
		$sesions = Sesion::paginate();
		return view('sesions.index', compact('sesions'));
	}

    public function show(Sesion $sesion)
    {
        return view('sesions.show', compact('sesion'));
    }

	public function create(Sesion $sesion)
	{
		return view('sesions.create_and_edit', compact('sesion'));
	}

	public function store(SesionRequest $request)
	{
		$sesion = Sesion::create($request->all());
		return redirect()->route('sesions.show', $sesion->id)->with('message', 'Created successfully.');
	}

	public function edit(Sesion $sesion)
	{
        $this->authorize('update', $sesion);
		return view('sesions.create_and_edit', compact('sesion'));
	}

	public function update(SesionRequest $request, Sesion $sesion)
	{
		$this->authorize('update', $sesion);
		$sesion->update($request->all());

		return redirect()->route('sesions.show', $sesion->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Sesion $sesion)
	{
		$this->authorize('destroy', $sesion);
		$sesion->delete();

		return redirect()->route('sesions.index')->with('message', 'Deleted successfully.');
	}
}