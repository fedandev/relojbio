<?php 
use App\Models\Sucursal;
$sucursales = Sucursal::get();
?>
    @if($sucursales->count())
        <option value="">Seleccionar sucursal...</option>
        @foreach($sucursales as $sucursal)
            <?php ?>
            <option value="{{$sucursal->id}}">{{$sucursal->sucursal_nombre}}</option>
        @endforeach
    @else
         <option value="">NO HAY SUCURSALES</option>
    @endif