<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuditRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;

class AuditsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'search', 'flush']]);
    }

	public function index()
	{
		$this->authorize('show', Audit::class);
		$audits = Audit::get();
		return view('audits.index', compact('audits'));
	}

    public function show(Audit $audit)
    {
    	$this->authorize('show', $audit);	
    	$id = $audit->id;
    	$audit = Audit::find($id);
        return view('audits.show', compact('audit'));
    }
    
    public function search(Request $request)
    {
    	$this->authorize('show', Audit::class);	
        $date_start = $request['date_start'];
		$date_end = $request['date_end'];
		$fechaInicio = date('Y-m-d', strtotime($request['date_start']));
		$fechaFin = date('Y-m-d', strtotime($request['date_end']));
		$usuario = $request['user_id'];
		$controlador = $request['auditable_type'];
		//$audits = array();
	    if($date_start != "" && $date_end != ""){
	        if($usuario != ""){
	            if(isset($controlador)){
	            	$audits = Audit::whereBetween('updated_at', array($fechaInicio,$fechaFin))->where('user_id',$usuario)->where(function ($query) use($controlador) {
			             for ($i = 0; $i < count($controlador); $i++){
			                $query->orwhere('auditable_type', 'like',  '%' . $controlador[$i] .'%');
			             }      
			        })->get();
	            }else{
	            	$audits = Audit::whereBetween('updated_at', array($fechaInicio,$fechaFin))->where('user_id',$usuario)->get();
	            }
	        }else{
	            if(isset($controlador)){
	                $audits = Audit::whereBetween('updated_at', array($fechaInicio,$fechaFin))->where(function ($query) use($controlador) {
			             for ($i = 0; $i < count($controlador); $i++){
			                $query->orwhere('auditable_type', 'like',  '%' . $controlador[$i] .'%');
			             }      
			        })->get();
	            }else{
	            	$audits = Audit::whereBetween('updated_at', array($fechaInicio,$fechaFin))->get();
	            }
	        }
	    }else{
	        if($usuario != ""){
	            if(isset($controlador)){
	                $audits = Audit::where('user_id',$usuario)->where(function ($query) use($controlador) {
			             for ($i = 0; $i < count($controlador); $i++){
			                $query->orwhere('auditable_type', 'like',  '%' . $controlador[$i] .'%');
			             }      
			        })->get();
	            }else{
	            	$audits = Audit::where('user_id',$usuario)->get();
	            }
	        }else{
	            if(isset($controlador)){
	                $audits = Audit::where(function ($query) use($controlador) {
			             for ($i = 0; $i < count($controlador); $i++){
			                $query->orwhere('auditable_type', 'like',  '%' . $controlador[$i] .'%');
			             }      
			        })->get();
	            }
	        }
	    }
		
        return view('audits.search', compact('audits'));
    }
    
    
     
    public function flush(Request $request)
    {
    	
        Cache::flush();
        return redirect()->route('main');
    }
}