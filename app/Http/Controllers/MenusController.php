<?php

namespace App\Http\Controllers;

//use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;

class MenusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function index()
	{
		$this->authorize('show', Menu::class);
		//$menus = DB::table('menus')->get();
		$menus = Menu::get();
		return view('menus.index', compact('menus'));
	}
	
	
    public function show(Menu $menu) {
    	$this->authorize('show', $menu);	
        return view('menus.show', compact('menu'));
    }

	public function create(Menu $menu)
	{
		$this->authorize('create', $menu);
		//$menus = Menu::paginate();
		$menus= Menu::where('menu_padre_id', '=', 0)->orderby('menu_posicion')->get();
		return view('menus.create_and_edit', compact('menu','menus'));
	}

	public function store(MenuRequest $request)
	{
		$this->authorize('store', Menu::class);		
		$this->validate($request, [
            'menu_padre_id' => 'required|integer',
            'menu_descripcion' => 'required|string|max:191',
            
        ]);
		$menu = Menu::create($request->all());
		return redirect()->route('menus.show', $menu->id)->with('info', 'Creado exitosamente.');
	}

	public function edit(Menu $menu)
	{
        $this->authorize('edit', $menu);
        $menus= Menu::where('menu_padre_id', '=', 0)->orderby('menu_posicion')->get();
		return view('menus.create_and_edit', compact('menu', 'menus'));
	}

	public function update(MenuRequest $request, Menu $menu)
	{
		$this->authorize('update', $menu);
		$this->validate($request, [
            'menu_padre_id' => 'required|integer',
            'menu_descripcion' => 'required|string|max:191',
        ]);
		$menu->update($request->all());
		return redirect()->route('menus.show', $menu->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(Menu $menu)
	{
		
		$this->authorize('destroy',$menu);
		$menu->Modulos()->sync([]);
		$menu->delete();
		return redirect()->route('menus.index')->with('info', 'Eliminado exitosamente.');
	}


}