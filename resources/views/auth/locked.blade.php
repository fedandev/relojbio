@extends('layouts.app')

@section('content')
<div class="lock-word animated fadeInDown">
    <span class="first-word">LOCKED</span><span>SCREEN</span>
</div>

<div class="middle-box text-center lockscreen animated fadeInDown">
    <div>
        <div class="m-b-md">
            <img alt="image" class="img-circle circle-border" src="https://s3.amazonaws.com/uifaces/faces/twitter/ok/128.jpg">
        </div>
        
        @include('common.error')
        <h3>{{ auth()->user()->nombre }}</h3>
        <p>Estás en pantalla de bloqueo. La aplicación principal se cerró y debe ingresar su contraseña para volver a la aplicación.</p>
        <form class="m-t" role="form" method="POST" action="{{ route('login.unlock') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="password" class="form-control" name='password' id='password-field' placeholder="**********" required>
            </div>
            <button type="submit" class="btn btn-primary block full-width">Unlock</button>
        </form>
    </div>
</div>
@endsection