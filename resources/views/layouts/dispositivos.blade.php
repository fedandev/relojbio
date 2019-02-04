<?php 
use App\Models\Dispositivo;
$dispositivos = Dispositivo::get();
?>
    @if($dispositivos->count())
        <option value="">Seleccionar dispositivo...</option>
        @foreach($dispositivos as $dispositivo)
            <?php ?>
            <option value="{{$dispositivo->id}}">{{$dispositivo->dispositivo_nombre}}</option>
        @endforeach
    @else
         <option value="">NO HAY RELOJES</option>
    @endif