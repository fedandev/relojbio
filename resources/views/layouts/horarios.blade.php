<?php 
use App\Models\Horario;
$horarios = Horario::get();
?>
    @if($horarios->count())
        <option value="">Seleccionar horario...</option>
        @foreach($horarios as $horario)
            <?php ?>
            <option value="{{$horario->id}}">{{$horario->horario_nombre}}</option>
        @endforeach
    @else
         <option value="">NO HAY HORARIOS</option>
    @endif