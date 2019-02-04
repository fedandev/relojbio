<?php 
use App\Models\TipoLicencia;
$tipolicencias = TipoLicencia::get();
?>
    @if($tipolicencias->count())
        <option value="">Seleccionar tipo...</option>
        @foreach($tipolicencias as $tipolicencia)
            <?php ?>
            <option value="{{$tipolicencia->id}}">{{$tipolicencia->tipolicencia_nombre}}</option>
        @endforeach
    @else
         <option value="">NO HAY TIPOS DE LICENCIAS DISPONIBLES</option>
    @endif