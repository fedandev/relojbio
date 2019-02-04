<?php 
use App\Models\TipoEmpleado;
$tipoempleados = TipoEmpleado::get();
?>
    @if($tipoempleados->count())
        <option value="">Seleccionar tipo...</option>
        @foreach($tipoempleados as $tipoempleado)
            <?php ?>
            <option value="{{$tipoempleado->id}}">{{$tipoempleado->tipoempleado_nombre}}</option>
        @endforeach
    @else
         <option value="">NO HAY TIPOS DE EMPLEADOS DISPONIBLES</option>
    @endif