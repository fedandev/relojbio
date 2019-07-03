@extends('layouts.app')

@section('content')
    <body class="gray-bg">
        <div class="middle-box text-center loginscreen animated fadeInDown">
            <div>
                <div>
                    <h1 class="logo-name">RH+</h1>
                   
                    <!--<img alt="image"  style="padding-bottom: 20px;padding-top: 50px;" src="{{ asset('images/Logo-ASSE-4.png') }}" />-->
                </div>
                <h3 style="padding-bottom: 20px;" >Sistema de Gestión de Recursos Humanos</h3>
                
                <p> Ingrese su cedula o correo electronico y password para iniciar sesión.</p>
               
                <form class="m-t" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input id="email" name="email" type="text" class="form-control" placeholder="Cedula/Correo Electronico" value="{{ old('email') }}" required autofocus>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
        
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input id="password" name="password" type="password" class="form-control" placeholder="Contraseña" required>
                      
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <button type="submit" class="btn btn-success block full-width m-b">Iniciar</button>
        
                    <a href="{{ route('password.request') }}"><small>Olvido su contraseña? Click aqui!</small></a>
                    <!--<p class="text-muted text-center"><small>No estas registrado?</small></p>-->
                    <!--<a class="btn btn-sm btn-white btn-block" href="{{ route('register') }}">Registrate!</a>-->
                </form>
                <p class="m-t"> <small>SGRHH+ &copy; 2019</small> </p>
            </div>
        </div>
    </body>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    
    @section('scripts')
    @show
@endsection

