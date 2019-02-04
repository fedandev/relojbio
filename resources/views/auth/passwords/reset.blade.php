@extends('layouts.app')

@section('content')
<body class="gray-bg">
    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">RB+</h1>
            </div>
            <h3>Reiniciar la contraseña</h3>
           
            <form class="m-t" role="form" method="POST" action="{{ route('password.request') }}">
                {{ csrf_field() }}
                
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" placeholder="Email" required autofocus>

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
                
                 <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirmar Contraseña">

                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif    
                </div>
                
                <button type="submit" class="btn btn-primary block full-width m-b">Reiniciar Contraseña</button>
               
            </form>
            <p class="m-t"> <small>RB+ &copy; 2018</small> </p>
        </div>
    </div>
</body>


@endsection
