<?php 
use App\Models\HorarioRotativo;
$horarios = HorarioRotativo::get();
?>
    @if($horarios->count())
        <option value="">Seleccionar horario...</option>
        @foreach($horarios as $horario)
            <?php ?>
            <option value="{{$horario->id}}">{{$horario->horariorotativo_nombre}}</option>
        @endforeach
    @else
         <option value="">NO HAY HORARIOS</option>
    @endif