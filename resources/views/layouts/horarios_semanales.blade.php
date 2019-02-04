<?php 
use App\Models\HorarioSemanal;
$horarios = HorarioSemanal::get();
?>
    @if($horarios->count())
        <option value="">Seleccionar horario...</option>
        @foreach($horarios as $horario)
            <?php ?>
            <option value="{{$horario->id}}">{{$horario->horariosemanal_nombre}}</option>
        @endforeach
    @else
         <option value="">NO HAY HORARIOS</option>
    @endif