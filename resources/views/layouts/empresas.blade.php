<?php 
use App\Models\Empresa;
$empresas = Empresa::get();
?>
    @if($empresas->count())
        <option value="">Seleccionar empresa...</option>
        @foreach($empresas as $empresa)
            <?php ?>
            <option value="{{$empresa->id}}">{{$empresa->empresa_nombre}}</option>
        @endforeach
    @else
         <option value="">NO HAY EMPRESAS</option>
    @endif