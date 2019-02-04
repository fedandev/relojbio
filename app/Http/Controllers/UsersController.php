<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Perfil;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
    use SendsPasswordResetEmails;
    public function __construct()
    {
        $this->middleware('auth');
        
    }

	 public function index(){
	 	$controller = 'users';
		if (!Gate::allows('view-report', $controller)) {
           return redirect()->route('main')->with('error', 'No esta autorizado a ejecutar la acción.'); 
        }  
        
        $users = User::paginate();
		return view('users.index', compact('users'));
    }
    

    public function show(User $user)
    {
    	$controller = 'users';
		if (!Gate::allows('view-report', $controller)) {
          return redirect()->route('main')->with('error', 'No esta autorizado a ejecutar la acción.');
        }		
        return view('users.show', compact('user'));
    }

	public function create(User $user)
	{
		$controller = 'users';
		if (!Gate::allows('view-report', $controller)) {
           return redirect()->route('main')->with('error', 'No esta autorizado a ejecutar la acción.');
        }	
		$g_perfiles = Perfil::all();		
		return view('users.create_and_edit', compact('user', 'g_perfiles'));
	}

	public function store(UserRequest $request)
	{
		$controller = 'users';
		if (!Gate::allows('view-report', $controller)) {
           return redirect()->route('main')->with('error', 'No esta autorizado a ejecutar la acción.'); 
        }
        
		$this->validate($request, [
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        
        $password = $request->input('password');
        $password_crypt = bcrypt($password);
        $request->merge([ 'password' => $password_crypt ]);
		$user = User::create($request->all());
		$user->Perfiles()->sync($request->v_perfiles);
		return redirect()->route('users.show', $user->id)->with('info', 'Creado exitosamente.');
		
	}

	public function edit(User $user)
	{
		$controller = 'users';
		if (!Gate::allows('view-report', $controller)) {
           return redirect()->route('main')->with('error', 'No esta autorizado a ejecutar la acción.'); 
        }
        //$this->authorize('update', $user);
        $g_perfiles = Perfil::all();	
		return view('users.create_and_edit', compact('user', 'g_perfiles'));
	}

	public function update(UserRequest $request, User $user)
	{
		$controller = 'users';
		if (!Gate::allows('view-report', $controller)) {
           return redirect()->route('main')->with('error', 'No esta autorizado a ejecutar la acción.');
        }
        
		//$this->authorize('update', $user);
		$user->update($request->all());
		$user->Perfiles()->sync($request->v_perfiles);
		return redirect()->route('users.show', $user->id)->with('info', 'Actualizado exitosamente.');
	}

	public function destroy(User $user)
	{
		$controller = 'users';
		if (!Gate::allows('view-report', $controller)) {
           return redirect()->route('main')->with('error', 'No esta autorizado a ejecutar la acción.'); 
        }	
		// $this->authorize('destroy', $user);
		$user->Perfiles()->sync([]);
		$user->delete();
	
		return redirect()->route('users.index')->with('info', 'Eliminado exitosamente.');
	}
	

}
