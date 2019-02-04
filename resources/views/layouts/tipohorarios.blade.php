<?php 
use App\Models\TipoHorario;
$tipohorarios = TipoHorario::get();
?>
    @if($tipohorarios->count())
        <option value="">Seleccionar tipo...</option>
        @foreach($tipohorarios as $tipohorario)
            <?php ?>
            <option value="{{$tipohorario->id}}">{{$tipohorario->tipohorario_nombre}}</option>
        @endforeach
    @else
         <option value="">NO HAY TIPOS DE HORARIOS DISPONIBLES</option>
    @endif