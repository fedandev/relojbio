@extends('layouts.app')

@section('content')
<body class="gray-bg">

    <div class="passwordBox animated fadeInDown">
        <div class="row">
            
            <div class="col-md-12">
                <div class="ibox-content">
                        
                    <h2 class="font-bold">Reiniciar contraseña</h2>

                    <p>
                        Ingrese su dirección de correo electrónico y le sera enviado un link para restablecer su contraseña.
                    </p>

                    <div class="row">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="col-lg-12">
                            <form class="m-t" role="form" method="POST" action="{{ route('password.email') }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary block full-width m-b">Enviar</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                Copyright RB+
            </div>
            <div class="col-md-6 text-right">
               <small>RB+ &copy; 2018</small>
            </div>
        </div>
    </div>

</body>

@endsection
