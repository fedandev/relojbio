<?php

namespace App\Models;
use OwenIt\Auditing\Contracts\Auditable;

class Conversacion extends Model implements Auditable
{       
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['conversacion_usuario_envia', 'conversacion_usuario_recibe', 'conversacion_fecha'];
    public $timestamps = false;
    
    public function Mensajes(){
        return $this->hasMany('App\Models\Mensaje','fk_conversacion_id','id');
    }
    
    public function Eliminar(){
        foreach($this->Mensajes()->get() as $msg ){
				$msg->eliminar();
		}
        $this->delete();    
    }
}
