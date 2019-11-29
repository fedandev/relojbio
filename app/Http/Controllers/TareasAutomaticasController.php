<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\TablonTrait;
class TareasAutomaticasController extends Controller
{
    use TablonTrait;
    public function ActualizaTablon(){
      
      $ok = $this->Tablon();
      return "ok";
    }//fin funcion ActualizaTablon
  
  
  
  
  
}//Fin class
