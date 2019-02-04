<?php 
use App\User;
$users = User::get();
?>
    <option value=""></option>
    @if($users->count())
        <option value="">Seleccionar usuario...</option>
        @foreach($users as $user)
            <?php ?>
            <option value="{{$user->id}}">{{$user->nombre}}</option>
        @endforeach
    @else
         <option value="">NO HAY USUARIOS DISPONIBLES</option>
    @endif