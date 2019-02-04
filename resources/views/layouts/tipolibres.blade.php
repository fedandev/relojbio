<?php 
use App\Models\TipoLibre;
$tipoLibres = TipoLibre::get();
?>
    @if($tipoLibres->count())
        <option value="">Seleccionar tipo...</option>
        @foreach($tipoLibres as $tipolibre)
            <?php ?>
            <option value="{{$tipolibre->id}}">{{$tipolibre->nombre}}</option>
        @endforeach
    @else
         <option value="">NO HAY TIPOS DE LIBRES DISPONIBLES</option>
    @endif