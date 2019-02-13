<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MensajeRequest;
use App\Models\Conversacion;

class MensajesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        /*if (ajuste('audit') != 'S'){
    		Mensaje::disableAuditing();
        }else{
        	Mensaje::enableAuditing();
        }*/
    }

	public function index()
	{
		$mensajes = Mensaje::paginate();
		return view('mensajes.index', compact('mensajes'));
	}

    public function show(Mensaje $mensaje)
    {
    	$mensaje->mensaje_leido = 1;
    	$mensaje->save();
        return view('mensajes.show', compact('mensaje'));
    }

	public function create(Mensaje $mensaje)
	{
		return view('mensajes.create_and_edit', compact('mensaje'));
	}

	public function store(MensajeRequest $request)
	{
		$usuarioEnvia = $request['mensaje_usuario_envia'];
		$usuarioRecibe = $request['usuario'];
		$totalconversacion = Conversacion::where('conversacion_usuario_recibe',$usuarioEnvia)->where('conversacion_usuario_envia',$usuarioRecibe)->orWhere('conversacion_usuario_recibe',$usuarioRecibe)->where('conversacion_usuario_envia',$usuarioEnvia)->count();
		if($totalconversacion == 0){
			$newConversacion = new Conversacion;
			$newConversacion->conversacion_usuario_envia = $usuarioEnvia;
			$newConversacion->conversacion_usuario_recibe = $usuarioRecibe;
			$newConversacion->conversacion_fecha = date("Y-m-d h:i:s");
			$newConversacion->save();
		}
		$conversacion = Conversacion::where('conversacion_usuario_recibe',$usuarioEnvia)->where('conversacion_usuario_envia',$usuarioRecibe)->orWhere('conversacion_usuario_recibe',$usuarioRecibe)->where('conversacion_usuario_envia',$usuarioEnvia)->get();
		
		$request['fk_conversacion_id'] = $conversacion[0]->id;
		$mensaje = Mensaje::create($request->all());
		return redirect()->route('conversacions.index')->with('info', 'Mensaje enviado exitosamente.');
	}

	public function edit(Mensaje $mensaje)
	{
        //$this->authorize('update', $mensaje);
		return view('mensajes.create_and_edit', compact('mensaje'));
	}

	public function update(MensajeRequest $request, Mensaje $mensaje)
	{
		//$this->authorize('update', $mensaje);
		$mensaje->update($request->all());

		return redirect()->route('mensajes.show', $mensaje->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Mensaje $mensaje)
	{
		//$this->authorize('destroy', $mensaje);
		$mensaje->delete();
		return redirect()->route('mensajes.index')->with('info', 'Mensaje eliminado exitosamente.');
	}
}