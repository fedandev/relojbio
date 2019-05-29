<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Mensaje extends Model implements Auditable
{       
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['mensaje_titulo','mensaje_mensaje', 'mensaje_fecha', 'mensaje_leido', 'mensaje_usuario_envia', 'fk_conversacion_id'];
    public $timestamps = false;
    
    public function Conversacion(){
        return $this->belongsTo('App\Models\Conversacion','fk_conversacion_id');
    }
    
    public function Usuario(){
        return $this->hasOne('App\User','id','mensaje_usuario_envia');
    }
    
}