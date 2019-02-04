@extends('layouts.app')

@section('content')
<body class="gray-bg">
    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <div>
    
                <h4 class="logo-name">SGRRHH+</h>
                <!--<img alt="image"  style="padding-bottom: 20px;padding-top: 50px;" src="{{ asset('images/Logo-ASSE-4.png') }}" />-->
            </div>
            <h3 style="padding-bottom: 20px;" >Sistema de Gestión de Recursos Humanos</h3>
            <p>Crea una cuenta para acceder a sus funciones.</p>
            <form class="m-t" role="form" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                    <input  id="nombre" type="text" class="form-control" placeholder="Nombre" name="nombre" value="{{ old('nombre') }}" required autofocus>
                    @if ($errors->has('nombre'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nombre') }}</strong>
                        </span>
                    @endif
                </div>
                
                <div class="form-group{{ $errors->has('observaciones') ? ' has-error' : '' }}">
                    <input  id="observaciones" type="text" class="form-control" placeholder="Observaciones" name="observaciones" value="{{ old('observaciones') }}" >
                    @if ($errors->has('observaciones'))
                        <span class="help-block">
                            <strong>{{ $errors->first('observaciones') }}</strong>
                        </span>
                    @endif
                </div>
                
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input  id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Correo electrónico">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input id="password" type="password" class="form-control" name="password" required placeholder="Contraseña" >
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif    
                </div>
                
                 <div class="form-group{{ $errors->has('password-confirm') ? ' has-error' : '' }}">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirmar Contraseña">
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password-confirm') }}</strong>
                        </span>
                    @endif    
                </div>
                <input type="hidden" name="estado" value="ACTIVO" id="estado"/>
                
                <!--<div class="form-group">-->
                <!--        <div class="checkbox i-checks"><label> <input type="checkbox"><i></i> Acepto los términos y la política </label></div>-->
                <!--</div>-->
                <button type="submit" class="btn btn-primary block full-width m-b">Registrar</button>
    
                <p class="text-muted text-center"><small>Ya tienes una cuenta?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="/login">Inicia Sesión</a>
            </form>
            <p class="m-t"> <small>SGRHH+ &copy; 2018</small> </p>
        </div>
    </div>
</body>
    
@endsection
