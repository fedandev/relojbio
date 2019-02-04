<?php 
use App\Models\Perfils;
$perfiles = Perfils::get();
?>
    @if($perfiles->count())
        <option value="">Seleccionar perfil...</option>
        @foreach($perfiles as $perfil)
            <?php ?>
            <option value="{{$perfil->id}}">{{$perfil->perfil_nombre}}</option>
        @endforeach
    @else
         <option value="">NO HAY PERFILES</option>
    @endif
    