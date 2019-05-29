<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TipoLibre extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    public $timestamps = false;
    protected $fillable = ['nombre', 'descripcion'];


    public function Libres(){
        return $this->hasMany('App\Models\LibreDetalle','fk_tipo_libre_id','id');
    }
    
    
    
    public function Eliminar(){
		
		if($this->Libres->count() > 0){
			$libres = $this->Libres()->get();
			foreach($libres as $lib){
				$lib->eliminar();
			}
		}
		
        $this->delete();    
    }
}
