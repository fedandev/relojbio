<?php 
use App\Models\Oficina;
$oficinas = Oficina::get();
?>
    @if($oficinas->count())
        <option value="">Seleccionar oficina...</option>
        <option value="ALL">TODAS</option>
        @foreach($oficinas as $oficina)
            <?php ?>
            <option value="{{$oficina->id}}">{{$oficina->oficina_nombre}}</option>
        @endforeach
    @else
         <option value="">NO HAY OFICINAS</option>
    @endif