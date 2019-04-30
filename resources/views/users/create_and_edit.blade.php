@extends('layouts.app')

@section('content')

    
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       
                        <h5>
                            <i class="fa fa-edit"></i> Usuario /
                            @if($user->id)
                                Editar #{{$user->id}}
                            @else
                                Nuevo
                            @endif
                        </h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    
                    
                    
                    <div class="ibox-content">
                        @include('common.error')
                        @if($user->id)
                            <form action="{{ route('users.update', $user->id) }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                                <input type="hidden" name="_method" value="PUT">
                        @else
                            <form action="{{ route('users.store') }}" method="POST" accept-charset="UTF-8" class="form-horizontal">
                        @endif
        
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                                    
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Email</label>
                                    <div class=" form-static col-sm-6"><input class="form-control" type="text" name="email" id="email-field" value="{{ old('email', $user->email ) }}"></div>
                                </div>
                                
                                <div class="hr-line-dashed"></div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nombre</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="nombre" id="nombre-field" value="{{ old('nombre', $user->nombre ) }}"></div>
                                </div>
                                
                                <div class="hr-line-dashed"></div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Observaciones</label>
                                    <div class="col-sm-6"><input class="form-control" type="text" name="observaciones" id="observaciones-field" value="{{ old('observaciones', $user->observaciones ) }}"></div>
                                </div>
                                
                                <div class="hr-line-dashed"></div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Estado</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="estado" id="estado-field" value="{{ old('estado', $user->estado) }}">
                                            <option value="ACTIVO">Activo</option>
                                            <option value ="BAJA">Baja</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Empleado</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="fk_empleado_cedula" id="fk_empleado_cedula-field" value="{{ old('fk_empleado_cedula', $user->fk_empleado_cedula) }}">
                                            @include('layouts.empleadosXcedula');
                                        </select>
                                    </div>
                                </div>
                                
                                @if(!$user->id)
                                
                                     <div class="hr-line-dashed"></div>
                                     
                                     <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label class="col-sm-2 control-label">Contraseña</label>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control" name="password" id="password-field" required>
                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif    
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('password-confirm') ? ' has-error' : '' }}">
                                        <label class="col-sm-2 control-label">Confirmar Contraseña</label>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control" name="password_confirmation" id="password-confirm-field" required>
                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password-confirm') }}</strong>
                                                </span>
                                            @endif    
                                        </div>
                                    </div>
                                     
                                @endif
                                
                                
                                <div class="hr-line-dashed"></div>
                                
                                <div class="form-group">
                                   
                                    <label class="col-sm-2 control-label">Perfiles</label>
                                    
                                    <div class="col-sm-6">
                                        @foreach($g_perfiles as $perfil)
                                            <div class="i-checks">
                                                <label> 
                                                    <input type="checkbox" name="v_perfiles[]" id="v_menus" value="{{ $perfil->id }}" {{ $user->Perfiles->contains($perfil->id) ? 'checked' : '' }}> <i></i>
                                                    {{ $perfil->perfil_nombre }} 
                                                </label>
                                            </div>
                                        @endforeach
                                    
                                    </div>
                                </div>
                                
                                
                                <div class="hr-line-dashed"></div>
                                
                                
                                
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="{{ route('users.index') }}"> Cancelar</a>
                                        <button class="btn btn-primary" type="submit" id="btnGuardar">Guardar</button>
                                    </div>
                                </div>
                                
                            </form>
                    </div>    
                </div>
            </div>
        </div>
    </div>

            

@endsection


@section('scripts')

<!-- Page-Level Scripts -->
<!--<script>-->
    
<!--$("#btnGuardar").click(function (e) {-->
<!--      e.preventDefault();-->
<!--      var email = $('#email-field').val();-->
<!--      var token = $('#token').val();-->
<!--      $.ajax({-->
<!--        type: "post",-->
<!--        url: "/password/email",-->
<!--        data: {-->
<!--            email: email,-->
<!--            _token: token-->
<!--        }, success: function (msg) {-->
<!--                alert("Se ha realizado el POST con exito "+msg);-->
<!--        }-->
<!--      });-->
<!--  });-->
  
  
  
<!--</script>-->


    <script>
        $(document).ready(function() {
            var empleado_cedula = $("#fk_empleado_cedula-field").attr('value');
            
            if(empleado_cedula!=''){
                $('#fk_empleado_cedula-field option[value="'+ empleado_cedula +'"]').prop("selected", true);
            }
        
        });
    </script>
@endsection