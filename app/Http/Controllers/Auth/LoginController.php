<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout','locked', 'unlock']);
        $this->middleware('auth.lock')->except(['locked', 'unlock']);
    }
    
    public function locked()
    {
        
        if(!session('lock-expires-at')){
            return redirect('/');
        }
    
        if(session('lock-expires-at') > now()){
            return redirect('/');
        }
        
        return view('auth.locked');
    }
    
    public function unlock(Request $request)
    {
        $check = Hash::check($request->input('password'), $request->user()->password);
        
        if(!$check){
            return redirect()->route('login.locked')->withErrors([
                'Su contraseña no coincide con su perfil.'
            ]);
        }
    
        session(['lock-expires-at' => now()->addMinutes($request->user()->getLockoutTime())]);
        $url =$request->input('url');
        return redirect($url);
        //return redirect('/');
    }
    
    
   
}
