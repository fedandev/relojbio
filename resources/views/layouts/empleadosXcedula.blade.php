<?php 
use App\Models\Empleado;
$empleados = Empleado::orderBy('empleado_apellido')->get();
?>
    @if($empleados->count())
        <option value="" selected >Seleccionar empleado...</option>
        @foreach($empleados as $empleado)
            <option value="{{$empleado->empleado_cedula}}">{{$empleado->empleado_cedula}} - {{$empleado->empleado_nombre}} {{$empleado->empleado_apellido}}</option>
        @endforeach
    @else
         <option value="">NO HAY EMPLEADOS</option>
    @endif