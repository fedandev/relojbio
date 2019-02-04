<?php 
use App\Models\Turno;
$turnos = Turno::get();
?>
    @if($turnos->count())
        <option value="">Seleccionar turno...</option>
        @foreach($turnos as $turno)
            <?php ?>
            <option value="{{$turno->id}}">{{ $turno->turno_nombre }}</option>
        @endforeach
    @else
         <option value="">NO HAY TURNOS</option>
    @endif